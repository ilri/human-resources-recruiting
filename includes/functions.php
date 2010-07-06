<?php

/*
*   loadXMLfile()	Load an XML file into a simpleXML object
*
*	@param	string	$file	Path to the xml file to load
*   @return object  a SimpleXML object containing the simpleXML object
*/
function loadXMLfile($file) {
	if(file_exists($file)) {
		$simple_xml_object = simplexml_load_file($file);
		return $simple_xml_object;
	}
	else {
		exit("Failed to open $file.");
	}
}

?>
