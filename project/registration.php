<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homework</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="css/contact.css" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
</head>

<body>

    <main>
        <div class="container">
            <div class="page-header">
                <h1>Registration</h1>
            </div>

            <!-- html form to create product will be here -->
            <?php
            if ($_POST) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['password2'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $account_status = $_POST['account_status'];

                $target_file = "";
                $file_upload_error_messages = "";


                $vaildation = true;


                if ($username == "" || $password == "" ||  $first_name == "" || $last_name == "" || $gender == "" || $date_of_birth == "") {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>Pls don't have empty.</div>";
                    $vaildation = false;
                }

                if (strpos($username, " ") !== false) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>can't space.</div>";
                    $vaildation = false;
                }
                if (strlen($username) < 6) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>The username need more then 6 word.</div>";
                    $vaildation = false;
                }

                if (!preg_match("/[0-9]/", $password) || (!preg_match("/[a-z]/", $password)) || (!preg_match("/[A-Z]/", $password)) || strlen($password) < 8) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>-Need the number !<br>-Need the a-z!<br>-Need the A-Z!<br>-The password need more the 8word!</br></div>";
                    $vaildation = false;
                } else if ($confirm_password !== $password) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>The password not same.</div>";
                    $vaildation = false;
                } else {
                    $password = md5($password);
                }

                if ($date_of_birth > date('Y-m-d')) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>Date of Birth can't in the future.</div>";
                    $vaildation = false;
                }
                $date1 = date_create(date('Y-m-d'));
                $date2 = date_create($date_of_birth);
                $diff = date_diff($date1, $date2);
                $age = $diff->format("%y");
                if ($age <= 18) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>Need 18 Age </div>";
                    $vaildation = false;
                }

                if (!empty($_FILES["image"]["name"])) {
                    include "image_uploaded.php";
                } else {
                    $image = "";
                }

                if ($vaildation == true) {

                    include 'config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO customers SET username=:username, password=:password, first_name=:first_name,customer_image=:customer_image, last_name=:last_name ,gender=:gender, date_of_birth=:date_of_birth, registration_date_time=:registration_date_time, account_status=:account_status";
                        // prepare query for execution
                        $stmt = $con->prepare($query);

                        // bind the parameters
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':password', $password);
                        $stmt->bindParam(':first_name', $first_name);
                        $stmt->bindParam(':last_name', $last_name);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':date_of_birth', $date_of_birth);
                        $registration_date_time = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':registration_date_time', $registration_date_time);
                        $stmt->bindParam(':account_status', $account_status);
                        $stmt->bindParam(':customer_image', $image);
                        // Execute the query

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Registration successful.</div>";
                            header("Location: index.php?error=Registration_successful&id=$id");
                        } else {
                            if (file_exists($target_file)) {
                                unlink($target_file);
                            }
                            echo "<div class='alert alert-danger'>Unsuccessful registration。</div>";
                        }
                    }
                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                } else {
                    if (file_exists($target_file)) {
                        unlink($target_file);
                    }
                    // it means there are some errors, so show them to user
                    echo "<div class='alert alert-danger'>";
                    echo "<div>{$file_upload_error_messages}</div>";
                    echo "</div>";
                }
            }



            ?>

            <!-- PHP insert code will be here -->


            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Username</td>
                        <td><input type='text' name='username' value='' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type='password' name='password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Confirm the Password</td>
                        <td><input type='password' name='password2' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='first_name' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='last_name' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>User image</td>
                        <td><input type="file" name="image" /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td class="d-flex">
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="radio" name="gender" value="Male" id="Male" required>
                                <label class="form-check-label" for="Male">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Female" id="Female" required>
                                <label class="form-check-label" for="Female">
                                    Female
                                </label>
                            </div>
                    </tr>
                    <tr>
                        <td>date_of_birth</td>
                        <td><input type='date' name='date_of_birth' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Account status</td>
                        <td class="d-flex">
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="radio" name="account_status" value="Activation" id="Activation" required>
                                <label class="form-check-label" for="Activation">
                                    Activation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="account_status" value="Inactivated" id="Inactivated">
                                <label class="form-check-label" for="InActivation">
                                    Inactivated
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='index.php' class='btn btn-danger'>Back to Login</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- end .container -->

        <hr class="featurette-divider">

        <!-- FOOTER -->
        <footer class="container">
            <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
            <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
                <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
                <a class="text-decoration-none fw-bold" href="#">Terms</a>
            </p>
        </footer>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>