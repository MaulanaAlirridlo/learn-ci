<?= $this->extend('layouts/index') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1>Data User</h1>
<?php if (session()->getFlashdata('flash')) { ?>
  <div class="alert alert-success" role="alert">
    <?= session()->getFlashdata('flash') ?>
  </div>
<?php } ?>
<a href="/user">
  <button class="btn btn-primary float-right mt-1 mb-3">Add</button>
</a>
<!-- karena diproses di controller yang sama action bisa dikosongi -->
<form action="">
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" name="searchKeyword">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="submit">Cari</button>
    </div>
  </div>
</form>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Id</th>
      <th scope="col">Foto</th>
      <th scope="col">Name</th>
      <th scope="col">Address</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1 + ($countItem * ($currentPage - 1));
    foreach ($users as $key => $v) {
    ?>
      <tr>
        <th scope="row"><?= $no++ ?></th>
        <td scope="row"><?= $v->id ?></td>
        <td><img class="w-25" src="/storage/img/<?= $v->photo != '' ? $v->photo : 'default.png' ?>" alt=""></td>
        <td><?= $v->name ?></td>
        <td><?= $v->address ?></td>
        <td>
          <a href="/user/<?= $v->id ?>">
            <button class="btn btn-warning">Edit</button>
          </a>
          <form action="/user/<?= $v->id ?>/<?= $v->photo ?>" method="post" class="d-inline">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger d-inline">Delete</button>
          </form>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>
<?= $pager->links('users', 'pagination') ?>
<?= $this->endSection() ?>