@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.dimensiune.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.dimensiunes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="dimensiune">{{ trans('cruds.dimensiune.fields.dimensiune') }}</label>
                <input type="text" class="form-control {{ $errors->has('dimensiune') ? 'is-invalid' : '' }}" name="dimensiune" id="dimensiune" required>{{ old('dimensiune') }}
                @if($errors->has('dimensiune'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dimensiune') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dimensiune.fields.dimensiune_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="departaments">{{ trans('cruds.dimensiune.fields.departament') }}</label>
                <select class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}" name="departaments[]" id="departaments" required multiple>
                    @foreach($departaments as $id => $entry)
                        <option value="{{ $id }}" {{ old('departaments') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('departament'))
                    <div class="invalid-feedback">
                        {{ $errors->first('departament') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dimensiune.fields.departament_helper') }}</span>
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
