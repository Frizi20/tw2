<?php

namespace App\Http\Requests;

use App\Models\Departamente;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDepartamenteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('departamente_edit');
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
