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
    <!-- Latest compiled and minified Bootstrap CSS →
 
    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Product</h1>
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
            $query = "SELECT ProductID, name, description, price , promotion_price ,manufacture_date , expired_date  FROM products WHERE ProductID = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();


                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $name = $row['name'];
                $description = $row['description'];
                $price = $row['price'];
                $promotion_price = $row['promotion_price'];
                $manufacture_date = $row['manufacture_date'];
                $expired_date = $row['expired_date'];
            
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
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE products
                  SET name=:name, description=:description,
                  price=:price, promotion_price=:promotion_price,manufacture_date=:manufacture_date,expired_date=:expired_date WHERE ProductID = :ProductID";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];

                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':ProductID', $id);
                $stmt->bindParam(':promotion_price', $promotion_price);
                $stmt->bindParam(':manufacture_date', $manufacture_date);
                $stmt->bindParam(':expired_date', $expired_date);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>

        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo $name ;  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo $description;  ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo $price;  ?>" class='form-control' /></td>
                </tr>
                <tr>
                        <td>Promotion_price</td>
                        <td><input type='number' name='promotion_price' value="<?php echo $promotion_price;  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Manufacture_date</td>
                        <td><input type='date' name='manufacture_date' value="<?php echo $manufacture_date;  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Expired_date</td>
                        <td><input type='date' name='expired_date' value="<?php echo $expired_date;  ?>" class='form-control' /></td>
                    </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
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