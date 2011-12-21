<?php

Configure::write('ImageEditor.cacheDir', 'thumbs'); // The folder (under WWW_ROOT) that's going to contain all the processed images.
Configure::write('ImageEditor.library', 'PHPThumb'); // The image processing library
Configure::write('ImageEditor.defaultImage', App::pluginPath('ImageEditor').DS.'webroot'.DS.'img'.DS.'no_image.png'); // Optional: The default image that's going to be used if the source image is not available (full path)

/**
 * PHPThumb Options
 * @see http://github.com/masterexploder/PHPThumb/wiki/Getting-Started
 */
Configure::write('ImageEditor.PHPThumb.resizeUp', true);
Configure::write('ImageEditor.PHPThumb.jpegQuality', 90);
// Configure::write('ImageEditor.PHPThumb.correctPermissions', false);
// Configure::write('ImageEditor.PHPThumb.preserveAlpha', true);
// Configure::write('ImageEditor.PHPThumb.alphaMaskColor', array(255, 255, 255));
// Configure::write('ImageEditor.PHPThumb.preserveTransparency', true);
// Configure::write('ImageEditor.PHPThumb.transparencyMaskColor', array(255, 255, 255));
