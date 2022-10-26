<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e0e2f315c7.js" crossorigin="anonymous"></script>
  </head>
  <body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">

                <a class="navbar-brand " href="#">
                    <i class="fa-solid fa-shop fa-xl text-light me-2 "></i>
                    eshop
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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
                            <a class="nav-link" href="create_customer.php">Create Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="Exercise.php">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active bg-light p-5">
          <h5 class="card-title">Learn to Create Websites</h5>
          <p class="card-text mt-2">In today's world internet is te most popular way of connection with the
              people. At <a href="tutorialrepublic.com" class="text-decoration-none">tutorialrepublic.com</a>
              you will lwarn the essential web development technologies along with real life pratice examples,
              so that you can create your own website to connect with the people around the world.</p>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Get Stared Today>>
              </button>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <img src="images/hand-painted-watercolor-background-with-sky-clouds-shape.jpg" width="100%">
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div id="second-slide" class="carousel-item p-5">
          <h5 class="card-title">Learn to Create Websites</h5>
          <p class="card-text mt-2">In today's world internet is te most popular way of connection with the
              people. At <a href="tutorialrepublic.com" class="text-decoration-none">tutorialrepublic.com</a>
              you will lwarn the essential web development technologies along with real life pratice examples,
              so that you can create your own website to connect with the people around the world.</p>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Get Stared Today>>
              </button>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <img src="images/hand-painted-watercolor-background-with-sky-clouds-shape.jpg" width="100%">
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between row">
      <div class="card col-12 col-sm-4 border-0">
          <div class="card-body">
              <h5 class="card-title">HTML</h5>
              <p class="card-text">HTML is the standard markup language for describing the structure of the web
                  page. Our HTML tutorials will help you to understand the basics of the latest HTML5 language, so
                  that you can create your own web pages or websites.</p>
              <a href="#" class="btn btn-success">Learn More &raquo;</a>
          </div>
      </div>
      <div class="card col-12 col-sm-4 border-0 d-none d-sm-flex">
          <div class="card-body">
              <h5 class="card-title">CSS</h5>
              <p class="card-text">CSS is used for describing the presentation of web pages. CSS can save a lot of
                  time and effort. Our CSS tutorials will help you to learn the essentials of latest CSS3, so that
                  you can control the styles and layout of your websites. </p>
              <a href="#" class="btn btn-success">Learn More &raquo;</a>
          </div>
      </div>
      <div class="card col-12 col-sm-4 border-0">
          <div class="card-body">
              <h5 class="card-title">Bootstrap</h5>
              <p class="card-text">Bootstrap is a powerful fromt-end framework for faster and easier web
                  development. Out Bootstrap tutorials will help you to learn all the features of latest Bootstrap
                  4 framework so that you can easily create responsive websites.</p>
              <a href="#" class="btn btn-success">Learn More &raquo;</a>
          </div>
      </div>
  </div>
    <footer class="margin border-top py-3 d-flex flex-column flex-sm-row text-start text-sm-center justify-content-between align-items-start align-items-sm-cente">
      <div>
        <p class="m-0">Copyright @2019 Tutorial Republic</p>
        </div>
        <div class = "d-flex pt-2 pt-sm-0">
          <a href="#" class="border-end pe-2 px-sm-2 text-decpration-none text-dark">Term of Us</a>
    
          <a href="#" class="px-2 txt-decoration-none text-dark">Privacy Policy</a>
        </div>
      </div>
    </div>
      </footer>
    </body>

</html>
