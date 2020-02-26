<?php

function upload_file(){
    if(isset($_POST['submit'])){
        $file_name = basename($_FILES["file"]["name"]);
        $file = "../data/uploads/" . $file_name;
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if($type != "csv"){
            return "File format is not csv.";
        }

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $file)){
            $_GET["file_route"] = $file;
            return "The file " . $file_name . "has been uploaded.";
        } else {
            return "Error uploading file.";
        }
    }
}
