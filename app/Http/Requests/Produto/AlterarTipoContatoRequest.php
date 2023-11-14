<?php

namespace App\Http\Requests\Produto;

use App\Http\Interfaces\TabelaModel;
use App\Http\Interfaces\TabelaProdutos;
use App\Http\Interfaces\TipoContatoInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AlterarTipoContatoRequest extends FormRequest
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
            'tipoContato' => ['required', Rule::enum(TipoContatoInterface::class)],
        ];
    }

    public function withValidator($validator){

        if($validator->fails()){
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo não foi preenchido corretamente!',
                'status' => false,
                'errors' => $validator->errors(),
            ], 404));
        }
    }
}
