<?php

namespace App\Controllers;

use App\Components\View;

class IndexController extends Controller {

	public function index()
	{
		return View::render("index");
	}
}