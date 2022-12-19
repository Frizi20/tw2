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

        $dimensiunes = Dimensiune::with(['departaments'])->get();




        return view('admin.dimensiunes.index', compact('dimensiunes'));
    }



    public function create()
    {
        abort_if(Gate::denies('dimensiune_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departaments = Departamente::pluck('nume', 'id');

        $dimensions = Dimensiune::pluck('dimensiune', 'id')->prepend(trans('global.pleaseSelect'), '');



        return view('admin.dimensiunes.create', compact('departaments', 'dimensions'));
    }
    // StoreDimensiuneRequest
    public function store(Request $request)
    {

        $dimensiune = Dimensiune::create([
            'dimensiune' => $request->input('dimensiune')
        ]);

        $x = $dimensiune->departaments()->sync($request->input('departaments',[]));
        // $role = Role::create($request->all());
        // $role->permissions()->sync($request->input('permissions', []));

        // return redirect()->route('admin.roles.index');

        return response()->json($x);

        // $dimensiune = Dimensiune::create($request->all());
        $dimensiune = Dimensiune::create([
            'dimensiune' => 'Dimensiune Conta'
        ]);

        $dimensiune->departamentx()->attach([2, 3]);

        // return redirect()->route('admin.dimensiunes.index');


        return response()->json($request->all());
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
