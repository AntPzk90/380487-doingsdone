<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form"  action="add.php" method="post" enctype="multipart/form-data">
  <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>

    <input class="form__input <?php if($errors["title"]): ?> form__input--error <?php endif; ?>" type="text" name="title" id="name" value="" placeholder="Введите название" >
    <?php if($errors["title"]): ?>
      <p class="form__message"><?= $name_task_error; ?></p>
    <?php endif; ?>
  </div>
  
  <div class="form__row">
    <label class="form__label" for="project">Проект</label>
    <select class="form__input form__input--select" name="name_project" id="project">
    <?php foreach ($projects as $projects_item) : ?>
      <option value="<?= $projects_item["name_project"]; ?>"><?= $projects_item["name_project"]; ?></option>
    <?php endforeach?>
    </select>
  </div>
  
  <div class="form__row">
    <label class="form__label" for="date">Дата выполнения</label>

    <input class="form__input form__input--date <?php if($errors["date_error"]): ?> form__input--error <?php endif; ?>" type="date" name="deadline" id="date" value="<?php if($errors["date_error"]): ?><?= $date ?><?php endif; ?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?php if(!empty($errors["date_error"])): ?>
      <p class="form__message"><?= $date_task_error; ?></p>
    <?php endif; ?>
  </div>

  <div class="form__row">
    <label class="form__label" for="preview">Файл</label>

    <div class="form__input-file">
      <input class="visually-hidden" type="file" name="preview" id="preview" value="">

      <label class="button button--transparent" for="preview">
        <span>Выберите файл</span>
      </label>
    </div>
  </div>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Добавить">
  </div>
</form>
