<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSaleInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' =>['required','integer',Rule::exists('users','id')],
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'ref' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
            'is_paid' => 'required|in:0,1',

            'items' => 'required|array|min:1',
            'items.*.delivery_note_id'    => 'required|integer|exists:delivery_notes,id',
            'items.*.discount' => 'required|numeric|min:0',
            'items.*.tax' => 'required|numeric|min:0',

            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:1000',           

        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422)
        );

    }

}
