<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'numeric', 'digits:11'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'وارد کردن شماره تلفن الزامی است.',
            'phone.numeric' => 'شماره تلفن باید فقط شامل اعداد باشد.',
            'phone.digits' => 'شماره تلفن باید دقیقاً 11 رقم باشد.',
        ];
    }
}
