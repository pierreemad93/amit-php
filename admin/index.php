<?php session_start();
      include  "includes/connect.inc"?>
<?php
      include "includes/header.inc";
      if ($_SERVER['REQUEST_METHOD'] =='POST'){
               $username  = $_POST['ad-username'];
               $password  = $_POST['ad-password'];
               $hashedPass=sha1($password);
               $stmt=$con->prepare('SELECT * FROM users WHERE username=? AND password=? AND groupid=1 LIMIT 1');
               $stmt->execute(array($username , $hashedPass));
               $row=$stmt->fetch();
               $count=$stmt->rowCount();
               if($count>=1 ){
                   $_SESSION['username']=$username;
                   $_SESSION['fullname']=$row['fullname'];
                   $_SESSION['id']=$row['id'];
                   header('location:dashboard.php');
               }else{
                   echo  "<div class='alert alert-danger'>Sorry you aren't admin</div>";
               }
      }
?>
<div class="login-form">
    <div class="container">
        <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
            <div class="form-group">
                <label for="exampleInputEmail1">username</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" name="ad-username">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="ad-password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">login</button>
        </form>
    </div>
</div>

<?php include  "includes/footer.inc"?>