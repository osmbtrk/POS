<?php
ob_start();
session_start();
$pageTitle='settings';
if (isset($_SESSION['user'])){
    include 'C:\xampp\htdocs\27club\admin\conn.php';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
    include 'C:\xampp\htdocs\27club\include\tpl\sidebar-09\sidebar.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Edit';
    if($do =='Edit'){
        $userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM users WHERE id = ?  LIMIT 1") ;
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count>0){?>
                    <div id="content" class="p-4 p-md-5 pt-5">
                        <h1 class="text-center" style="font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;">Edit Member</h1></br>
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
                    </div>
                </div>
                <script src="include/tpl/sidebar-09/js/jquery.min.js"></script>
                <script src="include/tpl/sidebar-09/js/popper.js"></script>
                <script src="include/tpl/sidebar-09/js/bootstrap.min.js"></script>
                <script src="include/tpl/sidebar-09/js/main.js"></script>
                <script src='admin/js\popup.js'></script>
                <?php

        }else{
            echo '<div class="container">';
            $theMsg='<div class="alert alert-danger">theres no such ID</div>';
            redirectHome($theMsg,"back");
            echo "</div>";
        }
    }elseif($do == 'Update'){
        echo "<h1 class='text-center' style='font-size: 55px;margin: 40px 0;font-weight: bold;color:#666;'>Update Member</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id    = $_POST['userid'];
            $user  = $_POST['username'];
            $pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
            $formErrors = array();
            if(strlen($user)>20){$formErrors[]='user cannot be more than <b>20 caracteres</b>';}
            if(empty($user)){$formErrors[]='username cant be <b>empty</b>';}
            if(empty($name)){$formErrors[]='full name cant be <b>empty</b>';}
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
    }
}else{
    header('location:admin/accueil.php');
    exit();
}
ob_end_flush();
?>