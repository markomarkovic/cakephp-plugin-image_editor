<?php
class ImageHelper extends AppHelper {

	var $helpers = array('Html');

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
	public function show($path, $options = array(), $editActions = array()) {
		return $this->Html->image($this->src($path, $editActions), $options);
	}

	/**
	 * Creates a path to the transformed image.
	 *
	 * ### Usage
	 *
	 * Create a resized image:
	 *
	 * `echo $this->Image->src('cake_icon.png', array('adaptiveResize' => array(200, 200)));`
	 *
	 * Create a rotated, then resized image:
	 *
	 * `echo $this->Image->show('cake_icon.png', array(rotateImageNDegrees' => array(-60), 'adaptiveResize' => array(200, 200)));`
	 *
	 * @param string $path Path to the image file, relative to the app/webroot/ directory.
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
	 * @return string img src
	 * @access public
	 */
	public function src($path, $editActions = array())
	{
		if (!$cacheDir = Configure::read('ImageEditor.cacheDir')) {
			trigger_error(__d('image_editor', 'ImageEditor.cacheDir is not defined.'), E_USER_ERROR);
		}
		$thumbName = base64_encode(json_encode($editActions)).'.'.pathinfo($path, PATHINFO_EXTENSION);
		if (strlen($thumbName) > 254) {
			trigger_error(__d('image_editor', 'Filename is too long for most Filesystems. Use less editActions.'), E_USER_WARNING);
		}
		$path = sprintf('/%s/%s/%s',
			$cacheDir,
			$path,
			$thumbName
		);

		return str_replace('://', 'COLON_SLASH_SLASH', $path); // For remote images
	}

}

