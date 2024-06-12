<?php

namespace App\Http\Requests\Profile;

use App\Helpers\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProfileActivationRequest extends FormRequest
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
            'name' => 'required|max:50',
            'username' => 'required|max:50',
            'description' => 'sometimes|max:150',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'sometimes|nullable|min:6|max:32'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Toko Harus Diisi',
            'name.max' => 'Nama Toko Maksimal 50 Karakter',
            'username.required' => 'Username Harus Diisi',
            'username.max' => 'Username Maksimal 50 Karakter',
            'description.max' => 'Deskripsi Maksimal 150 Karakter',
            'logo.image' => 'Logo Harus Berupa Gambar',
            'logo.mimes' => 'Logo Harus Berupa File Dengan Format: jpeg, png, jpg',
            'logo.max' => 'Logo Maksimal 2MB',
            'password.min' => 'Password Minimal 6 Karakter',
            'password.max' => 'Password Maksimal 32 Karakter',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        foreach ($errors as $field => $message) {
            throw new HttpResponseException(ResponseJson::failedResponse("field error", [$field => $message[0]]));
        }
    }
}
