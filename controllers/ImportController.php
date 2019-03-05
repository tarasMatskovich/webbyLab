<?php

namespace App\Controllers;

use App\Components\View;
use App\Models\Film;
use App\Models\Actor;
use App\Components\Session;

class ImportController extends Controller {

	public function index()
	{
		return View::render("import");
	}

	public function store()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
			$f = file($_FILES['file']['tmp_name']);
			$f = array_filter($f, function($element) {
			    return (strlen($element) > 1);
			});
			$f = array_values($f);
			$count = count($f);
			$data = [];
			for($i = 0; $i < $count; $i += 4) {
				$arr = [];
				for ($j = $i; $j < $i + 4; $j++) {
					$line = explode(":",$f[$j]);
					$arr[$line[0]] = $line[1];
				}
				$data[] = $arr;
			}
			if (!empty($data)) {
				foreach ($data as $filmD) {
					$film = new Film();
					$film->title = $filmD['Title'];
					$film->year = $filmD['Release Year'];
					$film->format = trim($filmD['Format']);
					$film->save();
					$stars = explode(",", $filmD['Stars']);
					foreach ($stars as $star) {
						$star = trim($star);
						$line = explode(" ", $star);
						$name = $line[0];
						$surname = $line[1];
						$actor = new Actor();
						$actor->name = $name;
						$actor->surname = $surname;
						$actor->film_id = $film->id;
						$actor->save();
					}
				}
			}
			Session::setFlash('success', [['Данные были успешно загружены']]);
			header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
		} else {
			throw new \Exception("Error: Method is not allowed");
		}
	}
}