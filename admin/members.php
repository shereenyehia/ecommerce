<?php
  session_start();
   //$do = "" ;
   if(isset($_GET['do'])){
       $do = $_GET['do'];
   }else{
      $do = "manage" ;
   }
   ?>
<?php if(isset($_SESSION['USER_NAME'])):?>
<?php include "resources/includes/header.inc"?>
<?php require "config.php"?>
<?php include "resources/includes/navbar.inc"?>
<!-- Start Members CRUD page-->
<?php if($do == "manage"): ?>
<!-- Start all members page -->
<?php
    // Select All From DB
    $stmt= $con->prepare("SELECT * FROM users  WHERE groupid=0");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    //echo "<pre>";
    //print_r($rows);
    //echo "</pre>";
?>
<div class="container">
    <h1 class="text-center">All Members</h1>
    <!-- add member button-->
    <a class="btn btn-primary" href="?do=add">
        <i class="fas fa-user-plus"></i> Add Member
    </a>
    <!--/member button-->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Created at</th>
                <th scope="col">Control</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $row):?>
            <tr>
                <!-- php echo => =  -->
                <th scope="row"><?= $row["username"]?></th>
                <td><?= $row["email"]?></td>
                <td><?= $row['created_at']?></td>
                <td>
                    <a class="btn btn-secondary" href="?do=show&userid=<?= $row["user_id"]?>" title="show">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-warning" href="?do=edit&userid=<?= $row["user_id"]?>" title="edit"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" href="" title="Delete"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
<!--/all members page -->
<?php elseif($do == "add"):?>
<div class="container">
    <h1 class="text-center">Add Member</h1>
    <form method="post" action="?do=insert">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="mb-3">
            <label class="form-label">Fullname</label>
            <input type="text" class="form-control" name="fullname">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php elseif($do == "insert"):?>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
       $username   = $_POST['username'] ;
        $email     = $_POST['email'] ;
        $password  = sha1($_POST['password']);
        $fullname  = $_POST['fullname'];

        $stmt= $con->prepare("INSERT INTO users (username,`password`,email,fullname,groupid,created_at) VALUES (? , ? , ? , ? ,  0 , now())");
        $stmt->execute(array($username , $password , $email,$fullname));
        header('location:members.php?do=add');
    }else{
         header("location:members.php");
    }
?>
<?php elseif($do == "edit"):?>
  <?php
    /*if(isset($_GET['userid'])&&is_numeric($_GET['userid'])){
      $userid = intval($_GET['userid']);
    }else{
      0
    }*/
    //$userid = condition?true:false ;

    $userid = isset($_GET['userid'])&&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
    $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute(array($userid));
    $row =$stmt->fetch();
    $count =$stmt->rowCount();
    // echo "<pre>" ;
    // print_r($rows);
    // echo "</pre>" ;
    ?>

    <?php if($count == 1):?>
  <div class="container">
    <h1 class="text-center">Edit Member</h1>
    <form method="post" action="?do=update">
      <div class="mb-3">
        <input type="hidden" class="form-control" value="<?= $row['user_id']?>" name="userid">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input type="text" class="form-control" value="<?= $row['username']?>" name="username">
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="newpassword">
        <input type="hidden" class="form-control" id="exampleInputPassword1" value="<?= $row['password']?>" name="oldpassword">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="text" class="form-control" value="<?= $row['email']?>" name="email">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Fullname</label>
        <input type="text" class="form-control" value="<?= $row['fullname']?>" name="fullname">
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
  <?php endif?>
<?php elseif($do == "update"):?>
<?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $password = empty($_POST['newpassword'])?$_POST['oldpassword']:$_POST['newpassword'];
    $hashedPass = sha1($password);
    $stmt = $con->prepare("UPDATE users SET username=? , password=? , email=? fullname=? WHERE user_id=?");
    $stmt->execute(array($username , $hashedPass , $email , $fullname , $userid));

    header("location:members.php");
  }
  ?>
<?php elseif($do == "delete"):?>

<?php elseif($do == "show"): ?>
<?php
        $userid =  $_GET["userid"] ;
        $stmt= $con->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();

        echo "<pre>";
        print_r($row);
        echo "</pre>";

     ?>
<a href="members.php" class="btn btn-dark">Back</a>
<?php endif?>

<?php include "resources/includes/footer.inc"?>
<!-- End Members CRUD page-->
<?php else:?>
<?php header("location:index.php")?>
<?php endif?>
