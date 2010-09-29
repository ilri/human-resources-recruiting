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

			// if this person is a rep, take note
			if($person['jobtitle'] == 'Regional Representative') $rep = true;
			else $rep = false;

			if($count == 2) {
				echo '<img src="images/ilricrowd_right2.png" id="ilricrowdright2" />';
			}

			// draw the "featured" section
			if($count == 4) {
				echo '<div id="feature">';
				echo '	<div id="featureLeft">';
				echo '		<div id="featureLeftTop">';
				echo '			<div id="crowdMember" style="font-size: 14px; color: #6d6d6d; margin-top: 20px; margin-left: 15px; height: 64px; width: 210px; float: left;">featured ilri crowd member:</div>';
				echo '			<div id="crowdMemberName" class="feature0" style="font-size: 20px; font-weight: 500; color: #6d6d6d; margin-top: 15px; height: 69px; width: 167px; float: left; text-align: right;">'.strtolower($featured[0]['name']).'</div>';
				//echo '			<div id="crowdMemberName" class="feature1" style="display: none; font-size: 20px; font-weight: 500; color: #6d6d6d; margin-top: 15px; height: 69px; width: 167px; float: left; text-align: right;">'.strtolower($featured[1]['name']).'</div>';
				echo '			<div id="crowdMemberDescription" style="color: #4d4d4d; height: 74px; width: 392px; text-align: right; float: left;">'.strtolower($featured[0]['description']).'</div>';
				echo '		</div>';
				echo '		<div id="featureLeftBottom">';
				echo '			<a id="featured" href="'.$featured[0]['video'].'" style="background-image: url('.$featured[0]['startimage'].');"><img src="images/play.png" class="play" /></a>';
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
				echo '				<div id="features">';
				echo '				<span class="person">Click icons for more featured staff</span>'."\n";
					// show the other 2 small
					for($x = 1; $x <= 2; $x++) {
						echo '				<img class="person person'.$x.'" src="'.$featured[$x]['image'].'" title="'.$featured[$x]['name'].'" alt="'.$featured[$x]['name'].'" />'."\n";
					}
				echo 	'			</div>';
				echo '			</div>';
				}

				echo '		<div id="featureButtons">';
				echo '		<img id="ilrijobs" src="images/ilri_jobs.png" title="ILRI jobs" alt="ILRI jobs" class="button first" />';
				echo '		<img src="images/ilri_people_facts.png" title="ILRI people facts" alt="ILRI people facts" class="button" />';
				echo '		<img src="images/ilri_specialties.png" title="ILRI specialties" alt="ILRI specialties" class="button" />';
				echo '		</div>';
				echo '	</div>';
				echo '</div>';
			}
			
			if($rep) $class = "person rep";
			else $class = "person";

			echo '<div class="'.$class.'">'."\n";
			echo '	<div class="img">'."\n";

			//check to see if the current person has a video
			if(isset($person['video']) && $person['video'] != 'false') {
				echo '		<a class="vid" style="background-image: url('.$person['image'].');" href="'.$person['video'].'"><img src="images/play.png" class="play" title="'.$person['name'].'" alt="'.$person['name'].'" /></a>'."\n";
			}
			// show image if there is no video
			else {
				if(isset($person['link'])) {
					echo '		<a href="'.$person['link'].'" title="Azizi Biobank on Facebook">'."\n";
					echo '			<img src="'.$person['image'].'" title="'.$person['name'].'" alt="'.$person['name'].'" />'."\n";
					echo '		</a>'."\n";
				}
				else {
					echo '		<img class="person" src="'.$person['image'].'" title="'.$person['name'].'" alt="'.$person['name'].'" />'."\n";
				}
			}
			echo '	</div>'."\n";
			echo '	<div class="currently"><p>Currently...</p><br />'.$person['currently']."</div>\n";

			if($rep) $class = "name rep";
			else $class = "name";

			echo '	<span class="'.$class.'">'.$person['name'].'</span>'."\n";

			if($sortby == 'jobtitle') {
				echo '	<span class="jobtitle">'.$person['jobtitle'].'</span>'."\n";
				if($rep)
					echo '	<span class="region">'.$person['region'].'</span>'."\n";
				echo '</div>'."\n";
			}
			else if($sortby == 'location') {
				echo '	<span class="location"><img title="ILRI campus" alt="Home icon" src="images/home.png" />'.$person['location'].'</span>'."\n";
				echo '</div>'."\n";
			}
			else {
				echo '	<span class="nationality"><img title="Country of Origin" alt="Flag icon" src="images/flag.png" />'.$person['nationality'].'</span>'."\n";
				echo '</div>'."\n";
			}

			$count++;
		}
	}
