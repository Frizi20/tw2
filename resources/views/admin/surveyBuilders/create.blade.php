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
        <form method="POST" action="{{ (" ") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="departamente_id">{{ trans('cruds.surveyBuilder.fields.departamente') }}</label>
                <select class="form-control select2 {{ $errors->has('departamente') ? 'is-invalid' : '' }}"
                    name="departamente_id" id="departamente_id">
                    @foreach($departamentes as $id => $entry)
                    <option value="{{ $id }}" {{ old('departamente_id')==$id ? 'selected' : '' }}>{{ $entry }}</option>
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
                    <input class="form-check-input" type="checkbox" name="generala" id="generala" value="1" {{
                        old('generala', 0)==1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="generala">{{ trans('cruds.surveyBuilder.fields.generala')
                        }}</label>
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
                <select class="form-control select2 {{ $errors->has('dimension') ? 'is-invalid' : '' }}"
                    name="dimensiune_id" id="dimensions" required>
                    {{-- @foreach($dimensions as $id => $entry)
                    <option value="{{ $id }}" {{ old('dimension')==$id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <label class="required" for="categorie_de_control_id">{{
                    trans('cruds.surveyBuilder.fields.categorie_de_control') }}</label>
                <select class="form-control select2 {{ $errors->has('categorie_de_control') ? 'is-invalid' : '' }}"
                    name="categorie_de_control_id" id="categorie_de_control_id" required>
                    {{-- @foreach($categorie_de_controls as $id => $entry)
                    <option value="{{ $id }}" {{ old('categorie_de_control_id')==$id ? 'selected' : '' }}>{{ $entry }}
                    </option>
                    @endforeach --}}
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

            {{-- <div class="form-group">
                <label for="schema">{{ trans('cruds.surveyBuilder.fields.schema') }}</label>
                <input class="form-control {{ $errors->has('schema') ? 'is-invalid' : '' }}" type="text" name="schema"
                    id="schema" value="{{ old('schema', '') }}">
                @if($errors->has('schema'))
                <div class="invalid-feedback">
                    {{ $errors->first('schema') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyBuilder.fields.schema_helper') }}</span>
            </div> --}}

            {{-- <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div> --}}
        </form>
    </div>
</div>


<script src="{{ asset('js/surveyBuilder.js') }}"></script>


@section('scripts')
@parent
<script>
    const formBuilderWrapper = $('.form-builder-wrapper')

    const dimensions = $('.dimensions')
    const controlCategory = $('.control-category')
    const departamentSelect = $('#departamente_id')

    const dimensionSelect = $('.dimensions .select2')
    const controlCategorySerect = $('.control-category .select2')

    let builtForm

    let departament_id
    let dimension_id
    let control_category_id

    dimensions.css('display','none')
    controlCategory.css('display','none')
    formBuilderWrapper.css('display','none')


    //Get dimensions based on the departament selected
    departamentSelect.on('change',function(){
        const depId = $(this).val()
        departament_id = depId

        //empty dimension select options
        dimensionSelect.empty()

         //empty controll category select options
         controlCategorySerect.empty()

        //empty control categories select options
        // controlCategorySerect.empty().trigger('change')

        if(depId){
           //show dimension
           getDimensionsForDepartament(depId,dimensionSelect,dimensions)
        //    dimensions.css('display','block')
        }else{
            dimensions.css('display','none')
            controlCategory.css('display','none')
        }
    })

    //get control categories based on the dimension selected

    dimensionSelect.on('change',function(){
        const dimId = $(this).val();

        dimension_id = dimId

         //empty controll category select options
        controlCategorySerect.empty()

        if(!dimId || !departament_id) return

        (async function(){

            try {
                const response = await fetch('/admin/survey-builders/get-available-categories',{
                    method: 'POST',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body:JSON.stringify({
                        dep_id : departament_id,
                        dim_id : dimId
                    })
                })

                if(!response.ok) throw new Error('Categories could not be fetched')

                const categories = await response.json()

                console.log(categories)
                controlCategory.css('display','block')


                const pleaseSelectOption = new Option('Please Select','',false,false)

                controlCategorySerect.append(pleaseSelectOption)

                Object.entries(categories).forEach(category =>{
                    const [id, name] = category
                    const newOption = new Option(name, id, false, false);

                    controlCategorySerect.append(newOption)
                })



            } catch (err) {
                console.error(err)
            }

        })()

    })

    controlCategorySerect.on('change',function(){
        const controlCategoryId = $(this).val()
        control_category_id = controlCategoryId
        if(dimension_id && departament_id && controlCategoryId){
            formBuilderWrapper.css('display','block')
            if(builtForm){
                builtForm.remove()
            }
            buildForm()

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


            const pleaseSelectOption = new Option('Please Select','',false,false)
            selectEl.append(pleaseSelectOption)

            Object.entries(dimensions).forEach(dimension =>{
                const [id, name] = dimension
                const newOption = new Option(name, id, false, false);

                selectEl.append(newOption)
            })




        } catch (error) {
            console.log(error)
        }

    }

    async function buildForm (){
        const fb = new SurveyBuilder(([]))
        builtForm = fb
        //add function that is triggered when the save btn is pressed
        fb.addSaveCallback(updateFormSchema)

    }


    //update schema method
    async function updateFormSchema(schema){

        if(!control_category_id && !departament_id && !dimension_id) {
            alert('nu')
            return
        }


        const response = await fetch('/admin/survey-builders/store-survey', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
                    },
                body: JSON.stringify({
                    dep_id:departament_id,
                    dim_id:dimension_id,
                    cat_id:control_category_id,
                    schema:schema
                })
            });

            const resData = await response.json();


            window.location.href = '/admin/survey-builders'


            if(resData.status === 'ok'){
                formUpdatedNotification(resData.message)
            }
    }

    function formUpdatedNotification(message){
        alert(message)
    }



</script>
@endsection


@endsection
