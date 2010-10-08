<?php
/**
 * A wrapper class for the PHPThumb Library
 */

App::import('Lib', 'PhpThumbFactory', array('file' => dirname(__FILE__).DS.'PHPThumb'.DS.'src'.DS.'ThumbLib.inc.php'));

class PHPThumbWrapper extends Folder {

	/**
	 * Processes the image according to $actions, saves and displays the generated thumbnail
	 *
	 * @param string $srcPath Absolute path to the source image
	 * @param string $dstPath Absolute path to the destination image
	 * @param string $fileType The fileType of the destination image (currently jpg, png or gif)
	 * @param array $actions Array of the actions with their parameters as described in the PHPThumb documentation: http://github.com/masterexploder/PHPThumb/wiki/GD-API
	 */
	function processImage($srcPath, $dstPath, $fileType, $actions) {

		$thumb = PhpThumbFactory::create($srcPath, Configure::read('ImageEditor.PHPThumb'));

		// Going through all the actions
		foreach ($actions as $action => $params) {
			if (is_array($params)) {
				$thumb->$action(@$params[0], @$params[1], @$params[3], @$params[4]);
			} else {
				$thumb->$action(@$params);
			}
		}

		// Creating the folder to store the thumbs
		Folder::create(dirname($dstPath), 0755);

		$thumb->save($dstPath, strtoupper($fileType));
		$thumb->show();
	}

}
