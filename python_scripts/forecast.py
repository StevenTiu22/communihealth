import sys
import json
import joblib
from datetime import datetime, timedelta

def forecast(data, model_path):
    try:
        # Load the model
        model = joblib.load(model_path)

        # Generate forecast with proper conversion
        forecast_result = model.forecast(steps=data)

        # Convert pandas objects to Python native types
        if hasattr(forecast_result, 'to_list'):
            forecast_values = forecast_result.to_list()  # For pandas Series
        elif hasattr(forecast_result, 'tolist'):
            forecast_values = forecast_result.tolist()  # For numpy arrays
        elif hasattr(forecast_result, 'values'):
            forecast_values = forecast_result.values.tolist()  # For pandas objects with numpy arrays
        else:
            forecast_values = list(forecast_result)  # Fallback to generic conversion

        # Generate dates for the forecast periods
        last_date = datetime.now()
        forecast_dates = [(last_date + timedelta(days=30*i)).strftime("%Y-%m-%d")
                         for i in range(1, data+1)]

        # Get confidence intervals (if available)
        conf_lower = None
        conf_upper = None

        try:
            # Try to get confidence intervals if the model supports it
            conf_interval = model.get_forecast(steps=data).conf_int()
            conf_lower = conf_interval.iloc[:, 0].tolist()
            conf_upper = conf_interval.iloc[:, 1].tolist()
        except (AttributeError, TypeError):
            # If confidence intervals aren't available, create approximate ones
            conf_lower = [max(0, val * 0.85) for val in forecast_values]
            conf_upper = [val * 1.15 for val in forecast_values]

        # Return the forecast with metadata
        return {
            'forecast': forecast_values,
            'forecast_dates': forecast_dates,
            'lower_bound': conf_lower,
            'upper_bound': conf_upper,
            'status': 'success',
        }
    except Exception as e:
        # Return error with metadata
        return {
            'error': str(e),
            'status': 'error',
        }


if __name__ == "__main__":
    try:
        # Get input JSON from command-line argument
        if len(sys.argv) > 1:
            json_input = sys.argv[1]
            data = json.loads(json_input)
            model_path = '../python_scripts/' + sys.argv[2] if len(sys.argv) > 2 else '../python_scripts/arima-model.pkl'  # Default model path

            # Call the forecast function with the number of months
            result = forecast(data, model_path)

            # Output the result
            print(json.dumps(result))
        else:
            # No input provided
            print(json.dumps({
                'error': 'No forecast period provided',
                'status': 'error',
                'meta': {
                    'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
                }
            }))
    except Exception as e:
        # Handle any uncaught exceptions
        print(json.dumps({
            'error': str(e),
            'status': 'error',
            'meta': {
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
            }
        }))
