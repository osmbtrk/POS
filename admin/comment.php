<?php
session_start();
if (isset($_SESSION['username'])){
    $pageTitle = 'Vente';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
   include 'C:\xampp\htdocs\27club\include\tpl\navbar.php';
   include 'C:\xampp\htdocs\27club\admin\conn.php';

   $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
   if($do == 'Manage') { 
       $stmt=$con->prepare("SELECT vente.*,article.artname AS artname,users.username AS username FROM vente INNER JOIN article ON article.id =vente.artid INNER JOIN users ON users.id =vente.userid ORDER BY date DESC ");
       $stmt->execute();
       $rows=$stmt->fetchAll();
       ?>
        <h1 class="text-center" >Manage Vente</h1>
        <div class="container">
            <div class="table-responsive">
                <table class=" main-table text-center table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>article Name</td>
                        <td>Vendor Name</td>
                        <td>Quantite</td>
                        <td>Prix</td>
                        <td>Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row) {
                            echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['artname']."</td>";
                                echo "<td>".$row['username']."</td>";
                                echo "<td>".$row['quantite']."</td>";
                                echo "<td>".$row['prix']."</td>";
                                echo "<td>".$row['date']."</td>";
                                echo  "<td>
                                <a href='comment.php?do=Edit&comid=" .$row['id']. "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='comment.php?do=Delete&comid=" .$row['id']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div><?php
   } elseif($do =='Edit'){
        $comid= isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM vente WHERE id = ?") ;
        $stmt->execute(array($comid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count>0){?> 
            <h1 class="text-center" >Edit Vente</h1>
            <div class="container">
                        <form class="form-horizontal" action="?do=Update" method="Post">
                            <input type="hidden" name="comid" value="<?php echo $comid?>"/>
                            <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                                <label class="col-sm-2 control-label"><b>vente</b></label>
                                <div class="col-sm-10 col-md-4">
                                    <textarea class='form-control' name='comment'><?php echo $row['date'] ?></textarea>
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
        echo "<h1 class='text-center' '>Update Comment</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $comid    = $_POST['comid'];
            $comment  = $_POST['comment'];
            $stmt = $con->prepare("UPDATE vente SET date = ? WHERE id= ?");
            $stmt->execute(array($comment,$comid));
            $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($theMsg,'back');
        }else {
            $theMsg='<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
            redirectHome($theMsg);
        }
        echo "</div>";
   }elseif($do=='Delete'){
        echo "<h1 class='text-center' >Delete Comment</h1>";
        echo "<div class='container'>";
            $comid= isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
            $check=checkItem("id","vente",$comid);
            if ($check>0){
            $stmt=$con->prepare('DELETE FROM vente WHERE id=:com');
            $stmt->bindParam(":com",$comid);
            $stmt->execute();
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($theMsg,'back');
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