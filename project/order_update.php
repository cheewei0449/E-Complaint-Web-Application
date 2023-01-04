<!DOCTYPE HTML>
<html>
<?php
include 'check.php';
?>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="css/contact.css" />
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
            <h1>Order Edit</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query1 = "SELECT order_detail.OrderID, order_detail.quantity ,order_detail.ProductID, customers.CustomerID, customers.username ,order_summary.order_date FROM order_summary 
        INNER JOIN customers ON order_summary.CustomerID = customers.CustomerID 
        INNER JOIN order_detail ON order_summary.OrderID = order_detail.OrderID
        WHERE order_detail.OrderID = ?";

            $stmt_id = $con->prepare($query1);

            // this is the first question mark
            $stmt_id->bindParam(1, $id);

            // execute our query
            $stmt_id->execute();

            $row1 = $stmt_id->fetch(PDO::FETCH_ASSOC);
            $num1 = $stmt_id->rowCount();
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        if ($_POST) {
            $CustomerID = $_POST['CustomerID'];
            $ProductID = $_POST['ProductID'];

            $validation = true;
            $product_error = 0;

            if ($CustomerID == 0) {
                echo "<div class='alert alert-danger'>Please choose a customer</div>";
                $validation = false;
            }

            for ($count = 0; $count < count($ProductID); $count++) {
                if ($ProductID[$count] == 0) {
                    $product_error++;
                }
            }

            if ($product_error > 0) {
                echo "<div class='alert alert-danger'>Please choose product for all blank</div>";
                $validation = false;
            }

            $quantity_error = 0;
            for ($count = 0; $count < count($ProductID); $count++) {
                if (isset($_POST["quantity"]) && $_POST["quantity"][$count] < 1) {
                    $quantity_error++;
                }
            }
            if ($quantity_error > 0) {
                echo "<div class='alert alert-danger'>Please enter a valid quantity</div>";
                $validation = false;
            }

            if ($validation) {
                try {
                    // include database connection
                    include 'config/database.php';
                    $query_delete = "DELETE FROM order_detail WHERE OrderID = ?";
                    $stmt_delete = $con->prepare($query_delete);
                    $stmt_delete->bindParam(1, $id);

                    if ($stmt_delete->execute()) {
                        $query_order_summary = "UPDATE order_summary SET CustomerID=:CustomerID WHERE OrderID=:OrderID";

                        // prepare query for execution
                        $stmt_order_summary = $con->prepare($query_order_summary);
                        $stmt_order_summary->bindParam(':OrderID', $id);
                        $stmt_order_summary->bindParam(':CustomerID', $CustomerID);

                        if ($stmt_order_summary->execute()) {
                            echo "<div class='alert alert-success'>Your order ID is <b class=\"fs-4 ms-2 mt-3\">$id</b></div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }
                } catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }

                $record_saved = 0;

                for ($count = 0; $count < count($ProductID); $count++) {
                    try {
                        $query_order_detail = "INSERT INTO order_detail SET OrderID=:OrderID, ProductID=:ProductID, quantity=:quantity";
                        // prepare query for execution
                        $stmt_order_detail = $con->prepare($query_order_detail);

                        $stmt_order_detail->bindParam(':OrderID', $id);
                        $stmt_order_detail->bindParam(':ProductID', $ProductID[$count]);
                        $stmt_order_detail->bindParam(':quantity', $_POST['quantity'][$count]);

                        $record_number = $count + 1;
                        if ($stmt_order_detail->execute()) {
                            $record_saved++;
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
                if ($record_saved == count($ProductID)) {
                    header("Location: order_read.php?message=update_success&id=$id");
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                }
            }
        }
        ?>

        <form id="myForm" action="<?php echo $_SERVER["PHP_SELF"] . "?id={$id}"; ?>" method="POST">
            <div class="table-responsive">
                <table class='table table-dark table-bordered '>
                    <thead>
                        <div class="col-8 col-sm-7 m-auto mb-4">
                            <div><b>OrderID</b></div>
                            <input type='text' name='OrderID' value="<?php echo $row1['OrderID']; ?>" class='form-control' disabled />
                        </div>
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
                            <td colspan="3" class="table-light table-active"><?php echo $row1['order_date'];  ?></td>
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

                        <table class='table table-hover table-responsive table-bordered' id='order'>
                            <tr>
                                <th>#</th>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th></th>
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
                                    echo    "<td>";
                                    echo "<div onclick=\"drop_item()\" class=\"btn btn-danger drop_item\">Delete</div>";
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
                    <input type='button' value='Save' class='btn btn-primary mt-3 col-3 col-md' onclick="checkDuplicate()" />
                    <input type="button" value="Add More Product" class="btn btn-info mt-3 col-3 col-md add_one" />

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
    function drop_item() {

        document.querySelector('#myForm').onclick = function(ev) {

            if (ev.target.innerHTML == "Delete") {
                var table = document.querySelectorAll('.pRow');
                var rowCount = table.length;


                if (rowCount > 1) {

                    var table_row = ev.target.parentElement.parentElement;
                    table_row.remove(table_row);
                } else {
                    alert("You must keep one record !")
                }

                undateSummaryTotal();
            }
        }
    }

    document.addEventListener('click', function(event) {
        if (event.target.matches('.add_one')) {
            var element = document.querySelector('.pRow');
            var clone = element.cloneNode(true);
            element.after(clone);
        }
        var total = document.querySelectorAll('.pRow').length;

        var row = document.getElementById('order').rows;
        for (var i = 1; i <= total; i++) {
            row[i].cells[0].innerHTML = i;

        }
    }, false);

    function checkDuplicate() {
        var newarray = [];
        const table = document.querySelector('#order');
        var select = table.getElementsByTagName('select');
        for (var i = 0; i < select.length; i++) {
            newarray.push(select[i].value);
        }
        var set = new Set(newarray);
        if (set.size !== newarray.length) {
            alert("The item can't repeat!");
        } else {
            document.getElementById("myForm").submit();
        }
    }
</script>

</html>