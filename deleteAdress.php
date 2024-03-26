<?php

// Para eliminar la ubicacion use la misma que se uso para eliminar los contactos, simplemente 
// con una query string le doy un id unico a cada a cada ubicacion y con ese id puedo localizar
// la ubicacion y asi poder modificarlo.

require "database.php";

session_start();

if (!isset($_SESSION["user"])){
  header("Location: index.php");
  return;
}

$id = $_GET["id"];

$statement = $conn -> prepare("SELECT * FROM adress WHERE id = :id LIMIT 1");
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

$conn -> prepare ("DELETE FROM adress WHERE id = :id")-> execute([":id" => $id]);

$_SESSION["flash"] = ["message" => "Adress {$adress['adress']} deleted."];

header("Location: home.php");

?>