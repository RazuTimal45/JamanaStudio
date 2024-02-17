<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SocialServicesRequest extends FormRequest
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
            'facebook' => 'required|url',
            'linked_in' => 'required|url',
            'twitter' => 'required|url',
            'instagram' => 'required|url'
        ];
    }
    function messages()
    {
        return [
            'facebook.required' => 'Enter Facebook link',
            'facebook.url' => 'Invalid Facebook URL',
            'linked_in.required' => 'Enter LinkedIn link',
            'linked_in.url' => 'Invalid LinkedIn URL',
            'twitter.required' => 'Enter Twitter link',
            'twitter.url' => 'Invalid Twitter URL',
            'instagram.required' => 'Enter Instagram link',
            'instagram.url' => 'Invalid Instagram URL',
        ];
    }
}
