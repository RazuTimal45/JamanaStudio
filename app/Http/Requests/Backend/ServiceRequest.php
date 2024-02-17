<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
    public function rules():array
    {
        $rules= [
            'title' => 'required',
            'first_description' => 'required',
            'rank'=>'required'
        ];
        if($this->isMethod('post')){
            $rules['image_file']='required';
        }
        return $rules;
    }
    public function messages():array
    {
        return [
            'title.required'=>'Enter title',
            'rank.required'=>'Enter rank',
            'first_description.required'=>'Enter first description',
            'image_file.required'=>'Upload image',

        ];
    }
}
