# CakePHP Image Editor plugin

## Instalation and configuration

First download or checkout the code for the ImageEditor and for the [PHPThumb][1]. Put the PHPThumb folder inside image_editor/libs and put the image_editor in your app/plugins directory. The directory structure should look like this:

    /app
       /plugins
          /image_editor
             /config
             /controllers
             /libs
                /PHPThumb
                   /src
             /views

In order to start using it, you'll need to tweak a few files:

####Bootstrap

First you'll need to configure some ImageEditor options. You can either include the */app/plugins/image_editor/config/bootstrap.php* file from your */app/config/bootstrap.php* file:

    ...
    // ImageEditor configuration
    require APP.'plugins'.DS.'image_editor'.DS.'config'.DS.'bootstrap.php';
    ...
or put the code from it directly into your bootstrap:

    ...
    Configure::write('ImageEditor.cacheDir', 'thumbs'); // The folder (under WWW_ROOT) that's going to contain all the processed images.
    Configure::write('ImageEditor.library', 'PHPThumb'); // The image processing library

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
    ...

#### .htaccess

Then, you'll need to add following code to your */app/webroot/.htaccess* file:

	<IfModule mod_rewrite.c>
		RewriteEngine On

    # Thumbnails
    # If thumb is not found, we'll try to create it through the image_editor plugin
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^thumbs/(.*?)$ image_editor/images/show/?imageURL=$1 [QSA,L]
    #   Attention!   ^^^^^^ this should be the same as ImageEditor.cacheDir configuration option.
    #   Don't forget to create this directory and make it writeable.

    ### Cake default
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
    </IfModule>

After that, you'll need to create and make writeable the **ImageEditor.cacheDir** directory and you're ready to start using the plugin!


## Usage

Add the **ImageEditor.image** to the $helpers you're using:

    ...
    $helpers = array('Html', 'ImageEditor.Image');
    ...

In your views, use the helper to generate IMG tag:

    ...
    <?php echo $this->Image->show('/img/cake.icon.png', array('width' => 200, 'height' => 200, 'alt' => 'Upside down cake', 'url' => 'http://www.youtube.com/watch?v=FuA8K1mQWMc'), array('rotateImageNDegrees' => 180, 'adaptiveResize' => array(300, 300))); ?>
    ...

And that's it!

If the file is updated, you simply delete the folder with its thumbnails and they are going to be regenerated on next access.

## How it works?

 The helper generates, using this code for example:

    <?php echo $this->Image->show('/img/cake.icon.png', array('width' => 200, 'height' => 200, 'alt' => 'Upside down cake'), array('rotateImageNDegrees' => 120, 'adaptiveResize' => array(300, 300))); ?>

  a IMG tag that looks like this:

    <img src="http://cms/thumbs/img/cake.icon.png/eyJyb3RhdGVJbWFnZU5EZWdyZWVzIjoxMjAsImFkYXB0aXZlUmVzaXplIjpbMzAwLDMwMF19.png" width="200" height="200" alt="Upside down cake" />

Because of the rules in the .htaccess file, if the file exists, web server is simply going to serve it so the image generation is not triggered. If it's not there, the plugin controller is called. The string *eyJyb3RhdGVJbWFnZU5EZWdyZWVzIjoxMjAsImFkYXB0aXZlUmVzaXplIjpbMzAwLDMwMF19* is decoded to

    stdClass Object
    (
        [rotateImageNDegrees] => 120
        [adaptiveResize] => Array
            (
                [0] => 300
                [1] => 300
            )
    )

and those actions with other parameters are passed to ImageEditor which generates the thumbnail, saves it to the target file and serves it.

## Licence

Released under The MIT License

[1]: http://phpthumb.gxdlabs.com/
