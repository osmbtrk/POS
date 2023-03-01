<?php
ob_start();
session_start();
$pageTitle='Sale';
if (isset($_SESSION['user'])){
    include 'C:\xampp\htdocs\27club\admin\conn.php';
    include 'C:\xampp\htdocs\27club\include\functions\functions.php';
    include 'C:\xampp\htdocs\27club\include\tpl\sidebar-09\sidebar.php';?>

        <div id="content" class="p-4 p-md-5 pt-5">
            <div class='main'>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Categories</h3>
                        </div>
                        <?php
                        foreach(getCat() as $cat){
                            echo '<div class="col-md-3">';
                                echo '<a href="design/playlist.php?pageid='.$cat['id'].'&userid='.$_SESSION['user'].'&pagename='
                                .str_replace(' ','-',$cat['catname']).'" class="album-poster">';
                                    echo '<img src="'.$cat['parentID'].'">';
                                echo '</a>';
                                echo'<h4>'.$cat['catname'].'</h4>';
                                echo '<p>'.$cat['parentID'].'</p>';
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