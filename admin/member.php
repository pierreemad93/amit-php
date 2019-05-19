<?php
session_start();
/*check the do get and put it at url*/
$do='';
if(isset($_GET['do'])){
    $do=  $_GET['do'];
}else{
    $do= "manage";
}
/*end check*/
include "includes/header.inc";
include "includes/connect.inc";
include "includes/nav.inc";
if($do == 'manage'){
//Start Manage Page
//    echo "Hello From Manage page";
    $stmt=$con->prepare('SELECT * FROM users WHERE groupid !=1 ');
    $stmt->execute();
    $rows=$stmt->fetchAll();
?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">username</th>
            <th scope="col">email</th>
            <th scope="col">Full name</th>
            <th scope="col">Permission</th>
            <th scope="col">Date</th>
            <th scope="col">Buttons</th>
        </tr>
        </thead>
        <tbody>
       <?php
           foreach ($rows as $row){
               echo "<tr>";
               echo  "<td>".$row['username']."</td>";
               echo  "<td>".$row['email']."</td>";
               echo  "<td>".$row['fullname']."</td>";
                   if ($row['groupid']== 1){
                       echo "<td>Admin</td>";
                   }elseif ($row['groupid']== 2){
                       echo "<td>Moderator</td>";
                   }else{
                       echo "<td>User</td>";
                   }
               echo  "<td>".$row['Date']."</td>";
               echo  "<td>
                          <a class='btn btn-warning' href='member.php?do=edit&userid=".$row['id']."'>Update</a>
                          <a class='btn btn-danger' href='member.php?do=delete&userid=".$row['id']."'>Delete</a>
                      </td>";
               echo "</tr>";
           }
       ?>
        </tbody>
    </table>
    <a class="btn btn-primary" href="?do=add">Add member</a>
<?php
}elseif ($do == 'add'){
    //Start Add page
    //echo "Hello From add page";
?>
    <div class="add-member">
        <div class="container">
            <h2 class="text-center">Add Member</h2>
            <form action="?do=insert" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username" name="username">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    <button class="btn btn-dark">generate password</button>
                </div>
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" aria-describedby="emailHelp" placeholder="Enter fullname" name="fullname">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="member.php" class="btn btn-dark">Back</a>
            </form>
        </div>
    </div>
<?php
}elseif($do == 'insert'){
    //Start insert Page
    //echo "Hello From insert page";
    $username = $_POST['username'];
    $email    =  $_POST['email'];
    $password =  $_POST['password'];
    $hashedPass=sha1($password);
    $fullname =  $_POST['fullname'];

    $stmt=$con->prepare('INSERT INTO users (username ,email , password,fullname ,groupid , Date)VALUES(?,? ,? ,?,0 ,now())');
    $stmt->execute(array($username,$email,$hashedPass,$fullname));
    $count=$stmt->rowCount();
    header('location:member.php?do=add');

}elseif ($do == 'edit'){
 //   Start Edit data
//    echo "Hello From Edit page";
//    $userid=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
    if(isset($_GET['userid'])&&is_numeric($_GET['userid'])){
       $userid=intval($_GET['userid']);
    }
    $stmt=$con->prepare('SELECT * FROM users WHERE id=?');
    $stmt->execute(array($userid));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();
    if ($count >= 1){
?>
        <div class="add-member">
        <div class="container">
            <h2 class="text-center">Edit Member</h2>
            <form action="?do=insert" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username" name="username" value="<?php echo $row['username']?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="<?php echo $row['email']?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" aria-describedby="emailHelp" placeholder="Enter fullname" name="fullname" value="<?php echo $row['fullname']?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="member.php" class="btn btn-dark">Back</a>
            </form>
        </div>
    </div>
<?php
    }else{
        echo  "Sorry this id does not exist";
    }
}elseif ($do == 'update'){
//

}elseif ($do == 'delete'){
    if(isset($_GET['userid'])&& is_numeric($_GET['userid'])){
        $userid=intval($_GET['userid']);
    }
    $stmt=$con->prepare('DELETE FROM users WHERE id=:Zid LIMIT 1');
    $stmt->bindParam(':Zid',$userid);
    $stmt->execute();
    header('location:member.php');

}else{
    echo "Page Not Found 404 ";
}
include "includes/footer.inc";

