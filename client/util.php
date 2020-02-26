<?php

function upload_file(){
    if(isset($_POST['submit'])){
        $file_name = basename($_FILES["file"]["name"]);
        $file = "../data/uploads/" . $file_name;
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if($type != "csv"){
            $_GET["error"] = "File format is not csv.";
            return false;
        }

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $file)){
            $_GET["file_route"] = $file;
            return true;
        }

        $_GET["error"] = "Error uploading file.";
        return false;
    }
}
