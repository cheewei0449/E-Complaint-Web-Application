<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ddd77b8ec.js" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified Bootstrap CSS →

</head>
<body>
 
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Product</h1>
        </div>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $ProductID = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT ProductID, name, description, price, promotion_price, manufacture_date, expired_date FROM products WHERE ProductID = :ProductID ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":ProductID", $ProductID);

            // execute our query
            $stmt->execute();

            $num = $stmt->rowCount();

            if ($num > 0) {
                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $name = $row['name'];
                $description = $row['description'];
                $price = $row['price'];
                $promotion_price = $row['promotion_price'];
                $manufacture_date = $row['manufacture_date'];
                $expired_date = $row['expired_date'];
                // shorter way to do that is extract($row)

                if ($promotion_price == Null) {
                    $promotion_price = "-";
                }

                if ($manufacture_date == Null) {
                    $manufacture_date = "-";
                }

                if ($expired_date == Null) {
                    $expired_date = "-";
                }
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
                <td><?php echo htmlspecialchars($ProductID, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?php echo "RM ", htmlspecialchars($price, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Promotion Price</td>
                <td><?php echo "RM ", htmlspecialchars($promotion_price, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Manufacture Date</td>
                <td><?php echo htmlspecialchars($manufacture_date, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Expired Date</td>
                <td><?php echo htmlspecialchars($expired_date, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
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