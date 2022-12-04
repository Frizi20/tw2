<?php

namespace App\Http\Requests;

use App\Models\Departamente;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDepartamenteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('departamente_create');
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
