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
                            <a class="nav-link active" href="customer_read.php">Customer riew</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="product_read.php">Product riew</a>
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
            <h1>Read Products</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here

        // select all data
        $query = "SELECT ProductID, name, description, price FROM products ORDER BY ProductID DESC";
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
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th>Action</th>";
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
                echo "<td>{$description}</td>";
                echo "<td>{$price}</td>";
                echo "<td>";
                // read one record
                echo "<a href='product_read_one.php?id={$ProductID}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='product_update.php?id={$ProductID}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_product({$ProductID});'  class='btn btn-danger'>Delete</a>";
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
</body>
<footer class="container">
    <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
    <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
        <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
        <a class="text-decoration-none fw-bold" href="#">Terms</a>
    </p>
</footer>

</html>