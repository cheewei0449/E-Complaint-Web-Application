<!DOCTYPE html>
<html>



<head>

    <?php include "bootstrap.php"; ?>

    <title>Registration</title>

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/register.css" />

</head>

<body>
    <!-- NAVBAR -->
    <?php

    // Function to check string starting
    // with given substring
    function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    function active($pagename)
    {
        return basename($_SERVER["PHP_SELF"]) == $pagename ? "active" : "";
    }

    function active_startwith($pagename_start)
    {
        return startsWith(basename($_SERVER["PHP_SELF"]), "$pagename_start") ? "active" : "";
    }


    include 'config/database.php';

    ?>
    <!-- NAVBAR END -->
    <main>

        <!-- Container -->
        <div class="container mt-5">
            <div class="page-header">
                <h1>Registration</h1>
            </div>

            <!-- html form to create product will be here -->
            <?php
            $file_upload_error_messages = "";

            if ($_POST) {
                $userID = trim($_POST['userID']);
                $password = $_POST['password'];
                $confirm_password = $_POST['password2'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $gender = $_POST['gender'];

                $validation = true;

                // Check Empty
                if ($userID == "" || $password == "" || $username == "" || $email == "" || $role == "") {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>Please make sure all fields are not empty</div>";
                    $validation = false;
                }

                // include database connection
                include 'config/database.php';

                // delete message prompt will be here

                // select all data
                $query_check = "SELECT userID FROM users WHERE userID=:userID";
                $stmt_check = $con->prepare($query_check);
                $stmt_check->bindParam(':userID', $userID);

                $stmt_check->execute();

                // this is how to get number of rows returned
                $num_check = $stmt_check->rowCount();

                if ($num_check > 0) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>User already exist</div>";
                    $validation = false;
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

                if ($validation == true) {
                    // include database connection
                    include 'config/database.php';

                    try {
                        // insert query
                        $query = "INSERT INTO users SET userID=:userID, password=:password, username=:username, gender=:gender, email=:email, role=:role ,register_date=:register_date";
                        // prepare query for execution
                        $stmt = $con->prepare($query);

                        // bind the parameters
                        $stmt->bindParam(':userID', $userID);
                        $stmt->bindParam(':password', $password);
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':role', $role);
                        $register_date = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':register_date', $register_date);

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Registration successful.</div>";
                            header("Location: index.php?message=Registration_successful&id=&id");
                            ob_end_flush();
                        } else {
                            if (file_exists($target_file)) {
                                unlink($target_file);
                            }
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }
                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                } else {
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
                <div class="m-auto">
                    <p class="fw-bold">userID</p>
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" class="form-control" name="userID" value="<?php echo isset($userID) ? $userID : ""; ?>" placeholder="userID" aria-label="userID" aria-describedby="basic-addon1" />
                    </div>
                </div>
                <div class="d-md-flex row">
                    <div class="mb-3 col">
                        <p class="fw-bold">Password</p>
                        <div class="input-group input-group-lg">
                            <input type='password' name='password' class='form-control input-group-lg' />
                        </div>
                    </div>
                    <div class="ms-md-1 mb-3 col">
                        <p class="fw-bold">Confirm Password</p>
                        <div class="input-group input-group-lg">
                            <input type='password' name='password2' class='form-control' />
                        </div>
                    </div>
                </div>
                <div class="d-md-flex row">
                    <div class="ms-md-1 mb-3 col">
                        <p class="fw-bold">Username</p>
                        <div class="input-group input-group-lg">
                            <input type='text' name='username' class='form-control' />
                        </div>
                    </div>
                    <div class="ms-md-1 mb-3 col">
                        <p class="fw-bold">Role</p>
                        <input type="hidden" class="btn-check" name="role" value="" />
                        <div class="input-group input-group-lg">
                            <input type="radio" class="btn-check" name="role" id="User" value="User"  <?php echo ((isset($role)) && ($role == 'User')) ?  "checked" : ""; ?>>
                            <label class="btn btn-lg btn-outline-primary col-6" for="User">User</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold">Email</p>
                        <div class="input-group input-group-lg">
                            <input type='email' name='email' value="<?php echo isset($email) ? $email : ""; ?>" class='form-control' />
                        </div>
                    </div>
                    <p class="fw-bold">Gender</p>
                    <input type="hidden" class="btn-check" name="gender" value="" />
                    <div class="d-flex mx-1 mb-3">
                        <input type="radio" class="btn-check" name="gender" id="Male" value="Male" autocomplete="off" <?php echo ((isset($gender)) && ($gender == 'Male')) ?  "checked" : ""; ?>>
                        <label class="btn btn-lg btn-outline-primary col-6" for="Male">Male</label>
                        <input type="radio" class="btn-check" name="gender" id="Female" value="Female" autocomplete="off" <?php echo ((isset($gender)) && ($gender == 'Female')) ?  "checked" : ""; ?>>
                        <label class="btn btn-lg btn-outline-danger col-6" for="Female">Female</label>
                    </div>

                    <div class="m-auto mt-5 row justify-content-center">
                        <input type='submit' value='Save' class='btn btn-primary col-6 me-3' />
                        <a href='index.php' class='btn btn-danger col-3 ms-3'>Cancle</a>
                    </div>
            </form>
        </div>
        <!-- End Container  -->

        <hr class="featurette-divider">

        <!-- FOOTER -->
        <?php
        include "footer.php";
        ?>
    </main>
</body>

</html>