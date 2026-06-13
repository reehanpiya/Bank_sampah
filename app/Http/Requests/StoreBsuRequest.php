<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBsuRequest extends FormRequest
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
            'kode_bsu' => [
                'required',
                'string',
                'max:20',
                'unique:bsu,kode_bsu',
            ],

            'nama_bsu' => [
                'required',
                'string',
                'max:150',
            ],

            'ketua' => [
                'nullable',
                'string',
                'max:150',
            ],

            'alamat' => [
                'required',
                'string',
            ],

            'kecamatan' => [
                'required',
                'string',
                'max:100',
            ],

            'no_hp' => [
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
            'kode_bsu.required' => 'Kode BSU wajib diisi.',
            'kode_bsu.unique'   => 'Kode BSU sudah digunakan.',

            'nama_bsu.required' => 'Nama BSU wajib diisi.',

            'alamat.required'   => 'Alamat wajib diisi.',

            'kecamatan.required' => 'Kecamatan wajib diisi.',
        ];
    }
}