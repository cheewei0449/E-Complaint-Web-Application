<!DOCTYPE HTML>
<html>


<head>
  <title>PDO - Create a Record - PHP CRUD Tutorial</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="css/login_page.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
</head>

<body class="text-center">
  <?php
  session_start();
  if ($_GET) {
    $error = $_GET['error'];

    if ($error == "logout") {
      echo "<div class = 'alert alert-success align-item-center'>Logout Successfully</div>";
    } elseif ($error == "session_expired") {
      echo "<div class = 'alert alert-danger align-item-center'>Access Denied</div>";
    }
  }
  if ($_POST) {
    $username = trim($_POST['username']);
    $pass = trim($_POST['password']);

    $validate = true;

    if ($username == "") {
      echo "<div class='alert alert-danger align-item-center'>Please enter your username</div>";
      $validate = false;
    }

    if ($pass == "") {
      echo "<div class='alert alert-danger align-item-center'>Please enter your password</div>";
      $validate = false;
    }

    if ($validate) {
      include 'config/database.php';
      try {

        // prepare select query
        $query = "SELECT username, password, account_status FROM customers WHERE username = :username";
        $stmt = $con->prepare($query);

        $stmt->bindParam(':username', $username);
        // execute our query
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
          // store retrieved row to a variable
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          extract($row);

          if ($pass == $password) {
            switch ($account_status) {
              case "Inactivated":
                echo "<div class='alert alert-danger align-item-center'>Your Account is Inactivated</div>";
                break;
              case "Activation":
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("Location: index.php");
                break;
              default:
                echo "<div class='alert alert-danger align-item-center'>No account status stated</div>";
            }
          } else {
            echo "<div class='alert alert-danger align-item-center mt-5'>Incorrect Password</div>";
          }
        } else {
          echo "<div class='alert alert-danger align-item-center mt-5'>User not found (Invalid Account)</div>";
        }
      }

      // show error
      catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
      }
    }
  }
  ?>

  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="vh-100 ">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                <div class="form-outline form-white mb-4">
                  <input type="text" id="typeusername" class="form-control  form-control-lg" name="username" />
                  <label class="form-label" for="typeusername">Username</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password" />
                  <label class="form-label" for="typePasswordX">Password</label>
                </div>
                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <hr class="featurette-divider">

  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
    <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
      <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
      <a class="text-decoration-none fw-bold" href="#">Terms</a>
    </p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>