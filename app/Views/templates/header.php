<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <title><?= $title; ?></title>
  <?= $this->renderSection('head'); ?>

</head>

<body>
  <?php
  $uri = service('uri');
  ?>
  <nav class="navbar navbar-expand-lg bg-transparant">
    <div class="container">
      <a class="navbar-brand fs-2" href="/">Ci4</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if (session()->get('isLoggedIn')) : ?>
          <ul class="navbar-nav mr-auto">
            <?php $role = session()->get('role'); ?>
            <?php if ($role == 'admin') :  ?>
              <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
                <a class="nav-link fs-4" href="/dashboard">Dashboard</a>
              </li>
              <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'laporan' ? 'active' : null) ?>">
                <a class="nav-link fs-4" href="/laporan">Laporan</a>
              </li>
              <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'wilayah' ? 'active' : null) ?>">
                <a class="nav-link fs-4" href="/wilayah">Data Wilayah</a>
              </li>
            <?php elseif ($role == 'user') :  ?>
              <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'chat' ? 'active' : null) ?>">
                <a class="nav-link fs-4" href="/chat">Chat</a>
              </li>
              <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'maps' ? 'active' : null) ?>">
                <a class="nav-link fs-4" href="/maps">Maps</a>
              </li>
              <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'halaman_utama' ? 'active' : null) ?>">
                <a class="nav-link fs-4" href="/halaman_utama">Maps</a>
              </li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item fs-4">
              <a class="nav-link fs-4" href="/logout">Logout</a>
            </li>
          </ul>
        <?php else : ?>
          <ul class="navbar-nav mr-auto">
            <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'chat' ? 'active' : null) ?>">
              <a class="nav-link fs-4" href="/chat">Chat</a>
            </li>
            <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'maps' ? 'active' : null) ?>">
              <a class="nav-link fs-4" href="/maps">Maps</a>
            </li>
            <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'halaman_utama' ? 'active' : null) ?>">
              <a class="nav-link fs-4" href="/halaman_utama">Halaman Utama</a>
            </li>
            <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'login' ? 'active' : null) ?>">
              <a class="nav-link fs-4" href="/login">Login</a>
            </li>
            <li class="nav-item fs-4<?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
              <a class="nav-link fs-4" href="/register">Register</a>
            </li>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </nav>