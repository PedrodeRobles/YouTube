<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
        return [
            'title'       => 'required|max:200',
            'image'       => [
                'image',
                $this->route('video') ? 'nullable' : "required"
            ],
            'video'       => [
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
                'max:60000',
                $this->route('video') ? 'nullable' : "required"
            ],
            'description' => 'max:1000',
            'category_id' => 'required',
        ];
    }
}
