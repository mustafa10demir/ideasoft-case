<?php

namespace App\Http\Requests\Discount;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DiscountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'orderId' => 'required|integer|min:1',
        ];
    }

    /**
     * Error message list
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'orderId.required' => 'Order Id is required.',
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
