<!DOCTYPE html>
<html>
<head>
    <title>
         Homework 1 
    </title>
    <!-- bootstrap -->
 <m<!-- bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</head>
<body>
<div class="row">
        <div class="col-12 col-sm-4">
            <select class="form-select form-select-lg mb-3 bg-info text-light" aria-label="Date">
                <option selected>DAY</option>
                <?php
                for ($num = 1; $num <= 31; $num++) {
                    echo "<option value=\"$num\">$num</option>";
                }
                ?>
            </select>
              </div>
            <div class="col-12 col-sm-4">
            <select class="form-select form-select-lg mb-3 bg-warning text-light" aria-label="Date">
                <option selected>Month</option>
                <?php
                for ($num = 1; $num <= 12; $num++) {
                    echo "<option value=\"$num\">$num</option>";
                }
                ?>
            </select>
            </div>
            <div class="col-12 col-sm-4">
            <select class="form-select form-select-lg mb-3 bg-danger text-light" aria-label="Date">
                <option selected>Year</option>
                <?php
                for ($num = 1900; $num <= 2022; $num++) {
                    echo "<option value=\"$num\">$num</option>";
                }
                ?>


            </div>
 
    <?php

    ?>
</body>
</html>