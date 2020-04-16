<?php
declare(strict_types=1);
namespace Alderley;

use AlderleyPHP\AlderleyUtility;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testGeneratePassword()
    {
        $passwordLength = 32;
        $password = AlderleyUtility::generatePassword($passwordLength);
        $this->assertSame($passwordLength, strlen($password));
    }

    public function testReadConfiguration()
    {
        $configuration = AlderleyUtility::getConfiguration('test.ini');
        $this->assertTrue(!empty($configuration));
    }

    public function testGetConfigurationKey()
    {
        $configuration = AlderleyUtility::getConfiguration('test.ini');
        $this->assertSame('test_value', $configuration['test_key']);
    }

    public function testGetDatabase()
    {
        $dbh = AlderleyUtility::getDatabase('pgsql:dbname=alderley-tests', 'user');
        $this->assertTrue(!empty($dbh));
        $dbh = null;
    }

    public function testResizeImage()
    {
        $resizedImage = AlderleyUtility::resizeImage('test.jpg', 'test_resized', 20, 50);
        $imageSize = getimagesize('test_resized');
        $this->assertSame(20, $imageSize[0]);
    }

    public function testThumbnailImage()
    {
        $thumbnailImage = AlderleyUtility::thumbnailImage('test.jpg', 'test_thumbnail', 20, 20);
        $imageSize = getimagesize('test_thumbnail');
        $this->assertSame(20, $imageSize[0]);
    }

    public function testSanitizeInput()
    {
        $inputString = '<html> tags and #$&^%-=/\ symbols.';
        $sanitizedInput = AlderleyUtility::sanitizeInput($inputString);
        $controlSanitizedInput = htmlspecialchars(stripslashes(trim($inputString)));
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testSanitizeString()
    {
        $inputString = '<html> tags and #$&^%-=/\ symbols.';
        $sanitizedInput = AlderleyUtility::sanitizeString($inputString);
        $controlSanitizedInput = htmlspecialchars(stripslashes(trim($inputString)));
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testSanitizeInteger()
    {
        $inputInteger = '/4#3$2%8.9!0@1';
        $sanitizedInput = AlderleyUtility::sanitizeInteger($inputInteger);
        $controlSanitizedInput = '4328901';
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testSanitizeEmail()
    {
        $inputString = 'te(st)@te//st.com';
        $sanitizedInput = AlderleyUtility::sanitizeEmail($inputString);
        $controlSanitizedInput = 'test@test.com';
        $this->assertSame($controlSanitizedInput, $sanitizedInput);
    }

    public function testGetPaginationOffset()
    {
        $page = 3;
        $paginationOffset = AlderleyUtility::getPaginationOffset($page);
        $this->assertSame(18, $paginationOffset);
    }

    public function testCreateSlug()
    {
        $input = 'This#@!#$%^& i*()s?$/ an< example !slug';
        $slug = AlderleyUtility::createSlug($input);
        $this->assertSame('this-is-an-example-slug', $slug);
    }
}
