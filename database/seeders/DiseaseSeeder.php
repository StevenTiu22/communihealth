<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -------------------------------
// Group 1: Provided disease mapping
// -------------------------------
        Disease::create([
            'code'         => 'D001',
            'name'         => 'Acute Upper Respiratory Infections (URI)',
            'type'         => 'acute', // acute infection
            'description'  => 'Acute upper respiratory infections affect the nose, sinuses, pharynx, and larynx and typically cause cough, colds, and fever.',
            'risk_factors' => 'Exposure to pathogens, seasonal changes, and weakened immune system.',
            'prevention'   => 'Good hand hygiene, vaccination, and avoiding contact with infected individuals.',
            'treatment'    => 'Rest, fluids, symptomatic care; antibiotics if a bacterial cause is confirmed.',
            'severity'     => 'moderate' // mapped from "Mild to Moderate"
        ]);

        Disease::create([
            'code'         => 'D002',
            'name'         => 'Acute Lower Respiratory Infections and Pneumonia',
            'type'         => 'acute',
            'description'  => 'These infections involve the airways below the voice box and may progress to pneumonia, leading to breathing difficulties, chest pain, and high fever.',
            'risk_factors' => 'Older age, smoking, chronic diseases, and compromised immunity.',
            'prevention'   => 'Vaccination, smoking cessation, and early treatment of respiratory symptoms.',
            'treatment'    => 'Antibiotics (if bacterial), supportive care, and hospitalization in severe cases.',
            'severity'     => 'severe' // mapped from "Moderate to Severe"
        ]);

        Disease::create([
            'code'         => 'D003',
            'name'         => 'Acute Gastroenteritis (AGE)',
            'type'         => 'acute',
            'description'  => 'Acute gastroenteritis is characterized by diarrhea, vomiting, abdominal cramps, and sometimes fever, often due to contaminated food or water.',
            'risk_factors' => 'Poor sanitation, contaminated food/water, and outbreak settings.',
            'prevention'   => 'Proper hand hygiene, safe food preparation, and clean water supply.',
            'treatment'    => 'Rehydration therapy, electrolyte replacement, and in certain cases, antibiotics.',
            'severity'     => 'moderate' // mapped from "Mild to Moderate"
        ]);

        Disease::create([
            'code'         => 'D004',
            'name'         => 'Hypertension',
            'type'         => 'chronic',
            'description'  => 'Hypertension increases the risk for heart disease and stroke by causing continuous high pressure in the arteries.',
            'risk_factors' => 'Genetics, obesity, sedentary lifestyle, high salt intake, and stress.',
            'prevention'   => 'Healthy diet, regular physical activity, weight management, and stress reduction.',
            'treatment'    => 'Lifestyle modifications and antihypertensive medications.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D005',
            'name'         => 'Urinary Tract Infection (UTI)',
            'type'         => 'acute',
            'description'  => 'UTIs are often characterized by a burning sensation during urination, frequent urges, and sometimes fever.',
            'risk_factors' => 'Female anatomy, sexual activity, and poor personal hygiene.',
            'prevention'   => 'Adequate hydration, proper hygiene, and urinating after intercourse.',
            'treatment'    => 'Antibiotics and supportive care.',
            'severity'     => 'moderate' // mapped from "Mild to Moderate"
        ]);

        Disease::create([
            'code'         => 'D006',
            'name'         => 'Influenza',
            'type'         => 'acute',
            'description'  => 'Influenza causes fever, cough, sore throat, muscle aches, and fatigue, with seasonal epidemics worldwide.',
            'risk_factors' => 'Close contact, crowded settings, and weakened immunity.',
            'prevention'   => 'Annual vaccination, hand hygiene, and respiratory etiquette.',
            'treatment'    => 'Rest, fluids, antiviral medications, and supportive care.',
            'severity'     => 'moderate' // mapped as provided
        ]);

        Disease::create([
            'code'         => 'D007',
            'name'         => 'Diabetes Mellitus',
            'type'         => 'chronic',
            'description'  => 'Diabetes Mellitus affects the body’s ability to produce or use insulin properly, leading to chronic hyperglycemia.',
            'risk_factors' => 'Obesity, sedentary lifestyle, genetic predisposition, and poor diet.',
            'prevention'   => 'Healthy eating, regular exercise, and maintaining a healthy weight.',
            'treatment'    => 'Insulin therapy, oral medications, and lifestyle modifications.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D008',
            'name'         => 'Coronary Artery Disease',
            'type'         => 'chronic',
            'description'  => 'Coronary artery disease results from plaque buildup in the arteries, reducing blood flow to the heart and increasing the risk of heart attacks.',
            'risk_factors' => 'High cholesterol, hypertension, smoking, diabetes, and sedentary lifestyle.',
            'prevention'   => 'Healthy diet, exercise, smoking cessation, and risk factor management.',
            'treatment'    => 'Medications, lifestyle changes, and possibly surgical interventions like angioplasty or bypass surgery.',
            'severity'     => 'severe' // mapped as provided
        ]);

        Disease::create([
            'code'         => 'D009',
            'name'         => 'Chronic Obstructive Pulmonary Disease (COPD)',
            'type'         => 'chronic',
            'description'  => 'COPD is characterized by chronic bronchitis and emphysema, leading to long-term breathing problems and decreased lung function.',
            'risk_factors' => 'Long-term smoking, exposure to pollutants, and genetic predisposition.',
            'prevention'   => 'Avoid smoking, reduce exposure to pollutants, and early intervention.',
            'treatment'    => 'Inhalers, medications, pulmonary rehabilitation, and oxygen therapy.',
            'severity'     => 'severe' // mapped from "Chronic" to severe for advanced lung disease
        ]);

        Disease::create([
            'code'         => 'D010',
            'name'         => 'Asthma',
            'type'         => 'chronic',
            'description'  => 'Asthma leads to episodes of wheezing, breathlessness, chest tightness, and coughing due to inflamed and narrowed airways.',
            'risk_factors' => 'Allergens, air pollution, respiratory infections, and genetic factors.',
            'prevention'   => 'Avoidance of triggers and adherence to preventive medication regimes.',
            'treatment'    => 'Inhaled corticosteroids, bronchodilators, and allergen avoidance.',
            'severity'     => 'moderate' // mapped from "Variable" to moderate as a default
        ]);

