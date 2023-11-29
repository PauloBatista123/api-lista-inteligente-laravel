<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListaCreateRequest extends FormRequest
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
            'tag' => 'required|max:50',
            'prazo_final' => 'required|date|after:tomorrow'
        ];
    }

    public function messages()
    {
        return [
            'tag.required' => 'O campo tag é obrigatório',
            'prazo_final.required' => 'O campo prazo final é obrigatório',
            'prazo_final.after' => 'O prazo final deve ser maior que a data de hoje'
        ];
    }

    public function withValidator($validator){
        if($validator->fails()){
            throw new HttpResponseException(response()->json([
                'message' => 'Ops! Algum campo não foi preenchido corretamente!',
                'status' => false,
                'errors' => $validator->errors(),
            ], 404));
        }
    }
}
