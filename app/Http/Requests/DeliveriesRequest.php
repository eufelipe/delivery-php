<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Constants\Constants;

class DeliveriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client' => 'required|min:3|max:255',
            'delivery_date' => 'required|date',
            'target_start' => 'required|min:3|max:255',
            'target_end' => 'required|min:3|max:255',
        ];
    }



    /**
     * translate error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client.required' => trans('deliveries.validator.client.required'),
            'client.min' => trans('deliveries.validator.client.min'),
            'client.max' => trans('deliveries.validator.client.max'),

            'delivery_date.required' => trans('deliveries.validator.delivery_date.required'),
            'delivery_date.date' => trans('deliveries.validator.delivery_date.date'),

            'target_start.required' => trans('deliveries.validator.target_start.required'),
            'target_start.min' => trans('deliveries.validator.target_start.min'),
            'target_start.max' => trans('deliveries.validator.target_start.max'),

            'target_end.required' => trans('deliveries.validator.target_end.required'),
            'target_end.min' => trans('deliveries.validator.target_end.min'),
            'target_end.max' => trans('deliveries.validator.target_end.max'),
        ];
    }


        /**
     * Intercepta o response de error e customiza o output.
     *
     * @param Validator;
     * @return \Illuminate\Http\Exceptions\HttpResponseException
     *
     */
    protected function failedValidation($validator)
    {
        $message = trans('deliveries.validator.message');
        $description =  $validator->errors()->first();
        $status = Constants::UNPROCESSABLE_ENTITY;

        $response = [
            "message" => $message,
            "description" => $description
        ];

        throw new HttpResponseException(response()->json($response, $status));
    }

}
