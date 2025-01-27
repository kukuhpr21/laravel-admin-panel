<?php

namespace App\Http\Requests;

use App\Utils\SessionUtils;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class changePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $sessionUtils = new SessionUtils();
        return $sessionUtils->isExist();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'new_password'     => ['required', Password::min(6)->letters()->numbers()->symbols()],
            'confirm_password' => ['required'],
        ];
    }
}
