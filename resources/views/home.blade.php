@extends('layouts.admin')
@section('content')

@section('styles')
@parent
<style>
    .dimension-surveys {

        display: flex;
        justify-content: space-between;
    }

    .dimension-surveys>div {
        width: 170px
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



    table{
        border-collapse: collapse
    }

    table thead th{
        padding-left: 10px;
    }

    table, th, td {
        border: 1px solid #e8e8e8;
        padding: 2px;
    }

    table tbody td{
        padding-left: 15px;
    }

    table tbody td:nth-child(2),
    table tbody td:nth-child(4){
        padding-left: 25px;
    }

    .line-chart-container .card-header{
        /* background: red; */
        display: flex;
    }
    .line-chart-container .card-header h5{
        margin-left: 15px;
    }

    .line-chart-container .card-header .form-group{
        flex: 0 0 150px;
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
                            <div class="card-header dimension-surveys" style="height: 55px;">
                                <h5>Completitudine dimensiuni</h5>

                                <div class="form-group">

                                    <select
                                        class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                        name="departament_id" id="departament_id">
                                        <option value="" disabled >Select Departament</option>
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
                            <div class="card-header" style="height: 55px;">
                                <h5> Completitudine categorii de control </h5>
                            </div>
                            <div class="card-body">
                                <div style="">
                                    <canvas id="radar-chart-2" width="800" height="400"></canvas>
                                </div>
                                <div class="chart-alert">
                                    Date insuficiente pentru afisarea graficului
                                </div>
                            </div>

                        </div>
                    </div>

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

                    <div class="col-md-4 pt-3 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Completitudine dimensiuni </h5>
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
                                <h5> Riscuri categorii de control </h5>
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

                    <div class="col-md-8 d-flex">
                        <div class="card flex-grow-1 line-chart-container">
                            <div class="card-header">
                                <div class="form-group">
                                    <select
                                        class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                        name="line_chart_dep_id" id="line_chart_dep_id">
                                        <option value="" disabled >Select Departament</option>
                                        @foreach($departaments as $id => $entry)
                                        <option value="{{ $id }}" {{ old('departament_id')==$id  ? 'selected' : '' }}>
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

        const departamentDimTable = document.querySelector('.departament-dimensions tbody')

        const chartDOM4 = document.getElementById("radar-chart-4");
        const departamentSelect = $('#departament_id')
        const lineChartDepartamentSelect = $('#line_chart_dep_id')

        let chart1
        let lineChart


        Promise.all([
            getGraphData(departamentSelect.val()),
            getGraphData(),
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
            createChart(chartDOM2,processedChartData2.titles,processedChartData2.values)
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
            const depID = $(this).val()

            const data = await getGraphData(depID)
            const processedData = processData(data)

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

        function updateChart(chart,newValues){

            chart.data.datasets[0].data = newValues
            chart.update()

        }

        async function getGraphData(deepartament){

            let params = deepartament ? `?depId=${deepartament}` :  '?all=true'

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

        async function getDimensionsResultsData(depId) {

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

        function processDepartamentsData(data){
            // console.log(data)

            const departaments = Object.entries(data).map(el=>{
                const [key,value] = el
                return value
            })

            let departamentsAnswers = []

            departaments.forEach(departament =>{

                const departamentsMergedSchemas = departament.survey_results.reduce((acc,curr)=>{
                    return [...acc, ...JSON.parse(curr.schema).fields]
                },[]).filter(field => field?.notApplicable !== true)


                departamentsAnswers.push({
                    departamentName:departament.name,
                    departamentsMergedSchemas
                })

            })


              return departamentsAnswers.map(depSurveyAnswer =>{
                const avgScore =  depSurveyAnswer.departamentsMergedSchemas.reduce((acc,curr,_,arr)=>{
                    return acc + Number(curr.value) / arr.length
                },0)

                return {
                    departamentName:depSurveyAnswer.departamentName,
                    avg:avgScore
                }
            }).reduce((acc,curr) =>{
                const currTitle = {titles:[...acc.titles,curr.departamentName]}
                const currVal =    {values:[...acc.values,curr.avg]}
                return {...currTitle, ...currVal}
            }, {titles:[],values:[]})
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

            // console.log(controlCategories)

            let categoriesSurveyAnswers = []

            // console.log(controlCategories)

            controlCategories.forEach(category => {
                // let mergedSchemas = []

                const categoryMergedSchemas =  category.survey_results.reduce((acc,curr)=>{
                    return [...acc, ...JSON.parse(curr.schema).fields]
                },[]).filter(field => field?.notApplicable !== true)

                // console.log(categoryMergedSchemas)


                categoriesSurveyAnswers.push({
                    categoryName: category.name,
                    categoryMergedSchemas
                })

            });

            console.log(categoriesSurveyAnswers)

            const avgs = categoriesSurveyAnswers.map(catSurveyAnswer =>{

                console.log(catSurveyAnswer)

                const avgSore =  catSurveyAnswer.categoryMergedSchemas.reduce((acc,curr,_,arr)=>{
                    return acc + Number(curr.value) / arr.length
                },0)

                return {
                    categoryName:catSurveyAnswer.categoryName,
                    avg:avgSore
                }
            })

            console.log(avgs)


			return avgs.reduce((acc,curr) =>{
                const currTitle = {titles:[...acc.titles,curr.categoryName]}
                const currVal =    {values:[...acc.values,curr.avg]}
                return {...currTitle, ...currVal}
            }, {titles:[],values:[]})


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
            console.log(completedData)
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
