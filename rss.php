<?php

// require_once 'includes/config/mysql_config.php';
require_once 'includes/config/config.php';



//TODO : check if file exists, also download if not
$mtime = filemtime("cache/rss");
$time = time();
$delta = ($time - $mtime) - $rss_cache_lifetime;
if($delta > 0) { // redownload
	$documentString = file_get_contents($rss_url);
	file_put_contents("cache/rss", $documentString);
}
else { // just read
	$documentString = file_get_contents("cache/rss");
}

$dom = new DOMDocument();
$dom->loadXML($documentString);

// echo "<pre>";
// print_r($rss); die;

$rss = $dom->childNodes->item(0);
// print_r($rss); die;
$channel = $rss->childNodes->item(0);
// print_r($channel); die;

$searches = array_keys($replacement_patterns);
$replaces = array_values($replacement_patterns);

$items = array();
foreach($channel->childNodes as $item)
{
	/* @var $item DOMNode */
	// 	print_r($item);
	if($item->nodeName=='item')
	{
		$items[] = $item; // stack items for further compute
	}	
}

foreach ($items as $item) { //compute the stack
	/* @var $item DOMNode */
// 	print_r($item);
	foreach($item->childNodes as $itemChild)
	{
		if($itemChild->nodeName=='title')
		{
			/* @var $itemChild DOMNode */
			// 	print_r($itemChild);
			$title = $itemChild->nodeValue;
			// 	var_dump($title);
	
			$title = str_replace($searches, $replaces, $title, $count);
			// 	continue;
			if($count > 0) {
// 				echo $title . PHP_EOL;
				$itemChild->nodeValue = $title;
			}
			else {
				$channel->removeChild($item);
			}
		}
			
	}
}




// echo "</pre>";



//TODO : recode with DOMDocument API
// $rss->channel->title = "Les joies du flug";
// $rss->channel->link = "http://www.lesjoiesduflug.fr.am/";

header('Content-Type:text/xml; charset=utf-8');
echo $dom->saveXML();

?>