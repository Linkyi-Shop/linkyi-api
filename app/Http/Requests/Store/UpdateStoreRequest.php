<?php

namespace App\Http\Requests\Store;

use App\Helpers\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:50',
            'description' => 'sometimes|max:150',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama Toko Harus Diisi',
            'name.max' => 'Nama Toko Maksimal 50 Karakter',
            'description.max' => 'Deskripsi Maksimal 150 Karakter',
            'logo.image' => 'Logo Harus Berupa Gambar',
            'logo.mimes' => 'Logo Harus Berupa File Dengan Format: jpeg, png, jpg',
            'logo.max' => 'Logo Maksimal 2MB',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        foreach ($errors as $field => $message) {
            throw new HttpResponseException(ResponseJson::validationErrorResponse("field error", [$field => $message[0]]));
        }
    }
}
