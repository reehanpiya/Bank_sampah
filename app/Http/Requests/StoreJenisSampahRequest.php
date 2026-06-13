<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisSampahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            'kode' => [
                'required',
                'string',
                'max:20',
                'unique:jenis_sampah,kode',
            ],

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'satuan' => [
                'nullable',
                'string',
                'max:20',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            'kode.required' => 'Kode jenis sampah wajib diisi.',
            'kode.unique'   => 'Kode jenis sampah sudah digunakan.',

            'nama.required' => 'Nama jenis sampah wajib diisi.',
        ];
    }
}