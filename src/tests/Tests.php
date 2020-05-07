<?php
declare(strict_types=1);

use AlderleyPHP\Core;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testGeneratePassword()
    {
        $passwordLength = 32;
        $password = Core::generatePassword($passwordLength);
        $this->assertSame($passwordLength, strlen($password));
    }

    public function testReadConfiguration()
    {
        $configuration = Core::getConfiguration('test.ini');
        $this->assertTrue(!empty($configuration));
    }

    public function testGetConfigurationKey()
    {
        $configuration = Core::getConfiguration('test.ini');
        $this->assertSame('test_value', $configuration['test_key']);
    }

    public function testGetDatabase()
    {
        $dbh = Core::getDatabase('pgsql:dbname=alderley-tests', 'user');
        $this->assertTrue(!empty($dbh));
        $dbh = null;
    }

    public function testResizeImage()
    {
        $resizedImage = Core::resizeImage('test.jpg', 'test_resized', 20, 50);
        $imageSize = getimagesize('test_resized');
        $this->assertSame(20, $imageSize[0]);
    }

    public function testThumbnailImage()
    {
        $thumbnailImage = Core::thumbnailImage('test.jpg', 'test_thumbnail', 20, 20);
        $imageSize = getimagesize('test_thumbnail');
        $this->assertSame(20, $imageSize[0]);
    }

    public function testSanitizeInput()
    {
        $inputString = '<html> tags and #$&^%-=/\ symbols.';
        $sanitizedInput = Core::sanitizeInput($inputString);
        $controlSanitizedInput = htmlspecialchars(stripslashes(trim($inputString)));
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testSanitizeString()
    {
        $inputString = '<html> tags and #$&^%-=/\ symbols.';
        $sanitizedInput = Core::sanitizeString($inputString);
        $controlSanitizedInput = htmlspecialchars(stripslashes(trim($inputString)));
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testSanitizeInteger()
    {
        $inputInteger = '/4#3$2%8.9!0@1';
        $sanitizedInput = Core::sanitizeInteger($inputInteger);
        $controlSanitizedInput = '4328901';
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testSanitizeEmail()
    {
        $inputString = 'te(st)@te//st.com';
        $sanitizedInput = Core::sanitizeEmail($inputString);
        $controlSanitizedInput = 'test@test.com';
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testGetPaginationOffset()
    {
        $page = 3;
        $paginationOffset = Core::getPaginationOffset($page);
        $this->assertSame(18, $paginationOffset);
    }

    public function testCreateSlug()
    {
        $input = 'This#@!#$%^& i*()s?$/ an< example !slug';
        $slug = Core::createSlug($input);
        $this->assertSame('this-is-an-example-slug', $slug);
    }
}
