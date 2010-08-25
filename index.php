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
<img src="images/ilricrowd_left.png" />
<form id="sortByLocation" class="sortby first" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="location" />
	<input type="image" name="submit" src="images/sort_by_location.png" />
</form>
<form id="sortByJobTitle" class="sortby" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="sortby" value="jobtitle" />
	<input type="image" name="submit" src="images/sort_by_job_title.png" />
</form>
<form id="audioOnly" class="sortby" action="<?php echo $pageref; ?>" method="post">
	<input type="hidden" name="media" value="audio" />
	<input type="image" name="submit" src="images/audio_only.png" />
</form>
</div> <!-- //#peopleLeftMenu -->

<img src="images/ilricrowd_right1.png" id="ilricrowdright1" />

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

	// remove "featured" people
	$featured = array(); // initialize empty array
	$elementnum = 0; // a counter
	// loop through our people and search for persons who are "featured"
	// when you find one, stick it in the $featured array and remove them from people
	foreach($people as $person) {
		if(array_key_exists('featured',$person)) {
			array_push($featured, $people[$elementnum]);
			unset($people[$elementnum]);
		}
		$elementnum++;
	}

	// determine how to sort our people!
	// first see if a "sortby" value exists
	if (!empty($_POST['sortby'])) {
		$sortby = $_POST['sortby'];

		// check for a sane sort value, otherwise just use the order in the XML file
		if($sortby == 'jobtitle') $people = sort_subval($people,'jobtitle');
		else if($sortby == 'location') $people = sort_subval($people,'location');
		else {
			$_POST['sortby'] = ''; // unset 'sortby' and assume the sortby value is not sane.
								   // sort the people using the order they appear in the XML file
		}
	}

	$count = 0;
	if(isset($people) && !empty($people)) {
		foreach($people as $person) {
			if($count == 2) {
				echo '<img src="images/ilricrowd_right2.png" id="ilricrowdright2" />';
			}

			if($count == 4) {
				echo '<div id="feature">';
				echo '	<div id="featureLeft">';
				echo '		<div id="featureLeftTop">';
				echo '			space on top for the description';
				echo '		</div>';
				echo '		<div id="featureLeftBottom">';
				echo '			<a id="featured" href="videos/true_blood.flv"></a>';
				echo '		</div>';
				echo '	</div>';
				echo '	<div id="featureRight">';
				if(isset($featured) && !empty($featured)) {
					// show 1 of our "featured" people big
					for($x = 0; $x < 1; $x++) {
						echo '			<div id="mainFeature">';
						echo '				<img class="person" src="'.$featured[$x]['image'].'" title="'.$featured[$x]['name'].'" alt="'.$featured[$x]['name'].'" />'."\n";
						echo '			</div>';
					}
				echo '			<div id="otherFeatures">';
				echo '				<span class="person">Click icons for more featured staff</span>'."\n";
					// show the other 2 small
					for($x = 1; $x <= 2; $x++) {
						echo '				<img class="person" src="'.$featured[$x]['image'].'" title="'.$featured[$x]['name'].'" alt="'.$featured[$x]['name'].'" />'."\n";
					}
				echo '			</div>';
				}

				echo '		<div id="featureButtons">';
				echo '		<a href="#" title="ILRI Jobs"><img src="images/ilri_jobs.png" alt="ILRI Jobs" class="button first" /></a>';
				echo '		<a href="#" title="ILRI People Facts"><img src="images/ilri_people_facts.png" alt="ILRI People Facts" class="button" /></a>';
				echo '		<a href="#" title="ILRI Specialties"><img src="images/ilri_specialties.png" alt="ILRI Specialties" class="button" /></a>';
				echo '		</div>';
				echo '	</div>';
				echo '</div>';
			}
			
			echo '<div class="person">'."\n";
			echo '	<div class="img">'."\n";

			//check to see if the current person has a video
			if(isset($person['video']) && $person['video'] != 'false') {
				echo '		<a class="vid" href="videos/'.$person['video'].'"><img src="'.$person['image'].'" title="'.$person['name'].'" alt="'.$person['name'].'" /></a>'."\n";
			}
			// show image if there is no video
			else {
				echo '		<img src="'.$person['image'].'" title="'.$person['name'].'" alt="'.$person['name'].'" />'."\n";
			}
			echo '	</div>'."\n";
			// check to see if the current person is a Regional Rep.
			// if so, give him/her a different class to change the text color
			if($person['jobtitle'] == 'Regional Representative') {
				echo '	<span class="name rep">'.$person['name'].'</span>'."\n";
			}
			else {
				echo '	<span class="name">'.$person['name'].'</span>'."\n";
			}

			if($sortby == 'jobtitle') {
				echo '	<span class="jobtitle">'.$person['jobtitle'].'</span>'."\n";
				if($person['jobtitle'] == 'Regional Representative') {
					echo '	<span class="region">'.$person['region'].'</span>'."\n";
				}
				echo '	<span class="nationality">'.$person['nationality'].'</span>'."\n";
				echo '</div>'."\n";
			}
			else {
				echo '	<span class="location">'.$person['location'].'</span>'."\n";
				echo '	<span class="nationality">'.$person['nationality'].'</span>'."\n";
				echo '</div>'."\n";
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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="scripts/flashembed.min.js"></script>
<script type="text/javascript" src="scripts/people.js"></script>
</body>
</html>
