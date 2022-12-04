<?php

namespace App\Http\Requests;

use App\Models\Dimensiune;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDimensiuneRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dimensiune_create');
    }

    public function rules()
    {
        return [
            'dimensiune' => [
                'required',
            ],
            'departament_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
