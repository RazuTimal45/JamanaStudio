<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioVideoRequest extends FormRequest
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
            'title' => 'required',
            'rank' => 'required',
            'video_url' => 'required',
        ];
        if($this->isMethod('post')){
            $rules['image_thumbnail']='required';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required'=>'Enter name',
            'rank.required'=>'Enter rank',
            'image_thumbnail.required'=>'Upload thumbnail image',
            'video_url.required' => 'Enter video url using iframe',
        ];
    }
}
