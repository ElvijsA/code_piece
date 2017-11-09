<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Avatar Image Upload</title>
</head>
<body>
   <h3>Users</h3>
   <?php
      require 'db/connect.php';

      $q = 'SELECT * FROM users';
      $r = mysqli_query($dbc, $q);

      if($r){
         while( $row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
            echo '<img src="uploads/'.$row['image'].'" alt="" width="30px"/>';
            echo $row['id'].' | '.$row['name'].' | '.$row['image'];
            echo '<br>';
         }
      }
   ?>
   <br>
   <hr>
   <h3>Add User</h3>
   <form action="create.php" method="post" enctype="multipart/form-data">
      Name - <input type="text" name="name"/>
      <br>
      <br>
      <input type="file" name="fileToUpload"/>
      <br>
      <br>
      <input type="submit" value="Upload Image" name="submit">
   </form>
   <br>
   <hr>
   <h3>Edit User</h3>
   <form action="update.php" method="post" enctype="multipart/form-data">
      Id - <input type="text" name="id"/><br><br>
      <input type="file" name="fileToUpload"/>
      <br>
      <br>
      <input type="submit" value="Upload Image" name="submit">
   </form>

</body>
</html>
