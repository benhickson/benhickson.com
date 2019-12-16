<?php

$pageid = 0; // preventing it from not being set, but otherwise not using yet

require 'portfolio.file';
if (isset($_GET['project']) && array_key_exists($_GET['project'], $portfolio)) {

	// set the project variable
	$project = $portfolio[$_GET['project']];

	// set the page title
	$pagetitle = $project['title'];

} else {

	// redirect to the homepage
	header('Location: ..');
	
}

require '../includes/header.file';
require 'page.file';
require '../includes/footer.file';
