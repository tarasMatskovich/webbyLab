<?php

namespace App\Controllers;

use App\Models\Film;
use App\Models\Actor;
use App\Components\View;
use App\Components\Session;
use App\Components\Validator;

class SearchController extends Controller {
	public function search()
	{
		if ($_SERVER['REQUEST_METHOD']  != "POST") {
			throw new \Exception("Error: Method is not allowed");
		}
		if ($_POST['query'] == "") {
			Session::setFlash('error', [['Введите значение для поиска']]);
			header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
		}
		$query = $_POST['query'];
		$films = Film::with('actors')::where(['title' => ['operator' => 'LIKE', 'value' => "%" . $query . "%"]])::getAll();
		return View::render("search", ['query' => $query, 'films' => $films]);
	}

	public function searchByActor()
	{
		if ($_SERVER['REQUEST_METHOD']  != "POST") {
			throw new \Exception("Error: Method is not allowed");
		}

		$rules = ['query' => ['required']];
		$messages = ['query.required' => 'Введите строку для поиска'];
		$data = ['query' => $_POST['query']];
		$validator = Validator::validate($data, $rules, $messages);
		if ($validator->getErrorsCount()) {
			Session::setFlash('error', $validator->getErrors());
			header('Location: http://'.$_SERVER['HTTP_HOST']. "/actors/search");
		}
		$segments = explode(" ", $data['query']);
		Actor::where(['name' => ['operator' => 'LIKE', 'value' => $segments[0]]])::orWhere(['surname' => ['operator' => 'LIKE', 'value' => $segments[0]]]);
		if (count($segments) > 1) {
			foreach ($segments as $value) {
				Actor::where(['name' => ['operator' => 'LIKE', 'value' => $value]])::orWhere(['surname' => ['operator' => 'LIKE', 'value' => $value]]);
			}
		}
		$actors = Actor::getAll();

		$ids = "(";

		foreach ($actors as $actor) {
			$ids .= $actor->film_id . ",";
		}
		$ids = substr($ids, 0, -1);
		$ids .= ")";
		$films = [];
		if (!empty($actors)) {
			$films = Film::with("actors")::where(['id' => ['operator' => 'IN', 'value' => $ids]])::getAll();
		}
		return View::render("search", ['query' => $data['query'], 'films' => $films]);
	}

	public function actors()
	{
		return View::render("search_by_actor");
	}
}