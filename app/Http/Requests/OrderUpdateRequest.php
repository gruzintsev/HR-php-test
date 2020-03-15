<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
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
            'client_email' => 'required|email',
            'partner_id' => [
                'required',
                Rule::exists('partners','id'),
            ],
            'status' => [
                'required',
                Rule::in(array_keys(Order::statuses()))
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_email.required' => 'Client email is required',
            'client_email.email' => 'Client email must be a valid email',
            'partner_id.required' => 'Partner is required',
            'partner_id.exists' => 'Such partner does not exists',
            'status.required' => 'Status is required',
            'status.in' => 'Status is wrong',
        ];
    }
}