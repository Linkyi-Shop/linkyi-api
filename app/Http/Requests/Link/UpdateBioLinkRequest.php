<?php

namespace App\Http\Requests\Link;

use App\Helpers\ResponseJson;
use App\Helpers\Sanitizer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBioLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'link' => ['sometimes', 'url', 'max:700', 'not_shortlink'],
            'name' => 'required|max:40',
            'is_active' => 'required|in:1,0'
        ];
    }

    public function messages(): array
    {
        return [
            'link.url' => 'Link harus berupa URL yang valid.',
            'link.max' => 'Link tidak boleh lebih dari 700 karakter.',
            'link.not_shortlink' => 'Untuk menjaga kenyamanan pengunjung toko anda, kami tidak mengizinkan link yang berasal dari domain shortlink.',
            'name.required' => 'Text tautan perlu diisi.',
            'name.max' => 'Text tautan tidak boleh lebih dari 40 karakter.',
            'is_active.required' => 'Status perlu diisi.',
            'is_active.in' => 'Status tidak valid',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        foreach ($errors as $field => $message) {
            throw new HttpResponseException(ResponseJson::failedResponse("field error", [$field => $message[0]]));
        }
    }
    public function withValidator($validator)
    {
        $validator->addImplicitExtension('not_shortlink', function ($attribute, $value, $parameters, $validator) {
            return CreateBioLinkRequest::isForbiddenShortlink($value);
        });
    }

    // Fungsi untuk memeriksa apakah domain shortlink ada dalam URL
    public static function isForbiddenShortlink($url)
    {
        return Sanitizer::forbiddenShortlink($url);
    }
}
