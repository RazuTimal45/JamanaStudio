<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
        $rules = [
            'name' => 'required|regex:/^[^0-9]+$/',
            'rank' => 'required|numeric|min:0',
            'facebook' => 'required|url',
            'instagram' => 'required|url',
            'position' => 'required|max:60|regex:/^[^0-9]+$/',
        ];

        if ($this->isMethod('post')) {
            $rules['image_file'] = 'required';
        }

        return $rules;
    }
    function messages():array
    {
       return [
           'name.required'=>'Enter name of the team',
           'name.regex' => 'The name field cannot contain any digits.',
           'rank.required'=>'Enter rank',
           'rank.numeric' => 'The rank field must be a number.',
           'rank.min' => 'The rank field cannot contain negative numbers.',
           'facebook.required'=>'Enter facebook link',
           'facebook.url' => 'Invalid Facebook URL',
           'instagram.required'=>'Enter instagram link',
           'instagram.url' => 'Invalid Instagram URL',
           'position.required'=>'Enter position',
           'position.max'=>'The position field shouldn\'t contain more than 60character',
           'image_file'=>'Upload Image'
       ];
    }
}
