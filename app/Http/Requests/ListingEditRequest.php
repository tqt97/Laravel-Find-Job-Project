<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListingEditRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'tags' => 'required',
            'company' => ['required', Rule::unique('listings')->ignore($this->listing->id)],
            'location' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'description' => 'required',
            'logo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