// -------------------------------
// Group 2: Generic data mapping (manually mapped)
// -------------------------------
        Disease::create([
            'code'         => 'D011',
            'name'         => "Alzheimer's Disease",
            'type'         => 'chronic',
            'description'  => "A progressive neurodegenerative disorder leading to memory loss and cognitive decline.",
            'risk_factors' => 'Age, genetics, and lifestyle factors.',
            'prevention'   => 'Healthy diet, mental stimulation, and regular exercise.',
            'treatment'    => 'Medications to manage symptoms and supportive care.',
            'severity'     => 'severe'
        ]);

        Disease::create([
            'code'         => 'D012',
            'name'         => "Parkinson's Disease",
            'type'         => 'chronic',
            'description'  => "A movement disorder characterized by tremors, rigidity, and balance issues.",
            'risk_factors' => 'Age, genetic factors, and environmental exposures.',
            'prevention'   => 'Regular exercise and a healthy lifestyle may lower risk.',
            'treatment'    => 'Medications and sometimes surgical interventions (e.g., deep brain stimulation).',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D013',
            'name'         => "Rheumatoid Arthritis",
            'type'         => 'chronic',
            'description'  => "A chronic inflammatory disorder affecting joints and causing pain and swelling.",
            'risk_factors' => 'Genetics, smoking, and gender (more common in women).',
            'prevention'   => 'Early diagnosis and treatment can help manage symptoms.',
            'treatment'    => 'Anti-inflammatory drugs, DMARDs, and physical therapy.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D014',
            'name'         => "Osteoarthritis",
            'type'         => 'chronic',
            'description'  => "A degenerative joint disease due to wear and tear.",
            'risk_factors' => 'Age, obesity, and joint injuries.',
            'prevention'   => 'Maintaining a healthy weight and avoiding joint overuse.',
            'treatment'    => 'Pain management, physical therapy, and sometimes surgery.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D015',
            'name'         => "Chronic Kidney Disease",
            'type'         => 'chronic',
            'description'  => "A gradual loss of kidney function over time.",
            'risk_factors' => 'Diabetes, hypertension, and family history.',
            'prevention'   => 'Control blood sugar and blood pressure, and a healthy lifestyle.',
            'treatment'    => 'Medications, dialysis, and potentially kidney transplant.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D016',
            'name'         => "Hepatitis B",
            'type'         => 'infectious',
            'description'  => "A viral infection that attacks the liver, causing both acute and chronic disease.",
            'risk_factors' => 'Exposure to infected blood or bodily fluids.',
            'prevention'   => 'Vaccination and avoiding contaminated blood exposure.',
            'treatment'    => 'Antiviral medications and supportive care.',
            'severity'     => 'moderate' // mapped from "Variable"
        ]);

        Disease::create([
            'code'         => 'D017',
            'name'         => "Hepatitis C",
            'type'         => 'infectious',
            'description'  => "A viral infection causing liver inflammation and potential chronic liver disease.",
            'risk_factors' => 'Exposure to infected blood, IV drug use, and unsafe medical practices.',
            'prevention'   => 'Avoiding exposure to infected blood and proper screening.',
            'treatment'    => 'Antiviral therapy that can often cure the infection.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D018',
            'name'         => "HIV/AIDS",
            'type'         => 'chronic',
            'description'  => "A virus that attacks the immune system, leading to immunodeficiency.",
            'risk_factors' => 'Unprotected sex, needle sharing, and vertical transmission.',
            'prevention'   => 'Safe sex practices, needle exchange programs, and prophylactic treatments.',
            'treatment'    => 'Antiretroviral therapy (ART) to control the virus.',
            'severity'     => 'moderate' // mapped from "Chronic"
        ]);

        Disease::create([
            'code'         => 'D019',
            'name'         => "Malaria",
            'type'         => 'acute',
            'description'  => "A mosquito-borne disease caused by Plasmodium parasites.",
            'risk_factors' => 'Living in or traveling to endemic regions.',
            'prevention'   => 'Use of insecticide-treated nets, repellents, and antimalarial prophylaxis.',
            'treatment'    => 'Antimalarial medications such as artemisinin-based combination therapies.',
            'severity'     => 'severe'
        ]);

        Disease::create([
            'code'         => 'D020',
            'name'         => "Tuberculosis",
            'type'         => 'infectious',
            'description'  => "A contagious infection primarily affecting the lungs, caused by Mycobacterium tuberculosis.",
            'risk_factors' => 'Close contact with infected individuals and compromised immunity.',
            'prevention'   => 'BCG vaccination, early detection, and improved living conditions.',
            'treatment'    => 'A long-term course of multiple antibiotics.',
            'severity'     => 'severe' // mapped from "Serious"
        ]);
    }
}
