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
		$(document).ready(function() {
			$('#player0').flashembed("videos/player_flv_maxi.swf", {
				flv: 'andrew.flv', //relative to player!
				showplayer: 'never',
				showloading: 'never',
				margin: '0',
				startimage: 'images/people/andrew_play.png'});
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
<form id="sortRandom" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="random" />
	<input type="submit" name="submit" value="Back to random" />
</form>

</div> <!-- //#peopleLeftMenu -->


<?php

?>

<ul id="peopleGrid">
<?php
	// create a SimpleXMLObject
	$people_xml_object = simplexml_load_file('people.xml');

	// convert it to an array
	$people = xmlobj2array($people_xml_object->children());

	// simplexml returns a namespace "person" containing several "people" so
	// we reset our people array to this subset
	$people = $people['person'];

	// determine how to sort our people!
	// first see if a "sortby" value exists, otherwise just sort randomly
	if (!empty($_POST['sortby'])) {
		$sortby = $_POST['sortby'];

		// check for a sane sort value, otherwise just use random
		if($sortby == 'name') $people = sort_subval($people,'name');
		else if($sortby == 'position') $people = sort_subval($people,'position');
		else if($sortby == 'location') $people = sort_subval($people,'location');
		else {
			$sortby = 'random';
			shuffle($people);
		}
	}
	else {
		$sortby = 'random';
		shuffle($people);
	}

	$count = 0;
	if(isset($people) && !empty($people)) {
		foreach($people as $person) {
			echo '<li id="person'.$count.'" class="person">'."\n";
			echo '	<div id="player'.$count.'" class="img">'."\n";
			echo '		<img src="'.$person['image'].'" alt="'.$person['name'].'" />'."\n";
			echo '	</div>'."\n";
			echo '	<h4>'.$person['name'].'</h4>'."\n";
			if($sortby == 'position') {
				echo '	<h5>'.$person['position'].'</h5>'."\n";
				echo '</li>'."\n";
			}
			else {
				echo '	<h5>'.$person['location'].'</h5>'."\n";
				echo '</li>'."\n";
			}

			$count++;
		}
	}
?>
</ul>
</div> <!-- //#inner -->

<div id="footer">
Footer
</div> <!-- //#footer -->

</div> <!-- //#outer -->

</body>
</html>
