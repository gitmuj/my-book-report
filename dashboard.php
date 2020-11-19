<?php
//session_start();
include('templates/header.php');
include('config/db_connect.php');




$books = [];

if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {
    $user = mysqli_real_escape_string($conn, $_SESSION['username']);

    $sql = "SELECT * FROM books WHERE user = '$user' ";

    //get result
    $result = mysqli_query($conn, $sql);
    $books = mysqli_fetch_all($result);
    mysqli_free_result($result);
    //mysqli_close($conn);
}

if (isset($_POST['add_report'])) {

    $_SESSION['book'] = $_POST['result'];
    header('Location: add_report.php');
}

if (isset($_POST['view_report'])) {

    $_SESSION['book'] = $_POST['result'];
    header('Location: view_report.php');
}

if (isset($_POST['delete_report'])) {

    $book = $_POST['result'];
    print_r($book);

    $id = mysqli_real_escape_string($conn, $book[0]);

    $sql = "DELETE FROM books where id = $id";
    echo $sql;

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // success

        header('Location: dashboard.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }


    // header('Location: dashboard.php');
}


?>

<style>
    .marginTop {
        margin-top: 40px;
    }
</style>



<div class="container marginTop mt-auto">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Book</th>
                <th scope="col">Report</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book) : ?>

                <tr>

                    <td><img src="<?php echo $book[4] ?>" alt="<?php echo $book[2] ?>" class="img-thumbnail"></td>
                    <td><?php echo $book[2] ?></br>
                        <?php echo $book[3] ?></br></td>

                    <td>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                            <?php $postvalue = $book;
                            foreach ($postvalue as $value) {
                                echo '<input type="hidden" name="result[]" value="' . $value . '">';
                            }
                            ?>
                            <button name="add_report" type="submit" class="btn btn-info">Add Report</button>
                            <button name="view_report" type="submit" class="btn btn-dark">View Report</button>
                            <button name="delete_report" type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('templates/footer.php'); ?>