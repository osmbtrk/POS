<?php
ob_start();
session_start();
$pageTitle='Items';
if (isset($_SESSION['username'])){
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
    include 'C:\xampp\htdocs\27club\include\tpl\navbar.php';
    include 'C:\xampp\htdocs\27club\admin\conn.php';
    $do=isset($_GET['do']) ?$_GET['do'] : 'Manage';
    if($do=='Manage'){
        $stmt=$con->prepare("SELECT article.*,categories.catname AS cat_name FROM article 
            INNER JOIN categories ON categories.id=article.categoryid");
        $stmt->execute();
        $items=$stmt->fetchAll();
        ?>
         <h1 class="text-center">Manage items</h1>
         <div class="container">
             <div class="table-responsive">
                 <table class=" main-table text-center table table-bordered">
                     <tr>
                         <td>#ID</td>
                         <td>Name</td>
                         <td>Category</td>
                         <td>Quantite</td>
                         <td>Prix</td>
                         <td>Prixbase</td>
                         <td>Barcode</td>
                         <td>Control</td>
                     </tr>
                     <?php
                         foreach($items as $item) {
                             echo "<tr>";
                                 echo "<td>".$item['id']."</td>";
                                 echo "<td>".$item['artname']."</td>";
                                 echo "<td>".$item['cat_name']."</td>";
                                 echo "<td>".$item['quantite']."</td>";
                                 echo "<td>".$item['prix']."</td>";
                                 echo "<td>".$item['prixbase']."</td>";
                                 echo "<td>".$item['barcode']."</td>";
                                 echo  "<td>
                                 <a href='items.php?do=Edit&itemid=" .$item['id']. "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                 <a href='items.php?do=Delete&itemid=" .$item['id']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>
                                 <a href='../php_barcode-master/barcode.php?do=Print&itemname=" .$item['artname']. "&itemqte=" .$item['quantite']. "&itemprix=" .$item['prix']. "&itemcode=" .$item['barcode']. "' class='btn btn confirm'><i class='fa fa-print'></i> Print</a>
                                 </td>";
                             echo "</tr>";
                         }
                     ?>
                 </table>
             </div>
             <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add item</a>
         </div><?php
    }elseif($do=='Add'){?>
         <h1 class="text-center">Add New Items</h1>
         <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="Post">
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Name</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="name" class="form-control" autocomplete='off' required='required' placeholder="Name of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Quantite</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="quantite" class="form-control" autocomplete='off' placeholder="Quantite of the item" />
                    </div>
                </div>
                
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Prix</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="prix" class="form-control" autocomplete='off' required='required' placeholder="Prix of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Prixbase</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="prixbase" class="form-control" autocomplete='off' required='required' placeholder="Prixbase of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Couleur</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="couleur" class="form-control" autocomplete='off' required='required' placeholder="Couleur of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>RAM</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="ram" class="form-control" autocomplete='off' required='required' placeholder="RAM of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Stockage</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="stockage" class="form-control" autocomplete='off' required='required' placeholder="Stockage of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>batterie</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="batterie" class="form-control" autocomplete='off' required='required' placeholder="batterie of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Barcode</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="barcode" class="form-control" autocomplete='off' required='required' placeholder="Barcode of the item" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Category</b></label>
                    <div class="col-sm-10 col-md-4">
                        <select class="sel" name="category">
                            <option value="0">...</option>
                            <?php
                                $stmt=$con->prepare("SELECT * FROM categories");
                                $stmt->execute();
                                $cats=$stmt->fetchAll();
                                foreach($cats as $cat){
                                    echo "<option value='".$cat['id']."'>".$cat['catname']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>faceid</b></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="vis-yes" type="radio" name="faceid" value="0" checked />
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="faceid" value="1" />
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>emprint</b></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="com-yes" type="radio" name="emprint" value="0" checked />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="emprint" value="1" />
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Double sim</b></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="ads-yes" type="radio" name="doublesim" value="0" checked />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="doublesim" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add item" class="btn btn-primary" />
                    </div>
                </div>
            </form>
         </div>
    <?php
    }elseif($do=='Insert'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Insert Item</h1>";
            echo "<div class='container'>";
            $name  = $_POST['name'];
            $quantite    = $_POST['quantite'];
            $barcode    = $_POST['barcode'];
            $prix = $_POST['prix'];
            $prixbase  = $_POST['prixbase'];
            $couleur = $_POST['couleur'];
            $ram  = $_POST['ram'];
            $stockage = $_POST['stockage'];
            $batterie  = $_POST['batterie'];
            $cate  = $_POST['category'];
            $faceid = $_POST['faceid'];
            $emprint  = $_POST['emprint'];
            $doublesim  = $_POST['doublesim'];
            $reference  = $_POST['category'].$_POST['name'].$_POST['ram'].$_POST['stockage'];
            $formErrors = array();
            if(empty($name)){$formErrors[]='name can\'t be <b>empty</b>';}
            if(empty($quantite)){$formErrors[]='quantite can\'t be <b>empty</b>';}
            if(empty($prix)){$formErrors[]='prix name can\'t be <b>empty</b>';}
            if(empty($prixbase)){$formErrors[]='prixbase can\'t be <b>empty</b>';}
            if($cate==0){$formErrors[]='category cant be <b>empty</b>';}
            foreach($formErrors as $error){$theMsg= '<div class="alert alert-danger">'.$error.'</div>';
                redirectHome($theMsg,'back');}
            if(empty($formErrors)){
                //check if user exist in data base
                $check=checkItem("artname","article",$name);
                if($check==1){
                    $theMsg='<div class="alert alert-danger">sorry this name is exist</div>';
                    redirectHome($theMsg,'back');
                }else{
                    //insert
                    $stmt= $con->prepare("INSERT INTO article(artname,quantite,barcode,prix,prixbase,categoryid,couleur,ram,stockage,batterie,faceid,emprint,doublesim,reference) VALUES(:name,:quantite,:barcode,:prix,:prixbase,:cat,:couleur,:ram,:stockage,:batterie,:faceid,:emprint,:doublesim,:reference)");
                    $stmt->execute(array(
                        'name' => $name,
                        'quantite' => $quantite,
                        'barcode' => $barcode,
                        'prix'=> $prix,
                        'prixbase' => $prixbase,
                        'cat' => $cate,
                        'couleur' => $couleur,
                        'ram' => $ram,
                        'stockage'=> $stockage,
                        'batterie' => $batterie,
                        'faceid' => $faceid,
                        'emprint' => $emprint,
                        'doublesim' => $doublesim,
                        'reference' => $reference
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
    }elseif($do=='Edit'){
        $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM article WHERE id = ? ") ;
        $stmt->execute(array($itemid));
        $item = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count>0){?>
         <h1 class="text-center">Edit Items</h1>
         <div class="container">
            <form class="form-horizontal" action="?do=Update" method="Post">
                <input type="hidden" name="itemid" value="<?php echo $itemid?>"/>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Name</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="name" class="form-control" autocomplete='off' required='required' placeholder="Name of the item" value="<?php echo $item['artname'] ?>" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>barcode</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="barcode" class="form-control" autocomplete='off' required='required' placeholder="Name of the item" value="<?php echo $item['barcode'] ?>" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Quantite</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="quantite" class="form-control" autocomplete='off' placeholder="Quantite of the item" value="<?php echo $item['quantite'] ?>" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Prix</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="prix" class="form-control" autocomplete='off' required='required' placeholder="Prix of the item" value="<?php echo $item['prix'] ?>" />
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Prixbase</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="prixbase" class="form-control" autocomplete='off' required='required' placeholder="Prixbase of the item" value="<?php echo $item['prixbase'] ?>" />
                    </div>
                </div>
                
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>couleur</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="couleur" class="form-control" placeholder="couleur of the category" value="<?php echo $item['couleur'] ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>ram</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="ram" class="form-control" placeholder="Describe the ram" value="<?php echo $item['ram'] ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>stockage</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="stockage" class="form-control" placeholder="stockage the categories" value="<?php echo $item['stockage'] ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>batterie</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="batterie" class="form-control" placeholder="batterie the categories" value="<?php echo $item['batterie'] ?>"/>
                    </div>
                </div>
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Category</b></label>
                    <div class="col-sm-10 col-md-4">
                        <select class="sel" name="category">
                            <?php
                                $stmt=$con->prepare("SELECT * FROM categories");
                                $stmt->execute();
                                $cats=$stmt->fetchAll();
                                foreach($cats as $cat){
                                    echo "<option value='".$cat['id']."'"; if($item['categoryid']==$cat['id']){ echo "selected";} echo ">".$cat['catname']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>faceid</b></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="vis-yes" type="radio" name="faceid" value="0" <?php if($item['faceid']==0){echo 'checked';} ?>/>
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="faceid" value="1" <?php if($item['faceid']==1){echo 'checked';} ?>/>
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>emprint</b></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="com-yes" type="radio" name="emprint" value="0" <?php if($item['emprint']==0){echo 'checked';} ?> />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="emprint" value="1" <?php if($item['emprint']==1){echo 'checked';} ?>/>
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>doublesim</b></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="ads-yes" type="radio" name="doublesim" value="0" <?php if($item['doublesim']==0){echo 'checked';} ?> />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="doublesim" value="1" <?php if($item['doublesim']==1){echo 'checked';} ?>/>
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save item" class="btn btn-primary" />
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
    }elseif($do=='Update'){
        echo "<h1 class='text-center'>Update Item</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id    = $_POST['itemid'];
            $name  = $_POST['name'];
            $barcode  = $_POST['barcode'];
            $quantite = $_POST['quantite'];
            $prix  = $_POST['prix'];
            $prixbase  = $_POST['prixbase'];
            $couleur = $_POST['couleur'];
            $ram  = $_POST['ram'];
            $stockage = $_POST['stockage'];
            $batterie  = $_POST['batterie'];
            $faceid = $_POST['faceid'];
            $emprint  = $_POST['emprint'];
            $doublesim  = $_POST['doublesim'];
            $cat  = $_POST['category'];
            $formErrors = array();
            if(empty($name)){$formErrors[]='name cant be <b>empty</b>';}
            if(empty($quantite)){$formErrors[]='quantite cant be <b>empty</b>';}
            if(empty($prix)){$formErrors[]='prix cant be <b>empty</b>';}
            if($cat==0){$formErrors[]='category cant be <b>empty</b>';}
            foreach($formErrors as $error){echo '<div class="alert alert-danger">'.$error.'</div>';}
            if(empty($formErrors)){
                $stmt = $con->prepare("UPDATE article SET artname = ?,barcode = ?, quantite = ?, prix = ?, prixbase = ?,categoryid= ?, couleur = ?, ram = ?, stockage = ?,batterie= ?, faceid = ?, emprint = ?, doublesim = ? WHERE id=? ");
                $stmt->execute(array($name,$barcode,$quantite,$prix,$prixbase,$cat,$couleur,$ram,$stockage,$batterie,$faceid,$emprint,$doublesim,$id));
                $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
                redirectHome($theMsg,'back');
            }
        }else {
            $theMsg='<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
            redirectHome($theMsg);
        }
        echo "</div>";
    }elseif($do=='Delete'){
        echo "<h1 class='text-center'>Delete Item</h1>";
        echo "<div class='container'>";
            $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
            $check=checkItem("id","article",$itemid);
            if ($check>0){
                $stmt=$con->prepare('DELETE FROM article WHERE id=:id');
                $stmt->bindParam(":id",$itemid);
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
ob_end_flush();
?>