?>
</div>
<div id="newWays" style="width: 960px; clear: both; position: relative; left: -88px; top: -20px; background-color: #ddd;">
<div class="row" style="background-image: url(images/purple_1px.png); background-position: bottom left; background-repeat: repeat-x; height: 190px;">
<div class="heading" style="background-color: #fff; font-size: 16px; font-weight: 600; color: rgb(138,115,115); text-align: left; height: 40px; padding-left: 15px;">
new ways of working - what suits you?
</div>
<img class="person" src="images/people/petr_h.png" style="margin-right:88px; padding-left: 0px; float: right;" />
<div style="float: left; margin-left: 88px; width: 640px; height: 60px; padding-top: 15px; font-size: 14px;">
An increasing number of scientists are employed through innovative arrangements such as joint appointments, sponsored positions and sabbaticals from international institutions.
</div>
<div style="margin-left: 88px; padding-left:540px; float: left; width: 100px; height: 75px; text-align: right; font-size: 12px;">
more about new ways of working at ILRI
</div>

</div>

<div class="row" style="background-image: url(images/purple_1px.png); background-position: bottom left; background-repeat: repeat-x; height: 190px;">
<div class="heading" style="height: 40px;">
</div>
	<img class="person" src="images/people/solenne.png" style="margin-left: 88px; float: left" />
	<img class="person" src="images/people/steve_k.png" style="margin-left: 88px; float: left" />
	<img class="person" src="images/people/kohei.png" style="margin-left: 88px; float: left" />
	<img class="person" src="images/people/jenny.png" style="margin-left: 88px; float: left" />
</div>
</div>

</div>
<div id="jobs">
<a href="#" class="close" style="position: absolute; top: 0px; right: 0px; display: block;">X</a>
	<ul>
		<li>Agronomist</li>
		<li>Anthropologist</li>
		<li>Bioinformatician</li>
		<li>Capacity Builder</li>
		<li>Science Communicators</li>
		<li>Computer Scientist</li>
		<li>Disease Modeler</li>
		<li>Ecologist</li>
		<li>Economist</li>
		<li>Epidemiologist</li>
		<li>Geneticist</li>
		<li>Geographer</li>
		<li>GIS Expert</li>
		<li>Human Geographer</li>
		<li>Immunologist</li>
		<li>Knowledge Sharer</li>
		<li>Livestock Systems Scientist</li>
		<li>Statisticians</li>
		<li>Systems Analyst</li>
		<li>Medical Doctor</li>
		<li>Parasitologist</li>
		<li>Social Scientist</li>
		<li>Veterinarian</li>
		<li>Virologist</li>
	</ul>
</div> <!-- //#jobs -->
<div id="footer">
	<div id="footer-inner">
	<p><a href="http://www.ilri.org/ContactUs">Contact us</a> | <a href="http://www.ilri.org/CopyRight">Copyright and permissions</a> | <a href="http://www.ilri.org/Search">Search</a> | <a href="http://www.ilri.org/Newsfeeds">Subscribe</a><br>
	&copy; International Livestock Research Institute (ILRI)</p>
	</div>
</div>
</div> <!-- //#inner -->

</div> <!-- //#outer -->

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
-->
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/jquery.flip.min.js"></script>
<script type="text/javascript" src="scripts/flowplayer-3.2.4.min.js"></script>
<script type="text/javascript" src="scripts/people.js"></script>
<script type="text/javascript">
<? 
	// print out our featured people's information so we can swap it in javascript
	echo 'var featured = new Array();'."\n";
	for($x = 0; $x <3; $x++) {
		echo "featured[$x] = new Array();\n";
		echo "featured[$x]['image'] = \"".$featured[$x]['image']."\";\n";
		echo "featured[$x]['name'] = \"".$featured[$x]['name']."\";\n";
		echo "featured[$x]['startimage'] = \"".$featured[$x]['startimage']."\";\n";
		echo "featured[$x]['description'] = \"".$featured[$x]['description']."\";\n";
		echo "featured[$x]['video'] = \"".$featured[$x]['video']."\";\n";
	}
?>
</script>
</body>
</html>
