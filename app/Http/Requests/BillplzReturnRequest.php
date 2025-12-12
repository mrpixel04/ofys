<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillplzReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Billplz sends return payload under "billplz" key
        $billplz = (array) $this->input('billplz', []);
        $this->merge($billplz);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'paid' => ['required', 'in:true,false'],
            'amount' => ['required', 'integer'],
            'paid_amount' => ['nullable', 'integer'],
            'transaction_id' => ['nullable', 'string'],
            'x_signature' => ['required', 'string'],
        ];
    }
}
