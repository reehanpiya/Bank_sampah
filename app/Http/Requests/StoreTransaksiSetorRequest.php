<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Support\Facades\Auth;

class StoreTransaksiSetorRequest extends FormRequest
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
        $rules = [

            'bsu_id' => [
                'required',
                'integer',
                'exists:bsu,id',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.jenis_sampah_id' => [
                'required',
                'integer',
                'exists:jenis_sampah,id',
            ],

            'items.*.berat' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],
        ];

        if (auth()->user()->role === 'admin_bsu') {

            $rules['nasabah_id'] = [
                'required',
                'exists:nasabah,id',
            ];

        } else {

            $rules['nasabah_id'] = [
                'nullable',
                'exists:nasabah,id',
            ];
        }

        return $rules;
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'bsu_id.required' => 'BSU wajib dipilih.',
            'bsu_id.exists'   => 'BSU tidak ditemukan.',

            'nasabah_id.required' => 'Nasabah wajib dipilih.',
            'nasabah_id.exists'   => 'Nasabah tidak ditemukan.',

            'items.required' => 'Detail setoran wajib diisi.',
            'items.array'    => 'Format detail setoran tidak valid.',
            'items.min'      => 'Minimal harus ada 1 jenis sampah yang disetor.',

            'items.*.jenis_sampah_id.required' =>
                'Jenis sampah wajib dipilih.',

            'items.*.jenis_sampah_id.exists' =>
                'Jenis sampah tidak ditemukan.',

            'items.*.berat.required' =>
                'Berat sampah wajib diisi.',

            'items.*.berat.numeric' =>
                'Berat harus berupa angka.',

            'items.*.berat.gt' =>
                'Berat harus lebih besar dari 0.',
        ];
    }
}