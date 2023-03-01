<?php
session_start();
if (isset($_SESSION['username'])){
   header('location: admin/dashboard.php'); //redirect to dashboard
}
if (isset($_SESSION['user'])){
   header('location: home.php');}
include 'C:\xampp\htdocs\27club\admin\conn.php';
// check if user coming from HTTP post request
include 'C:\xampp\htdocs\27club\include\functions\functions.php';
$do = isset($_GET['do']);
if($do=='Insert'){
   if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      echo "<h1 class='text-center' style='font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;'>Insert Member</h1>";
      echo "<div class='container'>";
      $user  = $_POST['user'];
      $pass    = $_POST['pass'];
      $hashPass=sha1($_POST['pass']);
      $formErrors = array();
      if(strlen($user)>20){$formErrors[]='user cannot be more than <b>20 caracteres</b>';}
      if(empty($user)){$formErrors[]='username cant be <b>empty</b>';}
      if(empty($pass)){$formErrors[]='password cant be <b>empty</b>';}
      foreach($formErrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
      if(empty($formErrors)){
         //check if user exist in data base
         $check=checkItem("username","users",$user);
         if($check==1){
            $theMsg='<div class="alert alert-danger">sorry this user is exist</div>';
            redirectHome($theMsg,'back');
         }else{
            //insert
            $stmt= $con->prepare("INSERT INTO users(username,pass) VALUES(:user,:pass)");
            $stmt->execute(array(
                  'user' => $user,
                  'pass' => $hashPass
            ));
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Insert</div>';
            redirectHome($theMsg,'back');
         }
      }
   }else {
         echo '<div class="container">';
         $theMsg='<div class="alert alert-danger">Sorry you cant Browse this page Directly</div>';
         redirectHome($theMsg);
         echo "</div>";
   }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   $username= $_POST['user'];
   $password= $_POST['pass'];
   $hashedPass= sha1($password);
   // check if user exist in database
   $stmt = $con->prepare("SELECT id, username, pass FROM users WHERE username = ? AND pass = ? AND groupID = 1 LIMIT 1") ;
   $stmt->execute(array($username,$hashedPass));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
   // if count >0 this mean database contain record about this username
   if ($count>0){
       $_SESSION['username'] = $username; //register session name
       $_SESSION['ID'] = $row['id']; //register session ID
       header('location: admin/dashboard.php'); //redirect to dashboard
       exit();

    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $username= $_POST['user'];
   $password= $_POST['pass'];
   $hashedPass= sha1($password);
   // check if user exist in database
   $stmt = $con->prepare("SELECT id, username, pass FROM users WHERE username = ? AND pass = ?") ;
   $stmt->execute(array($username,$hashedPass));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
   // if count >0 this mean database contain record about this username
   if ($count>0){
       $_SESSION['user'] = $username; //register session name
       $_SESSION['ID'] = $row['id']; //register session ID
       header('location:home.php'); //redirect to accuiel
       exit();

    }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta charset="utf-8">
      <title><?php getTitle() ?></title>
      <link rel="stylesheet" href="admin\css\bootstrap.min.css">
      <link rel="stylesheet" href="admin\css\fontawesome.min.css">
      <link rel="stylesheet" href="admin\css\log.css">
   </head>
   <body>
      <div class="main">
         <p class="sign" align="center">Sign in</p>
         <form class="form1" action="<?php echo $_SERVER['PHP_SELF'] ?> " method="POST">
               <input class="un " type="text" align="center" placeholder="Username" name="user">
               <input class="pass" type="password" align="center" placeholder="Password" name="pass">
               <button type="submit" class="submit" value="Login">Login</button>
               <p class="forgot" align="center"><a href="#">Forgot Password?</p>
         </form>
      </div>


<script src='admin\js\jquery-3.5.1.min.js'></script>
<script src='admin\js\bootstrap.min.js'></script>
</body>
</html>