Image
=====

Framework agnostic image manipulation library, Imagick not required. Scale and crop images, create thumbnails.

This library offers a clean interface for using PHP image manipulation functions.  It was created to provide a 
unified interface between various projects on various platforms and environments (some without Imagick).

### Supported Functions

* *crop* : crop an image
* *scale* : scale an image to a new height and width.
* *scale2h* : scale an image to a new height while preserving the aspect ratio
* *scale2w* : scale an image to a new width while preserving the aspect ratio
* *thumbnail* : create a thumbnail with specified dimensions, zooming and cropping.
* ... more coming...

----------------------

## Usage

### Composer 

To use this library in your projects, reference the library in your `composer.json`'s "require" node:

    "require": {
        "craftsmancoding/image": "dev-master"
    }

The run `composer install` or `composer update`.

Inclusion via Composer is the recommended way of utilizing this library.


### Without Composer

To use this library without composer, download the Image.php class and require it.
Call functions statically. 


    require_once 'path/to/Image.php';
    
    \Craftsmancoding\Image::scale2h('/path/to/img.jpg', '/path/to/new.jpg', 100);


If you are using namespaces (e.g. inside a class), the calls might look like this:

    
    require_once 'path/to/Image.php';
    use Craftsmancoding;
    
    class MyClass {
        public function my_method() {
            Image::scale2h('/path/to/img.jpg', '/path/to/new.jpg', 100);
        }
    }
    

    
--------------------

## Examples


### Crop (crop)

### Scale (scale)

### Scale to Height (scale2h)

### Scale to Width (scale2w)
