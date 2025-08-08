<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChildRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermission('update_children');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:laki-laki,perempuan',
            'photo_url' => 'nullable|url',
            'background_story' => 'nullable|string',
            'education_level' => 'nullable|in:tk,sd,smp,sma,kuliah,lulus',
            'school_name' => 'nullable|string|max:255',
            'health_condition' => 'nullable|string',
            'special_needs' => 'nullable|string',
            'status' => 'required|in:aktif,alumni,pindah',
            'entry_date' => 'required|date',
            'exit_date' => 'nullable|date|after:entry_date',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama anak harus diisi.',
            'birth_date.required' => 'Tanggal lahir harus diisi.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.required' => 'Jenis kelamin harus dipilih.',
            'gender.in' => 'Jenis kelamin harus laki-laki atau perempuan.',
            'education_level.in' => 'Tingkat pendidikan tidak valid.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'entry_date.required' => 'Tanggal masuk harus diisi.',
            'exit_date.after' => 'Tanggal keluar harus setelah tanggal masuk.',
        ];
    }
}