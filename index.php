<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="icon" type="image/png" href="/img/logo.png" />
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"
        integrity="sha512-WNZwVebQjhSxEzwbettGuQgWxbpYdoLf7mH+25A7sfQbbxKeS5SQ9QBf97zOY4nOlwtksgDA/czSTmfj4DUEiQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title id="pageTitle">Strona główna</title>
</head>

<body>
    <!-- the top part of the page with the logo and homepage button -->
    <div class="logoArea">
        <nav class="navbar">
            <ul class="navItems">
                <li class="item"><a href="/index.php">Strona główna</a></li>
            </ul>
        </nav>
    </div>

    <!-- carousel -->
    <div class="carousel">
        <?php include 'carousel.php'; ?>
    </div>

    <!-- container with a button and a place for the name of the random city -->
    <div class="container">
        <?php
            $cities = ['Wenecja', 'Zurych', 'Rodos', 'Wiedeń', 'Barcelona'];
            $filenames = ['venice', 'zurich', 'rodos', 'vienna', 'barcelona']
        ?>
        <button class="vacation" onclick="showRandomName()">Wylosuj miasto na wakacje</button>
        <div id="city"></div>
    </div>

    <div class="descriptionContainer">
        <!-- container for the trip ideas text -->
        <div id="tripDescriptionWindow">
            <!-- text with trip ideas -->
            <p id="tripDescription"></p>
        </div>
    </div>
</body>

<script>
// setup for the carousel 
$(document).ready(function() {
    $('.carousel').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        infinite: true,
        arrows: false,
        dots: false,
        centerMode: true,
        variableWidth: true
    });
});

var filename;
var interval;
var isPrinting = false;

// function for printing the file content letter by letter
function printContent() {
    $("#tripDescription").empty();
    clearInterval(interval);

    $.ajax({
        type: "POST",
        url: "trip.php",
        dataType: 'json',
        charset: 'utf-8',
        data: {
            filename: filename
        },
        success: function(response) {
            var lines = response.split('\n');
            var lineIndex = 0;
            var index = 0;

            interval = setInterval(function() {
                if (index >= lines[lineIndex].length) {
                    lineIndex++;
                    if (lineIndex >= lines.length) {
                        clearInterval(interval);
                        return;
                    }
                    $("#tripDescription").append('<br>');
                    index = 0;
                }
                $("#tripDescription").append(lines[lineIndex].charAt(index));
                index++;
            }, 20);
        }
    });
}

// function for choosing the random city and showing the name of that city, it also invokes the printContent() function
function showRandomName() {
    var tripDescriptionWindow = document.getElementById("tripDescriptionWindow");
    tripDescriptionWindow.classList.remove("active");

    var cities = <?php echo json_encode($cities); ?>;
    var randomIndex = Math.floor(Math.random() * cities.length);
    var randomName = cities[randomIndex];
    document.getElementById('city').innerHTML = randomName;

    var slideIndex = randomIndex;
    $('.carousel').slick('slickPause');
    $('.carousel').slick('slickGoTo', slideIndex);

    var filenames = <?php echo json_encode($filenames); ?>;
    filename = filenames[randomIndex];

    tripDescriptionWindow.classList.toggle("active");
    printContent();
}
</script>

</html>