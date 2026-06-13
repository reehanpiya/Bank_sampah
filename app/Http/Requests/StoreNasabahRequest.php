<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNasabahRequest extends FormRequest
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
            'bsu_id' => [
                'required',
                'integer',
                'exists:bsu,id',
            ],

            'nomor_nasabah' => [
                'required',
                'string',
                'max:30',
                'unique:nasabah,nomor_nasabah',
            ],

            'nik' => [
                'nullable',
                'string',
                'max:20',
            ],

            'nama' => [
                'required',
                'string',
                'max:150',
            ],

            'alamat' => [
                'required',
                'string',
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
            'bsu_id.required' => 'BSU wajib dipilih.',
            'bsu_id.exists'   => 'BSU tidak ditemukan.',

            'nomor_nasabah.required' => 'Nomor nasabah wajib diisi.',
            'nomor_nasabah.unique'   => 'Nomor nasabah sudah digunakan.',

            'nama.required' => 'Nama nasabah wajib diisi.',

            'alamat.required' => 'Alamat wajib diisi.',
        ];
    }
}