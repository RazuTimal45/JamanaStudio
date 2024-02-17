<?php

namespace App\Http\Requests\Backend;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email',
            'phone' => 'required|starts_with:98,97|digits:10',
            'starting_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    // Check if the date is after today's midnight
                    $afterMidnight = Carbon::today()->addDay()->startOfDay();
                    if (Carbon::parse($value)->lessThan($afterMidnight)) {
                        $fail('The '.$attribute.' should be tomorrow or afterwards');
                    }
                },
            ],
            'ending_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    // Check if the date is after today's midnight
                    $afterMidnight = Carbon::today()->addDay()->startOfDay();
                    if (Carbon::parse($value)->lessThan($afterMidnight)) {
                        $fail('The '.$attribute.' should be tomorrow or afterwards');
                    }
                },
                'after_or_equal:starting_date', // Ensures ending_date is not less than starting_date
            ],
            'service_id' => 'required',
            'message' => 'required',
        ];
    }
    function messages():array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.regex' => 'Name should only contain alphabets and spaces.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'phone.starts_with' => 'Phone number should start with either 98 or 97.',
            'phone.digits' => 'Phone number should be 10 digits long.',
            'starting_date.date' => 'Invalid date format.',
            'starting_date.custom' => 'Please select a date starting from tomorrow.',
            'starting_date.required_with' => 'The starting date is required',
            'ending_date.date' => 'Invalid date format for ending date.',
            'ending_date.after_or_equal' => 'The ending date should not be less than the starting date.',
            'ending_date.required_with' => 'The ending date is required',
            'service_id.required' => 'Please select a service.',
            'message.required' => 'Please enter your message.',
        ];
    }
}
