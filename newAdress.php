
<?php

  require 'database.php';

  session_start();

  if (!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
  }

  $statement = $conn->prepare("SELECT * FROM contacts WHERE user_id = :user_id AND id = :id");

  $statement->execute([
    ":user_id" => $_SESSION["user"]["id"],
    ":id" => $_GET["id"]
  ]);

  $contact = $statement->fetch(PDO::FETCH_ASSOC);

  // Seleccionar de la base de datos el contacto que tenga el mismo id que el cliente
  // y que el contacto tenga el mismo id que el query string que recibimos del GET, con
  // esto restrinjo que se seleccionen contactos ajenos.

  $statement = $conn->prepare("SELECT * FROM adress WHERE user_id = :user_id AND id = :id");

  $statement->execute([
    ":user_id" => $_SESSION["user"]["id"],
    ":id" => $_GET["id"]
  ]);

  $userAdress = $statement->fetch(PDO::FETCH_ASSOC);

  if ($contact["user_id"] !== $_SESSION["user"]["id"]){
    http_response_code(403);
    echo("HTTP 403 UNAUTHORIZED");
    return;

  }

  // Acá estoy restringiendo nuevamente que algun usuario externo no pueda acceder a un contacto que no es suyo,
  // en caso de que suceda, lanzarle un 403.

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $error = null;

    $statement = $conn->prepare("INSERT INTO adress (adress, user_id, adress_id) VALUES (:adress, :user_id, :adress_id)");

    $statement->execute([
      ":adress" => $_POST["adress"],
      ":user_id" => $_SESSION["user"]["id"],
      ":adress_id" => $_GET["id"]
    ]);

    $_SESSION["flash"] = ["message" => "Adress added"];

    header("Location: adresses.php");

    return;

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
              <label for="name" class="col-md-4 col-form-label text-md-end">Adress</label>
              <div class="col-md-6">
                <input id="adress" type="text" class="form-control" name="adress" required autocomplete="adress" autofocus>
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