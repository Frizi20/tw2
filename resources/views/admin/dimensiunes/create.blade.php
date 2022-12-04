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
                <textarea class="form-control {{ $errors->has('dimensiune') ? 'is-invalid' : '' }}" name="dimensiune" id="dimensiune" required>{{ old('dimensiune') }}</textarea>
                @if($errors->has('dimensiune'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dimensiune') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.dimensiune.fields.dimensiune_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="departament_id">{{ trans('cruds.dimensiune.fields.departament') }}</label>
                <select class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}" name="departament_id" id="departament_id" required>
                    @foreach($departaments as $id => $entry)
                        <option value="{{ $id }}" {{ old('departament_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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