<?php
require_once('classes/init.php');
global $session;

$volunteer_places = VolunteerPlace::fetch_places();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMA | Our Volunteer Places</title>
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/volunteerplaces.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&family=Ubuntu:ital,wght@1,500&display=swap"
          rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

<?php include 'header.php'; ?>

<main class="container">
    <!-- Header pic -->
    <div class="row">
        <div class="col-12">

            <div id="carousel" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../pics/volunteering.jpg" class="Carousel-pictures d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../pics/volunteer-cover2.jpg" class="Carousel-pictures d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../pics/VolunteeringisGood.jpg" class="Carousel-pictures d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-target="#carousel"
                        data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-target="#carousel"
                        data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- personal message -->


    <?php if ($session->user_signed_in) { ?>
        <div class="jumbotron jumbotron-fluid text-center">
            <div class="container">
                <h1 class="display-4">Welcome back.</h1>
                <p class="lead">This page is tailored for you. <a id="learn" href="#" data-toggle="modal"
                                                                  data-target="#learn-more">Learn more.</a></p>

                <!-- Modal -->
                <div class="modal fade" id="learn-more" tabindex="-1" aria-labelledby="learn-more"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="learn-more-label">Information we use</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                We are only using your information to show you the best places for you.
                                <br><br>Our algorithm shows you:
                                <ul>
                                    <li>Places in your location.</li>
                                    <li>Places from the field you last chose.</li>
                                    <li>Most loved place by our users.</li>
                                </ul>
                                We value your privacy and will never share you information with anyone.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($session->organ_signed_in) { ?>
        <div class="jumbotron jumbotron-fluid text-center">
            <div class="container">
                <p class="lead">You can add your own volunteering places through your dashboard.</p>
            </div>
        </div>
    <?php } else { ?>
        <div class="jumbotron jumbotron-fluid text-center">
            <div class="container">
                <h1 class="display-4">Welcome.</h1>
                <p class="lead">Log in to see tailored content and start volunteering!</p>
            </div>
        </div>
    <?php } ?>


    <!--    Volunteer Places-->

    <!--    By place-->
    <?php if ($session->user_signed_in) {
        $user = new User();
        $user->find_user_by_email($session->user_email);


        $user_location = $user->city;
        $volunteer_places = VolunteerPlace::fetch_places_by_location($user_location);
        ?>
        <h3>Places close to you (<?php echo $user->city ?>)</h3>
        <hr>

        <div class="row row-cols-1 row-cols-md-3">
            <?php

            for ($i = 0;
                 $i < count($volunteer_places);
                 $i++) {
                ?>
                <?php
                $volunteer_place_name = str_replace(' ', '', $volunteer_places[$i]->name);
                $volunteer_place_name = preg_replace('/[^A-Za-z0-9\-]/', '', $volunteer_places[$i]->name);
                ?>

                <div class="col mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="../pics/<?php echo $volunteer_places[$i]->image ?>"
                             alt="Card image cap">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $volunteer_places[$i]->name; ?></h5>
                            <p class="card-text"><?php echo $volunteer_places[$i]->description; ?>
                                <!-- <br><b>Light intensity: </b>Low to high. No direct sun! -->
                                <!-- <br><b>When to water: </b>When the soil is completely dry. -->
                            </p>

                        </div>
                        <div class="card-footer ">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Organization:</strong> <?php $organ = new Organization();
                                    $organ->find_organ_by_id($volunteer_places[$i]->organization);
                                    echo $organ->name; ?></li>
                                <li class="list-group-item">
                                    <strong>Field: </strong><?php echo $volunteer_places[$i]->field ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Location: </strong><?php echo $volunteer_places[$i]->location ?>
                                </li>
                            </ul>
                            <div class="card-body text-center">
                                <button type="button" class="buy-btn btn btn-dark" data-toggle="modal"
                                        data-target="#<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "place"; ?>">
                                    Join Now
                                </button>
                            </div>
                        </div>
                        <?php if (!$session->user_signed_in) { ?>
                            <!-- Modal -->
                            <div class="modal fade"
                                 id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "place"; ?>"
                                 tabindex="-1"
                                 aria-labelledby="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "place-label"; ?>"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "place-label"; ?>">
                                                Log in required</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            You need to be logged in to start volunteering!
                                        </div>
                                        <div class="modal-footer">
                                            <a href="login.php" class="btn btn-primary">Log In / Join Us</a>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                        <div class="modal fade"
                             id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "place"; ?>"
                             tabindex="-1"
                             aria-labelledby="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-place"; ?>"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-place"; ?>">
                                            Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to join this volunteer opportunity? <br> We'd love to have
                                        you!
                                    </div>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $volunteer_places[$i]->name ?>
                                    </div>

                                    <div class="modal-footer">

                                        <form method="POST">
                                            <input type="hidden" name="volunteer-num" class="input-disappear"
                                                   value="<?php echo $volunteer_places[$i]->number ?>">
                                            <input type="submit" class="btn btn-primary" name="join"
                                                   value="Yes, sign me up!">
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php

        ?>

        <!--By field-->
        <?php
        $volunteers = Volunteers::find_volunteering($user->email);
        if ($volunteers) {
            $last_volunteer = Volunteers::check_interest($volunteers);

            $volunteer_place = new VolunteerPlace;
            $volunteer_place->fetch_place_by_num($last_volunteer);

            $volunteer_places = VolunteerPlace::fetch_places_by_field($volunteer_place->field); ?>
            <h3 class="mt-3">Check out more from your latest chosen field (<?php echo $volunteer_place->field ?>) </h3>
            <hr>
            <div class="row row-cols-1 row-cols-md-3">
            <?php

            for ($i = 0;
                 $i < count($volunteer_places);
                 $i++) {
                ?>
                <?php
                $volunteer_place_name = str_replace(' ', '', $volunteer_places[$i]->name);
                $volunteer_place_name = preg_replace('/[^A-Za-z0-9\-]/', '', $volunteer_places[$i]->name);
                ?>

                <div class="col mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="../pics/<?php echo $volunteer_places[$i]->image ?>"
                             alt="Card image cap">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $volunteer_places[$i]->name; ?></h5>
                            <p class="card-text"><?php echo $volunteer_places[$i]->description; ?>
                            </p>

                        </div>
                        <div class="card-footer ">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Organization:</strong> <?php $organ = new Organization();
                                    $organ->find_organ_by_id($volunteer_places[$i]->organization);
                                    echo $organ->name; ?></li>
                                <li class="list-group-item">
                                    <strong>Field: </strong><?php echo $volunteer_places[$i]->field ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Location: </strong><?php echo $volunteer_places[$i]->location ?>
                                </li>
                            </ul>
                            <div class="card-body text-center">
                                <button type="button" class="buy-btn btn btn-dark" data-toggle="modal"
                                        data-target="#<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "field" ?>">
                                    Join Now
                                </button>
                            </div>
                        </div>

                        <?php if (!$session->user_signed_in) { ?>
                            <!-- Modal -->
                            <div class="modal fade"
                                 id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "field"; ?>"
                                 tabindex="-1"
                                 aria-labelledby="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-field"; ?>"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-field"; ?>">
                                                Log in required</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            You need to be logged in to start volunteering!
                                        </div>
                                        <div class="modal-footer">
                                            <a href="login.php" class="btn btn-primary">Log In / Join Us</a>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                        <div class="modal fade"
                             id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "field"; ?>"
                             tabindex="-1"
                             aria-labelledby="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-field" ?>"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-field"; ?>">
                                            Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to join this volunteer opportunity? <br> We'd love to have
                                        you!
                                    </div>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $volunteer_places[$i]->name ?>
                                    </div>
                                    <div class="modal-footer">

                                        <form method="POST">
                                            <input type="hidden" name="volunteer-num" class="input-disappear"
                                                   value="<?php echo $volunteer_places[$i]->number ?>">
                                            <input type="submit" class="btn btn-primary" name="join"
                                                   value="Yes, sign me up!">
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php
            }
        } ?>
        </div>


        <!-- By Most Loved -->

        <h3 class="mt-3">Most loved by our users</h3>
        <hr>
        <div class="row row-cols-1 row-cols-md-3">
            <?php

            $most_loved_num = VolunteerPlace::fetch_most_loved();
            $most_loved_num = $most_loved_num['volunteer_num'];

            $most_loved = new VolunteerPlace();
            $most_loved->fetch_place_by_num($most_loved_num);

            $volunteer_place_name = str_replace(' ', '', $most_loved->name);
            $volunteer_place_name = preg_replace('/[^A-Za-z0-9\-]/', '', $most_loved->name);

            ?>
            <?php
            ?>

            <div class="col mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="../pics/<?php echo $most_loved->image ?>"
                         alt="Card image cap">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $most_loved->name; ?></h5>
                        <p class="card-text"><?php echo $most_loved->description; ?>
                        </p>

                    </div>
                    <div class="card-footer ">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Organization:</strong> <?php $organ = new Organization();
                                $organ->find_organ_by_id($most_loved->organization);
                                echo $organ->name; ?></li>
                            <li class="list-group-item">
                                <strong>Field: </strong><?php echo $most_loved->field ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Location: </strong><?php echo $most_loved->location ?>
                            </li>
                        </ul>
                        <div class="card-body text-center">
                            <button type="button" class="buy-btn btn btn-dark" data-toggle="modal"
                                    data-target="#<?php echo $volunteer_place_name . "most"; ?>">
                                Join Now
                            </button>
                        </div>
                    </div>

                    <?php if (!$session->user_signed_in) { ?>
                        <!-- Modal -->
                        <div class="modal fade" id="<?php echo $volunteer_place_name . "most"; ?>" tabindex="-1"
                             aria-labelledby="<?php echo $volunteer_place_name . "mostlabel"; ?>"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?php echo $volunteer_place_name . "mostlabel"; ?>">Log
                                            in required</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        You need to be logged in to start volunteering!
                                    </div>
                                    <div class="modal-footer">
                                        <a href="login.php" class="btn btn-primary">Log In / Join Us</a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                    <div class="modal fade" id="<?php echo $volunteer_place_name . "most"; ?>" tabindex="-1"
                         aria-labelledby="<?php echo $volunteer_place_name . "mostlabel"; ?>"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="<?php echo $volunteer_place_name . "mostlabel"; ?>">
                                        Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to join this volunteer opportunity? <br> We'd love to have
                                    you!
                                </div>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $most_loved->name ?>
                                </div>
                                <div class="modal-footer">

                                    <form method="POST">
                                        <input type="hidden" name="volunteer-num" class="input-disappear"
                                               value="<?php echo $most_loved->number ?>">
                                        <input type="submit" class="btn btn-primary" name="join"
                                               value="Yes, sign me up!">
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

        </div>
        <?php
    } ?>

    <!--    All places-->
    <?php

    $volunteers = Volunteers::fetch_volunteering();

    $volunteer_places = VolunteerPlace::fetch_places();
    if ($session->user_signed_in) {
        ?>
        <h3 class="mt-3">All of our places</h3>
        <hr>
        <?php
    } ?>
    <div class="row row-cols-1 row-cols-md-3">
        <?php

        for ($i = 0;
             $i < count($volunteer_places);
             $i++) {
            $volunteer_place_name = str_replace(' ', '', $volunteer_places[$i]->name);
            $volunteer_place_name = preg_replace('/[^A-Za-z0-9\-]/', '', $volunteer_places[$i]->name);
            ?>

            <div class="col mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="../pics/<?php echo $volunteer_places[$i]->image ?>"
                         alt="Card image cap">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $volunteer_places[$i]->name; ?></h5>
                        <p class="card-text"><?php echo $volunteer_places[$i]->description; ?>
                        </p>

                    </div>
                    <div class="card-footer ">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Organization:</strong> <?php $organ = new Organization();
                                $organ->find_organ_by_id($volunteer_places[$i]->organization);
                                echo $organ->name; ?></li>
                            <li class="list-group-item">
                                <strong>Field: </strong><?php echo $volunteer_places[$i]->field ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Location: </strong><?php echo $volunteer_places[$i]->location ?>
                            </li>
                        </ul>
                        <div class="card-body text-center">
                            <button type="button" class="buy-btn btn btn-dark" data-toggle="modal"
                                    data-target="#<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "all"; ?>">
                                Join Now
                            </button>
                        </div>
                    </div>

                    <?php if (!$session->user_signed_in) { ?>
                        <!-- Modal -->
                        <div class="modal fade"
                             id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "all"; ?>"
                             tabindex="-1"
                             aria-labelledby="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-all"; ?>"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-all"; ?>">
                                            Log in required</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if($session->organ_signed_in){ ?> You need to be logged in <strong> as a user </strong> to start volunteering! <?php }else{ ?> You need to be logged in to start volunteering! <?php } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php if($session->organ_signed_in){ ?> logout.php <?php }else{ ?> login.php <?php } ?>" class="btn btn-primary"><?php if($session->organ_signed_in){ ?> Log out <?php }else{ ?> Log In / Join Us <?php } ?></a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="modal fade"
                             id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "all"; ?>"
                             tabindex="-1"
                             aria-labelledby="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-all"; ?>"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="<?php echo $volunteer_place_name . $volunteer_places[$i]->number . "label-all"; ?>">
                                            Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to join this volunteer opportunity? <br> We'd love to have
                                        you!
                                    </div>
                                    <div class="alert alert-success"
                                         role="alert"><?php echo $volunteer_places[$i]->name ?></div>
                                    <div class="modal-footer">

                                        <form method="POST">
                                            <input type="hidden" name="volunteer-num" class="input-disappear"
                                                   value="<?php echo $volunteer_places[$i]->number ?>">
                                            <input type="submit" class="btn btn-primary" name="join"
                                                   value="Yes, sign me up!">

                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        } ?>
    </div>


</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="../js/volunteerplaces.js"></script>

</body>

</html>