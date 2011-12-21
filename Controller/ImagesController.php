<?php
class ImagesController extends AppController {

	var $name = 'Images';
	var $uses = array();
	var $components = array('ImageEditor.ImageEditor');

	/**
	 * Calls the ImageEditor to generate the Thumb
	 */
	public function show() {
		$this->autoRender = false;

		$this->ImageEditor->processImage($this->request->params['url']['imageURL']);
	}

}
