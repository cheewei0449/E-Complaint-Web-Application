<!DOCTYPE html>
<html>

<?php
include 'check.php';
?>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="css/contact.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <!--Total number of customers
Total number of products
Total number of orders
Latest Order ID & Summary (Customer Name, Transaction Date & Amount)
The Order ID & Summary which has the highest purchased amount 
Top 5 selling Products  -->

</head>

<body>
    <?php
    include "header_navbar.php";
    ?>


    <div class="container">
        <div class="page-header">
            <h1>Welcome</h1>
        </div>
        <!-- Content End -->
        <?php

        $current_user = $_SESSION["username"];

        // include database connection
        include 'config/database.php';

        try {
            $query = "SELECT * FROM 
            (SELECT COUNT(CustomerID) as total_customer FROM customers) as c, 
            (SELECT COUNT(ProductID) as total_product FROM products) as p, 
            (SELECT COUNT(OrderID) as total_order FROM order_summary) as o,
            (SELECT IFNULL((SELECT OrderID FROM order_summary INNER JOIN customers ON order_summary.CustomerID = customers.CustomerID WHERE customers.username = :username ORDER BY order_date DESC LIMIT 0,1), 'No Record Found') as latest_order ) as l_o";

            $stmt = $con->prepare($query);

            $stmt->bindParam(':username', $current_user);

            $stmt->execute();
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        $num = $stmt->rowCount();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        extract($row);

        try {
            $query_2 = "SELECT first_name, last_name, order_date, sum(quantity * price) as total_price FROM order_summary 
            INNER JOIN customers 
            ON order_summary.CustomerID = customers.CustomerID
            INNER JOIN order_detail
            ON order_summary.OrderID = order_detail.OrderID
            INNER JOIN products
            ON order_detail.ProductID = products.ProductID
            WHERE order_summary.OrderID = :latest_order
            GROUP BY order_detail.OrderID";

            $stmt_2 = $con->prepare($query_2);

            $stmt_2->bindParam(':latest_order', $latest_order);

            $query_highest = "SELECT first_name as top_first_name, last_name as top_last_name,order_summary.OrderID as top_OrderID, order_date as top_order_date,sum(quantity * price) as highest_price FROM order_summary 
            INNER JOIN customers ON order_summary.CustomerID = customers.CustomerID 
            INNER JOIN order_detail ON order_summary.OrderID = order_detail.OrderID 
            INNER JOIN products ON order_detail.ProductID = products.ProductID 
            GROUP BY order_detail.OrderID 
            ORDER BY highest_price DESC LIMIT 1";

            $stmt_highest = $con->prepare($query_highest);

            $query_top = "SELECT products.name as top_name, SUM(quantity) as top_quantity FROM order_detail 
            INNER JOIN products ON order_detail.ProductID = products.ProductID 
            GROUP BY order_detail.ProductID
            ORDER BY top_quantity DESC LIMIT 5";

            $stmt_top = $con->prepare($query_top);

            $query_no = "SELECT products.name as no_product FROM products left JOIN order_detail ON order_detail.ProductID = products.ProductID WHERE order_detail.ProductID is NULL LIMIT 3";

            $stmt_no = $con->prepare($query_no);


            $stmt_2->execute();

            $stmt_highest->execute();

            $stmt_top->execute();
            $stmt_no->execute();
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        $num_2 = $stmt_2->rowCount();

        $row_2 = $stmt_2->fetch(PDO::FETCH_ASSOC);

        if ($num_2 > 0) {
            extract($row_2);
        }

        $num_highest = $stmt_highest->rowCount();

        if ($num_highest > 0) {

            $row_highest = $stmt_highest->fetch(PDO::FETCH_ASSOC);
            extract($row_highest);
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }

        $num_top = $stmt_top->rowCount();

        if ($num_top > 0) {
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }

        $num_no = $stmt_no->rowCount();


        ?>

        <main class="mt-5">
            <div class="container shadow p-3 pb-5 " id="background">
            <div class="card bg-white p-5" >
                <div class=" bg-black p-4 mb-5">
                    <div class="monitor center">
                        <p class="m-0 text-light">Welcome for <?php echo $current_user ?></p>
                    </div>
                </div>
                <div class="row gx-0 gx-md-5 gy-5">
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-black  text-center">
                            <h4 class="fw-semibold text-white ">Total Customers <br> <?php echo "<p class='my-2 fs-3 text-white fw-bolder'>$total_customer</p>" ?></h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-black   text-center">
                            <h4 class="fw-semibold text-white text-opacity-50">Total Products <br> <?php echo "<p class='my-2 fs-3 text-white  fw-bolder'>$total_product</p>" ?></h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-black  text-center">
                            <h4 class="fw-semibold text-white ">Total Orders <br> <?php echo "<p class='my-2 fs-3 text-white fw-bolder'>$total_order</p>" ?></h4>
                        </div>
                    </div>
                </div>
                <div class="row gx-0 gx-md-5 gy-5 mt-3">
                    <h3 class="fw-semibold text-black ">Your Latest Order</h3>
                    <div class="col-12 col-md-6">
                        <div class="p-3 bg-black -top text-center">
                            <h4 class="fw-semibold text-white ">Latest OrderID<br> <?php echo "<p class='my-2 fs-3 text-white fw-bolder'>$latest_order</p>" ?></h4>
                        </div>
                        <div class="p-3 bg-black border text-center">
                            <h4 class="fw-semibold text-white ">Name <br>
                                <p class='my-2 fs-3 text-white fw-bolder'><?php echo isset($first_name) && isset($last_name) ? $first_name . " " . $last_name : "No Record Found" ?></p>
                            </h4>
                        </div>
                        <div class="p-3 bg-black rounded-bottom text-center">
                            <h4 class="fw-semibold text-white ">Purchase Date <br>
                                <p class='my-2 fs-3 text-white fw-bolder'><?php echo isset($order_date) ? $order_date : "No Record Found" ?></p>
                            </h4>
                        </div>
                    </div>
                    <div class="col-12 col-md align-self-center">
                        <div class="p-3 bg-black  text-center">
                            <h4 class="fw-semibold text-white ">Purchase Amount <br>
                                <p class='my-2 fs-3 text-white fw-bolder'><?php echo isset($total_price) ? "RM" .   number_format(round($total_price, 1), 2) : "No Record Found" ?></p>
                        </div>
                    </div>
                </div>
                <div class="row gx-0 gx-md-5 gy-5 mt-3">
                    <h3 class="fw-semibold text-black">Top Purchase Order</h3>
                    <div class="col-12 col-md-6">
                        <div class="p-3 bg-black -top text-center">
                            <h4 class="fw-semibold text-white ">OrderID<br> <?php echo "<p class='my-2 fs-3 text-white fw-bolder'>$top_OrderID</p>" ?></h4>
                        </div>
                        <div class="p-3 bg-black border text-center">
                            <h4 class="fw-semibold text-white ">Name <br>
                                <p class='my-2 fs-3 text-white fw-bolder'><?php echo isset($top_first_name) && isset($top_last_name) ? $top_first_name . " " . $top_last_name : "No Record Found" ?></p>
                            </h4>
                        </div>
                        <div class="p-3 bg-black rounded-bottom text-center">
                            <h4 class="fw-semibold text-white ">Purchase Date <br>
                                <p class='my-2 fs-3 text-white fw-bolder'><?php echo isset($top_order_date) ? $top_order_date : "No Record Found" ?></p>
                            </h4>
                        </div>
                    </div>
                    <div class="col-12 col-md align-self-center">
                        <div class="p-3 bg-black  text-center">
                            <h4 class="fw-semibold text-white ">Purchase Amount <br>
                                <p class='my-2 fs-3 text-white fw-bolder'><?php echo isset($highest_price) ? "RM" . number_format(round($highest_price, 1), 2) : "No Record Found" ?></p>
                        </div>
                    </div>
                </div>
                <div class="row gx-0 gx-md-5 gy-5 mt-3">

                    <div class="col-12 col-md-6">
                        <table class='table  table-striped table-bordered border-secondary text-center'>
                            <tr class="table-dark">
                                <th colspan="2">The Top 5 Selling Products</th>
                            </tr>
                            <?php

                            if ($num_no > 0) {
                                while ($row_top = $stmt_top->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_top);
                                    echo "<tr class=\"table-light\">";
                                    echo "<th class=\"text-center\">$top_name</th>";
                                    echo "<th>$top_quantity</th>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>No records found.</div>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="col-12 col-md-6 ">
                        <table class='table table-striped table-bordered border-secondary text-center'>
                            <tr class="table-dark">
                                <th colspan="2">The Products Never be Purchased by any Customer</th>
                            </tr>
                            <?php

                            $count = 1;
                            if ($num_no > 0) {
                                while ($row_no = $stmt_no->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_no);
                                    echo "<tr class=\"table-light\">";
                                    echo "<th class=\"text-center\">$count</th>";
                                    echo "<th>$no_product</th>";
                                    echo "</tr>";
                                    $count++;
                                }
                            } else {
                                echo "<div class='alert alert-danger'>No records found.</div>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
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