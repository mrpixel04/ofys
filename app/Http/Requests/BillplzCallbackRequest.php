<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillplzCallbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'paid' => ['required', 'in:true,false'],
            'amount' => ['required', 'integer'],
            'paid_amount' => ['nullable', 'integer'],
            'transaction_id' => ['nullable', 'string'],
            'transaction_status' => ['nullable', 'string'],
            'collection_id' => ['nullable', 'string'],
            'x_signature' => ['required', 'string'],
        ];
    }
}
