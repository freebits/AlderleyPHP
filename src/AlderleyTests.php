<?php declare(strict_types=1);
include_once("Alderley.php");
use PHPUnit\Framework\TestCase;
final class AlderleyTest extends TestCase
{
/*    public function testCheckAuth(): void
    {
        Alderley::checkAuth();
        $this->assertEquals(401, http_response_code());
    }

    public function testLogIn(): void
    {
        Alderley::logIn();
        $this->assertTrue($_SESSION['auth']);
    }

    public function testLogOut(): void
    {
        Alderley::logOut();
        $this->assertTrue(empty($_SESSION['auth']));
    }
*/
    public function testGeneratePassword(): void 
    {
        $password_length = 32;
        $password = Alderley::generatePassword($password_length);
        $this->assertEquals($password_length, strlen($password));
    }

    public function testReadConfiguration(): void
    {
        $configuration = Alderley::getConfiguration('test.ini');
        $this->assertTrue(!empty($configuration)); 
    }

    public function testGetConfigurationKey(): void
    {
        $configuration = Alderley::getConfiguration('test.ini');
        $this->assertEquals('test_value', $configuration['test_key']); 
    }

    public function testGetDatabase(): void 
    {
        $dbh = Alderley::getDatabase('pgsql:dbname=alderley-tests', 'user');
        $this->assertTrue(!empty($dbh));
        $dbh = NULL;
    }

    public function testResizeImage(): void {
        $resized_image = Alderley::resizeimage('./src/test.jpg', 'test_resized', 50, 20);
        $this->assertTrue(file_exists('test_resized'));
    }

    public function testThumbnailImage(): void
    {
        $thumbnailImage = Alderley::thumbnailImage('./src/test.jpg', 'test_thumbnail', 20, 20);
        $imageSize = getimagesize('test_thumbnail');
        $this->assertEquals(20, $imageSize[0]);
    }

    public function sanitize_input(): void
    {
        $input_string = "<html> tags and #$&^%-=/\ symbols.";
        $sanitized_input = Alderley::sanitizeInput($input_string);
        $control_sanitized_input = htmlspecialchars(stripslashes(trim($input_string)));
        $this->assertEquals($control_sanitized_input, $sanitized_input);
    }
} 

?>
