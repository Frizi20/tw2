<?php

namespace App\Http\Requests;

use App\Models\SurveyResult;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySurveyResultRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('survey_result_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:survey_results,id',
        ];
    }
}
