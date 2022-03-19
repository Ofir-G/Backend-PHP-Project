<?php require_once('classes/init.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a id="VMA" class="navbar-brand" href="../index.php"> <i class="fas fa-praying-hands mr-3"></i>VMA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link pl-5 pr-5" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-5 pr-5" href="volunteerplaces.php">Our Volunteer Places</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link pl-5 pr-5" href="organizations.php">Our Organizations</a>
                </li>

                <?php
                global $session;
                if ($session->user_signed_in == true) {
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-5 pr-5" href="#" id="user_profile" role="button"
                           data-toggle="dropdown" aria-expanded="false">
                            Hello, <?php echo $session->user_firstname ?>
                        </a>
                        <div class="dropdown-menu bg-dark " aria-labelledby="user_profile">
                            <img
                                    src="../pics/<?php if ($session->user_image) {
                                        echo $session->user_image;
                                    } else {
                                        ; ?>No_image_available.jpg<?php } ?>" class="profile-pic mt-3 mb-3"
                                    alt="profile-pic">
                            <a class="dropdown-item text-white-50" href="dashboard.php">My Profile Dashboard</a>
                            <a class="dropdown-item text-white-50" href="logout.php">Logout</a>
                        </div>
                    </li>

                <?php } elseif ($session->organ_signed_in == true) {
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-5 pr-5" href="#" id="organ_profile" role="button"
                           data-toggle="dropdown" aria-expanded="false">
                            Hello, <?php echo $session->organ_name ?>
                        </a>
                        <div class="dropdown-menu bg-dark " aria-labelledby="user_profile">
                            <img src="../pics/<?php echo $session->organ_image ?>"
                                 class="profile-pic mt-3 mb-3" alt="why-roi3">
                            <a class="dropdown-item text-white-50" href="organ_dashboard.php">My
                                Dashboard</a>
                            <a class="dropdown-item text-white-50" href="logout.php">Logout</a>

                        </div>
                    </li>

                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link pl-5 pr-5" href="login.php">Log in / Sign up</a>
                    </li>

                    <?php
                }
                ?>

            </ul>
        </div>

    </div>
</nav>
</body>

</html>