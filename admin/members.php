<?php
session_start();
if (isset($_SESSION['username'])){
    $pageTitle = 'Members';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
   include 'C:\xampp\htdocs\27club\include\tpl\navbar.php';
   include 'C:\xampp\htdocs\27club\admin\conn.php';

   $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
   if($do == 'Manage') { 
       $stmt=$con->prepare("SELECT * FROM users");
       $stmt->execute();
       $rows=$stmt->fetchAll();
       ?>
        <h1 class="text-center" style="font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;">Manage Members</h1>
        <div class="container">
            <div class="table-responsive">
                <table class=" main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>groupID</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row) {
                            echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['username']."</td>";
                                echo "<td>".$row['groupID']."</td>";
                                echo  "<td>
                                <a href='members.php?do=Edit&userid=" .$row['id']. "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='members.php?do=Delete&userid=" .$row['id']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
        </div><?php
   } elseif($do=='Add'){?>
    <h1 class="text-center" style="font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;">Add New Member</h1>
    <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="Post">
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Username</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="username" class="form-control" autocomplete='off' required='required' placeholder="Username" />
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Password</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="password" name="password" class="password form-control" autocomplete="new-password" required='required' placeholder="Password" />
                        <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Member" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </div><?php
   } elseif($do=='Insert'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class='text-center' style='font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;'>Insert Member</h1>";
        echo "<div class='container'>";
        $user  = $_POST['username'];
        $pass    = $_POST['password'];
        $hashPass=sha1($_POST['password']);
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
    echo "</div>";
   } elseif($do =='Edit'){
        $userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM users WHERE id = ?  LIMIT 1") ;
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count>0){?> 
            <h1 class="text-center" style="font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;">Edit Member</h1>
            <div class="container">
                        <form class="form-horizontal" action="?do=Update" method="Post">
                            <input type="hidden" name="userid" value="<?php echo $userid?>"/>
                            <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                                <label class="col-sm-2 control-label"><b>Username</b></label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="username" class="form-control" value="<?php echo $row['username']?>" autocomplete='off' required='required' />
                                </div>
                            </div>
                            <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                                <label class="col-sm-2 control-label"><b>Password</b></label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['pass']?>" />
                                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave empty if you don't want to change it" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php

        }else{
            echo '<div class="container">';
            $theMsg='<div class="alert alert-danger">theres no such ID</div>';
            redirectHome($theMsg);
            echo "</div>";
        }
   }elseif($do == 'Update'){
        echo "<h1 class='text-center' style='font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;'>Update Member</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id    = $_POST['id'];
            $user  = $_POST['username'];
            $pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
            $formErrors = array();
            if(strlen($user)>20){$formErrors[]='user cannot be more than <b>20 caracteres</b>';}
            if(empty($user)){$formErrors[]='username cant be <b>empty</b>';}
            foreach($formErrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
            if(empty($formErrors)){
                $stmt = $con->prepare("UPDATE users SET username = ?, pass = ? WHERE id= ?");
                $stmt->execute(array($user,$pass,$id));
                $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
                redirectHome($theMsg,'back');
            }
        }else {
            $theMsg='<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
            redirectHome($theMsg);
        }
        echo "</div>";
   }elseif($do=='Delete'){
        echo "<h1 class='text-center' style='font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;'>Delete Member</h1>";
        echo "<div class='container'>";
            $userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
            $check=checkItem("id","users",$userid);
            if ($check>0){
                if($userid>1){
                $stmt=$con->prepare('DELETE FROM users WHERE id=:user');
                $stmt->bindParam(":user",$userid);
                $stmt->execute();
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
                redirectHome($theMsg,'back');
                }else {
                    $theMsg='<div class="alert alert-danger">You can\'t Delete Admin</div>';
                    redirectHome($theMsg,'back');
                }
            }else {
                $theMsg='<div class="alert alert-danger">This ID is Not Exist</div>';
                redirectHome($theMsg);
            }
        echo '</div>';
    }
   include 'C:\xampp\htdocs\27club\include\tpl\footer1.html';

}else{
    header('location:accueil.php');
    exit();
}