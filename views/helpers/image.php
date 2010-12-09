<?php

App::import('Lib', 'ImageEditor.ImageEditor');

class ImageHelper extends HtmlHelper {

	/**
	 * Creates a IMG element with SRC that has all the actions encoded.
	 *
	 * ### Usage
	 *
	 * Create a resized image:
	 *
	 * `echo $this->Image->show('cake_icon.png', array('alt' => 'CakePHP'), array('adaptiveResize' => array(200, 200)));`
	 *
	 * Create a rotated, then resized image:
	 *
	 * `echo $this->Image->show('cake_icon.png', array('alt' => 'CakePHP'), array(rotateImageNDegrees' => array(-60), 'adaptiveResize' => array(200, 200)));`
	 *
	 * @param string $path Path to the image file, relative to the app/webroot/ directory.
	 * @param array $options Array of HTML attributes.
	 * @param array $editActions Array of the actions with their parameters as described in the PHPThumb documentation: http://github.com/masterexploder/PHPThumb/wiki/GD-API
	 *
	 * # adaptiveResize ($width, $height)
	 * # adaptiveResizePercent ($width, $height, $percent = 50)
	 * # adaptiveResizeQuadrant ($width, $height, $quadrant = 'C')
	 * # crop ($startX, $startY, $cropWidth, $cropHeight)
	 * # cropFromCenter ($cropWidth, $cropHeight = null)
	 * # resize ($maxWidth, $maxHeight)
	 * # resizePercent ($percent)
	 * # rotateImage ($direction = 'CW')
	 * # rotateImageNDegrees ($degrees)
	 *
	 *
	 * @return string completed img tag
	 * @access public
	 */
	function show($path, $options = array(), $editActions = array()) {
		if (!$cacheDir = Configure::read('ImageEditor.cacheDir')) {
			trigger_error(__d('image_editor', 'ImageEditor.cacheDir is not defined.', true), E_USER_ERROR);
		}
		$thumbName = base64_encode(json_encode($editActions)).'.'.pathinfo($path, PATHINFO_EXTENSION);
		if (strlen($thumbName) > 254) {
			trigger_error(__d('image_editor', 'Filename is too long for most Filesystems. Use less editActions.', true), E_USER_WARNING);
		}
		$path = sprintf('/%s/%s/%s',
			$cacheDir,
			$path,
			$thumbName
		);
		return $this->image($path, $options);
	}

}
