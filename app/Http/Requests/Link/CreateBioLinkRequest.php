<?php

namespace App\Http\Requests\Link;

use App\Helpers\Sanitizer;
use App\Helpers\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBioLinkRequest extends FormRequest
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
            'link' => ['required_if:type,link', 'url', 'max:700', 'not_shortlink'],
            'name' => 'required|max:40',
            'type' => 'required|in:headline,link'
        ];
    }
    public function messages(): array
    {
        return [
            'link.required_if' => 'Link perlu diisi.',
            'link.url' => 'Link harus berupa URL yang valid.',
            'link.max' => 'Link tidak boleh lebih dari 700 karakter.',
            'link.not_shortlink' => 'Untuk menjaga kenyamanan pengunjung toko anda kami tidak mengizinkan link yang berasal dari domain shortlink.',
            'name.required' => 'Text tautan perlu diisi.',
            'name.max' => 'Text tautan tidak boleh lebih dari 40 karakter.',
            'type.required' => 'Tipe perlu diisi.',
            'type.in' => 'Tipe harus salah satu dari: headline, link.'
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
