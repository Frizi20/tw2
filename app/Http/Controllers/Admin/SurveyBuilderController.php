<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySurveyBuilderRequest;
use App\Http\Requests\StoreSurveyBuilderRequest;
use App\Http\Requests\UpdateSurveyBuilderRequest;
use App\Models\CategorieDeControl;
use App\Models\Departamente;
use App\Models\Dimensiune;
use App\Models\SurveyBuilder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SurveyBuilderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('survey_builder_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surveyBuilders = SurveyBuilder::with(['departamente', 'categorie_de_control','dimensiuni'])->get();




        return view('admin.surveyBuilders.index', compact('surveyBuilders'));
    }

    public function getDimensions(Request $request)
    {
        $departamentId = $request->depId;

        $departamente = Departamente::find($departamentId);

        if(!$departamente) return response()->json('No departaments found',404);

        $dimensions = $departamente->dimensions->pluck('dimensiune','id');

        return response()->json($dimensions);
    }

    public function getControllCategories()
    {
        return response()->json(CategorieDeControl::all());
    }

    public function create()
    {
        abort_if(Gate::denies('survey_builder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamentes = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categorie_de_controls = CategorieDeControl::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dimensions = Dimensiune::pluck('dimensiune', 'id')->prepend(trans('global.pleaseSelect'), '');



        return view('admin.surveyBuilders.create', compact('categorie_de_controls', 'departamentes','dimensions'));
    }

    public function store(StoreSurveyBuilderRequest $request)
    {
        $surveyBuilder = SurveyBuilder::create($request->all());

        return redirect()->route('admin.survey-builders.index');
    }

    public function edit(SurveyBuilder $surveyBuilder)
    {
        abort_if(Gate::denies('survey_builder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamentes = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categorie_de_controls = CategorieDeControl::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surveyBuilder->load('departamente', 'categorie_de_control');

        return view('admin.surveyBuilders.edit', compact('categorie_de_controls', 'departamentes', 'surveyBuilder'));
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
