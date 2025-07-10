@extends('admin.layout.app')

<style>
    label {
        font-weight: 800;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        font-size: 1rem !important;
    }
    .form-control:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
    }
    .checkbox-group label {
        display: block;
        margin-bottom: 0.5rem;
    }
    .checkbox-group input[type="checkbox"] {
        margin-right: 0.5rem;
    }
    .order-step {
        display: none;
    }
    .order-step.active {
        display: block;
    }
    .input-error {
        color: red;
        display: none;
    }
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }
    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        margin-top: 1rem;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        margin-top: 1rem;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        margin-top: 1rem;
    }
    .card{
        /* background: transparent!important; */
        background: linear-gradient(135deg, #fff0f6a2, #ffe3ec8f ), url('{{ asset('adminAssets/simplefixxx.jpg') }}')!important;
        background-size: cover !important;
        background-position: top center!important;
        background-repeat: no-repeat !important;
    }
</style>
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your submission:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Order</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Order Step <span id="step-indicator">1</span> of 9</h4>
                    </div>
                    <div class="card-body">
                        <div id="current-date-time" class="text-muted mb-3"></div>
                        <div class="form-card p-6">
                            <div id="orderForm" class="space-y-6">
                                <div class="order-step" data-step="1">
                                    <h3 class="text-2xl font-semibold text-pink-600">Medical History</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700">What are your weight loss goals? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="weight_loss_goals" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="lose_1_20" {{ isset($orderData['health_history']['weight_loss_goals']) && $orderData['health_history']['weight_loss_goals'] == 'lose_1_20' ? 'selected' : '' }}>Lose 1-20 lbs for good</option>
                                                <option value="lose_21_50" {{ isset($orderData['health_history']['weight_loss_goals']) && $orderData['health_history']['weight_loss_goals'] == 'lose_21_50' ? 'selected' : '' }}>Lose 21-50 lbs for good</option>
                                                <option value="lose_over_50" {{ isset($orderData['health_history']['weight_loss_goals']) && $orderData['health_history']['weight_loss_goals'] == 'lose_over_50' ? 'selected' : '' }}>Lose over 50 lbs for good</option>
                                                <option value="maintain" {{ isset($orderData['health_history']['weight_loss_goals']) && $orderData['health_history']['weight_loss_goals'] == 'maintain' ? 'selected' : '' }}>Maintain my healthy weight</option>
                                                <option value="none" {{ isset($orderData['health_history']['weight_loss_goals']) && $orderData['health_history']['weight_loss_goals'] == 'none' ? 'selected' : '' }}>None of the above</option>
                                                <option value="other" {{ isset($orderData['health_history']['weight_loss_goals']) && $orderData['health_history']['weight_loss_goals'] == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">What weight loss initiatives have you tried? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="weight_loss_initiatives[]" class="form-control w-full p-2 border rounded" multiple required>
                                                <option value="exercise_dieting" {{ isset($orderData['health_history']['weight_loss_initiatives']) && in_array('exercise_dieting', $orderData['health_history']['weight_loss_initiatives']) ? 'selected' : '' }}>Exercise/Dieting</option>
                                                <option value="supplements" {{ isset($orderData['health_history']['weight_loss_initiatives']) && in_array('supplements', $orderData['health_history']['weight_loss_initiatives']) ? 'selected' : '' }}>Weight-loss supplements</option>
                                                <option value="fasting" {{ isset($orderData['health_history']['weight_loss_initiatives']) && in_array('fasting', $orderData['health_history']['weight_loss_initiatives']) ? 'selected' : '' }}>Intermittent fasting</option>
                                                <option value="none" {{ isset($orderData['health_history']['weight_loss_initiatives']) && in_array('none', $orderData['health_history']['weight_loss_initiatives']) ? 'selected' : '' }}>None of the above</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Have you seen a doctor in the past 12 months? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="doctor_visit" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="no" {{ isset($orderData['health_history']['doctor_visit']) && $orderData['health_history']['doctor_visit'] == 'no' ? 'selected' : '' }}>No, I have not seen a doctor</option>
                                                <option value="yes" {{ isset($orderData['health_history']['doctor_visit']) && $orderData['health_history']['doctor_visit'] == 'yes' ? 'selected' : '' }}>Yes, I have seen a doctor</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Your Weight (lbs) <span class="text-red-500 ml-1">*</span></label>
                                            <input type="number" name="weight_lbs" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['weight_lbs']) ? $orderData['health_history']['weight_lbs'] : '' }}" required>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Height (Feet) <span class="text-red-500 ml-1">*</span></label>
                                            <input type="number" name="height_feet" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['height_feet']) ? $orderData['health_history']['height_feet'] : '' }}" required>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Height (Inches) <span class="text-red-500 ml-1">*</span></label>
                                            <input type="number" name="height_inches" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['height_inches']) ? $orderData['health_history']['height_inches'] : '' }}" required>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">BMI</label>
                                            <input type="number" name="bmi" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['bmi']) ? $orderData['health_history']['bmi'] : '' }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Weight (lbs)</label>
                                            <input type="number" name="weight_lbs_display" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['weight_lbs_display']) ? $orderData['health_history']['weight_lbs_display'] : '' }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Height (ft/in)</label>
                                            <input type="text" name="height_ft_in" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['height_ft_in']) ? $orderData['health_history']['height_ft_in'] : '' }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Height (cm)</label>
                                            <input type="number" name="height_cm" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['height_cm']) ? $orderData['health_history']['height_cm'] : '' }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Have you been diagnosed with any of these conditions? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="conditions" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="high_bp" {{ isset($orderData['health_history']['conditions']) && $orderData['health_history']['conditions'] == 'high_bp' ? 'selected' : '' }}>High blood pressure</option>
                                                <option value="high_cholesterol" {{ isset($orderData['health_history']['conditions']) && $orderData['health_history']['conditions'] == 'high_cholesterol' ? 'selected' : '' }}>High cholesterol</option>
                                                <option value="pulmonary" {{ isset($orderData['health_history']['conditions']) && $orderData['health_history']['conditions'] == 'pulmonary' ? 'selected' : '' }}>Pulmonary condition</option>
                                                <option value="none" {{ isset($orderData['health_history']['conditions']) && $orderData['health_history']['conditions'] == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="other" {{ isset($orderData['health_history']['conditions']) && $orderData['health_history']['conditions'] == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">How often do you exercise? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="exercise_frequency" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="3-4_days" {{ isset($orderData['health_history']['exercise_frequency']) && $orderData['health_history']['exercise_frequency'] == '3-4_days' ? 'selected' : '' }}>3-4 days a week</option>
                                                <option value="2-3_days" {{ isset($orderData['health_history']['exercise_frequency']) && $orderData['health_history']['exercise_frequency'] == '2-3_days' ? 'selected' : '' }}>2-3 days a week</option>
                                                <option value="very_little" {{ isset($orderData['health_history']['exercise_frequency']) && $orderData['health_history']['exercise_frequency'] == 'very_little' ? 'selected' : '' }}>Very little</option>
                                                <option value="never" {{ isset($orderData['health_history']['exercise_frequency']) && $orderData['health_history']['exercise_frequency'] == 'never' ? 'selected' : '' }}>Never</option>
                                                <option value="other" {{ isset($orderData['health_history']['exercise_frequency']) && $orderData['health_history']['exercise_frequency'] == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">What type of exercise do you do?</label>
                                            <input type="text" name="exercise_type" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['health_history']['exercise_type']) ? $orderData['health_history']['exercise_type'] : '' }}">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Which weight loss medications have you tried? <span class="text-red-500 ml-1">*</span></label>
                                            <div class="checkbox-group">
                                                <div class="space-y-2">
                                                    <label><input type="checkbox" name="medications[]" value="glp1" {{ isset($orderData['health_history']['medications']) && in_array('glp1', $orderData['health_history']['medications']) ? 'checked' : '' }} required> GLP-1</label>
                                                    <label><input type="checkbox" name="medications[]" value="glp1gip" {{ isset($orderData['health_history']['medications']) && in_array('glp1gip', $orderData['health_history']['medications']) ? 'checked' : '' }}> GLP-1/GIP</label>
                                                    <label><input type="checkbox" name="medications[]" value="orlistat" {{ isset($orderData['health_history']['medications']) && in_array('orlistat', $orderData['health_history']['medications']) ? 'checked' : '' }}> Orlistat (Xenical, Alli)</label>
                                                    <label><input type="checkbox" name="medications[]" value="phentermine_topiramate" {{ isset($orderData['health_history']['medications']) && in_array('phentermine_topiramate', $orderData['health_history']['medications']) ? 'checked' : '' }}> Phentermine-topiramate (Qsymia)</label>
                                                    <label><input type="checkbox" name="medications[]" value="reg_phentermine" {{ isset($orderData['health_history']['medications']) && in_array('reg_phentermine', $orderData['health_history']['medications']) ? 'checked' : '' }}> Reg Phentermine 37.5 mg</label>
                                                    <label><input type="checkbox" name="medications[]" value="naltrexone_bupropion" {{ isset($orderData['health_history']['medications']) && in_array('naltrexone_bupropion', $orderData['health_history']['medications']) ? 'checked' : '' }}> Naltrexone-bupropion (Contrave)</label>
                                                    <label><input type="checkbox" name="medications[]" value="liraglutide" {{ isset($orderData['health_history']['medications']) && in_array('liraglutide', $orderData['health_history']['medications']) ? 'checked' : '' }}> Liraglutide (Saxenda)</label>
                                                    <label><input type="checkbox" name="medications[]" value="none" {{ isset($orderData['health_history']['medications']) && in_array('none', $orderData['health_history']['medications']) ? 'checked' : '' }}> None</label>
                                                </div>
                                                <div class="input-error" style="color:red;display:none"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Have you had serious gallbladder issues in the past 12 months? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="gallbladder_issues" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="pain" {{ isset($orderData['health_history']['gallbladder_issues']) && $orderData['health_history']['gallbladder_issues'] == 'pain' ? 'selected' : '' }}>Pain in upper stomach (abdomen)</option>
                                                <option value="jaundice" {{ isset($orderData['health_history']['gallbladder_issues']) && $orderData['health_history']['gallbladder_issues'] == 'jaundice' ? 'selected' : '' }}>Yellowing of skin or eyes (jaundice)</option>
                                                <option value="clay_stools" {{ isset($orderData['health_history']['gallbladder_issues']) && $orderData['health_history']['gallbladder_issues'] == 'clay_stools' ? 'selected' : '' }}>Clay-coloured stools</option>
                                                <option value="active_disease" {{ isset($orderData['health_history']['gallbladder_issues']) && $orderData['health_history']['gallbladder_issues'] == 'active_disease' ? 'selected' : '' }}>I have active gallbladder disease</option>
                                                <option value="none" {{ isset($orderData['health_history']['gallbladder_issues']) && $orderData['health_history']['gallbladder_issues'] == 'none' ? 'selected' : '' }}>No, I do not have any of these symptoms</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Have you been diagnosed with pancreatitis in the past 6 months?</label>
                                            <select name="pancreatitis" class="form-control w-full p-2 border rounded">
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['health_history']['pancreatitis']) && $orderData['health_history']['pancreatitis'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['health_history']['pancreatitis']) && $orderData['health_history']['pancreatitis'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Have you been diagnosed with kidney disease in the past 12 months?</label>
                                            <select name="kidney_disease" class="form-control w-full p-2 border rounded">
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['health_history']['kidney_disease']) && $orderData['health_history']['kidney_disease'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['health_history']['kidney_disease']) && $orderData['health_history']['kidney_disease'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Do you have sleep conditions such as sleep apnea?</label>
                                            <select name="sleep_apnea" class="form-control w-full p-2 border rounded">
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['health_history']['sleep_apnea']) && $orderData['health_history']['sleep_apnea'] == 'yes' ? 'selected' : '' }}>Yes, I have sleep apnea</option>
                                                <option value="no" {{ isset($orderData['health_history']['sleep_apnea']) && $orderData['health_history']['sleep_apnea'] == 'no' ? 'selected' : '' }}>No, I do not have sleep apnea</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-step" data-step="2" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Important Notice</h3>
                                    <div class="alert alert-warning display-5" role="alert">
                                        <strong>New Compliance Measures:</strong> All new or returning patients seeking an increase in their medication schedule a call with a physician. If you are a new patient, or are seeking an increase in your dose, you will be directed to schedule an online doctor consult. If you answered accordingly, please continue. For any questions, please contact <a href="mailto:support@simplefix.com">support@simplefix.com</a> (your order could be delayed if consulted and payment refunded).
                                    </div>
                                    <input type="hidden" name="notice_acknowledged" value="true">
                                </div>
                                <div class="order-step" data-step="3" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Weight Management Rx History</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700">Did any of the following side effects cause you to discontinue treatment?</label>
                                            <div class="space-y-2">
                                                <label><input type="checkbox" name="side_effects[]" value="nausea" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('nausea', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> Nausea</label>
                                                <label><input type="checkbox" name="side_effects[]" value="diarrhea" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('diarrhea', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> Diarrhea</label>
                                                <label><input type="checkbox" name="side_effects[]" value="stomach" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('stomach', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> Stomach</label>
                                                <label><input type="checkbox" name="side_effects[]" value="vomiting" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('vomiting', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> Vomiting</label>
                                                <label><input type="checkbox" name="side_effects[]" value="constipation" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('constipation', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> Constipation</label>
                                                <label><input type="checkbox" name="side_effects[]" value="no_side_effects" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('no_side_effects', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> No side effects</label>
                                                <label><input type="checkbox" name="side_effects[]" value="other" {{ isset($orderData['weight_management_history']['side_effects']) && in_array('other', $orderData['weight_management_history']['side_effects']) ? 'checked' : '' }}> Other</label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Did you previously purchase your weight loss medication from SimpleFix? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="previous_purchase" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['weight_management_history']['previous_purchase']) && $orderData['weight_management_history']['previous_purchase'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['weight_management_history']['previous_purchase']) && $orderData['weight_management_history']['previous_purchase'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Would you like the strength of your prescription increased? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="prescription_increase" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes_slow" {{ isset($orderData['weight_management_history']['prescription_increase']) && $orderData['weight_management_history']['prescription_increase'] == 'yes_slow' ? 'selected' : '' }}>Yes, I'm having a slow rate in weight loss and would like to increase</option>
                                                <option value="no_happy" {{ isset($orderData['weight_management_history']['prescription_increase']) && $orderData['weight_management_history']['prescription_increase'] == 'no_happy' ? 'selected' : '' }}>No, I'm happy with the amount I'm losing</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Studies show adding B12 can help reduce nausea and increase energy, is feeling energetic important to you? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="b12_importance" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['weight_management_history']['b12_importance']) && $orderData['weight_management_history']['b12_importance'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['weight_management_history']['b12_importance']) && $orderData['weight_management_history']['b12_importance'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">If yes, would you like to add B12 to your request? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="add_b12" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['weight_management_history']['add_b12']) && $orderData['weight_management_history']['add_b12'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['weight_management_history']['add_b12']) && $orderData['weight_management_history']['add_b12'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Adding glycine can help muscle retention, is muscle retention important to you? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="glycine_importance" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['weight_management_history']['glycine_importance']) && $orderData['weight_management_history']['glycine_importance'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['weight_management_history']['glycine_importance']) && $orderData['weight_management_history']['glycine_importance'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Have you had gastrointestinal issues or nausea while on GLP-1 medications? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="glp1_issues" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['weight_management_history']['glp1_issues']) && $orderData['weight_management_history']['glp1_issues'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['weight_management_history']['glp1_issues']) && $orderData['weight_management_history']['glp1_issues'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">If yes, would you like to add nausea medication to your request? <span class="text-red-500 ml-1">*</span></label>
                                            <select name="add_nausea_med" class="form-control w-full p-2 border rounded" required>
                                                <option value="">Select</option>
                                                <option value="yes" {{ isset($orderData['weight_management_history']['add_nausea_med']) && $orderData['weight_management_history']['add_nausea_med'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no" {{ isset($orderData['weight_management_history']['add_nausea_med']) && $orderData['weight_management_history']['add_nausea_med'] == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <div class="input-error" style="color:red;display:none"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-step" data-step="4" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Shipping & Billing Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-700">Shipping Address <span class="text-red-500 ml-1">*</span></h4>
                                            <div>
                                                <input type="text" name="shipping_address1" placeholder="Shipping Address" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['shipping_address1']) ? $orderData['shipping_options']['shipping_address1'] : '' }}" required>
                                                <div class="input-error" style="color:red;display:none"></div>
                                            </div>
                                            <input type="text" name="shipping_address2" placeholder="Address Line 2" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['shipping_address2']) ? $orderData['shipping_options']['shipping_address2'] : '' }}">
                                            <div>
                                                <input type="text" name="shipping_city" placeholder="City" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['shipping_city']) ? $orderData['shipping_options']['shipping_city'] : '' }}" required>
                                                <div class="input-error" style="color:red;display:none"></div>
                                            </div>
                                            <div>
                                                <input type="text" name="shipping_state" placeholder="State" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['shipping_state']) ? $orderData['shipping_options']['shipping_state'] : '' }}" required>
                                                <div class="input-error" style="color:red;display:none"></div>
                                            </div>
                                            <div>
                                                <input type="text" name="shipping_zip" placeholder="Zip Code" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['shipping_zip']) ? $orderData['shipping_options']['shipping_zip'] : '' }}" required>
                                                <div class="input-error" style="color:red;display:none"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-700">Billing Address</h4>
                                            <label><input type="checkbox" name="billing_same_as_shipping" value="1" {{ isset($orderData['shipping_options']['billing_same_as_shipping']) && $orderData['shipping_options']['billing_same_as_shipping'] ? 'checked' : '' }}> Same as Shipping Address</label>
                                            <input type="text" name="billing_address1" placeholder="Billing Address" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['billing_address1']) ? $orderData['shipping_options']['billing_address1'] : '' }}">
                                            <input type="text" name="billing_address2" placeholder="Address Line 2" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['billing_address2']) ? $orderData['shipping_options']['billing_address2'] : '' }}">
                                            <input type="text" name="billing_city" placeholder="City" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['billing_city']) ? $orderData['shipping_options']['billing_city'] : '' }}">
                                            <input type="text" name="billing_state" placeholder="State" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['billing_state']) ? $orderData['shipping_options']['billing_state'] : '' }}">
                                            <input type="text" name="billing_zip" placeholder="Zip Code" class="form-control w-full p-2 border rounded mb-2" value="{{ isset($orderData['shipping_options']['billing_zip']) ? $orderData['shipping_options']['billing_zip'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="order-step" data-step="5" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Request RX</h3>
                                    <div class="space-y-4">
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_2.5_5" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_2.5_5' ? 'checked' : '' }} required> GLP1/1 with Glycine 2.5mg/5mg/ml $300 - 1 ml vial weekly, 24 units (0.6mg) Subcutaneous <span class="text-red-500 ml-1">*</span></label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_3.75_12.5" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_3.75_12.5' ? 'checked' : '' }} required> GLP1/1 with Glycine 3.75mg/12.5mg $350 - 2.5 ml vial, 60 units (0.9mg) Subcutaneous weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_6.25_12.5" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_6.25_12.5' ? 'checked' : '' }} required> GLP1/1 with Glycine 6.25mg/12.5mg $375 - 2.5 ml vial, 60 units (1.5mg) Subcutaneous weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_8.75_17.5" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_8.75_17.5' ? 'checked' : '' }} required> GLP1/1 with Glycine 8.75mg/17.5mg $400 - 3.5 ml vial, 80 units (2.0mg) Subcutaneous weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_starter" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_starter' ? 'checked' : '' }} required> GLP1/1 with Glycine Starter Package $595 - Month 1-3 with varying doses</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_performance" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_performance' ? 'checked' : '' }} required> GLP1/1 with Glycine Performance Package $795 - 3 vials with increasing doses</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_1_max" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_1_max' ? 'checked' : '' }} required> GLP1/1 with Glycine Max Package $895 - 12 weeks supply</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_20_10" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_20_10' ? 'checked' : '' }} required> GLP1/GIP/Glycine 20mg/10mg $450 - 2ml vial, 45 units (4.5mg) SQ weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_30_7.5" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_30_7.5' ? 'checked' : '' }} required> GLP1/GIP/Glycine 30mg/7.5mg $525 - 3ml vial, 68 units (6.8mg) SQ weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_40_10" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_40_10' ? 'checked' : '' }} required> GLP1/GIP/Glycine 40mg/10mg $550 - 2ml vial, 45 units (9mg) SQ weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_60_15" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_60_15' ? 'checked' : '' }} required> GLP1/GIP/Glycine 60mg/15mg $625 - 3ml vial, 68 units (13.6mg) SQ weekly</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_starter" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_starter' ? 'checked' : '' }} required> GLP1/GIP with Glycine Starter Package $795 - Month 1-3 with increasing doses</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_performance" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_performance' ? 'checked' : '' }} required> GLP1/GIP with Glycine Performance Package $1250 - 3 vials with increasing doses</label>
                                        <label><input type="radio" name="requested_rx" value="GLP1_GIP_max" {{ isset($orderData['medication_requests']) && $orderData['medication_requests'] == 'GLP1_GIP_max' ? 'checked' : '' }} required> GLP1/GIP Max Package $1450 - 3 month supply</label>
                                        <div class="input-error" style="color:red;display:none"></div>
                                    </div>
                                </div>
                                <div class="order-step" data-step="6" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Available Add-ons (Optional)</h3>
                                    <div class="space-y-4">
                                        <label><input type="checkbox" name="add_ons[]" value="anti_nausea_4mg" {{ isset($orderData['add_ons']) && in_array('anti_nausea_4mg', $orderData['add_ons']) ? 'checked' : '' }}> 4mg Ondansetron - $30 Anti-Nausea pills, 30-count</label>
                                        <label><input type="checkbox" name="add_ons[]" value="b12" {{ isset($orderData['add_ons']) && in_array('b12', $orderData['add_ons']) ? 'checked' : '' }}> B12 - $79 one month supply IM</label>
                                        <label><input type="checkbox" name="add_ons[]" value="phentermine_30" {{ isset($orderData['add_ons']) && in_array('phentermine_30', $orderData['add_ons']) ? 'checked' : '' }}> Phentermine 37.5mg - 30-Count $99</label>
                                        <label><input type="checkbox" name="add_ons[]" value="phentermine_60" {{ isset($orderData['add_ons']) && in_array('phentermine_60', $orderData['add_ons']) ? 'checked' : '' }}> Phentermine 37.5mg - 60-Count $127</label>
                                        <label><input type="checkbox" name="add_ons[]" value="phentermine_90" {{ isset($orderData['add_ons']) && in_array('phentermine_90', $orderData['add_ons']) ? 'checked' : '' }}> Phentermine 37.5mg - 90-Count $155</label>
                                        <label><input type="checkbox" name="add_ons[]" value="nad_monthly" {{ isset($orderData['add_ons']) && in_array('nad_monthly', $orderData['add_ons']) ? 'checked' : '' }}> NAD - $185 monthly</label>
                                        <label><input type="checkbox" name="add_ons[]" value="nad_2months" {{ isset($orderData['add_ons']) && in_array('nad_2months', $orderData['add_ons']) ? 'checked' : '' }}> NAD - $320 2 months</label>
                                    </div>
                                </div>
                                <div class="order-step" data-step="7" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Shipping Options</h3>
                                    <p class="text-gray-600 mb-4">Please allow 4 days (48 hours for the physician, 48 hours for the pharmacy) to review and process your order.</p>
                                    <div class="space-y-2">
                                        <label><input type="radio" name="shipping_option" value="standard" {{ isset($orderData['shipping_options']['shipping_option']) && $orderData['shipping_options']['shipping_option'] == 'standard' ? 'checked' : '' }} required> Standard Shipping + $25.00 <span class="text-red-500 ml-1">*</span></label>
                                        <label><input type="radio" name="shipping_option" value="insured" {{ isset($orderData['shipping_options']['shipping_option']) && $orderData['shipping_options']['shipping_option'] == 'insured' ? 'checked' : '' }} required> Standard Shipping with Insurance + $35.00</label>
                                        <p class="text-sm text-gray-500">SimpleFixRx is not liable for packages lost or stolen during transit. To ensure your package, select the insured option for an extra $10.</p>
                                        <div class="input-error" style="color:red;display:none"></div>
                                    </div>
                                </div>
                                <div class="order-step" data-step="8" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Sign & Consent</h3>
                                    <p class="text-gray-600 mb-4">By signing here, you agree that you have read HIPAA, Telemedicine consent, Disclosure and agree that you are the individual in ID and Photo. SimplefixRx uses CareValidate for medical decisions and patient care.</p>
                                    <div class="form-group">
                                        <label class="block text-gray-700">Sign here <span class="text-red-500 ml-1">*</span></label>
                                        <input type="text" name="signature" class="form-control w-full p-2 border rounded" value="{{ isset($orderData['consent']['signature']) ? $orderData['consent']['signature'] : '' }}" placeholder="Enter your signature" required>
                                        <div class="input-error" style="color:red;display:none"></div>
                                    </div>
                                </div>
                                <div class="order-step" data-step="9" style="display:none;">
                                    <h3 class="text-2xl font-semibold text-pink-600">Complete Your Payment</h3>
                                    <div class="bg-pink-600 text-white p-4 rounded-lg">
                                        <h4 class="text-lg font-semibold">Have a Promo Code?</h4>
                                        <input type="text" name="promo_code" class="form-control w-full p-2 border rounded mb-2 bg-white text-gray-800" value="{{ isset($orderData['payment_details']['promo_code']) ? $orderData['payment_details']['promo_code'] : '' }}" placeholder="Enter promo code">
                                        <h4 class="text-lg font-semibold">Your Selected Add-ons</h4>
                                        <p class="mb-2">{{ isset($orderData['add_ons']) ? implode(', ', $orderData['add_ons']) : 'None' }}</p>
                                        <h4 class="text-lg font-semibold">Credit Card</h4>
                                        <input type="text" name="card_number" class="form-control w-full p-2 border rounded mb-2 bg-white text-gray-800" value="{{ isset($orderData['payment_details']['card_number']) ? $orderData['payment_details']['card_number'] : '' }}" placeholder="Card Number (1234567890123456)" required pattern="\d{16}">
                                        <div class="input-error" style="color:blue;display:none"></div>
                                        <input type="text" name="expiry_date" class="form-control w-full p-2 border rounded mb-2 bg-white text-gray-800" value="{{ isset($orderData['payment_details']['expiry_date']) ? $orderData['payment_details']['expiry_date'] : '' }}" placeholder="Expiry Date (MM/YY)" required pattern="(0[1-9]|1[0-2])/[0-9]{2}">
                                        <div class="input-error" style="color:blue;display:none"></div>
                                        <input type="text" name="cvv" class="form-control w-full p-2 border rounded mb-2 bg-white text-gray-800" value="{{ isset($orderData['payment_details']['cvv']) ? $orderData['payment_details']['cvv'] : '' }}" placeholder="CVV (123)" required pattern="\d{3}">
                                        <div class="input-error" style="color:blue;display:none"></div>
                                        <input type="text" name="cardholder_name" class="form-control w-full p-2 border rounded mb-2 bg-white text-gray-800" value="{{ isset($orderData['payment_details']['cardholder_name']) ? $orderData['payment_details']['cardholder_name'] : '' }}" placeholder="Cardholder Name" required>
                                        <div class="input-error" style="color:blue;display:none"></div>
                                        <button type="submit" class="btn btn-light w-full">Submit Payment</button>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-4">
                                    <button type="button" id="prevBtn" class="btn btn-secondary">Previous</button>
                                    <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
                                    <button type="button" id="submitBtn" class="btn btn-success" style="display:none;">Submit</button>
                                </div>
                                <!-- Debug output -->
                                <div class="text-sm text-gray-600 mt-2">
                                    Current Step: <span id="debug-current-step"></span><br>
                                    Session Step: <span id="debug-session-step"></span><br>
                                    Current Date & Time: <span id="debug-date-time"></span><br>
                                    @if ($errors->any())
                                        <span class="text-red-500">Errors: {{ implode(', ', $errors->all()) }}</span><br>
                                    @endif
                                    @if (session('status'))
                                        <span class="text-green-500">Status: {{ session('status') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        let orderData = {
            health_history: {},
            weight_management_history: {},
            medication_requests: {},
            add_ons: [],
            shipping_options: {},
            consent: {},
            payment_details: {}
        };
        let currentStep = 1;
        const totalSteps = 9;

        function showStep(step) {
            document.querySelectorAll('.order-step').forEach(div => {
                div.style.display = (parseInt(div.dataset.step) === step) ? 'block' : 'none';
            });
            document.getElementById('step-indicator').textContent = step;
            // Previous button logic
            document.getElementById('prevBtn').disabled = (step === 1);
            // Next button logic
            document.getElementById('nextBtn').style.display = (step === totalSteps) ? 'none' : '';
            document.getElementById('nextBtn').disabled = (step === totalSteps);
            // Submit button logic
            document.getElementById('submitBtn').style.display = (step === totalSteps) ? '' : 'none';
            updateDebugInfo();
        }

        function updateDebugInfo() {
            const currentStepSpan = document.getElementById('debug-current-step');
            if (currentStepSpan) currentStepSpan.textContent = currentStep;
            const sessionStepSpan = document.getElementById('debug-session-step');
            if (sessionStepSpan) sessionStepSpan.textContent = currentStep; // Or use a session variable if available
            const dateTimeSpan = document.getElementById('debug-date-time');
            if (dateTimeSpan) dateTimeSpan.textContent = new Date().toLocaleString();
        }

        function saveStepData(step) {
            let stepDiv = document.querySelector('.order-step[data-step="' + step + '"]');
            if (!stepDiv) {
                return;
            }
            if (step === 1) {
                orderData.health_history = {
                    weight_loss_goals: stepDiv.querySelector('[name="weight_loss_goals"]')?.value || '',
                    weight_loss_initiatives: Array.from(stepDiv.querySelectorAll('[name="weight_loss_initiatives[]"] option:checked')).map(o => o.value),
                    doctor_visit: stepDiv.querySelector('[name="doctor_visit"]')?.value || '',
                    weight_lbs: stepDiv.querySelector('[name="weight_lbs"]')?.value || '',
                    height_feet: stepDiv.querySelector('[name="height_feet"]')?.value || '',
                    height_inches: stepDiv.querySelector('[name="height_inches"]')?.value || '',
                    conditions: stepDiv.querySelector('[name="conditions"]')?.value || '',
                    exercise_frequency: stepDiv.querySelector('[name="exercise_frequency"]')?.value || '',
                    exercise_type: stepDiv.querySelector('[name="exercise_type"]')?.value || '',
                    medications: Array.from(stepDiv.querySelectorAll('[name="medications[]"]:checked')).map(cb => cb.value),
                    gallbladder_issues: stepDiv.querySelector('[name="gallbladder_issues"]')?.value || '',
                    pancreatitis: stepDiv.querySelector('[name="pancreatitis"]')?.value || '',
                    kidney_disease: stepDiv.querySelector('[name="kidney_disease"]')?.value || '',
                    sleep_apnea: stepDiv.querySelector('[name="sleep_apnea"]')?.value || '',
                };
            } else if (step === 2) {
                orderData.notice_acknowledged = true;
            } else if (step === 3) {
                orderData.weight_management_history = {
                    side_effects: Array.from(stepDiv.querySelectorAll('[name="side_effects[]"]:checked')).map(cb => cb.value),
                    previous_purchase: stepDiv.querySelector('[name="previous_purchase"]')?.value || '',
                    prescription_increase: stepDiv.querySelector('[name="prescription_increase"]')?.value || '',
                    b12_importance: stepDiv.querySelector('[name="b12_importance"]')?.value || '',
                    add_b12: stepDiv.querySelector('[name="add_b12"]')?.value || '',
                    glycine_importance: stepDiv.querySelector('[name="glycine_importance"]')?.value || '',
                    glp1_issues: stepDiv.querySelector('[name="glp1_issues"]')?.value || '',
                    add_nausea_med: stepDiv.querySelector('[name="add_nausea_med"]')?.value || '',
                };
            } else if (step === 4) {
                orderData.shipping_options = {
                    shipping_address1: stepDiv.querySelector('[name="shipping_address1"]')?.value || '',
                    shipping_address2: stepDiv.querySelector('[name="shipping_address2"]')?.value || '',
                    shipping_city: stepDiv.querySelector('[name="shipping_city"]')?.value || '',
                    shipping_state: stepDiv.querySelector('[name="shipping_state"]')?.value || '',
                    shipping_zip: stepDiv.querySelector('[name="shipping_zip"]')?.value || '',
                    billing_same_as_shipping: stepDiv.querySelector('[name="billing_same_as_shipping"]')?.checked || false,
                    billing_address1: stepDiv.querySelector('[name="billing_address1"]')?.value || '',
                    billing_address2: stepDiv.querySelector('[name="billing_address2"]')?.value || '',
                    billing_city: stepDiv.querySelector('[name="billing_city"]')?.value || '',
                    billing_state: stepDiv.querySelector('[name="billing_state"]')?.value || '',
                    billing_zip: stepDiv.querySelector('[name="billing_zip"]')?.value || '',
                };
            } else if (step === 5) {
                orderData.medication_requests = stepDiv.querySelector('[name="requested_rx"]:checked') ? stepDiv.querySelector('[name="requested_rx"]:checked').value : '';
            } else if (step === 6) {
                orderData.add_ons = Array.from(stepDiv.querySelectorAll('[name="add_ons[]"]:checked')).map(cb => cb.value);
            } else if (step === 7) {
                if (!orderData.shipping_options) orderData.shipping_options = {};
                orderData.shipping_options.shipping_option = stepDiv.querySelector('[name="shipping_option"]:checked') ? stepDiv.querySelector('[name="shipping_option"]:checked').value : '';
            } else if (step === 8) {
                orderData.consent = {
                    signature: stepDiv.querySelector('[name="signature"]')?.value || ''
                };
            } else if (step === 9) {
                orderData.payment_details = {
                    promo_code: stepDiv.querySelector('[name="promo_code"]')?.value || '',
                    card_number: stepDiv.querySelector('[name="card_number"]')?.value || '',
                    expiry_date: stepDiv.querySelector('[name="expiry_date"]')?.value || '',
                    cvv: stepDiv.querySelector('[name="cvv"]')?.value || '',
                    cardholder_name: stepDiv.querySelector('[name="cardholder_name"]')?.value || ''
                };
            }
        }

        function validateField(input, message) {
            if (!input) return false;
            const errorDiv = input.parentElement.querySelector('.input-error');
            if (!input.value || (input.type === 'checkbox' && !input.checked)) {
                input.style.borderColor = 'red';
                if (errorDiv) {
                    errorDiv.textContent = message;
                    errorDiv.style.display = 'block';
                }
                return false;
            } else {
                input.style.borderColor = '';
                if (errorDiv) {
                    errorDiv.textContent = '';
                    errorDiv.style.display = 'none';
                }
                return true;
            }
        }

        function validateStep(step) {
            let stepDiv = document.querySelector('.order-step[data-step="' + step + '"]');
            let valid = true;
            if (!stepDiv) return false;
            if (step === 1) {
                valid = validateField(stepDiv.querySelector('[name="weight_loss_goals"]'), 'This field is required.') && valid;
                valid = stepDiv.querySelector('[name="weight_loss_initiatives[]"]')?.selectedOptions.length > 0 ? valid : (function(){
                    let el = stepDiv.querySelector('[name="weight_loss_initiatives[]"]');
                    let errorDiv = el.parentElement.querySelector('.input-error');
                    el.style.borderColor = 'red';
                    if (errorDiv) { errorDiv.textContent = 'This field is required.'; errorDiv.style.display = 'block'; }
                    return false;
                })();
                valid = validateField(stepDiv.querySelector('[name="doctor_visit"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="weight_lbs"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="height_feet"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="height_inches"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="conditions"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="exercise_frequency"]'), 'This field is required.') && valid;
                // exercise_type is nullable
                // medications[] (checkboxes)
                let meds = stepDiv.querySelectorAll('[name="medications[]"]:checked');
                let medsGroup = stepDiv.querySelector('.checkbox-group');
                let medsErrorDiv = medsGroup ? medsGroup.querySelector('.input-error') : null;
                if (meds.length === 0) {
                    if (medsErrorDiv) { medsErrorDiv.textContent = 'This field is required.'; medsErrorDiv.style.display = 'block'; }
                    valid = false;
                } else {
                    if (medsErrorDiv) { medsErrorDiv.textContent = ''; medsErrorDiv.style.display = 'none'; }
                }
                valid = validateField(stepDiv.querySelector('[name="gallbladder_issues"]'), 'This field is required.') && valid;
                // pancreatitis, kidney_disease, sleep_apnea are nullable
            } else if (step === 3) {
                valid = validateField(stepDiv.querySelector('[name="previous_purchase"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="prescription_increase"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="b12_importance"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="add_b12"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="glycine_importance"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="glp1_issues"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="add_nausea_med"]'), 'This field is required.') && valid;
            } else if (step === 4) {
                valid = validateField(stepDiv.querySelector('[name="shipping_address1"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="shipping_city"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="shipping_state"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="shipping_zip"]'), 'This field is required.') && valid;
                // billing fields are nullable
            } else if (step === 5) {
                // medication_requests (radio)
                let rx = stepDiv.querySelector('[name="requested_rx"]:checked');
                if (!rx) {
                    let group = stepDiv.querySelector('[name="requested_rx"]').closest('div');
                    let errorDiv = group.querySelector('.input-error');
                    if (errorDiv) { errorDiv.textContent = 'This field is required.'; errorDiv.style.display = 'block'; }
                    valid = false;
                } else {
                    let group = stepDiv.querySelector('[name="requested_rx"]');
                    let errorDiv = group.closest('div').querySelector('.input-error');
                    if (errorDiv) { errorDiv.textContent = ''; errorDiv.style.display = 'none'; }
                }
            } else if (step === 7) {
                // shipping_option (radio)
                let ship = stepDiv.querySelector('[name="shipping_option"]:checked');
                if (!ship) {
                    let group = stepDiv.querySelector('[name="shipping_option"]');
                    let errorDiv = group.closest('div').querySelector('.input-error');
                    if (errorDiv) { errorDiv.textContent = 'This field is required.'; errorDiv.style.display = 'block'; }
                    valid = false;
                } else {
                    let group = stepDiv.querySelector('[name="shipping_option"]');
                    let errorDiv = group.closest('div').querySelector('.input-error');
                    if (errorDiv) { errorDiv.textContent = ''; errorDiv.style.display = 'none'; }
                }
            } else if (step === 8) {
                valid = validateField(stepDiv.querySelector('[name="signature"]'), 'This field is required.') && valid;
            } else if (step === 9) {
                valid = validateField(stepDiv.querySelector('[name="card_number"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="expiry_date"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="cvv"]'), 'This field is required.') && valid;
                valid = validateField(stepDiv.querySelector('[name="cardholder_name"]'), 'This field is required.') && valid;
            }
            return valid;
        }

        // Example: Safe Datamap initialization
        document.addEventListener('DOMContentLoaded', function() {
            var mapContainer = document.getElementById('map');
            if (mapContainer) {
                // Initialize Datamap here
            } else {
            }
            showStep(currentStep);
            updateDebugInfo();
            document.getElementById('prevBtn').addEventListener('click', function() {
                let stepDiv = document.querySelector('.order-step[data-step="' + currentStep + '"]');
                if (!stepDiv) {
                    return;
                }
                if (currentStep > 1) {
                    saveStepData(currentStep);
                    currentStep--;
                    showStep(currentStep);
                }
            });
            document.getElementById('nextBtn').addEventListener('click', function() {
                if (!validateStep(currentStep)) {
                    return;
                }
                saveStepData(currentStep);
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
            document.getElementById('submitBtn').addEventListener('click', function(e) {
                if (!validateStep(currentStep)) {
                    return;
                }
                saveStepData(currentStep);
                // Remove fetch, use standard form submission
                // Create a hidden form if not present
                let form = document.getElementById('finalOrderForm');
                if (!form) {
                    form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/orders';
                    form.id = 'finalOrderForm';
                    // Add CSRF token
                    let csrf = document.querySelector('input[name="_token"]');
                    if (csrf) {
                        let csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrf.value;
                        form.appendChild(csrfInput);
                    }
                    document.body.appendChild(form);
                } else {
                    form.innerHTML = '';
                }
                // Helper to add fields recursively
                function appendFields(obj, prefix) {
                    for (let key in obj) {
                        if (!obj.hasOwnProperty(key)) continue;
                        let value = obj[key];
                        let name = prefix ? prefix + '[' + key + ']' : key;

                        // Fix for boolean fields
                        if (name === 'notice_acknowledged' || name === 'shipping_options[billing_same_as_shipping]') {
                            value = value ? 1 : 0;
                        }

                        if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
                            appendFields(value, name);
                        } else if (Array.isArray(value)) {
                            value.forEach((v, i) => {
                                if (typeof v === 'object') {
                                    appendFields(v, name + '[' + i + ']');
                                } else {
                                    let input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = name + '[]';
                                    input.value = v;
                                    form.appendChild(input);
                                }
                            });
                        } else {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = name;
                            input.value = value;
                            form.appendChild(input);
                        }
                    }
                }
                appendFields(orderData, '');
                form.submit();
            });
        });
        </script>
@endsection

@push('scripts')
    <script>
    </script>
@endpush

@push('styles')
    <style>
        .form-control {
            @apply border-gray-300 rounded-md p-2 w-full;
        }
        .btn {
            @apply px-4 py-2 rounded-md font-semibold;
        }
        .btn-primary {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }
        .btn-secondary {
            @apply bg-gray-500 text-white hover:bg-gray-600;
        }
        .btn-info {
            @apply bg-blue-500 text-white hover:bg-blue-600;
        }
        .btn-light {
            @apply bg-white text-pink-600 border border-pink-600 hover:bg-pink-50;
        }
        .alert {
            @apply bg-yellow-100 border border-yellow-400 text-yellow-700 p-4 rounded-md;
        }
        .disabled {
            @apply opacity-50 cursor-not-allowed;
        }
    </style>
@endpush
