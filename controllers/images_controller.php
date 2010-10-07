<?php

App::import('Lib', 'ImageEditor.ImageEditor');

class ImagesController extends AppController {

	var $name = 'Images';
	var $uses = array();

	/**
	 * Calls the ImageEditor to generate the Thumb
	 */
	public function show() {
		$this->autoRender = false;

		$ie = new ImageEditor;
		$ie->processImage($this->params['url']['imageURL']);
	}

}
