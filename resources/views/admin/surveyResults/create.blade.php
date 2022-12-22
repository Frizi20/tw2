@extends('layouts.admin')
@section('content')

@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('css/multiPart.css') }}">
@endsection

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.surveyResult.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ '' }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.surveyResult.fields.user') }}</label>
                <input class="form-control " type="text" name="user_id" id="user_id" value="{{ $user }}" readonly>
                @if($errors->has('user'))
                <div class="invalid-feedback">
                    {{ $errors->first('user') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyResult.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="departament_id">{{ trans('cruds.surveyResult.fields.departament') }}</label>
                <select class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                    name="departament_id" id="departament_id">
                    @foreach($departaments as $id => $entry)
                    <option value="{{ $id }}" {{ old('departament_id')==$id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('departament'))
                <div class="invalid-feedback">
                    {{ $errors->first('departament') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyResult.fields.departament_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="schema_results">{{ trans('cruds.surveyResult.fields.schema_results') }}</label>
                <input class="form-control {{ $errors->has('schema_results') ? 'is-invalid' : '' }}" type="text"
                    name="schema_results" id="schema_results" value="{{ old('schema_results', '') }}">
                @if($errors->has('schema_results'))
                <div class="invalid-feedback">
                    {{ $errors->first('schema_results') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.surveyResult.fields.schema_results_helper') }}</span>
            </div> --}}

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
            <div class="multi-part-wrapper">

                <div class="multi-form-container">
                    <div class="progress-bar-container">
                        <div class="progress-bar-indicator"></div>
                    </div>
                    <div class="slider">

                        {{-- <fieldset>
                            <div class="fs-title">Intrebarea 4</div>
                            <div class="fs-subtitle">
                                What postgraduate qualifications do you hold?
                            </div>

                            <div class="input-slider">
                                <div class="fs-input">
                                    <select name="" id="">
                                        <option value="1">Bucuresti</option>
                                        <option value="2">Brasov</option>
                                        <option value="3">Cluj</option>
                                    </select>
                                </div>

                            </div>
                        </fieldset> --}}

                    </div>
                    <div class="form-buttons">
                        <div class="prev-btn">Prev</div>
                        <div class="next-btn">Next</div>
                        <div class="send-btn hide">Send</div>
                        {{-- <div class="-btn"></div> --}}
                    </div>
                </div>

            </div>
            {{-- <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div> --}}
        </form>
    </div>
</div>


<script src="{{ asset('js/multiPart.js') }}"></script>


@section('scripts')
@parent
<script>

    const dimensions = $('.dimensions')
    const controlCategory = $('.control-category')
    const departamentSelect = $('#departament_id')
    const dimensionSelect = $('.dimensions .select2')
    const controlCategorySerect = $('.control-category .select2')
    const multiPartWrapper = $('.multi-part-wrapper')

    let builtForm

    let departament_id
    let dimension_id
    let control_category_id
    let survey_builder_id


    dimensions.css('display','none')
    controlCategory.css('display','none')
    multiPartWrapper.css('display','none')


   departamentSelect.on('change',function(){
        const depId = $(this).val()

        //hide multipart form
        multiPartWrapper.css('display','none')


        departament_id = depId

        //empty dimension select options
        dimensionSelect.empty()

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

    dimensionSelect.on('change',function(){
        const dimId = $(this).val();
        dimension_id = dimId

        //hide multipart form
        multiPartWrapper.css('display','none')

        //empty controll category select options
        controlCategorySerect.empty()

        if(!dimId || !departament_id) return

        (async function(){

            try {
                const response = await fetch('/admin/survey-builders/get-categories',{
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

    controlCategorySerect.on('change', function(){
        const controlCategoryId = $(this).val()

        control_category_id = controlCategoryId

        if(!(!!control_category_id && !!dimension_id && !!departament_id)) return

        buildForm()
    })

     async function getFormSchema() {



        try {
            const response = await fetch('/admin/survey-builders/get-survey-builder', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    cat_id:control_category_id,
                    dim_id:dimension_id,
                    dep_id:departament_id
                })
            });

            if(!response.ok) throw new Error('Survey builder could not be fetched')
            const data = await response.json()


            if(data.status == 'pending'){
                alert(data.message)
                return false
            }
            //check if form builder is allowed for this user

            if(data.status == 'resolved'){
                alert(data.message)
                return false
            }

            if(!data.id) return false


            survey_builder_id = data.id

            return JSON.parse(data.schema)

        } catch (err) {
            console.error(err)
        }

    }

    const buildForm = async function (depId) {
        const schema = await getFormSchema()

        if( builtForm ){
            builtForm.reset()
        }

        if(!schema) {
            // alert('formularul a fost deja completat!')
            multiPartWrapper.css('display','none')
            return
        }

        multiPartWrapper.css('display','block')

        const surveyBuilder = new SurveyBuilder(schema, slider)
        surveyBuilder.addSendSurveyCallback(sendSurveyResult)

        builtForm = surveyBuilder

    }

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

    async function sendSurveyResult(schema){

        const response = await fetch('/admin/survey-results/store-survey-result', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
                    },
                body: JSON.stringify({
                    schema,
                    surv_id:survey_builder_id
                },null,4)
        });

        const data = await response.json()

        console.log(data)

        if(!data.id){
            // alert('formularul a fost deja completat!')
            // location.reload();

        }

        // window.location.href = '/admin/survey-results'


    }



</script>
@endsection



@endsection
