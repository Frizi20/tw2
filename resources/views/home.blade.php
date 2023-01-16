@extends('layouts.admin')
@section('content')

@section('styles')
@parent
<style>
    .control-category-surveys,
    .dimensions-surveys {

        display: flex;
        justify-content: space-between;
    }

    .control-category-surveys {
        /* display: block; */
    }

    .control-category-surveys>div,
    .dimensions-surveys>div {
        width: 170px
    }

    .card-footer .select-inputs {
        display: flex;
        margin-right: 5px;

    }

    .card-footer .select-inputs .form-group {
        width: 100%;
        position: relative;
        width: 150px;
        margin-right: 15px;
    }

    .close-dimension-selection,
    .close-line-dimension-selection {
        position: absolute;
        right: -18px;
        top: 2px;
        cursor: pointer;
    }


    .line-dimension-select {
        position: relative;
        margin-left: 10px;
    }

    .card-body {
        position: relative;
    }

    .chart-alert {
        top: 14px;
        left: 10px;
        /* border: 1px solid gray; */
        width: 1090;
        width: 100%;
        left: 0;
        toop: 0;
        /* top: 18px; */
        font-size: 17px;
        font-weight: 400;
        color: #ff5e5e;
        text-align: center;
        padding-left: 10px;
        /* border-bottom: 1px solid; */
        top: unset;
        padding-bottom: 10px;
        bottom: 0;
        border-top: 1px solid gainsboro;
        padding: 17px;
        position: absolute;
        background: white;
        display: none;


        text-align: center;
        margin-top: 7px;
        background: #ff656561;
        padding: 8px;
        /* display: none; */
        color: #ff4646b3;
        /* color: white; */
        background: #ffe1e136;
        outline: 1px solid #ffa4a440;
        /* font-family: system-ui; */
        font-weight: 500;
        /* font-size: 13px; */
        position: absolute;
        top: -7px;
        left: 0;
        width: 100%;
        height: 100%;

        background-color: #fff9f9;

        justify-content: center;
        align-items: center;
        width: 100%;
        z-index: 1;
    }

    .chart-alert.active {
        display: flex;
    }

    .bar-chart-details {
        align-self: flex-start;
    }

    .chart-wrapper {
        position: relative;
    }

    .chart-wrapper.hidden {
        /* opacity: 0; */
    }

    table {
        border-collapse: collapse
    }

    table thead th {
        padding-left: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #e8e8e8;
        padding: 2px;
    }

    table tbody td {
        padding-left: 15px;
    }

    table tbody td:nth-child(2),
    table tbody td:nth-child(4) {
        padding-left: 25px;
    }

    .line-chart-container .card-header {
        /* background: red; */
        display: flex;
        align-items: center;
        /* min-height: 65px; */
    }

    .graphs-wrapper .card-header {
        /* min-height: 65px;
        border-bottom: none;
        z-index: 1;

        display: flex;
        flex-direction: column; */

        padding-top: 0;
        padding-bottom: 0;
    }

    .line-chart-container .card-header h5 {
        /* margin-left: 30px; */
        line-height: 24px;
        padding: 0;
    }

    .line-chart-container .card-header .form-group {
        flex: 0 0 150px;
        margin-bottom: 0 !important;
        min-width: 150px;

    }

    .graphs-wrapper .form-group {
        /* margin: 0; */
        margin-bottom: 0 !important;
        min-width: 150px;
    }

    .graphs-wrapper .card-header h5 {
        font-size: 14px;
        line-height: 24px;
        display: block;
        flex: none;
        font-size: 1.25rem;
        font-weight: 500;
        hyphens: auto;
        letter-spacing: .0125em;
        min-width: 0;
        overflow-wrap: normal;
        overflow: hidden;
        padding: 0.5rem 1rem;
        text-overflow: ellipsis;
        text-transform: none;
        white-space: nowrap;
        word-break: normal;
        word-wrap: break-word;
        padding-left: 0;
        padding-top: 17px;
    }

    .chart-container {
        position: relative;
    }

    .card-footer {
        padding: 0;
        min-height: 35px;
        width: 100%;
        /* background-color: grey; */
        position: relative;
        display: flex;
        align-items: center;
        padding-top: 20px;
        border: none;

    }

    @media (max-width: 1600px) {
        .graphs-wrapper .card-header h5 {
            font-size: 1rem;
        }
    }

    @media (max-width: 1354px) {
        .graphs-wrapper .card-header h5 {
            font-size: 0.8rem;
        }
    }
