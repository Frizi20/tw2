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

    .control-category-surveys .select-inputs {
        display: flex;
        margin-right:5px;
    }

    .control-category-surveys .select-inputs .form-group {
        width: 100%;
        position: relative;
    }

    .close-dimension-selection {
        position: absolute;
        right: -18px;
        top: 2px;
        cursor: pointer;
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
        font-weight: 4000;
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
    }

    .chart-alert.active {
        display: block;
    }

    .bar-chart-details {
        align-self: flex-start;
    }

    .chart-wrapper.hidden {
        display: none;
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
        /* min-height: 65px; */
    }

    .card-header{
        min-height: 65px;
    }

    .line-chart-container .card-header h5 {
        margin-left: 15px;
        line-height: 24px;
    }

    .line-chart-container .card-header .form-group {
        flex: 0 0 150px;
    }

    .card-header h5 {
        font-size: 14px;
        line-height: 24px;
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


                <div class="container col-md-12 d-flex flex-sm-row flex-column flex-wrap">

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Completitudine Departamente </h5>
                            </div>
                            <div class="card-body">
                                <div style="">
                                    <canvas id="radar-chart-3" width="" height="400"></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header control-category-surveys" style="height:55px;">
                                <h5>Completitudine categorii de control</i></h5>

                                <div class="select-inputs">
                                    <div class="form-group departament-select">
                                        <select
                                            class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                            name="departament_id" id="departament_id">
                                            <option value="" disabled>Select Departament</option>
                                            <option value="all">All departaments</option>
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
                                            trans('cruds.surveyBuilder.fields.categorie_de_control_helper') }}</span>
                                    </div>
                                </div>


                            </div>
                            <div class="card-body">
                                <div style="">
                                    <canvas id="radar-chart" width="800" height="400"></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header dimensions-surveys" style="height:55px;">
                                <h5> Completitudine dimensiuni </h5>
                                <div class="form-group">
                                    <select
                                        class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                        name="dimension_dep_id" id="dimension_dep_id">
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
                            </div>
                            <div class="card-body">
                                <div class="chart-wrapper">
                                    <canvas id="radar-chart-2" width="800" height="400"></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
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
                                <div style="">
                                    <canvas id="radar-chart-risk-3" width="" height=""></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
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
                                <div style="">
                                    <canvas id="radar-chart-risk-1" width="" height="400"></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
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
                                <div style="">
                                    <canvas id="radar-chart-risk-2" width="" height="400"></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-8 d-flex">
                        <div class="card flex-grow-1 line-chart-container">
                            <div class="card-header">
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
                                <h5> - completitudine & risc </h5>
                            </div>
                            <div class="card-body">
                                <div style="">
                                    <canvas id="radar-chart-4" width="" height=""></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
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
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
                                </div>
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

        const departamentSelect = $('#departament_id')
        const lineChartDepartamentSelect = $('#line_chart_dep_id')
        const dimensionDepartamentSelect = $('#dimension_dep_id')
        const controlCategoryDimensionSelect= $('#control_category_dim_id')
        const closeDimensionSelect = $('.close-dimension-selection')

        let selectedDepId

        let chart1
        let lineChart
        let dimensionsChart

        dimensionSelectContainer.css('display','none')


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

			createChart(chartRiskDOM1,revertChart1.titles,revertChart1.values, true)
			createChart(chartRiskDOM2,revertChart2.titles,revertChart2.values, true)
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

                window.chart1.data.datasets[0].data = processedData.values
                window.chart1.update()

                return
            }

            getDimensionsForDepartament(depId,controlCategoryDimensionSelect,dimensionSelectContainer,departamentSelectContainer)



        })

        controlCategoryDimensionSelect.on('change',async function(){
            const dimId = $(this).val()

            if(!dimId) return

            const data = await getGraphData(selectedDepId, dimId)
            const processedData = processData(data)

            window.chart1.data.labels = processedData.titles
            window.chart1.data.datasets[0].data = processedData.values

            window.chart1.update()



        })

        //Update line chart
        lineChartDepartamentSelect.on('change', async function () {
            const depId = $(this).val()

            const dimResultsData = await getDimensionsResultsData(depId)
            const processedData = processData(dimResultsData)
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

            dimensionsChart.data.labels = processedData.titles
            dimensionsChart.data.datasets[0].data = processedData.values

            dimensionsChart.update()

            console.log(
                chartDOM2.parentElement.parentElement
            )
            console.log(processedData.titles)

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

        async function getDimensionsForDepartament(depId,selectEl, selectedContainer,currentSelectContainer){

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
                currentSelectContainer.css('display','none')

                const pleaseSelectOption = new Option('Select dimension','',false,false)
                pleaseSelectOption.disabled = true
                pleaseSelectOption.selected = true
                selectEl.append(pleaseSelectOption)

                console.log(dimensions)

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
                    return JSON.parse(survey.schema).fields.filter(question=>question.notApplicable !== true).reduce((acc,curr,_,arr)=>{
                        return acc + Number(curr.value) / arr.length
                    },0)
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
                    return JSON.parse(survey.schema).fields.filter(question=>question.notApplicable !== true).reduce((acc,curr,_,arr)=>{
                        console.log(arr)
                        return acc + Number(curr.value) / arr.length
                    },0)
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
