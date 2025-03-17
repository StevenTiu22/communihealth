#!/usr/bin/env python3
"""
TB ARIMA Model Updater

This script incrementally updates an ARIMA model with new TB case data.
It maintains versioned models with a date-based naming convention.
Uses ARIMAResults.append(refit=True) for full model re-estimation with new data.
"""

import sys
import json
import os
import pandas as pd
from datetime import datetime
import joblib
from statsmodels.tsa.arima.model import ARIMA

# Constants
STORAGE_DIR = os.path.dirname(os.path.abspath(__file__))

MODEL_PREFIX = "arima-model"
BASE_MODEL_NAME = f"{MODEL_PREFIX}.pkl"
BASE_MODEL_PATH = os.path.join(STORAGE_DIR, BASE_MODEL_NAME)

# Ensure storage directory exists
os.makedirs(STORAGE_DIR, exist_ok=True)

def load_input_data(json_path):
    """Load and parse JSON input data"""
    try:
        with open(json_path, 'r') as f:
            data = json.load(f)

        # Convert to DataFrame
        df = pd.DataFrame(data)

        # Check if we have 'count' instead of 'cases' column (from Laravel data)
        if 'count' in df.columns and 'cases' not in df.columns:
            df = df.rename(columns={'count': 'cases'})

        # Ensure date column exists
        if 'date' not in df.columns:
            raise ValueError("Input data must contain 'date' column")

        # Ensure cases column exists
        if 'cases' not in df.columns:
            raise ValueError("Input data must contain 'cases' or 'count' column")

        # Convert date strings to datetime
        df['date'] = pd.to_datetime(df['date'])

        # Sort by date
        df = df.sort_values('date')

        # Set date as index
        df = df.set_index('date')

        return df
    except Exception as e:
        print(f"Error loading input data: {str(e)}")
        sys.exit(1)


def load_existing_model():
    """
    Try to load an existing model:
    1. First check if model_info.json exists with path to current model
    2. Fall back to default base model if no info file
    """
    try:
        # Check if we have a model_info.json file pointing to current version
        info_path = os.path.join(STORAGE_DIR, 'model_info.json')

        if os.path.exists(info_path):
            with open(info_path, 'r') as f:
                model_info = json.load(f)

            # Get current model path from info file
            current_model_path = os.path.join(STORAGE_DIR, model_info.get('current_model'), BASE_MODEL_NAME)

            if os.path.exists(current_model_path):
                model_data = joblib.load(current_model_path)
                print(f"Loaded existing model from {current_model_path}")

                # Ensure model data has the correct path info
                if 'version_path' not in model_data:
                    model_data['version_path'] = os.path.basename(current_model_path)

                return model_data

        # Fall back to base model if info file doesn't exist or specified model not found
        if os.path.exists(BASE_MODEL_PATH):
            model_data = joblib.load(BASE_MODEL_PATH)
            print(f"Loaded base model from {BASE_MODEL_PATH}")

            # Ensure model data has the correct path info
            if 'version_path' not in model_data:
                model_data['version_path'] = BASE_MODEL_NAME

            return model_data

        print("No existing model found")
        return None
    except Exception as e:
        print(f"Error loading existing model: {str(e)}")
        return None