</style>
@endsection

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>


                <div class="container col-md-12 d-flex flex-sm-row flex-column flex-wrap graphs-wrapper">

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Completitudine Departamente </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radar-chart-3" width="" height="400"></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>

                                </div>
                                <div class="card-footer">

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header control-category-surveys" style="">
                                <h5>Completitudine categorii de control</i></h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radar-chart" width="800" height="400"></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="select-inputs">
                                        <div class="form-group departament-select">
                                            <select
                                                class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                                name="departament_id" id="departament_id">
                                                <option value="" disabled>Select Departament</option>
                                                <option value="all">All departaments</option>
                                                @foreach($departaments as $id => $entry)
                                                <option value="{{ $id }}" {{ old('departament_id')==$id ? 'selected'
                                                    : '' }}>
                                                    {{$entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('departament'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('departament') }}
                                            </div>
                                            @endif
                                            <span class="help-block">{{
                                                trans('cruds.surveyResult.fields.departament_helper')
                                                }}</span>
                                        </div>

                                        <div class="form-group dimension-select">

                                            <div class="close-dimension-selection">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>

                                            <select
                                                class="form-control select2 {{ $errors->has('categorie_de_control') ? 'is-invalid' : '' }}"
                                                name="control_category_dim_id" id="control_category_dim_id" required>
                                                {{-- @foreach($categorie_de_controls as $id => $entry)
                                                <option value="{{ $id }}" {{ old('categorie_de_control_id')==$id
                                                    ? 'selected' : '' }}>{{ $entry }}
                                                </option>
                                                @endforeach --}}
                                            </select>
                                            @if($errors->has('categorie_de_control'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('categorie_de_control') }}
                                            </div>
                                            @endif
                                            <span class="help-block">{{
                                                trans('cruds.surveyBuilder.fields.categorie_de_control_helper')
                                                }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header dimensions-surveys" style="">
                                <h5> Completitudine dimensiuni </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-wrapper">
                                    <canvas id="radar-chart-2" width="800" height="400"></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="form-group">
                                        <select
                                            class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                            name="dimension_dep_id" id="dimension_dep_id">
                                            <option value="" disabled>Select Departament</option>
                                            <option value="">All departaments</option>
                                            @foreach($departaments as $id => $entry)
                                            <option value="{{ $id }}" {{ old('departament_id')==$id ? 'selected' : ''
                                                }}>
                                                {{$entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('departament'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('departament') }}
                                        </div>
                                        @endif
                                        <span class="help-block">{{
                                            trans('cruds.surveyResult.fields.departament_helper')
                                            }}</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-3 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Riscuri departamente </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radar-chart-risk-3" width="" height=""></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>
                                </div>
                                <div class="card-footer">

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-3 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Riscuri categorii de control </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radar-chart-risk-1" width="" height="400"></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>
                                </div>
                                <div class="card-footer">

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-3 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Riscuri dimensiuni </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radar-chart-risk-2" width="" height="400"></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>
                                </div>
                                <div class="card-footer">

                                </div>

                            </div>

                        </div>
                    </div>


                    <div class="col-md-8 d-flex">
                        <div class="card flex-grow-1 line-chart-container">
                            <div class="card-header">
                                <h5> Completitudine & risc </h5>

                                <div class="form-group">
                                    <select
                                        class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                        name="line_chart_dep_id" id="line_chart_dep_id">
                                        <option value="" disabled>Select Departament</option>
                                        <option value="">All departaments</option>
                                        @foreach($departaments as $id => $entry)
                                        <option value="{{ $id }}" {{ old('departament_id')==$id ? 'selected' : '' }}>
                                            {{$entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('departament'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('departament') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.surveyResult.fields.departament_helper')
                                        }}</span>
                                </div>
                                <div class="form-group line-dimension-select">

                                    <div class="close-line-dimension-selection">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>

                                    <select
                                        class="form-control select2 {{ $errors->has('categorie_de_control') ? 'is-invalid' : '' }}"
                                        name="line_chart_dim_id" id="line_chart_dim_id" required>
                                        {{-- @foreach($categorie_de_controls as $id => $entry)
                                        <option value="{{ $id }}" {{ old('categorie_de_control_id')==$id ? 'selected'
                                            : '' }}>{{ $entry }}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                    @if($errors->has('categorie_de_control'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('categorie_de_control') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{
                                        trans('cruds.surveyBuilder.fields.categorie_de_control_helper')
                                        }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radar-chart-4" width="" height=""></canvas>
                                    <div class="chart-alert">
                                        Date insuficeiente pentru afisarea graficului
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 d-flex bar-chart-details">
                        <div class="card flex-grow-1">
                            {{-- <div class="card-header">
                                <h5> Completitudine dimensiuni </h5>
                            </div> --}}
                            <div class="card-body">
                                <table class="departament-dimensions" style="width: 100%;">
                                    <thead>
                                        <th>Dimensiune</th>
                                        <th>Completitudine</th>
                                        <th>Risc</th>
                                        <th>Excelenta</th>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>Guvernanta Corporativa</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>5</td>
                                        </tr>
                                        <tr>
                                            <td>Departamente Suport</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>5</td>
                                        </tr>
                                        <tr>
                                            <td>Resurse Umane</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>5</td>
                                        </tr>
                                        <tr>
                                            <td>Financiar-Contabilitate</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>5</td>
                                        </tr> --}}
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    function init(){

        const chartDOM1 = document.getElementById("radar-chart");
        const chartDOM2 = document.getElementById("radar-chart-2");
        const chartDOM3 = document.getElementById("radar-chart-3");

        const chartRiskDOM1 = document.getElementById("radar-chart-risk-1")
        const chartRiskDOM2 = document.getElementById("radar-chart-risk-2")
        const chartRiskDOM3 = document.getElementById("radar-chart-risk-3")

        const chartDOM4 = document.getElementById("radar-chart-4");

        const departamentDimTable = document.querySelector('.departament-dimensions tbody')

        const dimensionSelectContainer   = $('.dimension-select')
        const departamentSelectContainer = $('.departament-select')
		const lineDimensionSelectContainer = $('.line-dimension-select')

        const departamentSelect = $('#departament_id')
        const lineChartDepartamentSelect = $('#line_chart_dep_id')
		const lineChartDimensionSelect = $('#line_chart_dim_id')
        const dimensionDepartamentSelect = $('#dimension_dep_id')
        const controlCategoryDimensionSelect= $('#control_category_dim_id')
        const closeDimensionSelect = $('.close-dimension-selection')
        const lineCloseDimensionSelect = $('.close-line-dimension-selection')

        let selectedDepId
        let lineChartDepId

        let chart1
        let lineChart
        let dimensionsChart
        let controlCategoryRiskChart
        let dimensionsRiskChart

        dimensionSelectContainer.css('display','none')
        lineDimensionSelectContainer.css('display','none')

        Promise.all([
            getGraphData(departamentSelect.val()),
            getDimensionsResultsData(),
            getDepartamentsResultsData(),
            getDimensionsResultsData(lineChartDepartamentSelect.val())
        ])
        .then(([chartData1,chartData2,depResultsData, dimResultsData])=>{

            const processedChartData1 = processData(chartData1)
            const processedChartData2 = processData(chartData2)
            const departamentsProcessedData = processDepartamentsData(depResultsData)
            //create graphs
			const revertChart1 = revertProcessedData(processedChartData1)
			const revertChart2 = revertProcessedData(processedChartData2)
			const revertChart3 = revertProcessedData(departamentsProcessedData)



            const processedLineGraphData = processData(dimResultsData)

            window.chart1 = createChart(chartDOM1,processedChartData1.titles,processedChartData1.values)
            dimensionsChart = createChart(chartDOM2,processedChartData2.titles,processedChartData2.values)
            createChart(chartDOM3,departamentsProcessedData.titles,departamentsProcessedData.values)

			controlCategoryRiskChart = createChart(chartRiskDOM1,revertChart1.titles,revertChart1.values, true)

            window.x = controlCategoryRiskChart

			dimensionsRiskChart = createChart(chartRiskDOM2,revertChart2.titles,revertChart2.values, true)
			createChart(chartRiskDOM3,revertChart3.titles,revertChart3.values, true)

            lineChart = createLineChart(chartDOM4,processedLineGraphData,revertProcessedData(processedLineGraphData))
            updateDimTable(departamentDimTable,processedLineGraphData,revertProcessedData(processedLineGraphData))


        })
        .catch(error=>{
            console.log(error)
        })


        //Change departament graph
        departamentSelect.on('change', async function(){
            const depId = $(this).val()

            selectedDepId = depId

            //Clear dimension options
            controlCategoryDimensionSelect.empty()

            if(!depId) return;

            if(depId === 'all'){


                const data = await getGraphData()
                const processedData = processData(data)
                const revertedData = revertProcessedData(processedData)

                controlCategoryRiskChart.data.labels = revertedData.titles
                controlCategoryRiskChart.data.datasets[0].data = revertedData.values
                controlCategoryRiskChart.update()


                window.chart1.data.labels = processedData.titles
                window.chart1.data.datasets[0].data = processedData.values
                window.chart1.update()

                dimensionSelectContainer.css('display','none')

                return
            }

            getDimensionsForDepartament(depId,controlCategoryDimensionSelect,dimensionSelectContainer)



        })

        controlCategoryDimensionSelect.on('change',async function(){
            const dimId = $(this).val()

            if(!dimId) return

            const data = await getGraphData(selectedDepId, dimId)
            const processedData = processData(data)
            const revertedData = revertProcessedData(processedData)


            window.chart1.data.labels = processedData.titles
            window.chart1.data.datasets[0].data = processedData.values
            window.chart1.update()

            console.log(controlCategoryRiskChart)

            controlCategoryRiskChart.data.labels = revertedData.titles
            controlCategoryRiskChart.data.datasets[0].data = revertedData.values
            controlCategoryRiskChart.update()



        })

        //Update line chart
        lineChartDepartamentSelect.on('change', async function () {
            const depId = $(this).val()
            const dimResultsData = await getDimensionsResultsData(depId)
            const processedData = processData(dimResultsData)
            const revertedData = revertProcessedData(processedData)

            lineChartDepId = depId


            lineChart.data.labels = processedData.titles
            lineChart.data.datasets[0].data = processedData.values
            lineChart.data.datasets[1].data = revertedData.values

            updateDimTable(departamentDimTable,processedData,revertedData)
            lineChart.update()
			lineChartDimensionSelect.empty()

            if(!depId) return
			getDimensionsForDepartament(depId,lineChartDimensionSelect,lineDimensionSelectContainer,true)

        })

		lineChartDimensionSelect.on('change', async function () {
			const dimId = $(this).val()

            const graphData = await getGraphData(lineChartDepId, dimId)
            const processedData = processData(graphData)
            const revertedData = revertProcessedData(processedData)


            lineChart.data.labels = processedData.titles
            lineChart.data.datasets[0].data = processedData.values
            lineChart.data.datasets[1].data = revertedData.values

            updateDimTable(departamentDimTable,processedData,revertedData)
            lineChart.update()

		})

        dimensionDepartamentSelect.on('change', async function () {
            const depId = $(this).val()

            const dimResultsData = await getDimensionsResultsData(depId)
            const processedData = processData(dimResultsData)
            const revertedData = revertProcessedData(processedData)

            console.log(dimensionsRiskChart.data)

            dimensionsRiskChart.data.labels = revertedData.titles
            dimensionsRiskChart.data.datasets[0].data = revertedData.values
            dimensionsRiskChart.update()

            dimensionsChart.data.labels = processedData.titles
            dimensionsChart.data.datasets[0].data = processedData.values
            dimensionsChart.update()

            dimensionsRiskChart


            if(processedData.titles.length <=2){
                chartDOM2.parentElement.parentElement.querySelector('.chart-alert').classList.add('active')
                chartDOM2.parentElement.parentElement.querySelector('.chart-wrapper').classList.add('hidden')
            }else{
                chartDOM2.parentElement.parentElement.querySelector('.chart-alert').classList.remove('active')
                chartDOM2.parentElement.parentElement.querySelector('.chart-wrapper').classList.remove('hidden')
            }

        })

        closeDimensionSelect.on('click', function(){
            dimensionSelectContainer.css('display','none')
            departamentSelectContainer.css('display','block')

            departamentSelect.val(departamentSelect.find("option:eq(0)").val()).trigger('change');
        })

        lineCloseDimensionSelect.on('click',async function () {
            lineDimensionSelectContainer.css('display','none')

            const dimResultsData = await getDimensionsResultsData(lineChartDepId)
            const processedData = processData(dimResultsData)
            const revertedData = revertProcessedData(processedData)



            lineChart.data.labels = processedData.titles
            lineChart.data.datasets[0].data = processedData.values
            lineChart.data.datasets[1].data = revertedData.values

            updateDimTable(departamentDimTable,processedData,revertedData)
            lineChart.update()


        })

        function updateChart(chart,newValues){

            chart.data.datasets[0].data = newValues
            chart.update()

        }

        async function getGraphData(departament = '', dimension){

            let params = departament ? `?depId=${departament}` :  '?all=true'

            if(!!departament && departament !== 'all' && dimension){
                params = `?depId=${departament}&dimId=${dimension}`
            }

            try {

                const response = await fetch(`/admin/categories-results/${params}`)

                if(!response.ok) throw new Error('category survey results could not be fetched')

                const data = await response.json()

                return Promise.resolve(data)
                // const categoryGraph = processData(data)

                // console.log(categoryGraph)


            } catch (error) {
                return Promise.reject(error)
            }

        }

        async function getDimensionsResultsData(depId='') {

            try {

                const response = await fetch(`/admin/dimensions-results/?depId=${depId}`)

                const resData = response.json()

                return Promise.resolve(resData)


            } catch (error) {
                Promise.reject(error)
            }

        }

        async function getDepartamentsResultsData() {

            try {
                const response = await fetch('/admin/departaments-results')

                const resData = await response.json()

                return Promise.resolve(resData)


            } catch (error) {

            }

        }

        async function getDimensionsForDepartament(depId,selectEl, selectedContainer, allDep = false ){

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
                // currentSelectContainer.css('display','none')

                const pleaseSelectOption = new Option('Select dimension','',false,false)
                pleaseSelectOption.disabled = true
                pleaseSelectOption.selected = true
                selectEl.append(pleaseSelectOption)

				if(allDep){
					const getAllDimensionsOption = new Option('Toate dimensiunile','all',false,false)
					selectEl.append(getAllDimensionsOption)
				}

                Object.entries(dimensions).forEach(dimension =>{
                    const [id, name] = dimension
                    const newOption = new Option(name, id, false, false);

                    selectEl.append(newOption)
                })


            } catch (error) {
                console.log(error)
            }

        }

        function processDepartamentsData(data){
            // console.log(data)

            const departaments = Object.entries(data).map(el=>{
                const [key,value] = el
                return value
            })

			departamentsSurveyAnswers = {
				titles:[],
				values:[]
			}

			departaments.forEach(departament=>{

				const surveyAvgs = departament.survey_results.map(survey=>{
                    const applicableSurveys = JSON.parse(survey.schema).fields.filter(question=>question.notApplicable !== true)

				return applicableSurveys.reduce((acc,curr,_,arr)=>{
                        return acc + Number(curr.value)
                    },0) / applicableSurveys.length
                }).reduce((acc,curr,_,arr)=>{
                    return acc + Number(curr) / arr.length
                },0)

				departamentsSurveyAnswers.titles.push(departament.name)
                departamentsSurveyAnswers.values.push(surveyAvgs)

			})


			return departamentsSurveyAnswers

            // let departamentsAnswers = []

            // departaments.forEach(departament =>{

            //     const departamentsMergedSchemas = departament.survey_results.reduce((acc,curr)=>{
            //         return [...acc, ...JSON.parse(curr.schema).fields]
            //     },[]).filter(field => field?.notApplicable !== true)


            //     departamentsAnswers.push({
            //         departamentName:departament.name,
            //         departamentsMergedSchemas
            //     })

            // })

			// console.log(departamentsAnswers)


            //   return departamentsAnswers.map(depSurveyAnswer =>{
            //     const avgScore =  depSurveyAnswer.departamentsMergedSchemas.reduce((acc,curr,_,arr)=>{
            //         return acc + Number(curr.value) / arr.length
            //     },0)

            //     return {
            //         departamentName:depSurveyAnswer.departamentName,
            //         avg:avgScore
            //     }
            // }).reduce((acc,curr) =>{
            //     const currTitle = {titles:[...acc.titles,curr.departamentName]}
            //     const currVal =    {values:[...acc.values,curr.avg]}
            //     return {...currTitle, ...currVal}
            // }, {titles:[],values:[]})
        }



		function revertProcessedData(data){
			const clonedData = JSON.parse(JSON.stringify(data))
			const reversedValues = clonedData.values.map(value => value === 0 || !value ? 0 : 6 - value )

			clonedData.values = reversedValues
			return clonedData
		}



        function processData(data){

            const controlCategories = Object.entries(data).map((el)=>{
                const [key,value] = el
                return value
            })


            const categoriesSurveyAvgs = {
                titles:[],
                values:[]
            }

            controlCategories.forEach(category=>{

                const surveyAvgs = category.survey_results.map(survey=>{
                    // console.log(category.name)
                    const applicableSurveys = JSON.parse(survey.schema).fields.filter(question=>question.notApplicable !== true)


					return applicableSurveys.reduce((acc,curr,_,arr)=>{
                        return acc + Number(curr.value)
                    },0) / applicableSurveys.length
                }).reduce((acc,curr,_,arr)=>{
                    return Number(curr) / arr.length + acc
                },0)

                // console.log(
                    // category.survey_results.map(survey=>{
                    //     // console.log(survey)
                    //     const x = JSON.parse(survey.schema).fields.filter(question=>question.notApplicable !== true).reduce((acc,curr,_,arr)=>{
                    //         console.log({
                    //             acc,
                    //             currNr:Number(curr.value),
                    //             length:arr.length
                    //         })
                    //         return acc + Number(curr.value) / arr.length
                    //     },0)

                    //     console.log(x)
                    //     return x
                    // })
                // )

                categoriesSurveyAvgs.titles.push(category.name)
                categoriesSurveyAvgs.values.push(surveyAvgs)

            })


            return categoriesSurveyAvgs




            // let categoriesSurveyAnswers = []


            // controlCategories.forEach(category => {
            //     // let mergedSchemas = []

            //     const categoryMergedSchemas =  category.survey_results.reduce((acc,curr)=>{
            //         return [...acc, ...JSON.parse(curr.schema).fields]
            //     },[]).filter(field => field?.notApplicable !== true)

            //     // console.log(categoryMergedSchemas)



            //     categoriesSurveyAnswers.push({
            //         categoryName: category.name,
            //         categoryMergedSchemas
            //     })

            // });



            // const avgs = categoriesSurveyAnswers.map(catSurveyAnswer =>{


            //     const avgSore =  catSurveyAnswer.categoryMergedSchemas.reduce((acc,curr,_,arr)=>{
            //         return acc + Number(curr.value) / arr.length
            //     },0)

            //     return {
            //         categoryName:catSurveyAnswer.categoryName,
            //         avg:avgSore
            //     }
            // })



			// return avgs.reduce((acc,curr) =>{
            //     const currTitle = {titles:[...acc.titles,curr.categoryName]}
            //     const currVal =    {values:[...acc.values,curr.avg]}
            //     return {...currTitle, ...currVal}
            // }, {titles:[],values:[]})


        }



        function createChart(chartDOMLocation, titles, values, reversed = false){

          if(titles.length <= 2){
            chartDOMLocation.parentElement.parentElement.querySelector('.chart-alert').classList.add('active')
            return
          }


          const chartInstance = new Chart(chartDOMLocation, {
                type: 'radar',
                data: {
                labels: titles,
                datasets: [
                        {
                            fill: true,
                            backgroundColor: reversed ? "rgba(255, 99, 132, 0.2)" : "#d7ecfb80",
                            borderColor: reversed ? "#ff6262e0" : '#5e95d6',
                            pointBorderColor: "#fff",
                            pointBackgroundColor: reversed ? "#ff6384" : "#5e95d6",
                            data: values
                        }
                    ]
                },
                options: {
                    legend:{
                        display:false
                    },
                    scale: {
                        ticks: {
                            beginAtZero: false,
                            max: 5,
                            min: 0,
                            stepSize: 1
                        },
                        min:0,
                        max:5
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                    return tooltipItem.yLabel;
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                            labels:{
                                font:{
                                    size:15
                                }
                            }
                        },
                        label:{
                            display:false
                        }
                    },
                    scales: {
                        r: {
                            pointLabels: {
                                // color: 'red',
                                font:{
                                    size:'12'
                                }
                            }
                        }
                    }


                }
            });

            return chartInstance
        }

        function createLineChart(chartDOMLocation,completedData,riskData){
            return new Chart(chartDOM4, {
                type: 'bar',
                data: {
                    labels: completedData.titles,
                    datasets: [{
                        label: "Completitudine",
                        type: "bar",
                        borderColor: "#36a2eb",
                            backgroundColor:'blue',
                            data: completedData.values,
                            fill: false
                        }, {
                            label: "Risc",
                            type: "bar",
                            backgroundColor:'#ff6565',
                            borderColor: "#ff6384",
                            data: riskData.values,
                            fill: false
                        }
                    ]
                },
                options: {
                    title: {
                        // display: true,
                        // text: 'Population growth (millions): Europe & Africa'
                    },
                    legend: { display: true },
                    scales: {
                        y: {
                            display: true,
                            max:5,
                            min:0
                        }
                    }

                }
            });
        }

        function updateDimTable(table,completedData,riskData){



            const html = completedData.titles.map((dim,i,currArr)=>{
                return `<tr>
                            <td> ${dim} </td>
                            <td> ${completedData.values[i] % 1 === 0 ? completedData.values[i] : completedData.values[i].toFixed(2)} </td>
                            <td> ${riskData.values[i] % 1 === 0 ? riskData.values[i] : riskData.values[i].toFixed(2)} </td>
                            <td> 5 </td>
                        </tr>`
            }).join('')

            document.querySelector('table tbody').innerHTML = html
        }

    }

    init()

</script>
@endsection
