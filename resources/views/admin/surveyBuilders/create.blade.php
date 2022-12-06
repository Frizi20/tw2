@extends('layouts.admin')
@section('content')

@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('css/surveyBuilder.css') }}">
@endsection

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.surveyBuilder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.survey-builders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="departamente_id">{{ trans('cruds.surveyBuilder.fields.departamente') }}</label>
                <select class="form-control select2 {{ $errors->has('departamente') ? 'is-invalid' : '' }}" name="departamente_id" id="departamente_id">
                    @foreach($departamentes as $id => $entry)
                        <option value="{{ $id }}" {{ old('departamente_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('departamente'))
                    <div class="invalid-feedback">
                        {{ $errors->first('departamente') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.departamente_helper') }}</span>
            </div>

            <div class="form-group ">
                <div class="form-check {{ $errors->has('generala') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="generala" value="0">
                    <input class="form-check-input" type="checkbox" name="generala" id="generala" value="1" {{ old('generala', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="generala">{{ trans('cruds.surveyBuilder.fields.generala') }}</label>
                </div>
                @if($errors->has('generala'))
                    <div class="invalid-feedback">
                        {{ $errors->first('generala') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.generala_helper') }}</span>
            </div>

            <div class="form-group dimensions">
                <label class="required" for="dimensions">Dimensiune </label>
                <select class="form-control select2 {{ $errors->has('dimension') ? 'is-invalid' : '' }}" name="dimensiune_id" id="dimensions" required>
                    {{-- @foreach($dimensions as $id => $entry)
                        <option value="{{ $id }}" {{ old('dimension') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach --}}
                </select>
                @if($errors->has('dimension'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categorie_de_control') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.categorie_de_control_helper') }}</span>
            </div>
            <div class="form-group control-category">
                <label class="required" for="categorie_de_control_id">{{ trans('cruds.surveyBuilder.fields.categorie_de_control') }}</label>
                <select class="form-control select2 {{ $errors->has('categorie_de_control') ? 'is-invalid' : '' }}" name="categorie_de_control_id" id="categorie_de_control_id" required>
                    @foreach($categorie_de_controls as $id => $entry)
                        <option value="{{ $id }}" {{ old('categorie_de_control_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('categorie_de_control'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categorie_de_control') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.categorie_de_control_helper') }}</span>
            </div>

            <div class="form-builder-wrapper">
                <div class="form-builder-container">
                    <div class="form-builder-header">
                        <div class="form-field-label">
                            Intrebari
                        </div>
                        <div class="add-form-field btn">
                            <span>Add +</span>
                        </div>
                    </div>
                    <div class="form-builder">

                        <div class="update-form btn"></div>
                    </div>
                    <div class="save-schema btn">
                        <span>Save</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="schema">{{ trans('cruds.surveyBuilder.fields.schema') }}</label>
                <input class="form-control {{ $errors->has('schema') ? 'is-invalid' : '' }}" type="text" name="schema" id="schema" value="{{ old('schema', '') }}">
                @if($errors->has('schema'))
                    <div class="invalid-feedback">
                        {{ $errors->first('schema') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.schema_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>


<script src="{{ asset('js/surveyBuilder.js') }}"></script>


@section('scripts')
@parent
<script>

    const dimensions = $('.dimensions')
    const controlCategory = $('.control-category')
    const departamentSelect = $('#departamente_id')

    const dimensionSelect = $('.dimensions .select2')

    dimensions.css('display','none')
    controlCategory.css('display','none')

    departamentSelect.on('change',function(){
        const depId = $(this).val()

        //empty dimension select options
        dimensionSelect.empty().trigger("change")


        if($(this).val()){
           //show dimension
           getDimensionsForDepartament(depId,dimensionSelect,dimensions)
        //    dimensions.css('display','block')
        }else{
            dimensions.css('display','none')
            controlCategory.css('display','none')

            // formBuilderWrapper.css('display','block')
        }
    })


    async function getDimensionsForDepartament(depId,selectEl,selectedContainer){


        try {

            const response = await fetch('/admin/survey-builders/get-dimensions', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
                    },
                body: JSON.stringify({
                    depId:depId
                })
            });

            if(!response.ok) throw new Error('Dimensions could not be fetched')

            const dimensions = await response.json();


            selectedContainer.css('display','block')
            controlCategory.css('display','block')

            const pleaseSelectOption = new Option('Please Select','',false,false)
            selectEl.append(pleaseSelectOption).trigger('change')

            Object.entries(dimensions).forEach(dimension =>{
                const [id, name] = dimension
                const newOption = new Option(name, id, false, false);

                selectEl.append(newOption).trigger('change');
            })


        } catch (error) {
            console.log(error)
        }

    }





</script>
@endsection


@endsection