def update_arima_model(input_path, output_path):
    """Update ARIMA model with new TB case data"""
    print(f"Starting TB ARIMA model update at {datetime.now()}")

    # Load new data
    new_data = load_input_data(input_path)
    print(f"Loaded {len(new_data)} new observations")

    # Load existing model
    model_data = load_existing_model()

    # Initialize response structure
    response = {
        "success": False,
        "message": "",
        "model_info": {},
        "forecast": []
    }

    try:
        today = datetime.now().strftime('%Y-%m-%d')
        version_filename = f"{MODEL_PREFIX}-{today}.pkl"
        version_path = os.path.join(STORAGE_DIR, version_filename)

        if model_data is not None:
            # Extract the ARIMA model
            arima_model = model_data['model']
            previous_end_date = model_data.get('last_updated_date')
            order = model_data.get('order', (1, 1, 1))

            # Find new data points (after the last update date)
            if previous_end_date:
                previous_end_date = pd.to_datetime(previous_end_date)
                update_data = new_data[new_data.index > previous_end_date]

                if update_data.empty:
                    print("No new data since last update")
                    response["success"] = True
                    response["message"] = "No new data to update model"
                    response["model_info"] = {
                        "last_updated_date": previous_end_date.strftime('%Y-%m-%d'),
                        "order": order,
                        "version_path": version_filename,
                        "version_date": today,
                        "aic": float(arima_model.aic) if hasattr(arima_model, 'aic') else None,
                        "bic": float(arima_model.bic) if hasattr(arima_model, 'bic') else None,
                    }

                    # Write response to output file
                    with open(output_path, 'w') as f:
                        json.dump(response, f, indent=2)
                    return response

                print(f"Updating model with {len(update_data)} new observations using append")

                # Use append with refit=True to re-estimate the entire model
                updated_model = arima_model.append(update_data, refit=True)

            else:
                # If we have an existing model but no date, use all data
                print("Updating model with all observations using append(refit=True)")
                updated_model = arima_model.append(new_data, refit=True)
        else:
            # Create a new model only if one doesn't exist
            print("Creating new ARIMA model")
            order = (1, 1, 1)  # Default p, d, q parameters

            # Fit new model
            arima_model = ARIMA(
                new_data['cases'],
                order=order
            ).fit()

            updated_model = arima_model

        # Generate forecast for next 12 months
        forecast_steps = 12
        forecast = updated_model.forecast(steps=forecast_steps)

        # Generate prediction intervals (95% confidence)
        pred_interval = updated_model.get_forecast(steps=forecast_steps).conf_int(alpha=0.05)

        # Create forecast dates
        last_date = new_data.index.max()
        forecast_dates = pd.date_range(start=last_date + pd.Timedelta(days=1), periods=forecast_steps, freq='MS')

        # Prepare forecast output
        forecast_data = []
        for i in range(len(forecast)):
            forecast_data.append({
                "date": forecast_dates[i].strftime('%Y-%m-%d'),
                "forecast": float(forecast[i]),
                "lower_bound": float(pred_interval.iloc[i, 0]),
                "upper_bound": float(pred_interval.iloc[i, 1])
            })

        # Save updated model with version
        model_data = {
            'model': updated_model,
            'order': order,  # Keep the original order structure
            'last_updated_date': new_data.index.max().strftime('%Y-%m-%d'),
            'training_samples': len(new_data),
            'update_time': datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
            'version_path': version_filename
        }

        # Save the versioned model
        joblib.dump(updated_model, version_path, compress=3)
        print(f"Saved versioned model to {version_path}")

        # Update model info file
        model_info = {
            'current_model': version_filename,
            'last_updated': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        }

        with open(os.path.join(STORAGE_DIR, 'model_info.json'), 'w') as f:
            json.dump(model_info, f, indent=2)

        # Set response
        response["success"] = True
        response["message"] = "Model successfully updated"
        response["model_info"] = {
            "last_updated_date": model_data['last_updated_date'],
            "order": order,
            "version_path": version_filename,
            "version_date": today,
            "aic": float(updated_model.aic) if hasattr(updated_model, 'aic') else None,
            "bic": float(updated_model.bic) if hasattr(updated_model, 'bic') else None,
            "mse": None  # Could calculate MSE on training data if needed
        }
        response["forecast"] = forecast_data

        # Write response to output file
        with open(output_path, 'w') as f:
            json.dump(response, f, indent=2)

        print(f"Updated model saved with date {today}")
        return response

    except Exception as e:
        import traceback
        traceback.print_exc()
        print(f"Error updating model: {str(e)}")

        response["success"] = False
        response["message"] = f"Error updating model: {str(e)}"

        # Write failure response
        with open(output_path, 'w') as f:
            json.dump(response, f, indent=2)

        return response


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(f"Usage: {sys.argv[0]} input_data.json output_response.json")
        sys.exit(1)

    update_arima_model(sys.argv[1], sys.argv[2])

