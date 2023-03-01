<?php
session_start();
if (isset($_SESSION['username'])){
    $pageTitle='Dashboard';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
   include 'C:\xampp\htdocs\27club\include\tpl\navbar.php';
   include 'C:\xampp\htdocs\27club\admin\conn.php';
   ?>
   <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class='stat st-members'>
                    <i class='fa fa-users'></i>
                    <div class='info'>
                        Total Members
                        <br><span><a href="members.php"><?php echo countItems('id','users') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class='stat st-pending'>
                    <i class="fa fa-user"></i> 
                    <div class='info'>
                        Total Vente
                        <br><span><a href="comment.php"><?php echo countItems('id','vente') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class='stat st-items'>
                    <i class='fa fa-tag'></i>
                    <div class='info'>
                        Total Articles
                        <br><span><a href="items.php"><?php echo countItems('id','article') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class='stat st-comment'>
                    <i class='fa fa-comments'></i>
                    <div class='info'>
                        Total Categories
                        <br><span><a href="comment.php"><?php echo countItems('id','categories') ?></a></span>
                    </div>
                </div>
            </div>
        </div>
   </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestUsers=5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?php echo $latestUsers; ?> Vente
                        <span class='toggle-info pull-right'>
                            <i class='fa fa-plus fa-lg'></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class='list-unstyled latest-users'>
                            <?php
                            $stmt=$con->prepare("SELECT vente.*,article.artname AS member FROM vente 
                            INNER JOIN article ON article.id=vente.artid LIMIT $latestUsers");
                            $stmt->execute();
                            $comments=$stmt->fetchAll();
                            foreach ($comments as $item){
                                echo '<li>'.$item['date'].'<b> Article: </b>'.$item['member'].'<a href="items.php?do=Edit&itemid=' .$item['id']. '"><span class="btn btn-success pull-right">
                                <i class="fa fa-edit"></i> Edit</span></a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestItems=5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest <?php echo $latestItems; ?> Items
                        <span class='toggle-info pull-right'>
                            <i class='fa fa-plus fa-lg'></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class='list-unstyled latest-users'>
                            <?php
                                $thelatest =getLatest("*","article","id",$latestItems);
                                foreach ($thelatest as $item){
                                echo '<li>'.$item['artname'].'<a href="items.php?do=Edit&itemid=' .$item['id']. '"><span class="btn btn-success pull-right">
                                <i class="fa fa-edit"></i> Edit</span></a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestcomment=5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-comments-o"></i> Latest <?php echo $latestcomment; ?> Comments
                        <span class='toggle-info pull-right'>
                            <i class='fa fa-plus fa-lg'></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class='list-unstyled latest-users'><?php
                            $stmt=$con->prepare("SELECT vente.*,article.artname AS member FROM vente 
                            INNER JOIN article ON article.id=vente.artid LIMIT $latestcomment");
                            $stmt->execute();
                            $comments=$stmt->fetchAll();
                            foreach($comments as $comment){
                                echo '<div class="comment-box">';
                                    echo '<span class="member-n">'.$comment['member'].'</span><p class="member-c">'.$comment['prix'].'</p>';
                                echo '</div>';

                            }
                            ?>
                        <ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <?php
   include 'C:\xampp\htdocs\27club\include\tpl\footer1.html';

}else{
    header('location:accueil.php');
    exit();
}