<!DOCTYPE html>
<html>

<?php
include 'check_session.php';
?>

<head>

    <?php include "bootstrap.php"; ?>

    <title>Read Users</title>

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/all.css" />
    
</head>

<body>
    <!-- NAVBAR -->
    <?php
    include "admin_navbar.php";
    ?>
    <!-- NAVBAR END -->

    <main class="mt-5">

        <!-- Content Start-->
        <!-- container -->
        <div class="container">
            <div class="page-header">
                <h1>User List</h1>
            </div>

            <!-- PHP code to read records will be here -->
            <?php

            if ($_GET) {
                $message = isset($_GET['message']) ? $_GET['message'] : "";
                $id = isset($_GET['id']) ? $_GET['id'] : "";

                if ($message == "update_success" && $id != "") {
                    echo "<div class='alert alert-success'>Record with <b class='fs-2'> userID : $id </b> updated.</div>";
                } else if ($message == "update_success") {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                }  else if ($message == "no_file_found") {
                    echo "<div class='alert alert-danger'>No file uploaded for this complaints</div>"; 
                } else if ($message == "create_success") {
                    echo "<div class='alert alert-success'>User was created.</div>"; 
                } else if ($message == "deleted") { // if it was redirected from delete.php
                    echo "<div class='alert alert-success'>Record was deleted.</div>";
                } else {
                    echo "<div class='alert alert-danger align-item-center'>Unknown error happened</div>";
                }
            }

            // include database connection
            include 'config/database.php';

            // delete message prompt will be here

            // select all data
            $query = "SELECT userID, username, email,image, role, register_date FROM users ORDER BY userID ASC";
            $stmt = $con->prepare($query);
            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();

            // link to create record form
            echo "<a href='admin_users_create.php' class='btn btn-primary mb-3'>Create New User</a>";

            //check if more than 0 record found
            if ($num > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-hover table-bordered align-middle'>"; //start table
                //creating our table heading
                echo "<tr>";
                echo "<th>userID</th>";
                echo "<th>Username</th>";
                echo "<th>Image</th>";
                echo "<th>Email</th>";
                echo "<th>Role</th>";
                echo "<th>Register Date</th>";
                echo "<th></th>";
                echo "</tr>";

                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['firstname'] to just $firstname only
                    extract($row);
                    // creating new table row per record
                    echo "<tr>";
                    echo "<td>{$userID}</td>";
                    // echo "<td>{$password}</td>";
                    echo "<td>{$username}</td>";
                    if ($image !== "") {
                        echo "<td><div class='text-center'><img src='uploads/$image' width='50px'/></div></td>";
                    } else {
                        echo "<td class='text-center'><img src='image/user.png'  width='50px'></td>";
                    }
                    echo "<td>{$email}</td>";
                    echo "<td>{$role}</td>";
                    echo "<td>{$register_date}</td>";

                    echo "<td>";


                    // we will use this links on next part of this post
                    echo "<a href='admin_users_update.php?id={$userID}' class='btn btn-primary ms-2 '>Edit</a>";

                    // we will use this links on next part of this post
                    echo "<a href='#' onclick='delete_customer({$userID});' class='btn btn-danger ms-2 '>Delete</a>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }

                // end table
                echo "</table>";
                echo "</div>";
            } else {
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
            ?>

        </div> <!-- end .container -->

        <script type='text/javascript'>
            // confirm record deletion
            function delete_customer(id) {

                if (confirm('Are you sure?')) {
                    // if user clicked ok,
                    // pass the id to delete.php and execute the delete query
                    window.location = 'admin_users_delete.php?id=' + id;
                }
            }
        </script>

        <!-- Content End -->

        <hr class="featurette-divider">

    </main>
    <!-- FOOTER -->
    <?php
    include "footer.php";
    ?>
    <!-- FOOTER END -->
</body>