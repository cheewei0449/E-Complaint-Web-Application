<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified Bootstrap CSS -->

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">

                <a class="navbar-brand " href="#">
                    <i class="fa-brands fa-shopify fa-xl text-light me-2 "></i>
                    eshop
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-md-flex justify-content-end" id="navbarCollapse">
                    <ul class="navbar-nav mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product_create.php">Create Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link Activation" href="create_customer.php">Create Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="customer_read.php">Customer riew</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product_read.php">Product riew</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create_new_order.php">Order List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Contact.php">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Order ID</h1>
        </div>

        <?php
        if ($_POST) {
            $CustomerID = $_POST['CustomerID'];

            // include database connection
            include 'config/database.php';

            try {
                $query_order_summary = "INSERT INTO order_summary SET CustomerID=:CustomerID";

                // prepare query for execution
                $stmt_order_summary = $con->prepare($query_order_summary);

                $stmt_order_summary->bindParam(':CustomerID', $CustomerID);

                if ($stmt_order_summary->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";

                    // prepare select query
                    $query = "SELECT OrderID FROM order_summary ORDER BY OrderID DESC LIMIT 1";
                    $stmt = $con->prepare($query);

                    // execute our query
                    $stmt->execute();

                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        // store retrieved row to a variable
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                    } else {
                        die('ERROR: Record ID not found.');
                    }
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }

            for ($count = 0; $count < count($_POST['ProductID']) ; $count++) {
                try {
                    $query_order_detail = "INSERT INTO order_detail SET OrderID=:OrderID, ProductID=:ProductID, quantity=:quantity";
                    // prepare query for execution
                    $stmt_order_detail = $con->prepare($query_order_detail);

                    $stmt_order_detail->bindParam(':OrderID', $OrderID);
                    $stmt_order_detail->bindParam(':ProductID', $_POST['ProductID'][$count]);
                    $stmt_order_detail->bindParam(':quantity', $_POST['quantity'][$count]);

                    $record_number = $count + 1;
                    if ($stmt_order_detail->execute()) {
                        echo "<div class='alert alert-success'>Record $record_number was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                } catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>
        
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="row">
                <?php include 'config/database.php'; ?>
                <div class="col-10 col-sm-6 m-auto">
                    <label for="CustomerID" class="form-label">Customer ID</label>
                    <select class="form-select" name='CustomerID' aria-label="OrderID">
                        <option selected>Select a customer</option>
                        <?php

                        // select all data
                        $query = "SELECT CustomerID, username FROM customers ORDER BY CustomerID ASC";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // this is how to get number of rows returned
                        $num = $stmt->rowCount();

                        //check if more than 0 record found
                        if ($num > 0) {

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                echo "<option value=\"$CustomerID\">$username</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-5 text-center">
                    <label class="form-label">--- Select Product Here ---</label>
                </div>

                <?php
                $query = "SELECT * FROM products ORDER BY ProductID ASC";
                ?>
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <th>#</th>
                        <th>Products</th>
                        <th>Quantity</th>
                    </tr>

                    <?php
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                    echo "<tr class=\"pRow\">";
                    echo "<td class=\"d-flex justify-content-center\">";
                    echo "<p class=\"mb-0 mt-2 number\"></p>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select class=\"form-select\" name=\"ProductID[]\" aria-label=\"OrderID\">";
                    echo "<option selected>Open this select menu</option>";

                    if ($num > 0) {

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            echo "<option value=\"$ProductID\">$name</option>";
                        }
                    }
                    echo    "</select>";
                    echo    "</td>";
                    echo    "<td>";
                    echo    "<input type='number' name='quantity[]' value=\"0\" class='form-control' min=\"0\" />";
                    echo    "</td>";
                    echo    "</tr>";
                    ?>

                </table>
                <div class="d-flex justify-content-between">
                    <input type='submit' value='Save' class='btn btn-primary mt-3 col-3 col-md' />
                    <input type="button" value="Add More Product" class="btn btn-info mt-3 col-3 col-md add_one" />
                    <input type="button" value="Delete" class="btn btn-danger mt-3 col-3 col-md delete_one" />
                </div>
            </div>
        </form>

        <hr class="featurette-divider">

        <?php
        if ($_POST) {
        }
        try {
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        ?>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->

<hr class="featurette-divider">
<footer class="container">
    <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
    <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
        <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
        <a class="text-decoration-none fw-bold" href="#">Terms</a>
    </p>
</footer>
<script>
    document.addEventListener('click', function(event) {
        if (event.target.matches('.add_one')) {
            var element = document.querySelector('.pRow');
            var clone = element.cloneNode(true);
            element.after(clone);
        }
        if (event.target.matches('.delete_one')) {
            var total = document.querySelectorAll('.pRow').length;
            if (total > 1) {
                var element = document.querySelector('.pRow');
                element.remove(element);
            }
        }
        var total = document.querySelectorAll('.pRow').length;

        var row = document.getElementById('order').rows;
        for (var i = 1; i <= total; i++) {
            row[i].cells[0].innerHTML = i;

        }
    }, false);
</script>
</body>
</html>