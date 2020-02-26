<?php

require_once './parser.php';
require_once './util.php';

if(($success = upload_file()) == true){
    $file_route = $_GET["file_route"];
    $customers = customers_to_array($file_route);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Calls</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <h1>Upload file</h1>
                <form action="form.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Select a file</label>
                        <input class="form-control" type="file" name="file" id="file">
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
                <br>
                <?php
                if(isset($_GET["file_route"])){
                    $file_name = basename($_FILES["file"]["name"]);

                    echo "<div class='alert alert-info' role='alert'>File $file_name uploaded.</div>";
                } else if(isset($_GET["error"])){
                    $error = $_GET["error"];

                    echo "<div class='alert alert-danger' role='alert'>$error</div>";
                }
                ?>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col"># Id</th>
                <th scope="col"># Calls from Continent</th>
                <th scope="col">Duration of calls from continent</th>
                <th scope="col"># Calls</th>
                <th scope="col">Duration of calls</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if(isset($customers)) {
                    foreach ($customers as $idx => $customer) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $idx ?></th>
                            <td><?php echo $customer['calls_in_continent'] ?></td>
                            <td><?php echo $customer['duration_in_continent'] ?></td>
                            <td><?php echo $customer['calls'] ?></td>
                            <td><?php echo $customer['duration'] ?></td>
                        </tr>
                        <?php
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>