<?php
include 'C:\xampp\htdocs\27club\admin\conn.php';
if(isset($_POST['articleid'])){
    $sort=$_POST['articleid'];
    print($sort);
    $stmt=$con->prepare("SELECT * FROM article WHERE categoryid=?");
    $stmt->execute(array($sort));
    $cats=$stmt->fetchAll();
    foreach($cats as $cat){
        echo "<option value='".$cat['id']."'>".$cat['artname']."</option>";
    }
}
    
?>