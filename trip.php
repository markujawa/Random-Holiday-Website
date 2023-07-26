<?php
// getting the content of the file with trip ideas for the random city
if(isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $response = file_get_contents('txt/' . $filename . '.txt');
    echo json_encode($response);
}
?>