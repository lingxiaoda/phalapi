<?php
/**
 * PhpUnderControl_PhalApiRequestFormatterFile_Test
 *
 * 针对 ../../../PhalApi/Request/Formatter/File.php PhalApi_Request_Formatter_File 类的PHPUnit单元测试
 *
 * @author: dogstar 20160101
 */

require_once dirname(__FILE__) . '/../../test_env.php';

if (!class_exists('PhalApi_Request_Formatter_File')) {
    require dirname(__FILE__) . '/../../../PhalApi/Request/Formatter/File.php';
}

class PhpUnderControl_PhalApiRequestFormatterFile_Test extends PHPUnit_Framework_TestCase
{
    public $phalApiRequestFormatterFile;

    protected function setUp()
    {
        parent::setUp();

        $this->phalApiRequestFormatterFile = new PhalApi_Request_Formatter_File();
    }

    protected function tearDown()
    {
    }


    /**
     * @group testParse
     */ 
    public function testParse()
    {
        $value = array();

        $_FILES['aFile'] = array('name' => 'aHa~', 'type' => 'image/jpeg', 'size' => 100, 'tmp_name' => '/tmp/123456', 'error' => 0);

        $rule = array('name' => 'aFile', 'range' => array('image/jpeg'), 'min' => 50, 'max' => 1024, 'require' => true, 'default' => array(), 'type' => 'file');

        $rs = $this->phalApiRequestFormatterFile->parse($value, $rule);
    }

    /**
     * @dataProvider provideFileForSuffix
     */
    public function testSuffixSingleInArray($fileIndex, $fileData)
    {
        $_FILES[$fileIndex] = $fileData;
        $value = array();

        $rule = array(
            'name' => $fileIndex, 
            'require' => true, 
            'default' => array(), 
            'suffix' => array('txt'),
            'type' => 'file',
        );
        $rs = $this->phalApiRequestFormatterFile->parse($value, $rule);
    }

    /**
     * @dataProvider provideFileForSuffix
     */
    public function testSuffixSingleInString($fileIndex, $fileData)
    {
        $_FILES[$fileIndex] = $fileData;
        $value = array();

        $rule = array(
            'name' => $fileIndex, 
            'require' => true, 
            'default' => array(), 
            'suffix' => 'txt',
            'type' => 'file',
        );
        $rs = $this->phalApiRequestFormatterFile->parse($value, $rule);
    }

    /**
     * @dataProvider provideFileForSuffix
     */
    public function testSuffixMultiInArray($fileIndex, $fileData)
    {
        $_FILES[$fileIndex] = $fileData;
        $value = array();

        $rule = array(
            'name' => $fileIndex, 
            'require' => true, 
            'default' => array(), 
            'suffix' => array('TXT', 'dat', 'bak'),
            'type' => 'file',
        );
        $rs = $this->phalApiRequestFormatterFile->parse($value, $rule);
    }

    /**
     * @dataProvider provideFileForSuffix
     */
    public function testSuffixSingleInMulti($fileIndex, $fileData)
    {
        $_FILES[$fileIndex] = $fileData;
        $value = array();

        $rule = array(
            'name' => $fileIndex, 
            'require' => true, 
            'default' => array(), 
            'suffix' => 'txt, DAT, baK',
            'type' => 'file',
        );
        $rs = $this->phalApiRequestFormatterFile->parse($value, $rule);
    }

    /**
     * @dataProvider provideFileForSuffix
     * @expectedException PhalApiApi_Exception_BadRequest
     */
    public function testSuffixMultiInArrayAndExcpetion($fileIndex, $fileData)
    {
        $_FILES[$fileIndex] = $fileData;
        $value = array();

        $rule = array(
            'name' => $fileIndex, 
            'require' => true, 
            'default' => array(), 
            'suffix' => array('XML', 'HTML'),
            'type' => 'file',
        );
        $rs = $this->phalApiRequestFormatterFile->parse($value, $rule);
    }

    public function provideFileForSuffix()
    {
        $aFile = array(
            'name' => '2016.log.txt', 
            'type' => 'application/text', 
            'size' => 100, 
            'tmp_name' => '/tmp/123456', 
            'error' => 0
        );

        return array(
            array('aFile', $aFile),
        );
    }
}
