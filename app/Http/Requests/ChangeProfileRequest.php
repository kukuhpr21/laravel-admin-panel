<?php

namespace App\Http\Requests;

use App\Utils\SessionUtils;
use Illuminate\Foundation\Http\FormRequest;

class ChangeProfileRequest extends FormRequest
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
            'name'  => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
        ];
    }
}
