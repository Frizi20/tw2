<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDimensiuneRequest;
use App\Http\Requests\StoreDimensiuneRequest;
use App\Http\Requests\UpdateDimensiuneRequest;
use App\Models\Departamente;
use App\Models\Dimensiune;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DimensiuneController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dimensiune_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dimensiunes = Dimensiune::with(['departament'])->get();

        return view('admin.dimensiunes.index', compact('dimensiunes'));
    }

    public function create()
    {
        abort_if(Gate::denies('dimensiune_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departaments = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dimensiunes.create', compact('departaments'));
    }

    public function store(StoreDimensiuneRequest $request)
    {
        $dimensiune = Dimensiune::create($request->all());

        return redirect()->route('admin.dimensiunes.index');
    }

    public function edit(Dimensiune $dimensiune)
    {
        abort_if(Gate::denies('dimensiune_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departaments = Departamente::pluck('nume', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dimensiune->load('departament');

        return view('admin.dimensiunes.edit', compact('departaments', 'dimensiune'));
    }

    public function update(UpdateDimensiuneRequest $request, Dimensiune $dimensiune)
    {
        $dimensiune->update($request->all());

        return redirect()->route('admin.dimensiunes.index');
    }

    public function show(Dimensiune $dimensiune)
    {
        abort_if(Gate::denies('dimensiune_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dimensiune->load('departament');

        return view('admin.dimensiunes.show', compact('dimensiune'));
    }

    public function destroy(Dimensiune $dimensiune)
    {
        abort_if(Gate::denies('dimensiune_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dimensiune->delete();

        return back();
    }

    public function massDestroy(MassDestroyDimensiuneRequest $request)
    {
        Dimensiune::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
