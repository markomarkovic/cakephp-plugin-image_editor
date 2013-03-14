<?php
class ImagesController extends AppController {

	var $name = 'Images';
	var $uses = array();
	var $components = array('ImageEditor.ImageEditor');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('show');
	}

	/**
	 * Calls the ImageEditor to generate the Thumb
	 */
	public function show() {
		$this->autoRender = false;

		$this->ImageEditor->processImage($this->request->query['imageURL']);
	}

}
