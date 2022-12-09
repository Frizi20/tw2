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

class SurveyResultController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('survey_result_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surveyResults = SurveyResult::with(['departament', 'user'])->get();

        return view('admin.surveyResults.index', compact('surveyResults'));
    }

    public function create()
    {
        abort_if(Gate::denies('survey_result_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departaments = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user =Auth::user()->name;


        return view('admin.surveyResults.create', compact('departaments', 'user'));
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
