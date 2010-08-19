<!doctype html>
<html>
<head>
	<title>ILRI - International Livestock Research Institutute</title>
	<?php
		require_once('head_includes.php');
		require_once('includes/functions.php');
		$pageref = $_SERVER['PHP_SELF']; // are we index.php?
	 ?>
</head>
<body>

<div id="outer">
<div id="header">
<?php require_once('navigation.php'); ?>
<div id="banner"></div>
</div> <!-- //#header -->

<div id="inner">
<div id="peopleLeftMenu">
<div id="ilricrowdleft"><img src="images/ilricrowd_left.png" /></div>
<div id="sortby" style="position: relative; bottom: 0px;">
<form id="sortByPosition" class="sortby" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="position" />
	<input type="image" name="submit" src="images/sort_by_position.jpg" />
</form>
<form id="sortByLocation" class="sortby" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="location" />
	<input type="image" name="submit" src="images/sort_by_location.jpg" />
</form>
<form id="audioOnly" class="sortby" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="media" value="audio" />
	<input type="image" name="submit" src="images/audio_only.jpg" />
</form>
</div> <!-- //#sortby -->

</div> <!-- //#peopleLeftMenu -->

<div id="ilricrowdright"><img src="images/ilricrowd_right.png" /></div>

<?php

?>

<div id="peopleGrid">
<?php
	// create a SimpleXMLObject
	$people_xml_object = simplexml_load_file('people.xml');

	// convert it to an array
	$people = xmlobj2array($people_xml_object->children());

	// simplexml returns a namespace "person" containing several "people" so
	// we reset our people array to this subset
	$people = $people['person'];

	// determine how to sort our people!
	// first see if a "sortby" value exists
	if (!empty($_POST['sortby'])) {
		$sortby = $_POST['sortby'];

		// check for a sane sort value, otherwise just use the order in the XML file
		if($sortby == 'name') $people = sort_subval($people,'name');
		else if($sortby == 'position') $people = sort_subval($people,'position');
		else if($sortby == 'location') $people = sort_subval($people,'location');
		else if($sortby = 'random') shuffle($people);
	}

	$count = 0;
	if(isset($people) && !empty($people)) {
		foreach($people as $person) {
			if($count == 6) {
				echo '<div id="feature">';
				echo '	<div id="featureleft" style="width: 392px; float: left;">Left, video, etc</div>';
				echo '	<div id="featureright" style="width: 262px; float: left;">';
				echo '		<div id="buttons" style="position: absolute; bottom: 0px;">';
				echo '		<img src="images/ilri_jobs.jpg" alt="ILRI Jobs" class="button" />';
				echo '		<img src="images/ilri_people_facts.jpg" alt="ILRI People Facts" class="button" />';
				echo '		<img src="images/ilri_specialties.jpg" alt="ILRI Specialties" class="button" />';
				echo '		</div>';
				echo '	</div>';
				echo '</div>';
			}
			else {
				echo '<div id="person'.$count.'" class="person">'."\n";
				echo '	<div class="img">'."\n";

				//check to see if the current person has a video
				if(isset($person['video']) && $person['video'] != 'false') {
					// we want "andrew_m" from "andrew_m.flv" so we can use it for other things.
					// store it in the class so we can access it via jQuery later.
					$name = basename($person['video'], '.flv');
					echo '		<div id="'.$name.' player'.$count.'" class="vid"><img src="'.$person['image'].'" alt="'.$person['name'].'" /></div>'."\n";
				}
				// show image if there is no video
				else {
					echo '		<img src="'.$person['image'].'" alt="'.$person['name'].'" />'."\n";
				}
				echo '	</div>'."\n";
				// check to see if the current person is a Regional Rep.
				// if so, give him/her a different class to change the text color
				if($person['position'] == 'Regional Representative') {
					echo '	<h4 class="rep">'.$person['name'].'</h4>'."\n";
				}
				else {
					echo '	<h4>'.$person['name'].'</h4>'."\n";
				}
				if($sortby == 'position') {
					echo '	<h5>'.$person['position'].'</h5>'."\n";
					echo '</div>'."\n";
				}
				else {
					echo '	<h5>'.$person['location'].'</h5>'."\n";
					echo '</div>'."\n";
				}
			}

			$count++;
		}
	}
?>
</div>
</div> <!-- //#inner -->

<div id="footer">
	<div id="footer-inner">
	<p><a href="http://www.ilri.org/ContactUs">Contact us</a> | <a href="http://www.ilri.org/CopyRight">Copyright and permissions</a> | <a href="http://www.ilri.org/Search">Search</a> | <a href="http://www.ilri.org/Newsfeeds">Subscribe</a><br>
	&copy; International Livestock Research Institute (ILRI)</p>
	</div> <!-- //#footer-inner -->
</div> <!-- //#footer -->

</div> <!-- //#outer -->

<script type="text/javascript" src="scripts/jquery.1.4.2.min.js"></script>
<script type="text/javascript" src="scripts/flashembed.min.js"></script>
<script type="text/javascript" src="scripts/people.js"></script>
</body>
</html>
