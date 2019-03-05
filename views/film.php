<!doctype html>
<html lang="en">
  <? include_once dirname(__FILE__) . "/layouts/header.php"?>
    <div class="content">
      <div class="container">
        <h2 class="title">Информация про фильм</h2>
        <div class="card">
          <h5 class="card-header"><?=$film->title?></h5>
          <div class="card-body">
            <h5 class="card-title">Год выпуска - <?=$film->year?></h5>
            <h5 class="card-title">Формат - <?=$film->format?></h5>
            <p class="card-text">Список актеров:</p>
            <ul class="list-group">
              <? foreach($film->actors as $actor):?>
              <li class="list-group-item"><?=$actor->name . " " . $actor->surname?></li>
              <? endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

  <? include_once dirname(__FILE__) . "/layouts/footer.php"?>