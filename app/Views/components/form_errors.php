<?php if (! empty($errors) && is_array($errors)) : ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $err) : ?>
        <li><?= esc($err) ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>
