       
<?php
  
  require 'database.php';

  session_start();

  if (!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
  }

  // Seleccionar de la base de datos el contacto que tenga el mismo id que el cliente 
  // y que el contacto tenga el mismo id que el query string que recibimos del GET, con
  // esto restrinjo que se seleccionen contactos ajenos

  
  $statement = $conn ->prepare("SELECT * FROM contacts WHERE user_id = :user_id AND id = :id");

  $statement->execute([
    ":user_id" => $_SESSION["user"]["id"],
    ":id" => $_GET["id"]
  ]);

  $contact = $statement->fetch(PDO::FETCH_ASSOC);

  // Acá estoy restringiendo nuevamente que algun usuario externo pueda acceder a un contacto que no es suyo,
  // en caso de que suceda, lanzarle un 403.

  if ($contact["user_id"] !== $_SESSION["user"]["id"]){
    http_response_code(403);
    echo("HTTP 403 UNAUTHORIZED");
    return;
    
  }


  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $error = null;
    
    

   

  }

?>

<?php require "partials/header.php" ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Adress to <?= $contact["name"]?></div>
        <div class="card-body">
        <?php if ($error): ?>
          <p class="text-danger">
            <?=$error?>
          </p>
        <?php endif ?>
        <form method = 'POST'>
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
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