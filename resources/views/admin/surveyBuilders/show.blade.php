@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.surveyBuilder.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.survey-builders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.id') }}
                        </th>
                        <td>
                            {{ $surveyBuilder->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.departamente') }}
                        </th>
                        <td>
                            {{ $surveyBuilder->departamente->nume ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.schema') }}
                        </th>
                        <td>
                            {{ $surveyBuilder->schema }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.generala') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $surveyBuilder->generala ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.categorie_de_control') }}
                        </th>
                        <td>
                            {{ $surveyBuilder->categorie_de_control->nume ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.survey-builders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection