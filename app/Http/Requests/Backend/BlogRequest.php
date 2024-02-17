<?php

namespace App\Http\Requests\backend;

use Illuminate\Foundation\Http\FormRequest;


class BlogRequest extends FormRequest
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
        $rules= [
            'event_date'=>['required', 'date', 'before_or_equal:' . now()->format('Y-m-d')],
            'event_type'=>'required',
            'event_title' => 'required',
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
            'event_date.required'=>'Enter date',
            'event_date.date'=>'Enter Valid date',
            'event_date.before_or_equal'=>'Enter date must be date before_or_equal',
            'event_type.required'=>'Enter Type',
            'event_title.required'=>'Enter title',
            'rank.required'=>'Enter rank',
            'first_description.required'=>'Enter first description',
            'image_file.required'=>'Upload image',
        ];
    }
}
