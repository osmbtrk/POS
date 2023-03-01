<?php
include 'C:\xampp\htdocs\27club\admin\conn.php';
include 'C:\xampp\htdocs\27club\include\functions\functions.php';
$do=isset($_GET['do']) ?$_GET['do'] : '';
if($do=='Add'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		echo "<h1 class='text-center'>Playlist of Member</h1>";
		echo "<div class='container'>";
		$musicid  = $_POST['musicid'];
		$playlist  = $_POST['playlist'];
		$check=checkIteminplay("userplaylist",$playlist,"items_of_userplaylist","items",$musicid);
		if($check==1){
			$theMsg='<div class="alert alert-danger">sorry this title is exist</div>';
			redirectHome($theMsg,'back');
		}else{
			//insert
			$stmt= $con->prepare("INSERT INTO items_of_userplaylist(items,userplaylist) VALUES(:music,:play)");
			$stmt->execute(array(
				'music' => $musicid,
				'play' => $playlist
			));
			$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Insert</div>';
			redirectHome($theMsg,'back');
		}
		
	}else {
		echo '<div class="container">';
		$theMsg='<div class="alert alert-danger">Sorry you cant Browse this page Directly</div>';
		redirectHome($theMsg,'back');
		echo "</div>";
	}
	echo "</div>";
}?>

<!DOCTYPE html>
<html>
	<head>
		<title>27club</title>

		<!-- Include Amplitude JS -->
		<script type="text/javascript" src="dist/amplitude.js"></script>

		<!-- Include Style Sheet -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" type="text/css" href="css/app.css"/>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

	</head>
	<body>
		<a class="back" href="javascript: history.back()">
		<i class='fa fa-chevron-left'></i> Back</a>

		<!-- Blue Playlist Container -->
		<div id="blue-playlist-container">

			<!-- Amplitude Player -->
			<div id="amplitude-player">

				<!-- Left Side Player -->
				<div id="amplitude-left">
					<img data-amplitude-song-info="cover_art_url" style='max-height: 400px;'/>
					<div id="player-left-bottom">
						<div id="time-container">
							<span class="current-time">
								<span class="amplitude-current-minutes" ></span>:<span class="amplitude-current-seconds"></span>
							</span>
							<div id="progress-container">
								<input type="range" class="amplitude-song-slider"/>
								<progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
								<progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
							</div>
							<span class="duration">
								<span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span>
							</span>
						</div>

						<div id="control-container">
							<div id="repeat-container">
								<div class="amplitude-repeat" id="repeat"></div>
								<div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
							</div>

							<div id="central-control-container">
								<div id="central-controls">
									<div class="amplitude-prev" id="previous"></div>
									<div class="amplitude-play-pause" id="play-pause"></div>
									<div class="amplitude-next" id="next"></div>
								</div>
							</div>

							<div id="volume-container">
								<div class="volume-controls">
									<div class="amplitude-mute amplitude-not-muted"></div>
									<input type="range" class="amplitude-volume-slider"/>
									<div class="ms-range-fix"></div>
								</div>
								<div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
							</div>
						</div>
						<div id="meta-container">
							<span data-amplitude-song-info="name" class="song-name"></span>

							<div class="song-artist-album">
								<span data-amplitude-song-info="artist"></span>
								<span data-amplitude-song-info="album"></span>
							</div>
						</div>
					</div>
				</div>
				<!-- End Left Side Player -->

				<!-- Right Side Player -->
				<div id="amplitude-right">
					<?php
					$catid=$_GET['pageid'];
                    $getItems=$con->prepare("SELECT items.*,artiste.name AS artiste_name FROM items 
                    INNER JOIN artiste ON artiste.ID=items.artiste WHERE artiste=?");
                    $getItems->execute(array($catid));
					$items =$getItems->fetchAll();
					$counts = 0 ;
                    foreach($items as $item){?>
					<div class="song amplitude-song-container amplitude-play-pause" data-amplitude-song-index="<?php echo $counts++;?>">
						<div class="song-now-playing-icon-container">
							<div class="play-button-container">

							</div>
							<img class="now-playing" src="./img/now-playing.svg"/>
						</div>
						<div class="song-meta-data">
							<span class="song-title"><?php echo $item['name'];?></span>
							<span class="song-artist"><?php echo $item['artiste_name'];?></span>
						</div>
						<a href='#' class='aplus' onclick="document.getElementById('id0<?php echo $item['item_ID']+2;?>').style.display='block'"><i class="fa fa-plus mr-5" ></i></a>
						<p class="padd"> Add to playlist</p>
						<div id="id0<?php echo $item['item_ID']+2;?>" class="w3-modal">
							<div class="w3-modal-content w3-card-4">
								<header class="w3-container w3-teal"> 
									<span onclick="document.getElementById('id0<?php echo $item['item_ID']+2;?>').style.display='none'" 
									class="w3-button w3-display-topright">&times;</span>
									<h2>Add to playlist</h2>
								</header>
								<div class="w3-container">
									<form class="form-horizontal" action="?do=Add" method="Post">
										<input type="hidden" name="musicid" value="<?php echo $item['item_ID'];?>"/>
										<div class="form-group form-group-lg" style="display:flex; flex-direction: row; align-items: center">
											<label class="col-sm-5 control-label"><h4>select playlist</h4></label>
											<div class="col-sm-10 col-md-4">
												<select class="sel" name="playlist">
													<option value="0">...</option>
													<?php 
													$catid=$_GET['userid'];
													foreach(getplaylists($catid) as $playlist){
															echo "<option value='".$playlist['playlist_ID']."'>".$playlist['name']."</option>";
															}
													?>
												</select>
												<input type="submit" value="Add" class="btn btn-success" style="top:0px;left:130px;" />
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<a href="#" class="bandcamp-link" target="_blank">
							<img class="bandcamp-grey" src="./img/bandcamp-grey.svg"/>
							<img class="bandcamp-white" src="./img/bandcamp-white.svg"/>
						</a>
						<span class="song-duration">3:30</span>
					</div>				<?php } ?>
				</div>
				<!-- End Right Side Player -->
			</div>
			<!-- End Amplitdue Player -->
		</div>
		
		<!--
			Include UX functions JS

			NOTE: These are for handling things outside of the scope of AmplitudeJS
		-->
		<script type="text/javascript" src="js/functions.js"></script>
		<script>
			Amplitude.init({
				continue_next: false,
				"songs": [
					<?php
					$catid=$_GET['pageid'];
                    $getItems=$con->prepare("SELECT items.*,artiste.name AS artiste_name FROM items 
                    INNER JOIN artiste ON artiste.ID=items.artiste WHERE artiste=? ORDER BY item_ID ASC");
                    $getItems->execute(array($catid));
					$items =$getItems->fetchAll();
                    foreach($items as $item){?>
					{
						"name": "<?php echo $item['name'];?>",
						"artist": "<?php echo $item['artiste_name'];?>",
						"url": "../<?php echo $item['adresse'];?>",
						"cover_art_url": "../<?php echo $item['image'];?>"
					},
				<?php } ?>
				]
			});
		</script>
	</body>
</html>