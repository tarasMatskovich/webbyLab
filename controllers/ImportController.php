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
			$filmErrors = 0;
			$actorsErrors = 0;
			if (!preg_match("~(.*).txt~", $_FILES['file']['name'])) {
				Session::setFlash('error', [['Можно загружать только файлы формата .txt']]);
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "/import");
			} else {
				$f = file($_FILES['file']['tmp_name']);
				$f = array_filter($f, function($element) {
				    return (strlen($element) > 1);
				});
				$f = array_values($f);
				$count = count($f);
				$data = [];
				$i = 0;
				while($i < $count) {
					$arr = [];
					$steps = 0;
					$innerCounter = 0;
					$j = $i;
					while($innerCounter < 4) {
						if (trim($f[$j]) != '') {
							$line = explode(":",$f[$j]);
							$arr[$line[0]] = $line[1];
							$innerCounter++;
						}
						$steps++;
						$j++;
						if ($j >= $count) {
							break;
						}
					}
					if ($steps >= 4) {
						$data[] = $arr;
					}
					$i += $steps;
				}
				if (!empty($data)) {
					foreach ($data as $filmD) {
						$film = new Film();
						$filmD['Title'] = trim($filmD['Title']);
						$filmD['Release Year'] = trim($filmD['Release Year']);
						$filmD['Format'] = trim($filmD['Format']);
						if (!isset($filmD['Title']) || !isset($filmD['Release Year']) || !isset($filmD['Format']) || $filmD['Format'] === '' || $filmD['Release Year'] === '' || $filmD['Title'] === '') {
							$filmErrors++;
						} else {
							$film->title = $filmD['Title'];
							$film->year = $filmD['Release Year'];
							$film->format = $filmD['Format'];
							$film->save();
							$stars = explode(",", $filmD['Stars']);
							foreach ($stars as $star) {
								$star = trim($star);
								if ($star === '') {
									$actorsErrors++;
								} else {
									$line = explode(" ", $star);
									if (count($line) < 2) {
										$actorsErrors++;
									} else {
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
						}
					}
				}
				Session::setFlash('success', [['Данные были успешно загружены']]);
				$errors = [];
				if ($filmErrors) {
					$errors[] = "Количество незагруженных фильмов = " . $filmErrors . ". Проверьте в загружаемом файле правильность данных";
				}
				if ($actorsErrors) {
					$errors[] = "Количество незагруженных актеров = " . $actorsErrors . ". Проверьте в загружаемом файле правильность данных";
				}
				if (!empty($errors)) {
					Session::setFlash('error', [$errors]);
				}
				header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
				}
		} else {
			throw new \Exception("Error: Method is not allowed");
		}
	}
}