<?php require_once('includes/classes/init.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMA - Volunteering made easy</title>
    <link rel="icon" type="image/x-icon" href="pics/favicon-praying.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&family=Ubuntu:ital,wght@1,500&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/footer.css">

</head>

<!--change ID-->

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a id="VMA" class="navbar-brand" href="index.php"> <i class="fas fa-praying-hands mr-3"></i>VMA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link pl-5 pr-5" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-5 pr-5" href="includes/volunteerplaces.php">Our Volunteer Places</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link pl-5 pr-5" href="includes/organizations.php">Our Organizations</a>
                </li>

                <?php
                global $session;
                if ($session->user_signed_in == true) {
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-5 pr-5" href="index.php" id="user_profile" role="button"
                           data-toggle="dropdown" aria-expanded="false">
                            Hello, <?php echo $session->user_firstname ?>
                        </a>
                        <div class="dropdown-menu bg-dark " aria-labelledby="user_profile">
                            <img
                                    src="pics/<?php if ($session->user_image) {
                                        echo $session->user_image;
                                    } else {
                                        ; ?>No_image_available.jpg<?php } ?>" class="profile-pic mt-3 mb-3"
                                    alt="profile-pic">
                            <a class="dropdown-item text-white-50" href="includes/dashboard.php">My Profile Dashboard</a>
                            <a class="dropdown-item text-white-50" href="includes/logout.php">Logout</a>
                        </div>
                    </li>

                <?php } elseif ($session->organ_signed_in == true) {
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-5 pr-5" href="index.php" id="organ_profile" role="button"
                           data-toggle="dropdown" aria-expanded="false">
                            Hello, <?php echo $session->organ_name ?>
                        </a>
                        <div class="dropdown-menu bg-dark " aria-labelledby="user_profile">
                            <img src="pics/<?php echo $session->organ_image ?>"
                                 class="profile-pic mt-3 mb-3" alt="why-roi3">
                            <a class="dropdown-item text-white-50" href="includes/organ_dashboard.php">My
                                Dashboard</a>
                            <a class="dropdown-item text-white-50" href="includes/logout.php">Logout</a>

                        </div>
                    </li>

                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link pl-5 pr-5" href="includes/login.php">Log in / Sign up</a>
                    </li>

                    <?php
                }
                ?>

            </ul>
        </div>

    </div>
</nav>

<main class="container">

    <section class="row">
        <video class="col-12" autoplay muted loop controls>
            <source src="pics/home-video.mp4" type="video/mp4">
        </video>
    </section>

    <section class="row">
        <div class="difference col-6 pr-0">
            <div>
                <h1 id="true-lover" class="mr-4 ml-4">The time is now. <br> Start making a difference.</span></h1>
                <a class="btn btn-dark our-places-link" href="includes/volunteerplaces.php" role="button"><span
                            class="disappear">Go to
                    Our</span> Volunteer Opportunities</a>
            </div>
        </div>
        <img class="col-6 volunteer-smile pl-0" src="pics/home-pic.jpg" alt="volunteer-smile">
    </section>


    <div class="row">
        <div class="col-12">

            <div class="chart">
                <h4 class="text-center"> Volunteer in <span id="environment">Environment</span> field now - why is
                    it important?</h4>
                <p class="text-center second">Check out our impact on earth by seeing country's daily
                    average CO-Value chart.
                </p>
                <p class="text-center">Carbon dioxide absorbs less heat per molecule than the greenhouse gases methane
                    or nitrous oxide, but it's
                    more abundant,
                    and it stays in the atmosphere much longer. Increases in atmospheric carbon dioxide are responsible
                    for
                    about two-thirds of the total energy imbalance that is causing Earth's temperature to rise.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-light bg-light">
                <form class="form-inline" method="get">
                    <select name="select" id="search" class="custom-select" required>
                        <option value="" Selected>Choose Country...</option>
                        <option value="IL">Israel</option>
                        <option value="DE">Germany</option>
                        <option value="US">USA</option>
                    </select>
                    <label for="begin"> Begin Date: </label>
                    <input class="date form-control mr-sm-2" max="2022-02-01" id="begin" required
                           type="date"
                           name="date_begin">
                    <label for="end"> End Date: </label>
                    <input class="date form-control mr-sm-2" max="2022-02-01" required type="date"
                           name="date_until"
                           id="end">

                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="show">
                        Show
                    </button>
                </form>
            </nav>
        </div>
    </div>


    <?php if (isset($_GET['show']) && !empty($_GET['select'])) { ?>

        <?php
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $urlContents = "https://api.v2.emissions-api.org/api/v2/carbonmonoxide/average.json?country=" . $_GET['select'] . "&begin=" . $_GET['date_begin'] . "&end=" . $_GET['date_until'] . "";
        $data = file_get_contents($urlContents, false, stream_context_create($arrContextOptions));

        $pollution = json_decode($data, true);

        if ($pollution) { ?>
            <div class="alert alert-success" role="alert">
                Showing results of <?php if ($_GET['select'] == "DE") {
                    echo "Germany";
                } elseif ($_GET['select'] == "IL") {
                    echo "Israel";
                } else {
                    echo "USA";
                }; ?> from <?php echo $_GET['date_begin'] ?> until <?php echo $_GET['date_until'] ?>.
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Could not find data on specified dates, showing default. try again.
            </div>
            <?php

            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );


            $urlContents = "https://api.v2.emissions-api.org/api/v2/carbonmonoxide/average.json?country=DE&begin=2019-02-01&end=2019-03-01";
            $data = file_get_contents($urlContents, false, stream_context_create($arrContextOptions));

            $pollution = json_decode($data, true);
        }

        $day_av = array();
        foreach ($pollution as $pollution_day) {
            array_push($day_av, $pollution_day['average']);
        }

        $day_av = json_encode($day_av);
        $number = range(1, count($pollution));
        $number = json_encode($number);
        ?>

    <?php }
    else {

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $urlContents = "https://api.v2.emissions-api.org/api/v2/carbonmonoxide/average.json?country=DE&begin=2019-02-01&end=2019-03-01";

        $data = file_get_contents($urlContents, false, stream_context_create($arrContextOptions));

        $pollution = json_decode($data, true);


        $day_av = array();
        foreach ($pollution as $pollution_day) {
            array_push($day_av, $pollution_day['average']);
        }

        $day_av = json_encode($day_av);
        $number = range(1, count($pollution));
        $number = json_encode($number);

    } ?>

    <div class="row">
        <div class="col-12">
                <canvas id="myChart" class="mt-4 mb-4"></canvas>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>

<script>

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: <?php echo $number?>,
            datasets: [{
                label: 'Daily Average CO-Value',
                backgroundColor: "#005f73",
                data: <?php echo $day_av ?>
            }]
        },
        options: {
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'carbon monoxide [mol/m²]'
                    },
                    ticks: {
                        beginAtZero: true
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'day'
                    }
                }
            }
        }
    });
</script>

</body>
</html>
