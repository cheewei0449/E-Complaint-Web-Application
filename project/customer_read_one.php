<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified Bootstrap CSS -->

</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Customer</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $CustomerID = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT CustomerID, username, password, first_name, last_name, gender, date_of_birth, registration_date_time, account_status FROM customers WHERE CustomerID = :CustomerID ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":CustomerID", $CustomerID);

            // execute our query
            $stmt->execute();

            $num = $stmt->rowCount();

            if ($num > 0) {
                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $username = $row['username'];
                $password = $row['password'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $gender = $row['gender'];
                $date_of_birth = $row['date_of_birth'];
                $registration_date_time = $row['registration_date_time'];
                $account_status = $row['account_status'];
                // shorter way to do that is extract($row)
            } else {
                die('ERROR: Record ID not found.');
            }
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>ID</td>
                <td><?php echo htmlspecialchars($CustomerID, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><?php echo htmlspecialchars($password, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><?php echo htmlspecialchars($date_of_birth, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Registration Date Time</td>
                <td><?php echo htmlspecialchars($registration_date_time, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Account</td>
                <td><?php echo htmlspecialchars($account_status, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                </td>
            </tr>
        </table>

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