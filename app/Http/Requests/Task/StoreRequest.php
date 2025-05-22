<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'project_id' => 'required|integer:projects,id',
            'priority_id' => 'nullable|integer|exists:task_priorities,id',
            'contractor_id' => 'nullable|integer',

            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
        ];
    }
}
