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

    }


    /**
     * Can we make good thumbnails?
     *
     */
    public function testThumbnail() {
        // prep
        $src = dirname(__FILE__).'/assets/support.jpg'; 
        $dst = dirname($src).'/thumbs/'.basename($src);
        if (file_exists($dst)) {
            unlink($dst);        
        }

        $this->assertFalse(file_exists($dst));
              
        $result = Image::scale2w($src,$dst,112);
        
        $this->assertTrue(file_exists($dst));
        $this->assertEquals($result,$dst);
        
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],112);
        
        if (file_exists($dst)) {
            unlink($dst);        
        }        
    }

    /**
     * Test with a different dimension
     */
    public function testThumbnail2() {
        // prep
        $src = dirname(__FILE__).'/assets/support.jpg'; 
        $dst = dirname($src).'/thumbs/'.basename($src);
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
     * Test with yet another dimension and compare signatures
     */
    public function testThumbnail3() {
        // prep
        $src = dirname(__FILE__).'/assets/support.jpg'; 
        $dst = dirname($src).'/thumbs/'.basename($src);
        if (file_exists($dst)) {
            unlink($dst);        
        }

        $this->assertFalse(file_exists($dst));
              
        $result = Image::scale2w($src,$dst,222);
        
        $this->assertTrue(file_exists($dst));
        $this->assertEquals($result,$dst);
        
        $info = getimagesize($result);
        $this->assertFalse(empty($info));
        $this->assertEquals($info[0],222);

        $actual_sig = md5_file($result);
        $expected_sig = md5_file(dirname(__FILE__).'/assets/222.support.jpg');
        $this->assertEquals($actual_sig,$expected_sig);
                
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
     * @expectedExceptionMessage file_exists() expects parameter 1 to be a valid path, array given
     */
    public function testCropExceptions2() {
        $result = Image::crop(array('junk'),'ignore',0,0,100,100);
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
        $src = dirname(__FILE__).'/assets/support.jpg'; 
        $result = Image::crop($src,'/can/not/write/here.jpg',0,0,100,100);
    }
    
    /**
     *
     *
     */
    public function testCrop() {
        $src = dirname(__FILE__).'/assets/macbook_pro.jpg'; 
        $dst = dirname(__FILE__).'/assets/cropped.macbook_pro.jpg';
        if (file_exists($dst)) {
            unlink($dst);        
        }        
        $x = 0;
        $y = 0;
        $w = 640;
        $h = 478;
        $result = Image::crop($src,$dst,$x,$y,$w,$h);
        $actual_sig = md5_file($result);
        $expected_sig = md5_file(dirname(__FILE__).'/assets/topleft.macbook_pro.jpg');
        $this->assertEquals($actual_sig,$expected_sig);
        
        if (file_exists($result)) {
            unlink($result);        
        }
    }
    
    public function testRealThumb() {
        $src = dirname(__FILE__).'/assets/macbook_pro.jpg'; 
        $dst = dirname(__FILE__).'/assets/thumb.macbook_pro.jpg';
        $actual_dst = dirname(__FILE__).'/assets/thumb2.macbook_pro.jpg';
        $tmp = 'thumb.macbook_pro.jpg';
        if (file_exists($dst)) {
            unlink($dst);        
        }        
        $result = Image::thumbnail($src,$dst,300,150);

        $actual_sig = md5_file($actual_dst);
        $expected_sig = md5_file($dst);
        $this->assertEquals($actual_sig,$expected_sig);
        if (file_exists($dst)) {
            unlink($dst);        
        }        

    }
    
}