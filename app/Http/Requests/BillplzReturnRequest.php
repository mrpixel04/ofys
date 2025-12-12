<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'amount' => ['nullable', 'integer'],
            'paid_amount' => ['nullable', 'integer'],
            'transaction_id' => ['nullable', 'string'],
            'x_signature' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Log validation errors
        \Log::warning('Billplz return validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
        ]);

        // Redirect to customer bookings with error instead of throwing exception
        throw new HttpResponseException(
            redirect()->route('customer.bookings')
                ->with('error', 'Payment verification failed. Please contact support if payment was deducted.')
        );
    }
}
