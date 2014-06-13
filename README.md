Image
=====

Framework agnostic image manipulation library, Imagick not required. Scale and crop images, create thumbnails et al...

This library offers a clean interface for using PHP image manipulation functions.  It was created to provide a 
unified interface between various projects on various platforms and environments (some without Imagick).

### Supported Functions

* **crop** : crop an image
* **scale** : scale an image to a new height and width.
* **scale2h** : scale an image to a new height while preserving the aspect ratio
* **scale2w** : scale an image to a new width while preserving the aspect ratio
* **thumbnail** : create a thumbnail with specified dimensions, zooming and cropping.
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

## Syntax

All the functions in this library class are meant to be called statically -- no instantiation is required and no class variables
persist.  No object oriented stuff here.

--------------

### Crop (crop)

**Syntax:** `crop(string $src, string $dst,int $x, int $y,int $w, int $h, number $ratio=1)`

* **$src** : full path to source image
* **$dst** : full path to destination
* **$x** : x-coordinate for start of crop area (0 = left)
* **$y** : y-coordinate for start of crop area (0 = top)
* **$w** : width of crop area (in pixels)
* **$h** : height of crop area (in pixels)
* **$ratio** : multiplier of actual-width/displayed-width. Useful if the image was displayed less than actual size.

The crop area is specified in X-Y coordinates where 0,0 is located at the top left of the image. Use the `$ratio` attribute for 
compatibility with jCrop or other instances when the image is displayed at a size other than its actual size.

### Example


-----------------

### scale (Scale to given dimensions)

**Syntax:** `scale(string $src, string $dst, int $new_w, int $new_h)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$new_w** : desired width of the new destination image (in pixels)
* **$new_h** : desired height of the new destination image (in pixels)

WARNING: This function may distort the aspect-ratio of the image.

--------------

### scale2h (Scale to Height)

**Syntax:** `scale2h(string $src, string $dst, int $new_h)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$new_h** : desired height of the new destination image (in pixels)

The width will be scaled automatically to maintain the original aspect-ratio.

--------------

### scale2w (Scale to Width)

**Syntax:** `scale2w(string $src, string $dst, int $new_w)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$new_w** : desired width of the new destination image (in pixels)

The height will be scaled automatically to maintain the original aspect-ratio.

--------------

### thumbnail

**Syntax:** `thumbnail(string $src, string $dst, int $w, int $h)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$w** : width of thumbnail (in pixels)
* **$h** : height of thumbnail (in pixels)

The `thumbnail` function will perform a zoom operation and center on the axis which requires cropping.


#### Example: Wide Image

    $src = '/path/to/wide.jpg';
    $dst = '/path/to/wide.thumb.jpg';
    \Craftsmancoding\Image::thumbnail($src,$dst,200,200);

![Wide Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/D.jpg?raw=true "Wide Image")

Becomes horizontally centered:

![Thumbnail](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/D.expected_thumb.jpg?raw=true "Thumbnail")


#### Example: Tall Image

    $src = '/path/to/tall.jpg';
    $dst = '/path/to/tall.thumb.jpg';
    \Craftsmancoding\Image::thumbnail($src,$dst,200,200);

![Tall Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/C.jpg?raw=true "Wide Image")

Becomes vertically centered:

![Thumbnail](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/C.expected_thumb.jpg?raw=true "Thumbnail")

