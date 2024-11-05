<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'language'=>['required',Rule::unique('languages','lang')->where(fn($query)=>$query->where('delete',0))],
            'name'=>['required',Rule::unique('languages','name')->where(fn($query)=>$query->where('delete',0))],
            'slug'=>['required',Rule::unique('languages','slug')->where(fn($query)=>$query->where('delete',0))],
        ];
    }
}
