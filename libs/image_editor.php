<?php
class ImageEditor {

	var $lib = null;
	var $cacheDir = null;

	function __construct() {
		if (!isset($this->lib)) {
			if (!$library = Configure::read('ImageEditor.library')) {
				trigger_error(__d('image_editor', 'ImageEditor.library is not defined.', true), E_USER_ERROR);
			}
			$library .= 'Wrapper';

			App::import('Lib', 'ImageEditor.'.$library);
			$this->lib = new $library;
		}
	}

	/**
	 * Decodes the imageURL and invokes the wrapper to process the image.
	 *
	 * @param string $imageURL a well-defined (from ImageHelper::show) URL with all the info needed
	 */
	function processImage($imageURL) {
		if (!$this->cacheDir = Configure::read('ImageEditor.cacheDir')) {
			trigger_error(__d('image_editor', 'ImageEditor.cacheDir is not defined.', true), E_USER_ERROR);
		}

		$info = pathinfo($imageURL);
		$srcPath = WWW_ROOT . $info['dirname'];
		$dstPath = sprintf('%s%s/%s/%s.%s',
			WWW_ROOT,
			$this->cacheDir,
			$info['dirname'],
			$info['filename'],
			$info['extension']
		);
		$fileType = $info['extension'];
		$actions = json_decode(base64_decode($info['filename']));

		$this->lib->processImage($srcPath, $dstPath, $fileType, $actions);
	}

}
