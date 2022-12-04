<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDepartamenteRequest;
use App\Http\Requests\StoreDepartamenteRequest;
use App\Http\Requests\UpdateDepartamenteRequest;
use App\Models\Departamente;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartamenteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('departamente_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamentes = Departamente::with(['created_by'])->get();

        return view('admin.departamentes.index', compact('departamentes'));
    }

    public function create()
    {
        abort_if(Gate::denies('departamente_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departamentes.create');
    }

    public function store(StoreDepartamenteRequest $request)
    {
        $departamente = Departamente::create($request->all());

        return redirect()->route('admin.departamentes.index');
    }

    public function edit(Departamente $departamente)
    {
        abort_if(Gate::denies('departamente_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamente->load('created_by');

        return view('admin.departamentes.edit', compact('departamente'));
    }

    public function update(UpdateDepartamenteRequest $request, Departamente $departamente)
    {
        $departamente->update($request->all());

        return redirect()->route('admin.departamentes.index');
    }

    public function show(Departamente $departamente)
    {
        abort_if(Gate::denies('departamente_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamente->load('created_by');

        return view('admin.departamentes.show', compact('departamente'));
    }

    public function destroy(Departamente $departamente)
    {
        abort_if(Gate::denies('departamente_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departamente->delete();

        return back();
    }

    public function massDestroy(MassDestroyDepartamenteRequest $request)
    {
        Departamente::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
