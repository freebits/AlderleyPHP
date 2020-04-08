<?php
require_once("Alderley.php");
use PHPUnit\Framework\TestCase;

class AlderleyTest extends TestCase
{
    public function testGeneratePassword() 
    {
        $password_length = 32;
        $password = Alderley::generatePassword($password_length);
        $this->assertSame($password_length, strlen($password));
    }

    public function testReadConfiguration()
    {
        $configuration = Alderley::getConfiguration('test.ini');
        $this->assertTrue(!empty($configuration)); 
    }

    public function testGetConfigurationKey()
    {
        $configuration = Alderley::getConfiguration('test.ini');
        $this->assertSame('test_value', $configuration['test_key']); 
    }

    public function testGetDatabase() 
    {
        $dbh = Alderley::getDatabase('pgsql:dbname=alderley-tests', 'user');
        $this->assertTrue(!empty($dbh));
        $dbh = NULL;
    }

    public function testResizeImage() {
        $resized_image = Alderley::resizeimage('./src/test.jpg', 'test_resized', 50, 20);
        $this->assertTrue(file_exists('test_resized'));
    }

    public function testThumbnailImage()
    {
        $thumbnailImage = Alderley::thumbnailImage('./src/test.jpg', 'test_thumbnail', 20, 20);
        $imageSize = getimagesize('test_thumbnail');
        $this->assertSame(20, $imageSize[0]);
    }

    public function sanitize_input()
    {
        $input_string = "<html> tags and #$&^%-=/\ symbols.";
        $sanitized_input = Alderley::sanitizeInput($input_string);
        $control_sanitized_input = htmlspecialchars(stripslashes(trim($input_string)));
        $this->assertSame($control_sanitized_input, $sanitized_input);
    }
} 

?>
