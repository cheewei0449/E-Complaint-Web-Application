<!DOCTYPE HTML>
<html>
<?php
include 'check.php';
?>

<head>
    <link rel="stylesheet" href="css/contact.css" />
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
    <?php
    include "header_navbar.php";
    ?>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Products</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';
        if ($_GET) {
            // delete message prompt will be here
            $message = isset($_GET['message']) ? $_GET['message'] : "";
            // if it was redirected from delete.php
            if ($message == "update_success") {
                echo "<div class = 'alert alert-success'> Record was upload.</div>";
            } else if ($message == "products_in_use") {
                echo "<div class = 'alert alert-danger'>The Products have be founded in order(Please delete specific order before delete products)</div>";
            } else if ($message == "deleted") {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            } else {
                echo "<div class='alert alert-danger'>Unknown error happened.</div>";
            }
        }

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }


        // select all data
        $query = "SELECT ProductID, name, description,image, price FROM products ORDER BY ProductID ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='product_create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Image</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th></th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$ProductID}</td>";
                echo "<td>{$name}</td>";
                echo "<td><div class='text-center'><img src='uploads/$image' width='50px'/></div></td>";
                echo "<td>{$description}</td>";
                echo "<td class='text-end'>" . number_format(round($price, 1), 2) . "</td>";
                echo "<td>";
                // read one record
                echo "<a href='product_read_one.php?id={$ProductID}' class='btn btn-info ms-2  m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='product_update.php?id={$ProductID}' class='btn btn-primary ms-2  m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$ProductID});'  class='btn btn-danger ms-2 '>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(id) {

            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'product_delete.php?id=' + id;
            }
        }
    </script>


</body>
<footer class="container">
    <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
    <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
        <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
        <a class="text-decoration-none fw-bold" href="#">Terms</a>
    </p>
</footer>

</html>