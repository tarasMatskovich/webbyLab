<!doctype html>
<html lang="en">
  <? include_once dirname(__FILE__) . "/layouts/header.php"?>
    <div class="content">
      <div class="container">
        <h2 class="title">
          Поиск фильма по актерам
        </h2>
        <form action="/searchByActor" method="POST">
          <div class="form-group">
            <label for="query">Имя или фамилия актера:</label>
            <input type="text" name="query" class="form-control" placeholder="Введите имя или фамилию актера">
          </div>
          <div class="form-group">
            <button class="btn btn-success">Найти</button>
          </div>
        </form>
      </div>
    </div>

  <? include_once dirname(__FILE__) . "/layouts/footer.php"?>