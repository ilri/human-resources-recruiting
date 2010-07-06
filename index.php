<!doctype html>
<html>
<head>
	<title>ILRI - International Livestock Research Institutute</title>
	<?php
		require_once('head_includes.php');
		require_once('includes/functions.php');
		$pageref = $_SERVER['PHP_SELF']; // are we index.php?
	 ?>
	<script>
		$(function() {
			$('#player').flashembed("videos/player_flv_maxi.swf", {
				flv: 'andrew.flv', //relative to player!
				showplayer: 'never',
				showloading: 'never',
				margin: '0',
				startimage: 'images/mugshots/andrew_play.png'});
		});
	</script>
</head>
<body>

<div id="outer">
<div id="header">
<?php require_once('navigation.php'); ?>
<div id="banner" style="padding-top: 0px;"></div>
</div> <!-- //#header -->

<div id="inner">
<div id="peopleLeftMenu">
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using. <a href="#">Testing links</a>.
<form id="sortByPosition" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="position" />
	<input type="submit" name="submit" value="Sort by position" />
</form>
<form id="sortByName" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="location" />
	<input type="submit" name="submit" value="Sort by location" />
</form>
</div> <!-- //#peopleLeftMenu -->

<?php
// determine how to sort our people!
// first see if a "sortby" value exists, otherwise just sort randomly
if (!empty($_POST['sortby'])) {
		$sortby = $_POST['sortby'];
}
else {
		$sortby = 'random';
}
?>

<ul id="peopleGrid">
<?php
	$people_xml_object = loadXMLfile('people.xml');

	$count = 0;
	if(isset($people_xml_object)) {
		foreach($people_xml_object->person as $person) {
			echo '<li id="person'.$count.'" class="person">'."\n";
			echo '	<div id="player'.$count.'" class="img">'."\n";
			echo '		<img src="'.$person->image.'" alt="'.$person->name.'" />'."\n";
			echo '	</div>'."\n";
			echo '	<h4>'.$person->name.'</h4>'."\n";
			if($sortby == 'position') {
				echo '	<h5>'.$person->position.'</h5>'."\n";
				echo '</li>'."\n";
			}
			else {
				echo '	<h5>'.$person->location.'</h5>'."\n";
				echo '</li>'."\n";
			}

			$count++;
		}
	}
?>
</ul>

<!--
<div id="player" class="person"><img src="images/mugshots/2andrew better.png" /></div>
<div class="person"><img src="images/mugshots/steve_k.png" /></div>
<div class="person"><img src="images/mugshots/steve_k.png" /></div>
<div class="person" id="player3"><img src="images/mugshots/2andrew better.png" /></div>
<div class="person"><img src="images/mugshots/steve_k.png" /></div>
<div class="person" id="player2"><img src="images/mugshots/2andrew better.png" /></div>
<div class="person"><img src="images/mugshots/steve_k.png" /></div>-->
<script type="text/javascript">
	flashembed("player0","videos/player_flv_maxi.swf", {
		flv: 'andrew.flv', //relative to player!
		showplayer: 'never',
		showloading: 'never',
		margin: '0',
		startimage: 'images/mugshots/andrew_play.png'
		}
	);

//	flashembed("player2","videos/flayr.swf", {
//		movie: 'andrew.flv', //relative to player!
//		autoplay: 'true',
//		controls: 'hide'
//		}
//	);
//
//	flashembed("player3","videos/flayr.swf", {
//		movie: 'andrew.flv', //relative to player!
//		autoplay: 'true',
//		controls: 'hide'
//		}
//	);

</script>
</div> <!-- //#inner -->

<div id="footer">
Footer
</div> <!-- //#footer -->

</div> <!-- //#outer -->

</body>
</html>
