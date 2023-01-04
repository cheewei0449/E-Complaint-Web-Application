<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">

      <a class="navbar-brand " href="welcome.php">
        <i class="fa-brands fa-shopify fa-xl text-light me-2 "></i>
        eshop
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-md-flex justify-content-end" id="navbarCollapse">
        <ul class="navbar-nav mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="welcome.php">Welcome </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="product_create.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Product
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
              <li><a class="dropdown-item" href="product_read.php">Product List</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="create_customer.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Customer
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="create_customer.php">Create Customer</a></li>
              <li><a class="dropdown-item" href="customer_read.php">Customer List</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="create_new_order.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Order
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="create_new_order.php">Create Order</a></li>
              <li><a class="dropdown-item" href="order_read.php">Order List</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Contact.php">Contact Us</a>
          </li>
          <li>
            <a class="btn btn-danger" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>