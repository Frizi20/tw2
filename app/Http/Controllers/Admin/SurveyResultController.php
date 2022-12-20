<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySurveyResultRequest;
use App\Http\Requests\StoreSurveyResultRequest;
use App\Http\Requests\UpdateSurveyResultRequest;
use App\Models\Departamente;
use App\Models\SurveyResult;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyResultController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('survey_result_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = Auth::user()->id;

        $surveyResults = DB::table('survey_results as sr')
        ->select([
            'sr.id as sr_id',
            'sb.id as sb_id',
            'dep.nume as dep_name',
            'sr.*',
            'sb.*',
            'dep.*',
            'dim.*',
            'cc.nume as cc_name'
        ])
        ->where('sr.user_id','=', $user_id)
        ->leftJoin('survey_builders as sb', function($join){
            $join->on('sb.id','=','sr.survey_builder_id');
        })
        ->leftJoin('departamentes as dep','dep.id','=','sb.departamente_id')
        // ->leftJoin('departament')
        ->leftJoin('dimensiunes as dim','dim.id','=','sb.dimensiune_id')
        ->leftJoin('categorie_de_controls as cc','cc.id','=','sb.categorie_de_control_id')
        ->get();

        // $surveyResults = SurveyResult::with(['departament', 'user','surveyBuilder'])
        // ->where('user_id',Auth::user()->id)
        // ->leftJoin('departamentes','departamentes.id','=', 'survey_builders.departamente_id')
        // ->get();


        // return response()->json($surveyResults);


        return view('admin.surveyResults.index', compact('surveyResults'));
    }

    public function create()
    {
        abort_if(Gate::denies('survey_result_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departaments = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user =Auth::user()->name;


        return view('admin.surveyResults.create', compact('departaments', 'user'));
    }

    public function storeSurveyResult(Request $request)
    {

        $user_id = Auth::user()->id;


        //check if the selected survey builder was created by current user

        $surveyIsResolvedByUser = SurveyResult::where([['user_id','=',Auth()->user()->id],['survey_builder_id','=',$request->surv_id]])->first();


        if($surveyIsResolvedByUser){
            return response()->json([
                'status' => 'form completed'
            ]);
        }

        $createdSurveyResult = SurveyResult::create([
            'schema_results' => $request->schema,
            'user_id' => $user_id,
            'survey_builder_id' => $request->surv_id,

        ]);



        return response()->json($createdSurveyResult);

    }

    public function store(StoreSurveyResultRequest $request)
    {
        $surveyResult = SurveyResult::create($request->all());

        return redirect()->route('admin.survey-results.index');
    }

    public function edit(SurveyResult $surveyResult)
    {
        abort_if(Gate::denies('survey_result_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departaments = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surveyResult->load('departament', 'user');

        return view('admin.surveyResults.edit', compact('departaments', 'surveyResult', 'users'));
    }

    public function update(UpdateSurveyResultRequest $request, SurveyResult $surveyResult)
    {
        $surveyResult->update($request->all());

        return redirect()->route('admin.survey-results.index');
    }

    public function show(SurveyResult $surveyResult)
    {
        abort_if(Gate::denies('survey_result_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surveyResult->load('departament', 'user');

        return view('admin.surveyResults.show', compact('surveyResult'));
    }

    public function destroy(SurveyResult $surveyResult)
    {
        abort_if(Gate::denies('survey_result_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surveyResult->delete();

        return back();
    }

    public function massDestroy(MassDestroySurveyResultRequest $request)
    {
        SurveyResult::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
