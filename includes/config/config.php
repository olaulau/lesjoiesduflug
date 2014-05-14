<?php

$rss_url = "http://lesjoiesducode.fr/rss";
$rss_cache_file = "cache/rss";
$rss_cache_lifetime = 5*60; // 5 min

$name = "Flo";
if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])) {
	$name = $_REQUEST['name'];
}

$replacement_patterns = array(
	"du stagiaire" => "de $name",
	"je" => "$name",
);

?>
