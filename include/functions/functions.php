<?php
//title
 function getTitle(){
     global $pageTitle;
     if (isset($pageTitle)){
         echo $pageTitle;
     } else {
         echo '27club';
     }
 }
 //redirect function
 function redirectHome($theMsg,$url=null,$seconds=4){
    if($url===null){
       $url='dashboard.php';
       $link='Homepage';
    }else{
        $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $url=$_SERVER['HTTP_REFERER'] : $url='dashboard.php';
        $link='Previous page';
    }
    echo $theMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds.</div>";
    header("refresh:$seconds;url=$url");
    exit();
 }
 //check items in database 
 function checkItem($select,$from,$value) {
     global $con;
     $statement=$con->prepare("SELECT $select FROM $from WHERE $select=?");
     $statement->execute(array($value));
     $count=$statement->rowCount();
     return $count;
 }
 function checkIteminplay($select,$play,$from,$check,$value) {
    global $con;
    $statement=$con->prepare("SELECT * FROM $from WHERE $check=$value AND $select=$play");
    $statement->execute();
    $count=$statement->rowCount();
    return $count;
}
 //count number of anything in database
 function countItems($item,$table){
     global $con;
     $stmt2=$con->prepare("SELECT COUNT($item) FROM $table");
     $stmt2->execute();
     return $stmt2->fetchColumn();
 }
 //get latest items from database
 function getLatest($select,$table,$order,$limit=5){
     global $con;
     $getstmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
     $getstmt->execute();
     $rows =$getstmt->fetchAll();
     return $rows;
 }
 //get category from db
 function getCat(){
    global $con;
    $getCat=$con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    $getCat->execute();
    $cats =$getCat->fetchAll();
    return $cats;
}
 //get items from db
 function getItems($catid){
    global $con;
    $getItems=$con->prepare("SELECT * FROM items WHERE cat_ID=? ORDER BY item_ID ASC");
    $getItems->execute(array($catid));
    $items =$getItems->fetchAll();
    return $items;
}
function getplaylist(){
    global $con;
    $getplaylist=$con->prepare("SELECT userID FROM user playlist");
    $getplaylist->execute();
    $user =$getplaylist->fetchAll();
    return $user;
}
function getplaylists($userid){
    global $con;
    $getplaylist=$con->prepare("SELECT * FROM userplaylist WHERE userID=?");
    $getplaylist->execute(array($userid));
    $playlists =$getplaylist->fetchAll();
    return $playlists;
}