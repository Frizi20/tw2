@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.surveyBuilder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.survey-builders.update", [$surveyBuilder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="departamente_id">{{ trans('cruds.surveyBuilder.fields.departamente') }}</label>
                <select class="form-control select2 {{ $errors->has('departamente') ? 'is-invalid' : '' }}" name="departamente_id" id="departamente_id">
                    @foreach($departamentes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('departamente_id') ? old('departamente_id') : $surveyBuilder->departamente->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('departamente'))
                    <div class="invalid-feedback">
                        {{ $errors->first('departamente') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.departamente_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="schema">{{ trans('cruds.surveyBuilder.fields.schema') }}</label>
                <input class="form-control {{ $errors->has('schema') ? 'is-invalid' : '' }}" type="text" name="schema" id="schema" value="{{ old('schema', $surveyBuilder->schema) }}">
                @if($errors->has('schema'))
                    <div class="invalid-feedback">
                        {{ $errors->first('schema') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.schema_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('generala') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="generala" value="0">
                    <input class="form-check-input" type="checkbox" name="generala" id="generala" value="1" {{ $surveyBuilder->generala || old('generala', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="generala">{{ trans('cruds.surveyBuilder.fields.generala') }}</label>
                </div>
                @if($errors->has('generala'))
                    <div class="invalid-feedback">
                        {{ $errors->first('generala') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.generala_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="categorie_de_control_id">{{ trans('cruds.surveyBuilder.fields.categorie_de_control') }}</label>
                <select class="form-control select2 {{ $errors->has('categorie_de_control') ? 'is-invalid' : '' }}" name="categorie_de_control_id" id="categorie_de_control_id" required>
                    @foreach($categorie_de_controls as $id => $entry)
                        <option value="{{ $id }}" {{ (old('categorie_de_control_id') ? old('categorie_de_control_id') : $surveyBuilder->categorie_de_control->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('categorie_de_control'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categorie_de_control') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.categorie_de_control_helper') }}</span>
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