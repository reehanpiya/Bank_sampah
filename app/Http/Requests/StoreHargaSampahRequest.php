<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHargaSampahRequest extends FormRequest
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
            'jenis_sampah_id' => [
                'required',
                'integer',
                'exists:jenis_sampah,id',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tanggal_berlaku' => [
                'required',
                'date',
            ],

            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_berlaku',
            ],

            'status_aktif' => [
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
            'jenis_sampah_id.required' => 'Jenis sampah wajib dipilih.',
            'jenis_sampah_id.exists'   => 'Jenis sampah tidak ditemukan.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric'  => 'Harga harus berupa angka.',
            'harga.min'      => 'Harga tidak boleh negatif.',

            'tanggal_berlaku.required' => 'Tanggal berlaku wajib diisi.',

            'tanggal_berakhir.after_or_equal' =>
                'Tanggal berakhir harus sama atau setelah tanggal berlaku.',
        ];
    }
}