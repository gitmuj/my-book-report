<?php

// connect to the database
$conn = mysqli_connect('localhost', 'muj', 'muj123', 'my_book_report');

// check connection
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}
