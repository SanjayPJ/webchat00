<?php 

  session_start();

  if(empty($_SESSION['username'])){
        header("Location: index.php");
  }else{
    $sess_user = $_SESSION['username'];
  }
  include 'include/db.php';

  if(!empty($_POST["message"])){
    $mess = $_POST["message"];

    $sql = "INSERT INTO message (author, message)
    VALUES ('$sess_user', '$mess')";

    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

  <title>WebChat - Simple chat app</title>
</head>

<body>
  <div class="container py-5">

    <h1 class="border p-1">
      <?php echo $_SESSION['username'] . "(active)";?>
    </h1>
    <div class="chat-container border p-2">

    <?php 
    $sql = "SELECT author, message FROM message";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $authordb = $row["author"];
          $messagedb = $row["message"];
          if($row['author'] != $sess_user){
            echo '<div class="alert alert-danger p-2 m-2 mr-5" role="alert">
            '.'<a href="#">@'.$authordb.' </a>'.$messagedb.'
          </div>';
          }else{
            echo '<div class="alert alert-success p-2 m-2 ml-5" role="alert">
            '.'<a href="#">@me </a>'.$messagedb.'
          </div>';
          }
        }
    } else {
        echo "0 results";
    }
    ?>
    </div>
    <form action="chat.php" method="post">
      <div class="row no-gutters mt-2 border p-2">
        <div class="col-9">
          <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-primary w-100 h-100">SEND MESSAGE</button>
        </div>
      </div>
    </form>
  </div>

</body>
<?php 
$conn->close();
?>
</html>