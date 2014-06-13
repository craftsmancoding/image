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

**Output:** full path to destination.

The crop area is specified in X-Y coordinates where 0,0 is located at the top left of the image. Use the `$ratio` attribute for 
compatibility with jCrop or other instances when the image is displayed at a size other than its actual size.

### Example

With cropping you need to adjust the parameters to find the area you are looking for.  Libraries like jCrop can be useful for doing
this visually.

    $x = 600; // from left
    $y = 300; // from top
    $w = 250; 
    $h = 325;
    \Craftsmancoding\Image::crop($src,$dst,$x,$y,$w,$h);

![Regular Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/A.jpg?raw=true "Regular Image")

Cropped area (250x325):

![Cropped](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/A.cropped.jpg?raw=true "Cropped Area")

### Example: Using a Ratio

The exact same crop as above could be performed using a multiplier `$ratio` of 2:

    $x = 300; // from left
    $y = 150; // from top
    $w = 125;
    $h = 163;
    $ratio = 2;
    Image::crop($src,$dst,$x,$y,$w,$h,$ratio);

The `$ratio` multiplier is useful when the image is not displayed at actual size.



-----------------

### scale (Scale to given dimensions)

**Syntax:** `scale(string $src, string $dst, int $new_w, int $new_h)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$new_w** : desired width of the new destination image (in pixels)
* **$new_h** : desired height of the new destination image (in pixels)

**Output:** full path to destination.

WARNING: This function may distort the aspect-ratio of the image.

#### Example: Stretch

    $src = '/path/to/image.jpg'; // e.g. 300x225
    $dst = '/path/to/stretched.jpg';
    \Craftsmancoding\Image::scale($src,$dst,400,100);

![Regular Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/E.jpg?raw=true "Regular Image")

Becomes stretched if you are not careful! 

![Thumbnail](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/E.distorted.jpg?raw=true "Distorted Aspect Ratio")

Use `scale2h` or `scale2w` if you are concerned about preserving the aspect ratio.


--------------

### scale2h (Scale to Height)

**Syntax:** `scale2h(string $src, string $dst, int $new_h)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$new_h** : desired height of the new destination image (in pixels)

**Output:** full path to destination.

The width will be scaled automatically to maintain the original aspect-ratio.

--------------

### scale2w (Scale to Width)

**Syntax:** `scale2w(string $src, string $dst, int $new_w)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$new_w** : desired width of the new destination image (in pixels)

**Output:** full path to destination.

The height will be scaled automatically to maintain the original aspect-ratio.

    $src = '/path/to/image.jpg'; // e.g. 300x225
    $dst = '/path/to/stretched.jpg';
    \Craftsmancoding\Image::scale2w($src,$dst,150);

![Regular Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/E.jpg?raw=true "Regular Image")

The height will be calculated automatically in order to preserve the aspect ratio:

![Width Scaled](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/E.150x112.jpg?raw=true "Correct Aspect Ratio")





--------------

### thumbnail

**Syntax:** `thumbnail(string $src, string $dst, int $w, int $h)`

* **$src** : full path to source image
* **$dst** : full path to destination image
* **$w** : width of thumbnail (in pixels)
* **$h** : height of thumbnail (in pixels)

**Output:** full path to destination.

The `thumbnail` function will perform a zoom and crop operation to best fit the thumb.  For more control, use the `crop` function.


#### Example: Thumbnail of Wide Image

    $src = '/path/to/wide.jpg';
    $dst = '/path/to/wide.thumb.jpg';
    \Craftsmancoding\Image::thumbnail($src,$dst,200,200);

![Wide Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/D.jpg?raw=true "Wide Image")

Becomes horizontally centered:

![Thumbnail](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/D.expected_thumb.jpg?raw=true "Thumbnail")


#### Example: Thumbnail of Tall Image

    $src = '/path/to/tall.jpg';
    $dst = '/path/to/tall.thumb.jpg';
    \Craftsmancoding\Image::thumbnail($src,$dst,200,200);

![Tall Image](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/C.jpg?raw=true "Wide Image")

Becomes vertically centered:

![Thumbnail](https://raw.githubusercontent.com/craftsmancoding/image/master/tests/assets/C.expected_thumb.jpg?raw=true "Thumbnail")

