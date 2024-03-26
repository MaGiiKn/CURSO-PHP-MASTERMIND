<?php

  require 'database.php';

  session_start();

  if (!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
  }

  // Aca estoy sacando de la base de datos el contacto y las ubiaciones que estan vinculadas a ese contacto

  $contacts = $conn -> query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']}");
  
  $contactAdresses = $conn -> query("SELECT * FROM adress WHERE user_id = {$_SESSION['user']['id']}");

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
    
    <!-- En este bucle por cada contacto estoy extrayendo de la base de datos todas las direcciones que le pertenecen a ese contacto. -->
    
    <?php $contactAdress = $conn -> query("SELECT * FROM adress WHERE adress_id = {$contact['id']} "); ?>
    
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
          <a href="newAdress.php?id=<?=$contact["id"]?>"class="m-2">Add adress</a>

          <!-- Por cada contacto que este recorriendo el primer bucle en este segundo bucle estoy recorriendo 
          cada direccion que le pertenece a cada contacto. -->
          
          <?php foreach ($contactAdress as $adress): ?>

            <div class="row m-2">
              
              <a class="col text-white text-start" style="text-decoration:none"><i class="fa-solid fa-location-dot text-success  "> </i> <?=$adress['adress']?></a>            
              
              <div class="col">
                <a class="m-2" href="editAdress.php?id=<?=$adress["id"]?>"><i class="fa-regular fa-pen-to-square"></i></a>
                <a class="m-2 text-danger" href="deleteAdress.php?id=<?=$adress["id"]?>"><i class="fa-solid fa-trash"></i></a>
              </div>
              
            </div>

          <?php endforeach ?>

        </div>
      </div>
    </div>

  <?php endforeach ?>

  </div>
</div>

<?php require "partials/footer.php" ?>