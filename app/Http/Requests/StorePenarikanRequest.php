<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenarikanRequest extends FormRequest
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

            'nasabah_id' => [
                'required',
                'integer',
                'exists:nasabah,id',
            ],

            'jumlah_tarik' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'bsu_id.required' =>
                'BSU wajib dipilih.',

            'bsu_id.exists' =>
                'BSU tidak ditemukan.',

            'nasabah_id.required' =>
                'Nasabah wajib dipilih.',

            'nasabah_id.exists' =>
                'Nasabah tidak ditemukan.',

            'jumlah_tarik.required' =>
                'Jumlah penarikan wajib diisi.',

            'jumlah_tarik.numeric' =>
                'Jumlah penarikan harus berupa angka.',

            'jumlah_tarik.gt' =>
                'Jumlah penarikan harus lebih besar dari 0.',
        ];
    }
}