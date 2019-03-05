<!doctype html>
<html lang="en">
  <? include_once dirname(__FILE__) . "/layouts/header.php"?>
    <div class="content">
      <div class="container">
        <h2 class="title">
          Результат для поиска: <?=$query?>
        </h2>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Название</th>
              <th scope="col">Год выпуска</th>
              <th scope="col">Формат</th>
              <th scope="col">Список актеров</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            <? foreach ($films as $film):?>
            <tr>
              <td>
                <a href="<?="/film/$film->id"?>">
                  <?=$film->title?>
                </a>
              </td>
              <td><?=$film->year?></td>
              <td><?=$film->format?></td>
              <td>
                <?foreach($film->actors as $actor):?>
                  <?=$actor->name?>
                  <?=$actor->surname?>
                  <br>
                <?endforeach;?>
              </td>
              <td>
                <a href="<?="/film/$film->id"?>"><i class="fas fa-bars"></i></a>
              </td>
            </tr>
            <? endforeach;?>
          </tbody>
        </table>
      </div>
    </div>

  <? include_once dirname(__FILE__) . "/layouts/footer.php"?>