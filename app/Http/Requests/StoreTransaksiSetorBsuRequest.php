<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiSetorBsuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'bsu_id' => [
                'required',
                'exists:bsu,id'
            ],

            'items' => [
                'required',
                'array',
                'min:1'
            ],

            'items.*.jenis_sampah_id' => [
                'required',
                'exists:jenis_sampah,id'
            ],

            'items.*.berat' => [
                'required',
                'numeric',
                'min:0.01'
            ],

            'keterangan' => [
                'nullable',
                'string'
            ],
        ];
    }
}
