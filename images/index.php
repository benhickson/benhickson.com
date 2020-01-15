<?php

if (isset($_GET['height']) || isset($_GET['quality'])) {
	if (!isset($_GET['format'])){
		exit('Custom height or quality requested without setting an output format.');
	}
}

if (isset($_GET['height'])) {
	$_GET['height'] = (int)$_GET['height'];
	if ($_GET['height'] < 10 || $_GET['height'] > 2000) {
		exit('Invalid height requested. Please use an integer from 10 to 2000');
	}
}

if (isset($_GET['quality'])) {
	$_GET['quality'] = (int)$_GET['quality'];
	if ($_GET['quality'] < 5 || $_GET['quality'] > 100) {
		exit('Invalid quality level requested. Please use an integer from 5 to 100');
	}
}

if (isset($_GET['format'])) {
	if (!($_GET['format'] == 'jpeg' || $_GET['format'] == 'webp')) {
		exit('Invalid format requested. Please use either "jpeg" or "webp".');
	}
}

$file_requested = $_GET['filename']
				. ($_GET['height'] ? '.'.$_GET['height'].'h' : '')
				. ($_GET['quality'] ? '.q'.$_GET['quality'] : '') 
				. ($_GET['format'] ? '.'.$_GET['format'] : '');

$serveable = 'serveable/'.$file_requested;

if (file_exists($serveable)) {
	
	// serve the file
	header('X-Sendfile: '.__DIR__.'/'.$serveable);
	header('Content-type: image/'.$_GET['format']);
	header('Content-Disposition: inline; filename="'.$file_requested.'"');

	// add a header so these files are cached
	header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24 * 365 * 10))); // 10 years 
	
	// override the header that prevents these from being cached
	header('Cache-Control: public');

} else {

	// Check that the request is coming from our site, 
	// to help prevent some malicious script generating tons of files
	if(parse_url($_SERVER['HTTP_REFERER'])['host'] !== 'benhickson.com') {
		exit('Files cannot be generated unless requested on a page on benhickson.com');
	}	

	$highquality = 'highquality/'.$_GET['filename'];

	if (!file_exists($highquality)) {
		exit('Neither a serveable file or a high quality source file exist.');
	}

	// start the imagick class
	$imagick = new Imagick($highquality);

	// scale the image - width of zero means it maintains the aspect ratio
	$imagick->scaleImage(0,$_GET['height']);

	// write it to a file
	$imagick->writeImage($serveable);

	// serve it to the user
	// TODO: reorganize this to be more DRY
	header('Content-Type: image/'.$_GET['format']);
    echo $imagick->getImageBlob();

}