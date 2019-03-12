<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/all.css">
    <link rel="stylesheet" href="/public/css/main.css">

    <title>Films App</title>
  </head>
  <body>
  	<div id="app">
  <div class="main-menu">
  	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="/">Films App</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active">
	        <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="/list">Список фильмов</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="/import">Импортировать</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="/actors/search">Поиск по актерам</a>
	      </li>
	    </ul>
	    <form class="form-inline my-2 my-lg-0" method="POST" action="/search">
	      <input class="form-control mr-sm-2" type="search" placeholder="Название фильма" aria-label="Search" name="query">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
	    </form>
	  </div>
	</nav>
	<div class="alerts">
  		<?if (\App\Components\Session::isset('error')): ?>
			<?foreach (\App\Components\Session::get('error') as $error):?>
				<? foreach ($error as $e):?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  <?=$e?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?endforeach?>
			<?endforeach;?>
  		<? endif;?>

  		<?if (\App\Components\Session::isset('success')): ?>
			<?foreach (\App\Components\Session::get('success') as $error):?>
				<? foreach ($error as $e):?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <?=$e?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?endforeach?>
			<?endforeach;?>
  		<? endif;?>
  	</div>
  	</div>
  </div>