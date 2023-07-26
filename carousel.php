<?php
$images = array(
    "img/carousel/venice.jpg",
    "img/carousel/zurich.jpg",
    "img/carousel/rodos.jpg",
    "img/carousel/vienna.jpg",
    "img/carousel/barcelona.jpg"
);

foreach ($images as $image) {
    echo '<div><img src="' . $image . '"></div>';
}
?>