@extends('layouts.admin')
@section('content')

@section('styles')
@parent
    <style>
        .dimension-surveys{

            display: flex;
            justify-content: space-between;
        }

        .dimension-surveys > div{
            width: 170px
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
                    <div class="col-md-6 pt-5 ">
                        <div class="card">
                            <div class="card-header dimension-surveys" style="height: 55px;">
                                <h5>Completitudine dimensiuni</h5>

                                <div class="form-group">

                                    <select
                                        class="form-control select2 {{ $errors->has('departament') ? 'is-invalid' : '' }}"
                                        name="departament_id" id="departament_id">
                                        <option value="" disabled selected>Select Departament</option>
                                            @foreach($departaments as $id => $entry)
                                                <option value="{{ $id }}" {{ old('departament_id')==$id ? 'selected' : '' }}>{{$entry }}</option>
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
                                    <canvas id="radar-chart" width="800" height="600"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 pt-5 ">
                        <div class="card">
                            <div class="card-header" style="height: 55px;">
                                <h5> Completitudine categorii de control </h5>
                            </div>
                            <div class="card-body">
                                <div style="">
                                    <canvas id="radar-chart-2" width="800" height="600"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 pt-2">
                        <div class="card">
                            <div class="card-header">
                                <h5> Completitudine categorii de control </h5>
                            </div>
                            {{-- <div class="card-body">
                                <div style="width: 800px;">
                                    <canvas id="radar-chart-2" width="800" height="600"></canvas>
                                </div>
                            </div> --}}

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
        const departamentSelect = $('#departament_id')

        let chart1



        Promise.all([
            getGraphData(1),
            getGraphData()
        ])
        .then(([chartData1,chartData2])=>{

            processedChartData1 = processData(chartData1)
            processedChartData2 = processData(chartData2)

            console.table(processedChartData1)
            console.table(processedChartData2)

            //create graphs

            window.chart1 = createChart(chartDOM1,processedChartData1.titles,processedChartData1.values)
            createChart(chartDOM2,processedChartData2.titles,processedChartData2.values)

        })
        .catch(error=>{
            console.log(error)
        })

        departamentSelect.on('change', async function(){
            const depID = $(this).val()

            const data = await getGraphData(depID)
            const processedData = processData(data)

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




        function processData(data){
            const controlCategories = Object.entries(data).map((el)=>{
                const [key,value] = el
                return value
            })


            let categoriesSurveyAnswers = []

            controlCategories.forEach(category => {
                // let mergedSchemas = []

                const categoryMergedSchemas =  category.survey_results.reduce((acc,curr)=>{
                    return [...acc, ...JSON.parse(curr.schema)]
                },[])

                categoriesSurveyAnswers.push({
                    categoryName: category.name,
                    categoryMergedSchemas
                })

            });

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
    }

    init()

</script>
@endsection
