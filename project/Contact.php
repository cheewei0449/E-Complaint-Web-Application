<!DOCTYPE html>
<html>
<?php
include 'check.php';
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
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
    <main>

        <!-- Content -->
        <div class="container contact-form">
            <div class="contact-image">
                <form method="post">
                    <h3>Contact Us</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="txtName" class="form-control" placeholder="Your Name *" value="" />
                            </div>
                            <div class="form-group  mt-4">
                                <input type="text" name="txtEmail" class="form-control" placeholder="Your Email *" value="" />
                            </div>
                            <div class="form-group mt-4">
                                <input type="text" name="txtPhone" class="form-control" placeholder="Your Phone Number *" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-4 mt-md-auto">
                                <textarea name="txtMsg" class="form-control" placeholder="Your Message *" style="width: 100%; height: 165px;"></textarea>
                            </div>
                        </div>
                        <div class="form-group mt-4 text-center">
                            <input type="submit" name="btnSubmit" class="btnContact" value="Send " />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Content End -->

            <hr class="featurette-divider">

            <!-- FOOTER -->
            <footer class="container">
                <p class="float-end"><a class="text-decoration-none fw-bold" href="#">Back to top</a></p>
                <p class="text-muted fw-bold">&copy; Ch'ng Chee Wei 2022 &middot;
                    <a class="text-decoration-none fw-bold" href="#">Privacy</a> &middot;
                    <a class="text-decoration-none fw-bold" href="#">Terms</a>
                </p>
            </footer>
    </main>
</body>

</html>