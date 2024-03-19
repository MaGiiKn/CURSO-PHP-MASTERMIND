<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="#">
        <img class="mr-2" src="./static/img/logo.png" />
        ContactsApp
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        
        <div class="d-flex justify-content-between w-100">
          
          <?php if (isset($_SESSION["user"])): ?>
            
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="add.php">Add Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="adresses.php">Add adress</a>
              </li>
              <li class="nav-item" action="logout.php">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
            </ul>
            <div class="p-2">
                <?= $_SESSION["user"]["email"]?>
            </div>
          
          <?php else: ?>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Log in</a>
              </li>
            </ul>
          <?php endif ?>

        </div>

      </div>

    </div>
  </nav>