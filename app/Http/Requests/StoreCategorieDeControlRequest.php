<?php

namespace App\Http\Requests;

use App\Models\CategorieDeControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCategorieDeControlRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('categorie_de_control_create');
    }

    public function rules()
    {
        return [
            'nume' => [
                'string',
                'required',
            ],
        ];
    }
}
