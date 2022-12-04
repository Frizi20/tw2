@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.surveyResult.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.survey-results.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="departament_id">{{ trans('cruds.surveyResult.fields.departament') }}</label>
                <select class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}" name="departament_id" id="departament_id">
                    @foreach($departaments as $id => $entry)
                        <option value="{{ $id }}" {{ old('departament_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('departament'))
                    <div class="invalid-feedback">
                        {{ $errors->first('departament') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyResult.fields.departament_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.surveyResult.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyResult.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="schema_results">{{ trans('cruds.surveyResult.fields.schema_results') }}</label>
                <input class="form-control {{ $errors->has('schema_results') ? 'is-invalid' : '' }}" type="text" name="schema_results" id="schema_results" value="{{ old('schema_results', '') }}">
                @if($errors->has('schema_results'))
                    <div class="invalid-feedback">
                        {{ $errors->first('schema_results') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyResult.fields.schema_results_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection