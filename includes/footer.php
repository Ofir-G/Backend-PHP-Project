<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roi | Footer</title>
    <link rel="icon" type="image/x-icon" href="../pics/favicon-praying.ico">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
<footer class="p-5 h-75 bg-dark text-white text-center position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="headers_footer">We are here for you.</h1><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md">
                <h2 class="headers_footer">Contact Us</h2>
                <p>03-680-6080</p> <br>
                <a href="mailto:VMA@managment.com">VMA@managment.com</a><br>
                <br>
            </div>
            <div class="col-md">
                <h2 class="headers_footer">Visit Us</h2>
                <p>Rabenu Yeruham St 2, Tel Aviv-Yafo <br> Mon 10 am - 3 pm <br> Wed - Fri 12 pm - 7 pm <br> Sat - Sun
                    10 am - 3 pm <br>
                </p>
            </div>
        </div>
    </div>


    <div class="google-map mt-4" id="map">
    </div>

    <script>
        //Initialize and add the map
        function initMap() {
            // The location of f4l
            const f4l = {lat: 32.0487508, lng: 34.7597556};
            // The map, centered at f4l
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: f4l,
            });
            // The marker, positioned at f4l
            const marker = new google.maps.Marker({
                position: f4l,
                map: map,
            });
        }
    </script>
    <script async
            src="https://maps.googleapis.com/maps/api/js?key=X&callback=initMap">
            // ## API key was removed ##
    </script>

    <div class="row">
        <div class="col-12">
            <p class="copyright"><br>VMA 2022, All Rights Reserved &copy;</p>
        </div>
    </div>

</footer>

</body>

</html>
