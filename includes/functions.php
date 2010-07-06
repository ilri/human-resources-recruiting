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
?>
