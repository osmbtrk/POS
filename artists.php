<?php
ob_start();
session_start();
$pageTitle='playlist';
if (isset($_SESSION['user'])){
    include 'C:\xampp\htdocs\27club\admin\conn.php';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
    include 'C:\xampp\htdocs\27club\include\tpl\sidebar-09\sidebar.php';?>

        <div id="content" class="p-4 p-md-5 pt-5">
            <div class='main'>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>band & article</h3>
                        </div>
                        <?php
                        $getartist=$con->prepare("SELECT * FROM article ");
                        $getartist->execute();
                        $artists =$getartist->fetchAll();
                            foreach ($artists as $artiste){
                                echo '<div class="col-md-3">';
                                    echo '<a href="design/artplaylist.php?pageid='.$artiste['id'].'&userid='.$_SESSION['ID'].'&pagename='
                                    .str_replace(' ','-',$artiste['artname']).'" class="album-poster" id="band">';
                                        echo '<img src="'.$artiste['id'].'">';
                                    echo '</a>';
                                    echo'<h4>'.$artiste['artname'].'</h4>';
                                echo '</div>';}?>
                    </div>
                </div>
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
    header('location:admin/accueil.php');
    exit();
}
ob_end_flush();
?>