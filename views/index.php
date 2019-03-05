<!doctype html>
<html lang="en">
  <? include_once dirname(__FILE__) . "/layouts/header.php"?>
    <div class="content">
      <div class="container">
        <h1 class=main-title>Приложение для хранения информации о фильмах.</h1>
        <div class="list-group">
          <a href="/list" class="list-group-item list-group-item-action active">
            Список фильмов
          </a>
          <a href="/import" class="list-group-item list-group-item-action">Импортировать фильмы с файла</a>
          <a href="/add" class="list-group-item list-group-item-action">Добавить фильмы</a>
        </div>
      </div>
    </div>

  <? include_once dirname(__FILE__) . "/layouts/footer.php"?>