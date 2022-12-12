<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'category_id' => 'required',
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'post_date' => 'nullable|date',
            'tag_id' => 'required|array',
            
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'please enter a valid category',
            'title.required' => 'please enter a valid title',
            'image.required' => 'upload a valid image',
            'description.required' => 'input your description',
            'post_date' => 'nullable|date',
        ];
    }

   
}
