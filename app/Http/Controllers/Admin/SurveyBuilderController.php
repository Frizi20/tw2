<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySurveyBuilderRequest;
use App\Http\Requests\StoreSurveyBuilderRequest;
use App\Http\Requests\UpdateSurveyBuilderRequest;
use App\Models\CategorieDeControl;
use App\Models\Departamente;
use App\Models\Dimensiune;
use App\Models\SessionModel;
use App\Models\SurveyBuilder;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class SurveyBuilderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('survey_builder_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $sessionId = Session::getId();
        // $session = SessionModel::where('user_id','=',Auth::user()->id)->where('id','!=',$sessionId)->first();
        // // return response()->json($session);
        // if($session){
        //     return response()->json('same user is already here');
        // }

        // return response()->json('poti');

        $surveyBuilders = SurveyBuilder::with(['departamente', 'categorie_de_control', 'dimensiuni'])->get();

        // return response()->json($surveyBuilders);


        return view('admin.surveyBuilders.index', compact('surveyBuilders'));
    }

    public function storeSurvey(Request $request)
    {
        $createdSurvey = SurveyBuilder::create([
            'schema' => $request->schema,
            'departamente_id' => $request->dep_id,
            'dimensiune_id'   => $request->dim_id,
            'categorie_de_control_id' => $request->cat_id,
            'generala'          => $request->general
        ]);
        return response()->json($createdSurvey);
    }


    public function getDimensions(Request $request)
    {
        $departamentId = $request->depId;

        $departament = Departamente::find($departamentId);


        if (!$departament) return response()->json('No departaments found', 404);

        $dimensions = $departament->dimensions->pluck('dimensiune', 'id');

        return response()->json($dimensions);
    }
    // > Departamente::find(3)->dimensions[0]->categoriiDeControl->pluck('id')->all()

    public function getSurveyBuilder(Request $request)
    {
        $overlaping = false;
        $user_id = Auth::user()->id;
        $session_id = Session::getId();
        $surveyPath = '' . $request->dim_id . $request->dep_id . $request->cat_id;

        Session::put('survey_result', $surveyPath);

        $sameAuthUsersSessions = SessionModel::where('user_id', '=', $user_id)->where('id', '!=', $session_id)->get();

        foreach ($sameAuthUsersSessions as $key => $session) {
            # code...
            $payload = unserialize(base64_decode($session->payload));
            // return response()->json($payload);
            if (isset($payload['survey_result'])) {
                $otherUserSurveyPath = $payload['survey_result'];
                if ($otherUserSurveyPath && $otherUserSurveyPath == $surveyPath) {
                    $overlaping = true;
                }
            }


            //    return response()->json();
        }

        if ($overlaping) {

            Session::forget('survey_result');


            return response()->json([
                'status' => 'pending',
                'message' => 'Work in progress!'
            ]);
        }



        //return array with surveyBuilder and with the general questions of that builder
        $sb = SurveyBuilder::where([
            ['dimensiune_id', '=', $request->dim_id],
            ['departamente_id', '=', $request->dep_id],
            ['categorie_de_control_id', '=', $request->cat_id]
        ])->first();

        if (!isset($sb)) {
            return response()->json('No survey builder found');
        }

        //check if the survey was completed by current user
        $surveyHasResultsForUser = $sb->surveyResults()->where('user_id', '=', $user_id)->first();

        if ($surveyHasResultsForUser) {
            return response()->json([
                'status' => 'resolved',
                'message' => 'Survey was resolved'
            ]);
        }

        $generalQuestions = SurveyBuilder::where('generala', '=', 1)->first();


        //if survey has general question add the general questions to the survey builder schema
        if (isset($generalQuestions)) {
            $survey = json_decode($sb->schema)->fields;
            $generalQuestions = json_decode($generalQuestions->schema)->fields;


            foreach ($generalQuestions as $key => $question) {
                $generalQuestions[$key]->fieldOrder = 0;
            }

            $merged = array_merge($generalQuestions, $survey);

            $mergedSb = $sb->schema = json_encode(["fields" => $merged]);


            return response()->json(($sb));
        }


        return response()->json($sb);
    }

    public function getControllCategories(Request $request)
    {
        $departamenteId = $request->dep_id;
        $dimensionId = $request->dim_id;


        $departament = Departamente::find($departamenteId);
        $dimensiune = $departament->dimensions->find($dimensionId);

        $categoriesWithSurveys = $dimensiune->categoriiDeControl()->wherePivot('departamente_id', $departamenteId)->pluck('nume', 'categorie_de_controls.id');



        return response()->json($categoriesWithSurveys);
    }

    public function getAvailableControllCategories(Request $request)
    {

        $departamenteId = $request->dep_id;
        $dimensionId = $request->dim_id;


        $departament = Departamente::find($departamenteId);
        $dimensiune = $departament->dimensions->find($dimensionId);

        //  Departamente::find(1)->dimensions()->find(2)->categoriiDeControl()->wherePivot('departamente_id',1)->get()

        $categoriesWithSurveys = $dimensiune->categoriiDeControl()->wherePivot('departamente_id', $departamenteId)->pluck('categorie_de_controls.id')->all();
        // return response()->json($categoriesWithSurveys);
        $categoriesWithoutSurveys = CategorieDeControl::whereNotIn('id', $categoriesWithSurveys)->get()->pluck('nume', 'id');

        return response()->json($categoriesWithoutSurveys);
    }

    public function create()
    {
        abort_if(Gate::denies('survey_builder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamentes = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categorie_de_controls = CategorieDeControl::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dimensions = Dimensiune::pluck('dimensiune', 'id')->prepend(trans('global.pleaseSelect'), '');



        return view('admin.surveyBuilders.create', compact('categorie_de_controls', 'departamentes', 'dimensions'));
    }

    public function store(StoreSurveyBuilderRequest $request)
    {
        $surveyBuilder = SurveyBuilder::create($request->all());

        return redirect()->route('admin.survey-builders.index');
    }

    public function edit(SurveyBuilder $surveyBuilder)
    {


        abort_if(Gate::denies('survey_builder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $departamentes = Departamente::has('surveys')->get()->pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');



        return view('admin.surveyBuilders.edit', compact('surveyBuilder'));


        //------------------
        abort_if(Gate::denies('survey_builder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamentes = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categorie_de_controls = CategorieDeControl::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surveyBuilder->load('departamente', 'categorie_de_control');

        return view('admin.surveyBuilders.edit', compact('categorie_de_controls', 'departamentes', 'surveyBuilder'));
    }

    public function updateSurvey(Request $request)
    {

        $schema = $request->schema;
        $surveyId = $request->survId;


        if (!$schema || !$surveyId) return response()->json([
            'error' => 'Survey ID or survey schema missing',
            'status' => 'error'
        ], 403);

        $survey = SurveyBuilder::find($surveyId);

        $updatedSurvey = $survey->update([
            'schema' => $schema
        ]);

        if (!$updatedSurvey) return response()->json(['error' => 'survey could not be updated', 'status' => 'error'], 403);

        return response()->json($updatedSurvey);
        // return redirect()->route('admin.survey-builders.index');

        return response()->json($request->all());
    }

    public function update(UpdateSurveyBuilderRequest $request, SurveyBuilder $surveyBuilder)
    {
        $surveyBuilder->update($request->all());

        return redirect()->route('admin.survey-builders.index');
    }

    public function show(SurveyBuilder $surveyBuilder)
    {
        abort_if(Gate::denies('survey_builder_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surveyBuilder->load('departamente', 'categorie_de_control');

        return view('admin.surveyBuilders.show', compact('surveyBuilder'));
    }

    public function destroy(SurveyBuilder $surveyBuilder)
    {
        abort_if(Gate::denies('survey_builder_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surveyBuilder->delete();

        return back();
    }

    public function massDestroy(MassDestroySurveyBuilderRequest $request)
    {
        SurveyBuilder::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
