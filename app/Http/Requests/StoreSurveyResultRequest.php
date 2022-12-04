<?php

namespace App\Http\Requests;

use App\Models\SurveyResult;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSurveyResultRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('survey_result_create');
    }

    public function rules()
    {
        return [
            'schema_results' => [
                'string',
                'nullable',
            ],
        ];
    }
}
