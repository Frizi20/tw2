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
                                        <option value="" disabled selected>Select Departament</option>
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
                                <h5> Completitudine dimensiuni </h5>
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

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Completitudine dimensiuni </h5>
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

                    <div class="col-md-4 pt-5 d-flex">
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Completitudine dimensiuni </h5>
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
                        <div class="card flex-grow-1">
                            <div class="card-header">
                                <h5> Resurse Umane dimensiuni - completitudine & risc </h5>
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
                                <table style="width: 100%;">
                                    <thead>
                                        <th>Departament</th>
                                        <th>Completitudine</th>
                                        <th>Risc</th>
                                        <th>Excelenta</th>
                                    </thead>
                                    <tbody>
                                        <tr>
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
                                        </tr>
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
        const departamentSelect = $('#departament_id')
        let chart1



        Promise.all([
            getGraphData(1),
            getGraphData(),
            getDepartamentsResultsData()
        ])
        .then(([chartData1,chartData2,depResultsData])=>{




            processedChartData1 = processData(chartData1)
            processedChartData2 = processData(chartData2)
            departamentsProcessedData = processDepartamentsData(depResultsData)
            //create graphs

            console.log(departamentsProcessedData)

            window.chart1 = createChart(chartDOM1,processedChartData1.titles,processedChartData1.values)
            createChart(chartDOM2,processedChartData2.titles,processedChartData2.values)
            createChart(chartDOM3,departamentsProcessedData.titles,departamentsProcessedData.values)

        })
        .catch(error=>{
            console.log(error)
        })

        departamentSelect.on('change', async function(){
            const depID = $(this).val()

            const data = await getGraphData(depID)
            const processedData = processData(data)

            console.log(processedData)

            window.chart1.data.datasets[0].data = processedData.values

            window.chart1.update()

        })

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

            console.log(departaments)

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

        function processData(data){

            // console.log(
            //     data
            // )

            const controlCategories = Object.entries(data).map((el)=>{
                const [key,value] = el
                return value
            })

            // console.log(controlCategories)

            let categoriesSurveyAnswers = []

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



            return categoriesSurveyAnswers.map(catSurveyAnswer =>{


                const avgSore =  catSurveyAnswer.categoryMergedSchemas.reduce((acc,curr,_,arr)=>{
                    return acc + Number(curr.value) / arr.length
                },0)

                return {
                    categoryName:catSurveyAnswer.categoryName,
                    avg:avgSore
                }
            }).reduce((acc,curr) =>{
                const currTitle = {titles:[...acc.titles,curr.categoryName]}
                const currVal =    {values:[...acc.values,curr.avg]}
                return {...currTitle, ...currVal}
            }, {titles:[],values:[]})


        }



        function createChart(chartDOMLocation, titles, values){
          console.log(chartDOMLocation)
          if(true){
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
                            backgroundColor: "rgba(179,181,198,0.2)",
                            borderColor: "rgba(179,181,198,1)",
                            pointBorderColor: "#fff",
                            pointBackgroundColor: "rgba(179,181,198,1)",
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



        new Chart(chartDOM4, {
            type: 'bar',
            data: {
                labels: ["Guvernanta Corporativa", "Departamente Suport", "Resurse Umane", "Financiar-Contabilitate"],
                datasets: [{
                        label: "Completitudine",
                        type: "bar",
                        borderColor: "#36a2eb",
                        backgroundColor:'blue',
                        data: [408,547,675,734],
                        fill: false
                    }, {
                        label: "Risc",
                        type: "bar",
                        backgroundColor:'#ff6565',
                        borderColor: "#ff6384",
                        data: [133,221,783,2478],
                        fill: false
                    }
                ]
                },
                options: {
                title: {
                    display: true,
                    text: 'Population growth (millions): Europe & Africa'
                },
                legend: { display: true }
                }
            });
    }

    init()

</script>
@endsection
