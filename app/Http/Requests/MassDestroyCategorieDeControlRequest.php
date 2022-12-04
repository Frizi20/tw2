<?php

namespace App\Http\Requests;

use App\Models\CategorieDeControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategorieDeControlRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('categorie_de_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categorie_de_controls,id',
        ];
    }
}
