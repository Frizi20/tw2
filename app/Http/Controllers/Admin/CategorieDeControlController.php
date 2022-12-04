<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategorieDeControlRequest;
use App\Http\Requests\StoreCategorieDeControlRequest;
use App\Http\Requests\UpdateCategorieDeControlRequest;
use App\Models\CategorieDeControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategorieDeControlController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('categorie_de_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorieDeControls = CategorieDeControl::all();

        return view('admin.categorieDeControls.index', compact('categorieDeControls'));
    }

    public function create()
    {
        abort_if(Gate::denies('categorie_de_control_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categorieDeControls.create');
    }

    public function store(StoreCategorieDeControlRequest $request)
    {
        $categorieDeControl = CategorieDeControl::create($request->all());

        return redirect()->route('admin.categorie-de-controls.index');
    }

    public function edit(CategorieDeControl $categorieDeControl)
    {
        abort_if(Gate::denies('categorie_de_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categorieDeControls.edit', compact('categorieDeControl'));
    }

    public function update(UpdateCategorieDeControlRequest $request, CategorieDeControl $categorieDeControl)
    {
        $categorieDeControl->update($request->all());

        return redirect()->route('admin.categorie-de-controls.index');
    }

    public function show(CategorieDeControl $categorieDeControl)
    {
        abort_if(Gate::denies('categorie_de_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categorieDeControls.show', compact('categorieDeControl'));
    }

    public function destroy(CategorieDeControl $categorieDeControl)
    {
        abort_if(Gate::denies('categorie_de_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorieDeControl->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategorieDeControlRequest $request)
    {
        CategorieDeControl::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
