<?php


// HANDLE FILE
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $id = $_POST['id'];
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
   //DELETE OLD IMAGE FILE

   //Get Current Image name from DB
      require 'db/connect.php';
      $q = 'SELECT * FROM users WHERE id ='.$id;
      $r = mysqli_query($dbc, $q);

      if($r){
         while( $row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
            $filename = 'uploads/'.$row['image'];

            if (file_exists($filename)) {
                unlink($filename);
                echo 'File '.$filename.' has been deleted';
              } else {
                echo 'Could not delete '.$filename.', file does not exist';
              }
            }
         }
      }
   //Delete file

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

// HANDLE FILE END
?>
<br>
<?php
// HANDLE DATABASE VARIABLES

$image = $_FILES['fileToUpload']['name'];

require "db/connect.php";
//Insert Variables into database

$q = "UPDATE users
      SET image = '$image'
      WHERE id = '$id'";
$r = mysqli_query($dbc, $q);

//Check if errors
if($r){
   header( 'Location: index.php' ) ;
} else{
   echo "ERROR";
}
?>
