<?php

namespace App\Http\Requests;

use App\Models\SurveyBuilder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSurveyBuilderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('survey_builder_edit');
    }

    public function rules()
    {
        return [
            'schema' => [
                'string',
                'nullable',
            ],
            'categorie_de_control_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
