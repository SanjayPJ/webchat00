<!doctype html>
<html lang="en">

<?php 

session_start();



include 'include/db.php';
if(!empty($_POST['uname']) && !empty($_POST['pass'])){
  
  //collecting data from the post request

  $enteredUserName = $_POST['uname'];
  $enteredPassword = $_POST['pass'];

  //check passwords

  $sql = "SELECT * FROM user_details WHERE username='". $enteredUserName . "'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $password = $row['password'];
          if($password == $enteredPassword){
            $_SESSION["username"] = $enteredUserName;
            header("Location: chat.php");
          }else{
            $auth_error = "NO DATA";
          }
      }
  } else {
      $auth_error = "NO DATA";
  } 
}
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

  <title>WebChat00 - Simple Chat App</title>
</head>

<body>
  <div class="container p-5">
    <form class="border p-3" method="post" action="index.php">
      <h3 class="text-center mb-4 border py-2 text-uppercase">
        <b>Log In</b>
      </h3>
      <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input name="uname" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="pass" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div>
        <?php 
      if(!empty($auth_error)){
        echo $auth_error;
      }
      ?>
      </div>
      <button type="submit" class="btn btn-primary w-100">LOG IN</button>
    </form>
  </div>
</body>

<?php 
$conn->close();
?>

</html>