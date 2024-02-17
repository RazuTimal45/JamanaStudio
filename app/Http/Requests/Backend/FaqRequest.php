<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            'question' => 'required',
            'answer' => 'required',
            'rank' => 'required',
        ];
    }
    public function messages():array
    {
        return [
         'question.required'=>'Enter Question',
            'answer.required'=>'Enter Answer',
            'rank.required'=>'Enter rank',
        ];
    }
}
