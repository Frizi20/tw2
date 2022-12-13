@extends('layouts.admin')
@section('content')
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
                            <div class="card-header">
                                <h5>Completitudine dimensiuni
                                </h5>
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
                            <div class="card-header">
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

        const chart1 = document.getElementById("radar-chart");
        const chart2 = document.getElementById("radar-chart-2");

        (async function(){

            try {

                const response = await fetch('/admin/categories-results')

                if(!response.ok) throw new Error('category survey results could not be fetched')

                const data = await response.json()


                const categoryGraph = processData(data)
                setTimeout(() => {
                    createChart(chart2, categoryGraph.titles, categoryGraph.values)
                    createChart(chart1, categoryGraph.titles, categoryGraph.values)

                }, 100);


            } catch (error) {
                console.error(error)
            }

        })()

        function processData(data){
            const controlCategories = Object.entries(data).map((el)=>{
                const [key,value] = el
                return value
            })

            console.table(controlCategories)

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
            new Chart(chartDOMLocation, {
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
                                    size:22
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
                                    size:13
                                }
                            }
                        }
                    }


                }
            });
        }
    }

    init()

</script>
@endsection
