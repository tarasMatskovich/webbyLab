<?php

namespace App\Controllers;

use App\Components\View;
use App\Models\Film;
use App\Models\Actor;
use App\Components\Validator;
use App\Components\Session;

class FilmController extends Controller {
	public function index()
	{
		$order = ['title' => "ASC"];
		if (isset($_GET['sort'])) {
			switch($_GET['sort']) {
				case 1:
					$order = ['title' => "ASC"];
					break;
				case 2:
					$order = ['title' => "DESC"];
					break;
			}
		}
		$films = Film::with("actors")::orderBy($order)::getAll();
		return View::render("films_list", ["films" => $films]);
	}

	public function show($id)
	{
		$film = Film::with('actors')::find($id);
		if (!$film)
			throw new \Exception("Error: Such Film does not exist!");
		return View::render("film", ['film' => $film]);
	}

	public function add()
	{
		return View::render("film_add");
	}

	public function addFilm()
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$rules = [
				'title' => ['required'],
				'year' => ['required'],
				'format' => ['required']
			];
			$data = [
				'title' => $_POST['title'],
				'year' => $_POST['year'],
				'format' => $_POST['format'],
			];
			$messages_film = [
				'title.required' => 'Поле Название обезательное',
				'year.required' => 'Поле Год выпуска обезательное',
				'format.required' => 'Поле Формат обезательное',
			];
			$errors = [];
			$validator_film = Validator::validate($data, $rules, $messages_film);
			if($validator_film->getErrorsCount()) {
				$errors = $validator_film->getErrors();
			}
			if (!$_POST['actors']) {
				$errors['actors'] = ["Список актеров не должен быть пустым"];
			} else {
				if ((int)$_POST['year'] <= 0) {
					$errors['film'] = ["Год выпуска не может быть меньше или равно 0"];
				} else {
					foreach ($_POST['actors'] as $actor) {
						$validator_actors = Validator::validate(['actor'], ['name' => ['required'], 'surname' => ['required']], ['name.required' => 'Поле Имя обезательное', 'surname.required' => 'Поле Фамилия обезательное']);
						if ($validator_actors->getErrorsCount()) {
							$actorError = $validator_actors->getErrors();
							$errors = array_merge($errors, $actorError);
						}
					}
				}
			}
			if (count($errors)) {
				Session::setFlash('error', $errors);
				header('Location: http://'.$_SERVER['HTTP_HOST']. "/add");
			} else {
				$film = new Film();
				$film->title = $_POST['title'];
				$film->year = (int)$_POST['year'];
				$film->format = $_POST['format'];
				if ($film->save()) {
					foreach ($_POST['actors'] as $actorI) {
						$actor = new Actor();
						$actor->name = $actorI['name'];
						$actor->surname = $actorI['surname'];
						$actor->film_id = $film->id;
						$actor->save();
					}
					Session::setFlash('success', [['Фильм был успешно добавлен']]);
					header('Location: http://'.$_SERVER['HTTP_HOST']. "/list");
				} else {
					Session::setFlash('error', [['При сохранении фильма в базе данных произошла ошибка']]);
					header('Location: http://'.$_SERVER['HTTP_HOST']. "/list");
				}
			}
		} else {
			throw new \Exception("Error: 404 Resource not found");
		}
	}

	public function delete($id)
	{
		$film = Film::find($id);
		if (!$film)
			throw new \Exception("Error: 404 film is not found");

		if ($film->delete()) {
				Session::setFlash('success', [['Фильм был успешно удален']]);
				header('Location: http://'.$_SERVER['HTTP_HOST']. "/list");
		} else {
				Session::setFlash('error', [['При удалении фильма в базе данных произошла ошибка']]);
				header('Location: http://'.$_SERVER['HTTP_HOST']. "/list");
		}
	}
}
