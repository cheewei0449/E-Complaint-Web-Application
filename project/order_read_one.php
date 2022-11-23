<!DOCTYPE html>
<html>

<?php
include 'check.php';
?>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified Bootstrap CSS -->

</head>

<body>

    <!-- Content -->
    <div class="page-header">
        <h1>Read Order </h1>
    </div>

    <?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $OrderID = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    //include database connection
    include 'config/database.php';

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT OrderID, ProductID, quantity FROM order_detail WHERE OrderID= :OrderID ";
        $stmt = $con->prepare($query);
        $query_customer = "SELECT username, OrderID FROM customers LEFT JOIN order_summary ON customers.CustomerID = order_summary.CustomerID WHERE OrderID=:OrderID ";
        $stmt_customer = $con->prepare($query_customer);

        // Bind the parameter
        $stmt->bindParam(":OrderID", $OrderID);
        $stmt_customer->bindParam(":OrderID", $OrderID);
        // execute our query
        $stmt->execute();
        $stmt_customer->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            extract($row);
        } else {
            die('ERROR: Record ID not found.');
        }

        $num_customer = $stmt_customer->rowCount();

        if ($num_customer > 0) {
            // store retrieved row to a variable
            $row_customer = $stmt_customer->fetch(PDO::FETCH_ASSOC);

            extract($row_customer);
        } else {
            die('ERROR: Record ID not found.');
        }
    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
    ?>


    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
    <div class="row">
                <?php include 'config/database.php'; ?>
                <div class="col-10 col-sm-6 m-auto">
 
                        <?php
                    try {
                        $query = "SELECT CustomerID, username FROM customers ORDER BY CustomerID ASC";
                        // select all data
                        $query = "SELECT OrderID, ProductID, quantity FROM order_detail WHERE OrderID= :OrderID ";
                        $stmt = $con->prepare($query);
                        $query_customer = "SELECT username, OrderID FROM customers LEFT JOIN order_summary ON customers.CustomerID = order_summary.CustomerID WHERE OrderID=:OrderID ";
                        $stmt_customer = $con->prepare($query_customer);
                        $stmt->bindParam(":OrderID", $OrderID);
                        $stmt_customer->bindParam(":OrderID", $OrderID);
                        $stmt->execute();
                        $stmt_customer->execute();

                        // this is how to get number of rows returned
                        $num = $stmt->rowCount();

                        //check if more than 0 record found
                        if ($num > 0) {
                            // store retrieved row to a variable
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            extract($row);
                        } else {
                            die('ERROR: Record ID not found.');
                        }

                        $num_customer = $stmt_customer->rowCount();

                        if ($num_customer > 0) {
                            // store retrieved row to a variable
                            $row_customer = $stmt_customer->fetch(PDO::FETCH_ASSOC);

                            extract($row_customer);
                        } else {
                            die('ERROR: Record ID not found.');
                        }
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                    ?>
                </select>
                <!--we have our html table here where the record will be displayed-->
                <div class="table-responsive">
                    <table class='table table-hover table-bordered '>
                        <thead>
                            <tr>
                                <th class="table-light">OrderID</th>
                                <td colspan="3" class="table-light table-active"><?php echo $OrderID;  ?></td>
                            </tr>
                            <tr>
                                <th class="table-light ">Customer</th>
                                <td colspan="3" class="table-light table-active"><?php echo $username;  ?></td>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <th colspan="4" class="text-center">
                                    <p class="my-2">------------------- Order -------------------</p>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center">Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Price</th>
                            </tr>
                            <?php

                            try {
                                $query_product = "SELECT * FROM products WHERE ProductID= :ProductID ";
                                $stmt_product = $con->prepare($query_product);

                                $no = 1;
                                $total_amount = 0;

                                echo $stmt_product->fetch(PDO::FETCH_ASSOC);
                                do {
                                    // Bind the parameter
                                    $stmt_product->bindParam(":ProductID", $row["ProductID"]);
                                    // execute our query
                                    $stmt_product->execute();

                                    $num_product = $stmt_product->rowCount();
                                    if ($num_product > 0) {
                                        // store retrieved row to a variable
                                        $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);
                                    } else {
                                        die('ERROR: Record ID not found.');
                                    }



                                    $total_unit_price = $row['quantity'] * $row_product['price'];
                                    $total_amount += $total_unit_price;
                                    echo "<tr>";
                                    echo "<td>$no. {$row_product['name']}</td>";
                                    echo "<td>{$row['quantity']}</td>";
                                    echo "<td>RM {$row_product['price']}</td>";
                                    echo "<td>RM $total_unit_price</td>";
                                    echo "</tr>";

                                    $no++;
                                } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
                            }

                            // show error
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
                            ?>
                            <tr>
                                <th colspan="3" class="text-end">
                                    <p class="me-3 my-2 fs-5">Total</p>
                                </th>
                                <td><?php echo "<p class='me-3 my-2 fs-5'>RM $total_amount</p>" ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href='order_read.php' class='btn btn-danger'>Back to read orders</a>
            </div>
    </form>


    <!-- Content End -->

    <hr class="featurette-divider">

    </main>
    <!-- FOOTER -->
    <footer class="container">
        <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
        <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
            <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
            <a class="text-decoration-none fw-bold" href="#">Terms</a>
        </p>
    </footer>
    <!-- FOOTER END -->
</body>