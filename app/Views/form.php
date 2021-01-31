<?= $this->extend('layouts/index') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (!isset($user)) { ?>
  <h1><?= $title ?></h1>
  <div class="form-group">
    <form action="/user" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="text" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : '' ?>" value="<?= old('name') ?>" name="name">
      <div class="invalid-feedback">
        <?= $validation->getError('name') ?>
      </div>
      <input type="text" class="form-control" value="<?= old('address') ?>" name="address">
      <div class="custom-file">
        <input type="file" accept="image/*" class="custom-file-input <?= $validation->hasError('img') ? 'is-invalid' : '' ?>" id="img" name="img">
        <label class="custom-file-label" for="img">Choose file</label>
        <div class="invalid-feedback">
          <?= $validation->getError('img') ?>
        </div>
      </div>
      <input type="submit" class="btn btn-primary" name="submit" value="simpan">
    </form>
  </div>
<?php } else { ?>
  <h1><?= $title ?></h1>
  <div class="form-group">
    <form action="/user/<?= $user->id ?>/<?= $user->photo ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <img class="w-25" src="/storage/img/<?= $user->photo != '' ? $user->photo : 'default.png' ?>" alt="">
      <div class="custom-file">
        <input type="file" accept="image/*" class="custom-file-input <?= $validation->hasError('img') ? 'is-invalid' : '' ?>"" id="img" name="img">
        <label class="custom-file-label" for="img">Choose file</label>
        <div class="invalid-feedback">
          <?= $validation->getError('img') ?>
        </div>
      </div>
      <input type="text" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : '' ?>" name="name" value="<?= !empty(old('name')) ? old('name') : $user->name ?>">
      <div class="invalid-feedback">
        <?= $validation->getError('name') ?>
      </div>
      <input type="text" class="form-control" name="address" value="<?= !empty(old('address')) ? old('address') : $user->address ?>">
      <input type="submit" class="btn btn-primary" name="submit" value="simpan">
    </form>
  </div>
<?php } ?>
<?= $this->endSection() ?>