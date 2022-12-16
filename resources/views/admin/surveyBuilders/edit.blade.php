@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="{{ asset('css/surveyBuilder.css') }}">


<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.surveyBuilder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.survey-builders.update", [$surveyBuilder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- <div class="form-group">
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
            </div> --}}

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

                        <div class="update-form "></div>
                    </div>
                    <div class="save-schema btn">
                        <span>Save</span>
                    </div>
                </div>
            </div>
            {{json_encode($surveyBuilder->schema)}}

            {{-- <div class="form-group">
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
         const schema = '';
        const departamentSelect = $('#departamente_id')
        const formBuilderWrapper = $('.form-builder-wrapper')

        let builtForm





        // departamentSelect.on('change',function(){
        //     const newDepId = $(this).val()
        //     if(!newDepId){
        //         formBuilderWrapper.css('display','none')
        //         builtForm.remove()
        //     }else{
        //         formBuilderWrapper.css('display','block')
        //         builtForm.remove()
        //         buildForm(newDepId)

        //     }

        // })


        const getFormSchema = async function(survId) {

            try {
                const res = await fetch(`/admin/survey-builders/get-form-schema/${survId}`)
                if(!res?.ok) throw new Error('Schema could not be fetched!')
                const data = await res.json()
                return data

            } catch (error) {
                console.error(error)
            }


		}

		const buildForm = async function(survId){
			const data = await getFormSchema(survId)
			const fb = new SurveyBuilder(JSON.parse(data.schema).fields)

            //set curr form builder instance globally
            builtForm = fb

			//add function that is triggered when the save btn is pressed
			fb.addSaveCallback(updateFormSchema)

		}


		//update schema method
		async function updateFormSchema(schema){


            // console.log(survId)
            // return
			const response = await fetch(`/admin/survey-builders/update-survey`, {
					method: 'post',
					headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
						},
					body: JSON.stringify({
						survId:survId,
						schemaData:schema
					})
				});

                if(!response.ok) throw Error('Could not update row')

				const resData = await response.json();

                window.location.href = '/admin/survey-builders'


		}

		function formUpdatedNotification(message){
			alert(message)
		}

        buildForm();


        // buildForm(survId)

</script>

@endsection

@endsection
