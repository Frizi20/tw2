<?php

namespace App\Http\Controllers\Admin;

use App\Models\SurveyResult;
use App\Models\Dimensiune;
use App\Models\CategorieDeControl;
use App\Models\Departamente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController
{
	public function index()
	{
        $departaments =  Departamente::pluck('nume', 'id');


		return view('home', compact('departaments') );
	}

	public function getCategoriesResults(Request $request)
	{

		$getAll = isset($request->all) && $request->all === 'true';
		$depId = $request->depId ?? '';

		$catgegories = DB::table('categorie_de_controls')
			->whereNull('categorie_de_controls.deleted_at')
			->leftJoin('survey_builders as sb', function ($join) use ($depId, $getAll) {
				$join->on('sb.categorie_de_control_id', '=', 'categorie_de_controls.id');

				// Get results by depatament
				if($depId){
					$join->where('sb.departamente_id','=', $depId);
				}
			})

			// ->leftJoin('initiatives', 'category_initiative.initiative_id', '=', 'initiatives.id')
			// ->leftJoin('initiativegroups', 'initiatives.initiativegroup_id', '=', 'initiativegroups.id')
			// ->where('categories.id', '=', 40)
			->leftJoin('survey_results as sr', function ($join) use ($getAll) {
				$join->on('sr.survey_builder_id', '=', 'sb.id');


				// Get results by user
                // $join->where('sr.user_id', '=', 2);
			})
			->leftJoin('users as u', 'u.id', '=', 'sr.user_id')
			->select([
				'categorie_de_controls.id as cat_id',
				'categorie_de_controls.nume as cat_name',
				'sb.id as sb_id',
				'sr.id as sr_id',
				'sb.*',
				'sr.*',
				'u.name as user_name',
				'u.email as user_email',
			])
			->orderBy('cat_id')
			->get();


		$data = [];

		foreach ($catgegories as $category) {

			if (!isset($data[$category->cat_id])) {
				$data[$category->cat_id] = [
					'id'             => $category->cat_id,
					'name'            => $category->cat_name,
					'survey_results' => []
				];
			}

			if ($category->sr_id) {
				$data[$category->cat_id]['survey_results'][] = [
					'id' => $category->sr_id,
					'schema' => $category->schema_results,
					'user_name'  => $category->user_name
				];
			}
		}

		return response()->json($data);
	}

	public function getDepartamentsResults()
	{
		$departaments = DB::table('departamentes')
			->select([
				'departamentes.*',
				'departamentes.id as dep_id'
			])
			->whereNull('departamentes.deleted_at')
			->leftJoin('dimensiunes as dim', 'dim.id', '=', 'departamentes.id')
			->get();


		return response()->json($departaments);
	}

}
