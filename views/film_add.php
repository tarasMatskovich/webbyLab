<!doctype html>
<html lang="en">
  <?php include_once dirname(__FILE__) . "/layouts/header.php"?>
    <div class="content">
      <div class="container">
        <h2 class="title">Добавление нового фильма</h2>
        <form action="/addFilm" method='POST' @submit="onSubmit">
          <div class="form-group">
            <label for="title">Название</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Название фильма">
          </div>
          <div class="form-group">
            <label for="year">Год выпуска</label>
            <input type="number" name="year" class="form-control" id="year" placeholder="Год выпуска фильма">
          </div>
          <div class="form-group">
            <label for="format">Формат</label>
            <select name="format" id="format" class="form-control">
              <option value="VHS">VHS</option>
              <option value="DVD">DVD</option>
              <option value="Blu-Ray">Blue-Ray</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Списки актеров</label>
            <div id="actors-hidden">

            </div>
            <ul class="actors-list list-group">
              <li class="list-group-item" v-for="actor in actors">{{actor.name}} {{actor.surname}} <i class="fas fa-times delete-actor" @click="deleteActor(actor.id)"></i></li>
            </ul>
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" placeholder="Имя актера" v-model="name">
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" placeholder="Фамилия актера" v-model="surname">
                </div>
              </div>
            </div>
            <button class="btn btn-secondary add-actor" type="button" @click="onAddActor">Добавить актера</button>
          </div>
          <button class="btn btn-success">Добавить фильм</button>
        </form>
      </div>
    </div>

  <?php include_once dirname(__FILE__) . "/layouts/footer.php"?>
