<?php

/*
* xmlobj2array() - convert an object to an array maintaining key/value pairs
*
* @param	mixed	$object	can be either an array or an object (such as a SimpleXMLObject)
* @return	array
*
*/
function xmlobj2array($object) {
       if (is_object($object)) {
               foreach (get_object_vars($object) as $key => $val) {
                       $ret[$key] = xmlobj2array($val);
               }   
               return $ret;
       } elseif (is_array($object)) {
               foreach ($object as $key => $val) {
                       $ret[$key] = xmlobj2array($val);
               }   
               return $ret;
       } else {
               return $object;
       }   
}

/*
* sort_subval() - sorts an array of arrays by a sub value
*
* @param	array	$a		the array to be sorted
* @param	string	$subkey	the subkey to sort by
* @return	array	$c		the sorted array
*
* Given an array of arrays, $a:
* $a = array(
* 	0=>array('name'=>'Alan','location'=>'Kenya'),
* 	1=>array('name'=>'Steve','location'=>'Britain')
* );
* 
* Sort $a's elements by a sub value such as 'name'
*/
function sort_subval($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

/*
* print_current_jobs() - prints a list of currently available jobs
*						 from ILRI's Jobs RSS feed
* 
* Uses simplepie's caching mechanism to save time.  By default
* the cache is 3600 seconds (1 hour), but it can be set with:
*   $feed->set_cache_duration(3600);
*
* Also, the "cache location" tries to find a safe place for tmp
* on this platform by using PHP's sys_get_temp_dir().
*/
require_once('simplepie.inc');
function print_current_jobs() {
	$feed = new SimplePie();
	$feed->set_feed_url('http://feeds.feedburner.com/ILRIjobs?format=xml');
	$feed->set_cache_location(sys_get_temp_dir());
	$feed->init();
	$feed->handle_content_type();

	// print the first 7 items, wrapped in a list
	echo '<ul>';
	foreach ($feed->get_items(0,7) as $item) {
		echo '<li><a href="'.$item->get_permalink().'">'.$item->get_title().'</a></li>';
 	}
	echo '</ul>';

	// done with the feed, free up some memory
	unset($feed);
}

?>
