<!DOCTYPE HTML>
<html>
<?php
include 'check.php';
?>

<head>
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
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Order Edit</h1>
        </div>
        <?php

        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

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
                    $query2 = "SELECT OrderID FROM order_summary ORDER BY OrderID DESC LIMIT 1";
                    $stmt2 = $con->prepare($query2);
                    // execute our query
                    $stmt2->execute();

                    $num2 = $stmt2->rowCount();

                    if ($num2 > 0) {
                        // store retrieved row to a variable
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                        extract($row2);
                    } else {
                        die('ERROR: Record ID not found.');
                    }
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }

            for ($count = 0; $count < count($_POST['ProductID']); $count++) {
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

        <?php

        //include database connection
        include 'config/database.php';
        try {
            // prepare select query
            $query1 = "SELECT order_summary.OrderID, username, order_date,quantity,ProductID,customers.CustomerID FROM order_summary 
            INNER JOIN customers ON order_summary.CustomerID = customers.CustomerID
            INNER JOIN order_detail
            ON order_summary.OrderID = order_detail.OrderID
            Where order_detail.OrderID = ? ";
            $stmt_id = $con->prepare($query1);

            // this is the first question mark
            $stmt_id->bindParam(1, $id);

            // execute our query
            $stmt_id->execute();


            // store retrieved row to a variable
            $row1 = $stmt_id->fetch(PDO::FETCH_ASSOC);
            $num1 = $stmt_id->rowCount();

            // values to fill up our form
            extract($row1);
        }


        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        ?>
        <form action="<?php echo $_SERVER["PHP_SELF"] . "?id={$id}"; ?>" method="POST">
            <div class="table-responsive">
                <table class='table table-hover table-bordered '>
                    <thead>
                        <tr>
                            <th class="table-light">OrderID</th>
                            <td colspan="3" class="table-light table-active"><?php echo $OrderID;  ?></td>
                        </tr>
                        <tr>
                            <th class="table-light ">Customer</th>
                            <td colspan="3" class="table-light table-active">
                                <select class="form-select" name='CustomerID' aria-label="CustomerID">
                                    <?php
                                    $query_username = "SELECT CustomerID,username FROM customers ORDER BY CustomerID ASC";
                                    $stmt_username = $con->prepare($query_username);
                                    $stmt_username->execute();

                                    $num_username = $stmt_username->rowCount();

                                    if ($num_username) {
                                        while ($row_username = $stmt_username->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row_username);
                                            if ($CustomerID == $row1['CustomerID']) {
                                                echo "<option value=\"$CustomerID\" selected>$username</option>";
                                            } else {
                                                echo "<option value=\"$CustomerID\">$username</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        </td>
                        </tr>
                        <tr>
                            <th class="table-light ">Order Date</th>
                            <td colspan="3" class="table-light table-active"><?php echo $order_date;  ?></td>
                        </tr>
                        <tr>
                        <tr>
                            <th colspan="4" class="text-center">
                                <p class="my-2">------------------- Order -------------------</p>
                            </th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM products ORDER BY ProductID ASC  ";
                        ?>

                        <table class='table table-hover table-responsive table-bordered'>
                            <tr>
                                <th>#</th>
                                <th>Products</th>
                                <th>Quantity</th>
                            </tr>

                            <?php
                            if ($num1 > 0) {
                                do {
                                    $default = "";

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
                                            if ($ProductID == $row1['ProductID']) {
                                                $status = "selected";
                                            } else {
                                                $status = "";
                                            }

                                            echo "<option $status value=\"$ProductID\">$name </option>";
                                        }
                                    }
                                    echo    "</select>";
                                    echo    "</td>";
                                    echo    "<td>";
                                    echo    "<input type='number' name='quantity[]' value=\"$row1[quantity]\" class='form-control' min=\"1\" />";
                                    echo    "</td>";
                                    echo    "</tr>";
                                } while ($row1 = $stmt_id->fetch(PDO::FETCH_ASSOC));
                            }

                            ?>

                            <td></td>
                            <td>
                                <a href='order_read.php' class='btn btn-danger'>Back to read order</a>
                            </td>
                            </tr>
                    </thead>
                </table>
                <div class="d-flex justify-content-between">
                    <input type='submit' value='Save' class='btn btn-primary mt-3 col-3 col-md' />
                    <input type="button" value="Add More Product" class="btn btn-info mt-3 col-3 col-md add_one" />
                    <input type="button" value="Delete" class="btn btn-danger mt-3 col-3 col-md delete_one" />
                </div>
            </div>
        </form>

        <!-- end .container -->
</body>

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

</html>