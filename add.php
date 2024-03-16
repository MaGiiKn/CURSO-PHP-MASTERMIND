       
<?php
  
  require 'database.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $error = null;

    if(empty($_POST["name"]) || empty($_POST["phone_number"])){
      $error = "Please fill all the fields";
    }elseif(strlen($_POST["phone_number"]) < 9 && is_numeric($_POST["phone_number"])) {
      $error = "Please enter a valid phone number";
    }elseif(!is_numeric($_POST["phone_number"])){
      $error = "Please enter a numeric phone number";
    }else{

    $contact = [
      $name = $_POST['name'],
      $phoneNumber = $_POST['phone_number']
    ];

    $statement = $conn->prepare("INSERT INTO contacts (name, phone_number) values ('$name', '$phoneNumber')");
    $statement -> execute();

    header("Location: index.php");
    

  }
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