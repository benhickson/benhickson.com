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

	$highquality = 'highquality/'.$_GET['filename'];

	if (!file_exists($highquality)) {
		exit('Neither a serveable file or a high quality source file exist.');
	}

	// start the imagick class
	$imagick = new Imagick($highquality);

	// $newwidth = round($_GET['height'] * ($imagick->getImageWidth() / $imagick->getImageHeight()));
	// echo $newwidth;

	$imagick->scaleImage(0,$_GET['height']);

	$imagick->writeImage($serveable);

	echo '<pre>';
	print_r($imagick);
	


}