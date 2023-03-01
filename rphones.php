<?php
ob_start();
session_start();
$pageTitle='Phones';
if (isset($_SESSION['user'])){
    include 'C:\xampp\htdocs\27club\admin\conn.php';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
    include 'C:\xampp\htdocs\27club\include\tpl\sidebar-09\sidebar.php';
    $do=isset($_GET['do']) ?$_GET['do'] : 'Manage';
    if($do=='Manage'){
        
        ?>
        <div id="content" class="p-2 p-md-5 pt-5">
            <form class="form-inline " action="?do=search" method="Post">
                <input class="form-control form-control-sm mr-1 w-60" name='sea' type="text" placeholder="Recherchez des articles By Barcode"
                aria-label="Search">
                <div class="col-sm-offset-2 col-sm-4">
                    <input type="submit" value="Search" class="btn btn-primary" />
                </div>
            </form>
            </br></br></br>
            <div class='main'>
                <div class="container">
                    <form action="?do=search1" method="POST">
                        <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                            <label class="col-sm-4 control-label"><b>Search By Category</b></label>
                            <div class="col-sm-10 col-md-4">
                                <select class="category" id="category" name="category">
                                    <option value="0">...</option>
                                    <?php
                                        $stmt=$con->prepare("SELECT * FROM categories WHERE parentID=5");
                                        $stmt->execute();
                                        $cats=$stmt->fetchAll();
                                        foreach($cats as $cat){
                                            echo "<option value='".$cat['id']."'>".$cat['catname']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                            <label class="col-sm-4 control-label"><b>Article</b></label>
                            <div class="col-sm-10 col-md-4">
                                <select class="article" id="article" name="article">
                                    <option value="0">...</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div><?php
    }elseif($do=='search'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<div class='container'>";
            echo "<h1 class='text-center'>phones in stock</h1>";
            $search  = $_POST['sea'];
            $check=checkItem("barcode",'phones',$search);
            if($check==0){
                $theMsg='<div class="alert alert-danger">sorry this title is not exist</div>';
                redirectHome($theMsg,'back');
            }else{
                    //insert
                    $getItems=$con->prepare("SELECT * FROM phones WHERE barcode=?");
                    $getItems->execute(array($search));
                    $items =$getItems->fetchAll();?>
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class=" main-table text-center table table-bordered">
                                            <tr>
                                                <td>#ID</td>
                                                <td>Name</td>
                                                <td>Category</td>
                                                <td>Quantite en stock</td>
                                                <td>Couleur</td>
                                                <td>Prix</td>
                                                <td>Remise</td>
                                                <td>Qte</td>
                                                <td>Control</td>
                                            </tr>
                                            <?php
                                                foreach($items as $item) {
                                                    echo "<tr>";
                                                        echo "<td>".$item['id']."</td>";
                                                        echo "<td>".$item['artname']."</td>";
                                                        echo "<td>".$item['categoryid']."</td>";
                                                        echo "<td>".$item['quantite']."</td>";
                                                        echo "<td>".$item['couleur']."</td>";
                                                        echo "<td>".$item['prix']."</td>";
                                                        echo "<form class='form-inline ' action='?do=sell&itemid=" .$item['id']. "' method='Post'>";
                                                            echo '<td><input type="text" name="remise" class="form-control" autocomplete="off" placeholder="Remise" /></td>';
                                                            echo '<td><input type="text" name="quantite" class="form-control" autocomplete="off" placeholder="Qte" /></td>';
                                                            echo  "<td><input style='border: 1px solid transparent;
                                                            padding: 0.375rem 0.75rem;
                                                            font-size: 1rem;
                                                            line-height: 1.5;
                                                            border-radius: 0.25rem;' type='submit' value='Sell' class='btn-success' /></td></form>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                        <?php
                        
            }
            
        }else {
            echo '<div class="container">';
            $theMsg='<div class="alert alert-danger">Sorry you cant Browse this page Directly</div>';
            redirectHome($theMsg,'back');
            echo "</div>";
        }
        echo "</div>";
    }elseif($do=='search1'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<div class='container'>";
            echo "<h1 class='text-center'>article in stock</h1>";
            $search1  = $_POST['category'];
            $search2  = $_POST['article'];
            $check=checkItem("barcode",'phones',$search2);
            if($check==1){
                $theMsg='<div class="alert alert-danger">sorry this title is not exist</div>';
                redirectHome($theMsg,'back');
            }else{
                    //insert
                    $getItems=$con->prepare("SELECT * FROM phones WHERE categoryid=? AND id=?");
                    $getItems->execute(array($search1,$search2));
                    $items =$getItems->fetchAll();?>
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class=" main-table text-center table table-bordered">
                                            <tr>
                                                <td>#ID</td>
                                                <td>Name</td>
                                                <td>Category</td>
                                                <td>Quantite en stock</td>
                                                <td>Couleur</td>
                                                <td>Prix</td>
                                                <td>Remise</td>
                                                <td>Qte</td>
                                                <td>Control</td>
                                            </tr>
                                            <?php
                                                foreach($items as $item) {
                                                    echo "<tr>";
                                                        echo "<td>".$item['id']."</td>";
                                                        echo "<td>".$item['artname']."</td>";
                                                        echo "<td>".$item['categoryid']."</td>";
                                                        echo "<td>".$item['quantite']."</td>";
                                                        echo "<td>".$item['couleur']."</td>";
                                                        echo "<td>".$item['prix']."</td>";
                                                        echo "<form class='form-inline ' action='?do=sell&itemid=" .$item['id']. "' method='Post'>";
                                                            echo '<td><input type="text" name="remise" class="form-control" autocomplete="off" placeholder="Remise" /></td>';
                                                            echo '<td><input type="text" name="quantite" class="form-control" autocomplete="off" placeholder="Qte" /></td>';
                                                            echo  "<td><input style='border: 1px solid transparent;
                                                            padding: 0.375rem 0.75rem;
                                                            font-size: 1rem;
                                                            line-height: 1.5;
                                                            border-radius: 0.25rem;' type='submit' value='Sell' class='btn-success' /></td></form>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                        <?php
                        
            }
            
        }else {
            echo '<div class="container">';
            $theMsg='<div class="alert alert-danger">Sorry you cant Browse this page Directly</div>';
            redirectHome($theMsg,'back');
            echo "</div>";
        }
        echo "</div>";
    }elseif($do=='sell'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $remise  = intval($_POST['remise']);
            $quantite    = intval($_POST['quantite']);
            $userid    = intval($_SESSION['ID']);
            $artid    = intval($_GET['itemid']);
            $stmt=$con->prepare("SELECT * FROM phones WHERE id=$artid");
            $stmt->execute();
            $cats=$stmt->fetchAll();
            foreach($cats as $cat){
                $check=$cat['prix']-$remise;
                $check0=$cat['prix']*$quantite-$remise;

                $check1=$cat['prixbase'];
                $check2=$cat['quantite'];
                $check3=$check2-$quantite;
            }
            if($check<$check1){
                    $theMsg='<div class="alert alert-danger">sorry your make big discount</div>';
                    $seconds=3;
                    echo $theMsg;
                    echo "<div class='alert alert-info'>You Will Be Redirected To home After $seconds Seconds.</div>";
                    header("refresh:$seconds;url=rphones.php");
            }elseif($check2<$quantite){
                    $theMsg='<div class="alert alert-danger">sorry we dont have this quantite</div>';
                    $seconds=3;
                    echo $theMsg;
                    echo "<div class='alert alert-info'>You Will Be Redirected To home After $seconds Seconds.</div>";
                    header("refresh:$seconds;url=rphones.php");
            }else{
                    //insert
                    $stmt= $con->prepare("INSERT INTO `vente` (`id`, `artid`, `userid`, `quantite`, `prix`) VALUES (NULL, $artid, $userid, $quantite, $check0)");
                    $stmt->execute();
                    $stm = $con->prepare("UPDATE phones SET quantite= ? WHERE id= ?");
                    $stm->execute(array($check3,$artid));
                    $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Insert</div>';
                    $seconds=3;
                    echo $theMsg;
                    echo "<div class='alert alert-info'>You Will Be Redirected To home After $seconds Seconds.</div>";
                    header("refresh:$seconds;url=rphones.php");
            }
            
        }else {
            echo '<div class="container">';
            $theMsg='<div class="alert alert-danger">Sorry you cant Browse this page Directly</div>';
            redirectHome($theMsg,'back');
            echo "</div>";
        }
        echo "</div>";
    }
    ?>
            
    </div>
    <script src="include/tpl/sidebar-09/js/jquery.min.js"></script>
    <script src="include/tpl/sidebar-09/js/popper.js"></script>
    <script src="include/tpl/sidebar-09/js/bootstrap.min.js"></script>
    <script src="include/tpl/sidebar-09/js/main.js"></script>
    <script src='admin/js\popup.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('.category').change(function(){
          var articleid = $(this).val();
          $.ajax({
            url:'rphones1.php',
            method:'POST',
            data:{articleid:articleid},
            success:function(data){
              $('.article').html(data);
            }
          });
        });
      });
    </script>
    
    <?php
}else{
    header('location:admin/accueil.php');
    exit();
}
ob_end_flush();
?>