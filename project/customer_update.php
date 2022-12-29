<!DOCTYPE HTML>
<html>
<?php
include 'check.php';
ob_start();
?>

<head>
    <link rel="stylesheet" href="css/contact.css" />
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>



</head>

<body>
    <?php
    include "header_navbar.php";
    ?>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT CustomerID, username, password, gender,customer_image as old_image, date_of_birth, account_status, first_name, last_name FROM customers WHERE CustomerID = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();


            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            extract($row);
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML form to update record will be here -->
        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {

            if ($_POST) {
                $username = $_POST['username'];
                $old_password = ($_POST['old_password']);
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $account_status = $_POST['account_status'];
                $delete_image = $_POST['delete_image'];

                $today = date('Y-m-d');

                $date1 = date_create($date_of_birth);
                $date2 = date_create($today);
                $age = date_diff($date1, $date2);

                $validation = true;

                $file_upload_error_messages = "";

                // Check Empty
                if ($username == "" || $first_name == "" || $last_name == "" || $gender == "" || $date_of_birth == "") {
                    echo "<div class='alert alert-danger'>Please make sure all fields are not empty</div>";
                    $validation = false;
                }

                //Check Password
                echo $old_password;
                if ($old_password != "" && md5($old_password) != $password) {
                    $file_upload_error_messages .= "<div class='alert alert-danger'>Please enter corret password</div>";
                    $validation = false;
                } else if ($old_password == "" && $new_password == "" && $confirm_password == "") {
                    $pass = $password;
                } else if (!preg_match("/[0-9]/", $new_password) || !preg_match("/[a-z]/", $new_password) || !preg_match("/[A-Z]/", $new_password) || strlen($new_password) < 8) {
                    echo "<div class='alert alert-danger'>Please enter new password with at least <br> - 1 capital letter <br> - 1 small letter <br> - 1 integer <br> - more than 8 character</div>";
                    $validation = false;
                } else if ($confirm_password !== $new_password) {
                    echo "<div class='alert alert-danger'>Please enter valid confirm password</div>";
                    $validation = false;
                }

                // var_dump($username);

                // Check Username
                if (strpos($username, " ") !== false) {
                    // if (preg_match("/[\s]/", $username)) {
                    echo "<div class='alert alert-danger'>No space is allowed in username</div>";
                    $validation = false;
                } else if (strlen($username) < 6) {
                    echo "<div class='alert alert-danger'>Username should contained at leats 6 characters</div>";
                    $validation = false;
                }

                // Check birthday
                if ($date_of_birth > date('Y-m-d')) {
                    echo "<div class='alert alert-danger'>Date of Birth cannot in future.</div>";
                    $validation = false;
                } else if ($age->format("%y") < 18) {
                    echo "<div class='alert alert-danger'>Age below 18 years old are not allowed.</div>";
                    $validation = false;
                }
            }

            if ((!empty($_FILES["image"]["name"]) && $delete_image == "Yes")) {
                $file_upload_error_messages .= "<div class='alert alert-danger'>Cannot upload image if want to delete image.</div>";
                $validation = false;
            } else if ($delete_image == "Yes") {
                unlink("uploads/$old_image");
                $new_image = "";
            } else if (empty($_FILES["image"]["name"])) {
                $new_image = $old_image;
            } else {
                include "image_uploaded.php";
                if ($validation == true && $old_image != "" && getimagesize($target_file) !== false) {
                    unlink("uploads/$old_image");
                }
                $new_image = $image;
            }


            if ($validation) {
                try {
                    // write update query
                    // in this case, it seemed like we have so many fields to pass and
                    // it is better to label them and not use question marks
                    $query = "UPDATE customers SET username=:username, password=:password, first_name=:first_name, last_name=:last_name ,customer_image=:image, gender=:gender, date_of_birth=:date_of_birth, account_status=:account_status WHERE CustomerID=:CustomerID";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(":CustomerID", $id);
                    $stmt->bindParam(':username', $username);
                    if ($old_password == "" && $new_password == "" && $confirm_password == "") {
                        $stmt->bindParam(':password', $pass);
                    } else {
                        $stmt->bindParam(':password', md5($new_password));
                    }
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':image', $new_image);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':account_status', $account_status);
                    // Execute the query

                    if ($stmt->execute()) {
                        header("Location:customer_read.php?message=update_success");
                        ob_end_flush();
                    } else {
                        if (file_exists($target_file)) {
                            unlink($target_file);
                        }
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            } else {
                // it means there are some errors, so show them to user
                echo "<div class='alert alert-danger'>";
                echo "<div>{$file_upload_error_messages}</div>";
                echo "</div>";
            }
        } ?>

        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' value="<?php echo $username;  ?>" class='form-control' disabled /></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type='password' name='old_password' placeholder="Enter old password" class='form-control' /></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type='password' name='new_password' placeholder="Enter new password" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirm_password' placeholder="Enter confirm password" class='form-control' /></td>
                </tr>
                <tr>
                    <td>First name</td>
                    <td><textarea name='first_name' class='form-control'><?php echo $first_name;  ?></textarea></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><input type='text' name='last_name' value="<?php echo $last_name;  ?>" class='form-control' /></td>
                </tr>
                <input type='hidden' name='delete_image' value='No'>
                <?php if ($old_image != "") {
                    echo "<tr>";
                    echo "<td colspan='2' class='text-center'><img src='uploads/$old_image'alt='Image not found' width='250px'>";
                    echo "<div class='form-check form-switch mt-2 d-flex justify-content-center'>";
                    echo "<input class='form-check-input me-3' type='checkbox' role='switch' name='delete_image' value='Yes' id='delete_image'>";
                    echo "<label class='form-check-label fw-bold' for='delete_image'>";
                    echo  "Delete Image";
                    echo "</td>";
                    echo "</label>";
                    echo "</div>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td colspan='2' class='text-center'><img src='images/user.png'alt='Image not found' width='250px'></td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td>User Image</td>
                    <td><input type="file" name="image" /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td class="d-flex">
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="radio" name="gender" value="Male" id="Male" required <?php echo ($gender == 'Male') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="Male">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Female" id="Female" required <?php echo ($gender == 'Female') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="Female">
                                Female
                            </label>
                        </div>
                </tr>
                <tr>
                    <td>date_of_birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo $date_of_birth; ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account status</td>
                    <td class="d-flex">
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="radio" name="account_status" value="Activation" id="Activation" required <?php echo ($account_status == 'Activation') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="Activation">
                                Activation
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="account_status" value="Inactivated" id="Inactivated" <?php echo ($account_status == 'Inactivated') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="Inactivated">
                                Inactivated
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
</body>
<footer class="container">
    <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
    <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
        <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
        <a class="text-decoration-none fw-bold" href="#">Terms</a>
    </p>
</footer>

</html>