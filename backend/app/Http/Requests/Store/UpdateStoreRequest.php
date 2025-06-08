<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->whatsapp == $this->route('store')->whatsapp) {
            return [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'whatsapp' => 'required|string',
                'image' => 'image',
                'chave_pix' => 'required|string|max:255',
            ];
        }

        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'whatsapp' => 'required|string|unique:stores,whatsapp',
            'image' => 'image',
            'chave_pix' => 'required|string|max:255',
        ];
    }
}
