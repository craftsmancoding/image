<?php
/**
 * Before running these tests, you must install the package using Repoman
 * and seed the database with the test data!
 *
 *  php repoman.php install /path/to/repos/moxycart '--seed=base,test'
 * 
 * That will ensure that the database tables contain the correct test data. 
 * If you need to create more test data, make sure you add the appropriate 
 * arrays to the model/seeds/test directory (either manually or via repoman's
 * export command).
 *
 * To run these tests, pass the test directory as the 1st argument to phpunit:
 *
 *   phpunit path/to/moxycart/core/components/moxycart/tests
 *
 * or if you're having any trouble running phpunit, download its .phar file, and 
 * then run the tests like this:
 *
 *  php phpunit.phar path/to/moxycart/core/components/moxycart/tests
 *
 *
 */
namespace Craftsmancoding;
class imageTest extends \PHPUnit_Framework_TestCase {

    
    /**    
     *
     */
    public static function setUpBeforeClass() {        
        require_once dirname(dirname(__FILE__)).'/src/Image.php';
    }


    /**
     * Can we make good thumbnails?
     *
     */
    public function testScaleToWidth() {
        // prep
        $src = dirname(__FILE__).'/assets/A.jpg'; 
        $dst = dirname(__FILE__).'/assets/A.512x410.jpg';
        if (file_exists($dst)) {
            unlink($dst);        
        }

        $this->assertFalse(file_exists($dst));
              
        $result = Image::scale2w($src,$dst,512);
        
        $this->assertTrue(file_exists($dst));
        $this->assertEquals($result,$dst);
        
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],512);
        
        if (file_exists($dst)) {
            unlink($dst);        
        }        
    }

    /**
     * Test with a different dimension
     */
    public function testScaleToWidth2() {
        // prep
        $src = dirname(__FILE__).'/assets/B.jpg'; 
        $dst = dirname(__FILE__).'/assets/B.100x75.jpg'; 
        if (file_exists($dst)) {
            unlink($dst);        
        }

        $this->assertFalse(file_exists($dst));
              
        $result = Image::scale2w($src,$dst,100);
        
        $this->assertTrue(file_exists($dst));
        $this->assertEquals($result,$dst);
        
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],100);
                
        if (file_exists($dst)) {
            unlink($dst);        
        } 
    }


    


    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage File not found
     */
    public function testCropExceptions() {
        $result = Image::crop('/does/not/exist','ignore',0,0,100,100);

    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage File not found
     */
    public function testCropExceptions2() {
        $result = Image::crop('junk','ignore',0,0,100,100);
    }

    /**
     * This should fail when you use a php file.
     *
     * @expectedException        \Exception
     * @expectedExceptionMessage Could not read image
     */
    public function testCropExceptions3() {
        $result = Image::crop(__FILE__,'ignore',0,0,100,100);
    }

    /**
     *
     * @expectedException        \Exception
     * @expectedExceptionMessage Failed to create directory
     */
    public function testCropExceptions4() {
        $src = dirname(__FILE__).'/assets/B.jpg'; 
        $result = Image::crop($src,'/can/not/write/here.jpg',0,0,100,100);
    }
    
    /**
     *
     *
     */
    public function testBasicCrop() {
        $src = dirname(__FILE__).'/assets/A.jpg'; 
        $dst = dirname(__FILE__).'/assets/A.expected_topleft.jpg';
        if (file_exists($dst)) {
            unlink($dst);        
        }        
        $x = 0;
        $y = 0;
        $w = 512;
        $h = 410;
        $result = Image::crop($src,$dst,$x,$y,$w,$h);

        // Test height and width
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],512);
        $this->assertEquals($info[1],410);

        // Test signature
        $actual_sig = md5_file($result);
        $expected_sig = md5_file(dirname(__FILE__).'/assets/A.topleft.jpg');
        $this->assertEquals($actual_sig,$expected_sig);
        
        if (file_exists($result)) {
            unlink($result);        
        }

    }


    
    public function testThumbnailofTallImage() {
        $src = dirname(__FILE__).'/assets/C.jpg'; 
        $expected_dst = dirname(__FILE__).'/assets/C.expected_thumb.jpg';
        $actual_dst = dirname(__FILE__).'/assets/C.actual_thumb.jpg';

        if (file_exists($actual_dst)) {
            unlink($actual_dst);        
        }        
        $result = Image::thumbnail($src,$actual_dst,200,200);
        // Test height and width
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],200);
        $this->assertEquals($info[1],200);
        
        // Test signature
        $actual_sig = md5_file($actual_dst);
        $expected_sig = md5_file($expected_dst);
        $this->assertEquals($actual_sig,$expected_sig);
        
        if (file_exists($actual_dst)) {
            unlink($actual_dst);        
        }        
    }

    public function testThumbnailofWideImage() {
        $src = dirname(__FILE__).'/assets/D.jpg'; 
        $expected_dst = dirname(__FILE__).'/assets/D.expected_thumb.jpg';
        $actual_dst = dirname(__FILE__).'/assets/D.actual_thumb.jpg';

        if (file_exists($actual_dst)) {
            unlink($actual_dst);        
        }        
        $result = Image::thumbnail($src,$actual_dst,200,200);
        // Test height and width
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],200);
        $this->assertEquals($info[1],200);
        
        // Test signature
        $actual_sig = md5_file($actual_dst);
        $expected_sig = md5_file($expected_dst);
        $this->assertEquals($actual_sig,$expected_sig);
        
        if (file_exists($actual_dst)) {
            unlink($actual_dst);        
        }        
    }
    
    public function testDistort() {
         // prep
        $src = dirname(__FILE__).'/assets/E.jpg'; 
        $dst = dirname(__FILE__).'/assets/E.400x100.jpg';
        if (file_exists($dst)) {
            unlink($dst);        
        }

        $this->assertFalse(file_exists($dst));
              
        $result = Image::scale($src,$dst,400,100);
        
        $this->assertTrue(file_exists($dst));
        $this->assertEquals($result,$dst);
        
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],400);
        $this->assertEquals($info[1],100);
                
        if (file_exists($dst)) {
            unlink($dst);        
        }        
   
    }


    public function testRotateCW() {
         // prep
        $src = dirname(__FILE__).'/assets/rotate90.jpg';   
        $info_before = getimagesize($src);  
        $result = Image::rotateCW($src,90);
        $this->assertTrue(file_exists($src));
        $this->assertEquals($result,$src);
        $info_after = getimagesize($result);
        $this->assertNotEquals($info_before[3],$info_after[3]);
    }
 
/*
     public function testX() {
        $src = dirname(__FILE__).'/assets/A.jpg'; 
        $dst = dirname(__FILE__).'/assets/A.crop2.jpg';
        if (file_exists($dst)) {
            unlink($dst);        
        }        
        $x = 300; // from left
        $y = 150; // from top
        $w = 125;
        $h = 163;
        $result = Image::crop($src,$dst,$x,$y,$w,$h,2);

        
        if (file_exists($result)) {
//            unlink($result);        
        }
    }
*/
    
}