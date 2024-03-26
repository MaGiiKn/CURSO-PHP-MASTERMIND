       
<?php

  // Usando la misma logica que en la edicion de los contactos, aca con el id de cada ubicacion 
  // mediante una query string puedo localizar la ubicacion y asi editarlo.
  
  require 'database.php';

  session_start();

  if (!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
  }
  $id = $_GET["id"];

  $statement = $conn -> prepare("SELECT * FROM adress WHERE id = :id");
  $statement -> execute([":id" => $id]);

  if ($statement -> rowCount() == 0){
    http_response_code(404);
    echo("HTTP 404 NOT FOUND");
    return;
  }

  $adress = $statement->fetch(PDO::FETCH_ASSOC);

  if ($adress["user_id"] !== $_SESSION["user"]["id"]){
    http_response_code(403);
    echo("HTTP 403 UNAUTHORIZED");
    return;
  } 

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $error = null;

    if(empty($_POST["adress"]) || empty($_POST["phone_number"])){
      $error = "Please fill all the fields";
    }

    $statement = $conn->prepare("UPDATE adress SET adress = :adress WHERE id = :id");
    $statement -> execute([
      ":id" => $id,
      ":adress" => $_POST["adress"]
    ]);

    $_SESSION["flash"] = ["message" => "Adress {$_POST['adress']} updated."];

    header("Location: adresses.php");

    return;
    
  }

?>

<?php require "partials/header.php" ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
        
        <?php if ($error): ?>
          <p class="text-danger">
            <?=$error?>
          </p>
        <?php endif ?>
        
        <form method = 'POST'>
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Adress</label>
              <div class="col-md-6">
                <input value="<?= $adress["adress"]?>"id="adress" type="text" class="form-control" name="adress" required autocomplete="adress" autofocus>
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "partials/footer.php" ?>