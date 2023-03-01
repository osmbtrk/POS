<?php
ob_start();
session_start();
$pageTitle='Categories';
if (isset($_SESSION['username'])){
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
    include 'C:\xampp\htdocs\27club\include\tpl\navbar.php';
    include 'C:\xampp\htdocs\27club\admin\conn.php';
    $do=isset($_GET['do']) ?$_GET['do'] : 'Manage';
    if($do=='Manage'){
        $sort='ASC';
        $sort_array=array('ASC','DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            $sort=$_GET['sort'];
        }
        $stmt2=$con->prepare("SELECT * FROM categories ORDER BY parentID $sort");
        $stmt2->execute();
        $cats=$stmt2->fetchAll(); ?>
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading"><i class='fa fa-edit'></i> Manage Categories
                    <div class="option pull-right">
                        <i class='fa fa-sort'></i> Ordering:[
                        <a class="<?php if($sort== 'ASC'){echo 'active';} ?>" href="?sort=ASC">Asc</a>
                        <a class="<?php if($sort== 'DESC'){echo 'active';} ?>" href="?sort=DESC">Desc</a>]
                        <i class='fa fa-eye'></i> View:[
                        <span class='active' data-view='full'>Full</span>
                        <span data-view='classic'>Classic</span>]
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                        foreach($cats as $cat){
                            echo '<div class="cat">';
                                echo '<div class="hidden-buttons">';
                                    echo "<a href='categories.php?do=Edit&catid=".$cat['id']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                    echo "<a href='categories.php?do=Delete&catid=".$cat['id']."' class='btn btn-xs btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                echo '</div>';
                                echo "<h3>".$cat['catname'].'</h3>';
                                echo "<div class='full-view'>";
                                    echo "<p>"; if($cat['catname']==''){echo 'category without img';}else{echo $cat['catname'];} echo'</p>';
                                    if($cat['parentID']==0){echo'<span class="commenting"><i class="fa fa-close"></i> Parent categories</span>';}
                                echo "</div>";
                            echo '</div>';
                            echo '<hr>';
                        }
                    ?>
                </div>
            </div>
            <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class='fa fa-plus'></i> Add new Category</a>
        </div>
        <?php
    }elseif($do=='Add'){?>
         <h1 class="text-center">Add New categories</h1>
         <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="Post">
                <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                    <label class="col-sm-2 control-label"><b>Name</b></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="name" class="form-control" autocomplete='off' required='required' placeholder="Name of the category" />
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
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Category" class="btn btn-primary" />
                    </div>
                </div>
            </form>
         </div>
    <?php
    }elseif($do=='Insert'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Category Member</h1>";
            echo "<div class='container'>";
            $name  = $_POST['name'];
            $category    = $_POST['category'];
                //check if user exist in data base
            $check=checkItem("catname","categories",$name);
            if($check==1){
                    $theMsg='<div class="alert alert-danger">sorry this category is exist</div>';
                    redirectHome($theMsg,'back');
            }else{
                    //insert
                    $stmt= $con->prepare("INSERT INTO categories(catname,parentID) VALUES(:name,:category)");
                    $stmt->execute(array(
                        'name' => $name,
                        'category' => $category
                    ));
                    $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Insert</div>';
                    redirectHome($theMsg,'back');
            }
            
        }else {
            echo '<div class="container">';
            $theMsg='<div class="alert alert-danger">Sorry you cant Browse this page Directly</div>';
            redirectHome($theMsg);
            echo "</div>";
        }
        echo "</div>";
    }elseif($do=='Edit'){
        $catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM categories WHERE id = ? ") ;
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count>0){?>
            <h1 class="text-center">Edit categories</h1>
            <div class="container">
               <form class="form-horizontal" action="?do=Update" method="Post">
                   <input type="hidden" name="catid" value="<?php echo $catid?>"/>
                   <div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
                       <label class="col-sm-2 control-label"><b>Name</b></label>
                       <div class="col-sm-10 col-md-4">
                           <input type="text" name="name" class="form-control" required='required' placeholder="Name of the category" value="<?php echo $cat['catname'] ?>"/>
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
                                    echo "<option value='".$cat['id']."'"; if($cat['id']==$cat['parentID']){ echo "selected";} echo ">".$cat['catname']."</option>";
                                }
                            ?>
                        </select>
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
    }elseif($do=='Update'){
        echo "<h1 class='text-center'>Update Category</h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id    = $_POST['catid'];
            $name  = $_POST['name'];
            $cat = $_POST['category'];
            $stmt = $con->prepare("UPDATE categories SET catname=?, parentID = ? WHERE id= ?");
            $stmt->execute(array($name,$cat,$id));
            $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($theMsg,'back');
        }else {
            $theMsg='<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
            redirectHome($theMsg);
        }
        echo "</div>";
    }elseif($do=='Delete'){
        echo "<h1 class='text-center'>Delete Category</h1>";
        echo "<div class='container'>";
            $catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
            $check=checkItem("id","categories",$catid);
            if ($check>0){
                $stmt=$con->prepare('DELETE FROM categories WHERE id=:id');
                $stmt->bindParam(":id",$catid);
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