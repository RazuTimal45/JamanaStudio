<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioImageRequest extends FormRequest
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
            'title' => 'required',
            'rank' => 'required',
            'short_description' => 'required|max:100',
        ];

        if ($this->isMethod('post')) {
            $rules['image_file'] = 'required';
        }

        return $rules;
    }
    function messages():array
    {
       return [
           'title.required'=>'Enter title',
           'rank.required'=>'Enter rank',
           'short_description.required'=>'Enter short description',
           'short_description.max' => 'Short Description must be less than 100 characters',
           'image_file.required'=>'Upload Image',
       ];
    }
}
