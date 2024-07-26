<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'items'             => 'required|array|min:1',
            'total'             => 'required|numeric',
            'items.*.productId' => 'required|integer',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unitPrice' => 'required|numeric',
            'items.*.total'     => 'required|numeric',
        ];
    }

    /**
     * Error message list
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'items.required'             => 'At least one item is required.',
            'total.required'             => 'Total required.',
            'items.*.productId.required' => 'Each item must have a product ID.',
            'items.*.quantity.required'  => 'Each item must have a quantity.',
            'items.*.unitPrice.required' => 'Each item must have a unit price.',
            'items.*.total.required'     => 'Each item must have a total.',
        ];
    }

    /**
     * @param Validator $validator
     *
     * @return mixed
     * @throws ValidationException
     */
    protected function failedValidation( Validator $validator )
    {
        $response = response()->json( [
            'errors' => $validator->errors(),
        ], 422 );

        throw new ValidationException( $validator, $response );
    }
}
