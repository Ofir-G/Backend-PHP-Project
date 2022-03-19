<?php
require_once('classes/init.php');
global $session;
error_reporting(0);
$organizations = Organization::fetch_organizations();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VMA | Our Volunteer Organizations</title>
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&family=Ubuntu:ital,wght@1,500&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="../css/organizations.css">

</head>

<body>

<?php include 'header.php'; ?>

<main class="container">

    <!-- Header -->

    <div class="row">
        <div class=" col-md-12">
            <img src="../pics/organ_header.jpg" id="headerpic">
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <?php if ($session->organ_signed_in == false) { ?>
                <h1 class="display-4"> Are you an organization?</h1>
                <p class="lead">Join us now and start publishing your volunteer opportunities!</p>
            <?php } else { ?>
                <p class="lead">You can see your details published here. if you're unhappy you can contact us at
                    VMA@managment.com</p>
            <?php } ?>
        </div>
    </div>

    <!-- Search nav bar -->

    <nav class="navbar navbar-light bg-light">
        <form class="form-inline" method="get">
            <select name="select" id="search" class="custom-select">
                <option value="our" Selected>Search Our Organizations</option>
                <option value="api">Search Organizations Globally</option>
            </select>
            <input id="input" class="form-control mr-sm-2" required type="search" placeholder="Search By Name"
                   aria-label="Search" name="search_term">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search
            </button>
        </form>
    </nav>

    <!-- API info -->

    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
        <strong>What is this?</strong> We are using our friends "Charity Navigator" API to supply a global search for
        organizations. There might be issues that are not linked to us.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <!-- API Search results -->

    <?php
    $found=false;

    if (isset($_GET["search"]) && isset($_GET["search_term"])) {
        if ($_GET["select"] == "api") {

            ?>
            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">EIN</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Category</th>
                </tr>
                </thead>

                <?php

                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                ### API key was removed ### 
                $urlContents = "https://api.data.charitynavigator.org/v2/Organizations?app_id=afddb78a&app_key=X&search=" . urlencode($_GET["search_term"]);

                $data = file_get_contents($urlContents, false, stream_context_create($arrContextOptions));

                if($data) {
                    $found = true;
                }

                $organizations_array = json_decode($data, true);

                foreach ($organizations_array

                as $organization_api){
                ?>
                <tbody>
                <tr>
                    <td><?php echo $organization_api['organization']['ein']; ?></td>
                    <td><?php echo $organization_api['charityName']; ?></td>
                    <td><?php echo $organization_api['mailingAddress']['city'] . ", " . $organization_api['mailingAddress']['streetAddress1'] .
                            ", " . $organization_api['mailingAddress']['stateOrProvince']; ?></td>
                    <td><?php echo $organization_api['irsClassification']['nteeClassification']; ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php
        }
    }
    ?>

    <!-- Our Search results -->

    <?php




    if (isset($_GET["search"]) && !empty($_GET["search_term"])) {
        if ($_GET["select"] == "our") {

            foreach ($organizations as $organization) {

                if (stripos($organization->name, $_GET["search_term"]) !== false) { $found=true;
    ?>

                    <h2 class="mt-4">Search results...</h2>
                    <hr>
                    <?php
                    $organization_name = str_replace(' ', '', $organization->name);
                    $organization_name = preg_replace('/[^A-Za-z0-9\-]/', '', $organization->name);
                    ?>
                    <article class="card mb-5 mt-5" id="light">
                        <div class="row">
                            <div class="col-md-4 img_flex">
                                <img class="card-img-top" src="../pics/<?php echo $organization->image ?>" alt=" ... ">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $organization->name ?></h5>
                                    <p class="card-text"><?php echo $organization->mission_statement ?> </p>
                                    <p class="card-text"><small
                                                class="text-muted"><?php echo $organization->city . ", " . $organization->address . ", " . $organization->phone ?></small>
                                    </p>
                                    <button class="btn btn-dark mt-5 col-6 mx-auto" type="button" data-toggle="collapse"
                                            data-target="#<?php echo $organization_name . $organization->id; ?>"
                                            aria-expanded="false"
                                            aria-controls="<?php echo $organization_name . $organization->id; ?>">Read
                                        More
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="<?php echo $organization_name . $organization->id; ?>">
                            <div class="card card-body">
                                <p class="keep-format"><?php echo $organization->description ?>
                                </p>
                            </div>
                        </div>
                    </article>
                    <?php
                }
            }
        }

    } else {
        ?>

        <!--        All Our organizations-->

        <?php
        foreach ($organizations as $organization) {
            $organization_name = str_replace(' ', '', $organization->name);
            $organization_name = preg_replace('/[^A-Za-z0-9\-]/', '', $organization->name);
            ?>
            <article class="card mb-5 mt-5" id="light">
                <div class="row">
                    <div class="col-md-4 img_flex">
                        <img class="card-img-top" src="../pics/<?php echo $organization->image ?>" alt=" ... ">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $organization->name ?></h5>
                            <p class="card-text"><?php echo $organization->mission_statement ?> </p>
                            <p class="card-text"><small
                                        class="text-muted"><?php echo $organization->city . ", " . $organization->address . ", " . $organization->phone ?></small>
                            </p>
                            <button class="btn btn-dark mt-5 col-6 mx-auto" type="button" data-toggle="collapse"
                                    data-target="#<?php echo $organization_name . $organization->id; ?>"
                                    aria-expanded="false"
                                    aria-controls="<?php echo $organization_name . $organization->id; ?>">Read
                                More
                            </button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="<?php echo $organization_name . $organization->id; ?>">
                    <div class="card card-body">
                        <p class="keep-format"><?php echo $organization->description ?>
                        </p>
                    </div>
                </div>
            </article>
            <?php
        }
    }

            if($found==false && isset($_GET["search"])) { ?>
    <div class="alert alert-danger alert-dismissible fade show mt-2 " role="alert">
        Sorry, no results were found.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    }
    ?>

</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../js/organizations.js"></script>

<script>

</script>


</body>

</html>