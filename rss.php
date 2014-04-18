<?php

require_once 'mysql_config.php';
require_once 'config.php';




$rss_url = "http://lesjoiesducode.fr/rss";
//TODO : download
$rss = simplexml_load_file("rss"); // from dev cache


//echo "<pre>";
//print_r($xml); die;

$item = $rss->channel->item;
$nb_item = $item->count();


foreach($rss->channel->item as $item) {
	$title = $item->title;
	foreach($replacement_patterns as $search => $replace) {
		$title = str_replace($search, $replace, $title);
	}
	$item->title = $title;


//	print_r($item);
//	echo "-------------------------------------" . PHP_EOL;
}

//echo "</pre>";

$rss->channel->title = "Les joies du flug";
$rss->channel->link = "http://www.lesjoiesduflug.fr.am/";



header('Content-Type:text/xml; charset=utf-8');
echo $rss->asXML();

?>
