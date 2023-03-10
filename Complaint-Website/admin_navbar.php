<?php

// Function to check string starting
// with given substring
function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function active($pagename)
{
    return basename($_SERVER["PHP_SELF"]) == $pagename ? "active" : "";
}

function active_startwith($pagename_start)
{
    return startsWith(basename($_SERVER["PHP_SELF"]), "$pagename_start") ? "active" : "";
}

$current_user = $_SESSION["userID"];

include 'config/database.php';

?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-xl d-flex justify-content-between ">
            <a class="navbar-brand " href="admin_users_list.php">
            <i class="fas fa-comments fa-xl text-light me-2 "></i>
                E-Complaint
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-md-flex justify-content-end" id="navbarCollapse">
                <ul class="navbar-nav mb-2 mb-md-0">
                    <li class="nav-item align-self-md-center">
                        <a class="nav-link <?php echo active("admin_users_list.php") ?>" aria-current="page" href="admin_users_list.php">UserList</a>
                    </li>
                    <li class="nav-item align-self-md-center">
                        <a class="nav-link <?php echo active("admin_users_create.php") ?>" aria-current="page" href="admin_users_create.php">Create User</a>
                    </li>
                    <li class="nav-item align-self-md-center">
                        <a class="btn btn-danger ms-0 ms-md-4 mt-3 mt-md-0" href="logout.php">LOGOUT</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>