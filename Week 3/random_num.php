<!DOCTYPE html>
<html>
<head>
    <title>Exercise 1</title>
    <style>                    
             .green{
                color:green;
             }
             .blue{
                color:blue;
             }
             .red{
                color:red;
             }
             .black{
                color:black;
             }
            </style>
            
</head>
<body>
<?php
$x= rand(100,200);
$y= rand(100,200);
$sum = $x+$y;
$mun = $x*$y;
echo "<i class=\"green \"> $x <br></i>";
echo "<i class=\"blue\">  $y <br></i>";
echo "<b class=\"red\"> $sum <br></b>"; 
echo "<i class=\"black\"> <b>$mun <br></b></i>";


?>

</body>
</html>