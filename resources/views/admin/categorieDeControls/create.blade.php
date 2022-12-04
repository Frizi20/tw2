@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.categorieDeControl.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categorie-de-controls.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="nume">{{ trans('cruds.categorieDeControl.fields.nume') }}</label>
                <input class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}" type="text" name="nume" id="nume" value="{{ old('nume', '') }}" required>
                @if($errors->has('nume'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nume') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.categorieDeControl.fields.nume_helper') }}</span>
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