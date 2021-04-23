<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'weight' => 'nullable',
            'photo' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'description' => 'Descrição',
            'price' => 'Preço',
            'weight' => 'Peso',
            'photo' => 'Foto',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            //'name.min' => 'O campo :attribute deve conter pelo menos 5 caracteres',
            'numeric' => 'O campo :attribute deve ser numérico',
            'image' => 'O campo :attribute deve ser uma imagem',
        ];
    }
}
