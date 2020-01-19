<?php

$pageid = 0; // preventing it from not being set, but otherwise not using this variable yet

require 'portfolio.file';

// if there is a project requested that exists
if (isset($_GET['project']) && array_key_exists($_GET['project'], $portfolio)) {

	// set the project variable
	$project = $portfolio[$_GET['project']];

	// set the page title
	$pagetitle = $project['title'];

} else {

	// redirect to the homepage, which already lists the portfolio, so the user can select another
	header('Location: ..');
	
}

require '../includes/header.file';
require 'project-page.file';
require '../includes/footer.file';
