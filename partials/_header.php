<?php
echo '
<nav class="navbar navbar-dark navbar-expand-lg bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">iQure.Ai</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="patient.php">Patients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="contact.php">Contact</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success mx-2" type="submit">Search</button>
      </form>
     
      ';
echo '<div>
        <button class="btn btn-outline-success ml-2 " data-bs-toggle="modal" data-bs-target="#loginModal"  type="submit">Login</button>
        <button class="btn btn-outline-success ml-2 "data-bs-toggle="modal" data-bs-target="#SignupModal"  type="submit">SignUp</button>
        </div>
        ';
echo
  '
    </div>
  </div>
</nav>
';
?>