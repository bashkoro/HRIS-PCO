<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'unit_kerja' => ['nullable', 'string', 'max:255'],
            'status_pns' => ['nullable', 'in:PNS,Non-PNS,Kontrak'],
            'status_kepegawaian' => ['nullable', 'string', 'max:255'],
            'sisa_cuti' => ['nullable', 'integer', 'min:0', 'max:30'],
        ];
    }
}
