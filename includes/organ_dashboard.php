<?php
require_once('classes/init.php');
global $session;

if ($session->organ_signed_in == false) {
    header('Location: ../index.php');
}

$organization = new Organization();
$organization->find_organ_by_id($session->organ_id);

$volunteer_places = VolunteerPlace::fetch_places_by_organ($session->organ_id);


if (isset($_POST["delete"])) {
    $error = volunteerplace::delete_volunteer_place($_POST["vol-num"]);
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">

    <link rel="stylesheet" href="../css/dashboard.css">

    <title>VMA | My Dashboard</title>
</head>
<body>
<div class="sidebar active">
    <div class="logo-details">
        <i class="fas fa-praying-hands"></i>
        <span class="logo_name">F4L</span>
    </div>
    <ul class="nav-links p-0">
        <li>
            <a href="#" class="active">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>

        <li class="log_out">
            <a href="logout.php">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Log out</span>
            </a>
        </li>
    </ul>
</div>

<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
        <a href="../index.php" class="btn-back btn btn-primary" role="button">Go back to site</a>

        <div class="profile-details">
            <img src="../pics/<?php if ($organization->image) {
                echo $organization->image;
            } else {
                echo "no_image_available.jpg";
            } ?>" alt="profile-pic">
            <span class="admin_name "><?php echo $organization->name; ?></span>
        </div>
    </nav>

    <div class="home-content">

        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="title"> <?php echo $organization->name; ?>'s Volunteer Places</div>
                <div class="sales-details">

                    <table class="table table-hover mt-4">
                        <thead>
                        <tr>
                            <th scope="col">Date Added</th>
                            <th scope="col">Location</th>
                            <th scope="col">Name</th>
                            <th scope="col">Field</th>
                            <th scope="col">Delete</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($volunteer_places) {
                            foreach ($volunteer_places

                                     as $volunteer_place) {

                                ?>
                                <tr>
                                    <td><?php echo $volunteer_place->date; ?></td>
                                    <td><?php echo $volunteer_place->location ?></td>
                                    <td><?php echo $volunteer_place->name ?></td>
                                    <td><?php echo $volunteer_place->field ?></td>
                                    <td>
                                        <form method="post" id="delete"><input name="vol-num" type="hidden"
                                                                               value="<?php echo $volunteer_place->number ?>"><input
                                                    id="delete"
                                                    name="delete"
                                                    class="btn btn-danger"
                                                    type="submit"
                                                    value="Delete">
                                        </form>
                                    </td>

                                </tr>

                            <?php }
                        } else { ?>
                            <tr>
                                <td>You haven't added any volunteering yet :(</td>

                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                </div>

                <button type="button" class="btn-update btn btn-primary m-auto" data-toggle="modal"
                        data-target="#add-volunteer">
                    Publish a volunteer opportunity
                </button>

                <!-- Modal -->
                <div class="modal fade" id="add-volunteer" tabindex="-1" aria-labelledby="add-volunteerLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class=" m-0 modal-body box">

                                <!-- alert-->
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>For your information:</strong> once added the data you provided will be
                                    immediately
                                    show in our Places page.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>


                                </div>
                                <form id="add">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" class="form-control" id="floatingInput"
                                               placeholder="Name">
                                        <label for="floatingInput">Name</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="location" id="floatingSelectLocation"
                                                aria-label="select-location">
                                            <option selected>Choose...</option>
                                            <option>Tel Aviv</option>
                                            <option>Petah Tikva</option>
                                            <option>Haifa</option>
                                            <option>Jerusalem</option>
                                            <option>Holon</option>
                                        </select>
                                        <label for="floatingSelectLocation">Select Lcation</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="field" id="floatingSelectField"
                                                aria-label="select-field">
                                            <option selected>Choose...</option>
                                            <option>Community</option>
                                            <option>Environment</option>
                                            <option>Animals</option>
                                            <option>Poverty</option>
                                            <option>Disabilities</option>
                                        </select>
                                        <label for="floatingSelectField">Select Field</label>
                                    </div>

                                    <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Description" id="floatingTextarea2"
                              name="description"></textarea>
                                        <label for="floatingTextarea2">Short Description</label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload a picture</label>
                                        <input class="form-control" type="file" id="formFile" name="fileToUpload">
                                        <small id="fileHelp" class="form-text text-muted">File types allowed: jpg, jpeg,
                                            gif, png. Max
                                            size: 5MB.</small>
                                    </div>

                                    <!-- alert-->
                                    <div class="alert alert-error alert-danger display-error display-none"></div>
                                    <button name="volunteer-add" class="btn-submit btn btn-dark mt-4 mb-3"
                                            type="submit" id="add-vol">
                                        Add
                                    </button>


                                    <button type="button" class="btn-submit btn btn-info mt-3 mb-3 display-none"
                                            id="refresh">
                                        Refresh Page
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="top-sales box">
                <div class="title"> <?php echo $organization->name; ?>'s Profile Summery</div>
                <div class="top-sales-details">

                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">ID:</strong>
                            &nbsp; <?php echo $organization->id; ?></li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Name:</strong>
                            &nbsp; <?php echo $organization->name; ?></li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Mobile:</strong>
                            &nbsp; <?php echo $organization->phone; ?></li>
                        <li class="list-group-item list-group-item-hover"><strong class="text-dark">Location: </strong>
                            &nbsp; <?php echo $organization->address . ", " . $organization->city; ?></li>
                        <img class="organ-image mt-3" src="../pics/<?php if ($organization->image) {
                            echo $organization->image;
                        } else { ?>no_image_available.jpg<?php } ?>">

                    </ul>
                </div>
            </div>
        </div>

        <script>

        </script>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
        <script src="../js/dashboard.js"></script>

        <script>

            $(document).ready(function () {

                $("#add").submit(function (e) {

                    e.preventDefault();

                    var formData = new FormData(this);
                    formData.append("volunteer-add", "true");
                    button = $("#add-vol");
                    error = $(".alert-error")
                    warning = $(".alert-warning")

                    var form = this;

                    $.ajax({
                        type: 'post',
                        url: 'addVolunteerPlace.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            button.html("Loading...");
                        },
                        complete: function () {
                            button.html("Try again");
                        },
                        success: function (response) {
                            if (response.replace(/\s/g, '').length) {
                                error.html("<ul>" + response + "</ul>");
                                error.css("display", "block");
                            } else {
                                error.addClass("alert-success").removeClass("alert-danger");
                                warning.addClass("display-none");
                                error.html('Volunteering added! You should see it in our Places page.');
                                error.css("display", "block");
                                button.addClass("display-none");
                                $("#refresh").removeClass("display-none")
                            }
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                });
            });

            $(document).ready(function () {

                $("#refresh").click(function (e) {
                    location.reload();
                });
            });


        </script>
</body>
</html>

