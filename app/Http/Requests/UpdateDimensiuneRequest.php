<?php

namespace App\Http\Requests;

use App\Models\Dimensiune;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDimensiuneRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dimensiune_edit');
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
