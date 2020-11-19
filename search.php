<?php

if (!isset($_SESSION)) {
  session_start();
}

$APIKEY = "AIzaSyD7roHPfdKfCmzmKh54bqpqolerM6cR6dU";
$search_keyword = '';


//$_SESSION['books'] = null;

if (isset($_GET['submit'])) {

  $search_keyword = str_replace(" ", "+", $_GET['search_keyword']);
  echo  $search_keyword;
  $params = array("q" => $search_keyword, "key" => $APIKEY);
  $query = http_build_query($params);

  //$url = "https://www.googleapis.com/books/v1/volumes?q=$search_keyword&key=$APIKEY";
  $url = "https://www.googleapis.com/books/v1/volumes";

  //  Initiate curl
  $ch = curl_init();
  // Will return the response, if false it print the response
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Set the url
  curl_setopt($ch, CURLOPT_URL, "$url?$query");

  // Execute
  $result = curl_exec($ch);
  // Closing
  curl_close($ch);

  // Will dump a beauty json :3
  $books = json_decode($result, true);
  $_SESSION['keyword'] = $search_keyword;
  $_SESSION['books'] = $books;
  session_write_close();
  // print_r($_SESSION['books']);
  if ($_SESSION['books'] != null && $_SESSION['keyword'] != '') header('Location: books.php');
}


?>

<!-- Masthead -->
<header class="masthead text-white text-center">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-xl-9 mx-auto">
        <h1 class="mb-5">Find your next read, and remember your last.</h1>
      </div>
      <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">

        <div class="form-row">
          <div class="col-12 col-md-12 mb-2 mb-md-0">
            <!-- search bar -->
            <form action="search.php" method="GET">
              <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-4">
                <div class="input-group">
                  <input type="search" placeholder="Search for book or author" aria-describedby="button-addon1" class="form-control border-0 bg-light" name="search_keyword">
                  <div class="input-group-append">
                    <button name="submit" id="button-addon1" type="submit" class="btn btn-link text-primary"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>

          </div>

        </div>
        </form>
      </div>
    </div>
  </div>
</header>