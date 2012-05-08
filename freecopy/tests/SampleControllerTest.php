<?php

/**
 * Test class for controllers/sample.php
 *
 * @author     Carlo Guli
 *
 * @since      18/04/2011
 */

require_once 'CITestCaseExtension.php';

class SampleControllerTest extends CITestCaseExtension {

	protected static $sql = "
		DELETE FROM `shema`.`table` WHERE `ID` = 1;
		INSERT INTO `shema`.`table`
			(`ID`, `dateCreated`, `dateRequired`,) VALUES
			(1, 1207063610, 1207668410);
	";

	public static function setUpBeforeClass() {
		echo "\n".__CLASS__;
		self::_setValidState();
		self::_setDBState(self::$sql);
		self::_setUpCI('sample');
    }

	protected static function _setValidState() {
		$_POST['orderRef'] = '1';
	}

    public static function tearDownAfterClass() {
		self::_setDBState(self::$sql);
		parent::tearDownAfterClass();
    }

	public function testPreconditions() {
		$this->assertTrue(self::$CI->_hasPreconditions());
	}

	/**
     * @depends testPreconditions
     */
	public function testBodyData() {
		$data = self::$CI->_getBodyData();
		$this->assertArrayHasKey('orderRef', $data);
		$this->assertArrayHasKey('htmlMsg', $data);
	}
}


/**
 * controllers/sample.php
 *
 *
class Sample extends CI_Controller {

	public function index() {
		// Render views using data provided by _getBodyData() if preconditions are met
	}

	public function _hasPreconditions() {
		$condition = (
			isset($_POST['orderRef'])
		);
		return $condition;
	}

	public function _getBodyData() {
		$data['orderRef'] = $_POST['orderRef'];
		$data['htmlMsg'] = isset($_POST['htmlMsg']) ? $_POST['htmlMsg'] : '';
		return $data;
	}
}
 *
 */