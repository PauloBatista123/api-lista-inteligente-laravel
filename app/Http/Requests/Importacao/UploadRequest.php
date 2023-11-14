<?php

namespace App\Http\Requests\Importacao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
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
            'arquivo' => 'required', File::types('application/vnd.ms-excel application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
            'lista' => 'nullable|exists:App\Models\Lista,id',
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
