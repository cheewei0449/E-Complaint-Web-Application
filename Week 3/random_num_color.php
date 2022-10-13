<!DOCTYPE html>
<html>
<head>
    <title>Exercise 2</title>
 <!-- bootstrap -->
 <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <h5></h5>    
</head>
<body>
 <?php
 $x = rand(1, 10);
 $y = rand(1, 10);

 if ($x > $y) {
     echo "
     <div class=\"row justify-content-evenly\">
         <diV class=\"col-5\">
             <div class=\"card text-bg-warning\">
               <div class=\"card-body fs-1 text-center\">
                 <b>$x</b>
               </div>
             </div> 
         </div>
         <div class=\"col-5\">
             <div class=\"card text-bg-primary\">
               <div class=\"card-body text-center\">
                 $y
               </div>
             </div> 
         </div>
     </div>";
 } else {
     echo "
     <div class=\"row justify-content-evenly\">
         <div class=\"col-5\">
             <div class=\"card text-bg-primary\">
               <div class=\"card-body text-center\">
                 $x
               </div>
             </div> 
         </div>
         <diV class=\"col-5\">
             <div class=\"card text-bg-warning\">
               <div class=\"card-body fs-1 text-center\">
                 <b>$y</b>
               </div>
             </div> 
         </div>
     </div>";
 }
?> 

</body>
</html>