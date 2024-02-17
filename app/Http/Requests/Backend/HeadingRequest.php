<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class HeadingRequest extends FormRequest
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
        return [
            'service' => 'required|max:50',
            'blogs' => 'required|max:50',
            'portfolio' => 'required|max:50',
            'contact' => 'required|max:50',
            'about' => 'required|max:50',
        ];
    }
    public function messages():array
    {
        return [
         'service.required'=>'Enter Service Heading Name',
         'service.max'=>'Name cannot be greater than 50characters',
            'blogs.required'=>'Enter Blog Heading Name',
         'blogs.max'=>'Name cannot be greater than 50characters',
            'portfolio.required'=>'Enter Portfolio Heading Name',
         'portfolio.max'=>'Name cannot be greater than 50characters',
            'contact.required'=>'Enter Contact Heading Name',
         'contact.max'=>'Name cannot be greater than 50characters',
            'about.required'=>'Enter About Heading Name',
            'about.max'=>'Name cannot be greater than 50characters',
        ];
    }
}
