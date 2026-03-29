<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'recipient_email' => 'required|string|email|exists:users,email',
            'amount' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'recipient_email.required' => 'O campo email do destinatário é obrigatório.',
            'recipient_email.email' => 'O campo email do destinatário deve ser um endereço de email válido.',
            'recipient_email.exists' => 'O destinatário com o email fornecido não existe.',
            'amount.required' => 'O campo valor é obrigatório.',
            'amount.numeric' => 'O campo valor deve ser um número.',
            'amount.min' => 'O valor mínimo para transferência é 1 centavo.',
        ];
    }
}
