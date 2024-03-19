<?php

  require 'database.php';

  session_start();

  if (!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
  }

  $contacts = $conn -> query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']}");

?>

<?php require "partials/header.php" ?>

<div class="container pt-4 p-3">
  <div class="row">
    
  <?php if ($contacts->rowCount() == 0): ?>
    
    <div class="col-md-4 mx-auto">
      <div class="card card-body text-center">
        <p>No contacts saved yet</p>
        <a href="add.php">Add One!</a>
      </div>
    </div>
    
  <?php endif ?>  
  
  <?php foreach ($contacts as $contact): ?>

    <?php $message = $contact["id"] ?> 
      
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
          <div class="mb-3"><a href="newAdress.php?id=<?= $contact["id"]?>" class="m-2 text-success text-decoration-underline"> Add Adress </a></div>
          <a href="#?id=<?= $contact["id"]?>" class="btn btn-secondary mb-2 m-1">Edit adress</a>
          <a href="#?id=<?= $contact["id"]?>" class="btn btn-danger mb-2 m-1">Delete Contact</a>
        </div>
      </div>
    </div>

    <?php endforeach ?>

  </div>
</div>

<?php require "partials/footer.php" ?>