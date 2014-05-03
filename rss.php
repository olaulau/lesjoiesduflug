<?php

require_once 'includes/config/config.php';
require_once 'includes/SimpleDOMDocument.class.php';


if(file_exists($rss_cache_file)) { //calculate real delta
	$mtime = filemtime($rss_cache_file);
	$time = time();
	$delta = ($time - $mtime) - $rss_cache_lifetime;
}
else  { // fake delta, force download
	$delta = 1;
}

if($delta > 0) { // (re)download
	$documentString = file_get_contents($rss_url);
	file_put_contents($rss_cache_file, $documentString);
}
else { // just read cache file
	$documentString = file_get_contents($rss_cache_file);
}

$dom = SimpleDOMDocument::fromXmlString($documentString);
$rss = $dom->getFirstChild();
$channel = $rss->getFirstChild();

$searches = array_keys($replacement_patterns);
$replaces = array_values($replacement_patterns);

$items = $channel->getChildrenOfType('item');
foreach ($items as $item) { //compute the stack
	/* @var $item SimpleDOMDocument */

	$itemChild = $item->getFirstChildOfType('title');
	/* @var $itemChild SimpleDOMDocument */
	
	$title = $itemChild->getValue();
	$title = str_replace($searches, $replaces, $title, $count);
	if($count > 0) {
 		$itemChild->setValue($title);
	}
	else {
		$item->delete();
	}
}


$channel->getFirstChildOfType('title')->setValue("Les joies du flug");
$channel->getFirstChildOfType('link')->setValue("http://www.lesjoiesduflug.fr.am/");


header('Content-Type:text/xml; charset=utf-8');
echo $dom->toXmlString();


?>