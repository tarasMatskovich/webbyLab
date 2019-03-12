<!doctype html>
<html lang="en">
  <?php include_once dirname(__FILE__) . "/layouts/header.php"?>
    <div class="content">
      <div class="container">
        <h2 class="title">
          Загрузка данных из файлов
        </h2>
        <form action="/store/import" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="">Загрузите файл с данными в формате .txt:</label>
            <input type="file" name="file" class="form-control">
          </div>
          <div class="form-group">
            <button class="btn btn-primary">Загрузить</button>
          </div>
        </form>
      </div>
    </div>

  <?php include_once dirname(__FILE__) . "/layouts/footer.php"?>
