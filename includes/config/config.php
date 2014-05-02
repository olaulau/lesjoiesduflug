<?php

$rss_url = "http://lesjoiesducode.fr/rss";
$rss_cache_file = "cache/rss";
$rss_cache_lifetime = 5*60; // 5 min

$firstname = "Flo";

$replacement_patterns = array(
	"du stagiaire" => "de $firstname",
	"je" => "$firstname",
);

?>
