<?php

function upload_file(){
    if(isset($_POST['submit'])){
        $file_name = basename($_FILES["file"]["name"]);
        $target_file = "../data/uploads/" . $file_name;
        $type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if($type != "csv"){
            $_GET["error"] = "File format is not csv.";
            return false;
        }

        if(file_exists($target_file)){
            $_GET["error"] = "File is already exists.";
            return false;
        }

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
            $_GET["file_route"] = $target_file;
            return true;
        }

        $_GET["error"] = "Error uploading file.";
    }

    return false;
}
