<?php

/**
 * Test super class integrating CI support.
 *
 * @author     Carlo Guli
 *
 * @since      18/04/2011
 */

require_once 'bootstrap.php';

class CITestCaseExtension extends PHPUnit_Framework_TestCase
{
    /**
     * CI controller
     */
    protected static $CI;

    protected static $dbObj;

    public static function tearDownAfterClass() {
		if (!empty(self::$dbObj)) {
			self::$dbObj->close();
		}
		self::$dbObj = null;
    }

    protected static function _setDBState($sql) {
    	$mysqli = self::_getDBObject();
    	if ($mysqli->multi_query($sql)) {
    		self::_clearResults();
    	}
    }

    protected static function _getDBState($sql) {
    	$mysqli = self::_getDBObject();
    	if ($mysqli->multi_query($sql)) {
    		$results = array();
    		self::_clearResults(&$results);
    	}
    	return $results;
    }

    protected static function _setUpCI($path) {
		$class = str_replace('/', '', $path);
    	require_once APPPATH.'controllers/'.$path.EXT;
        // Overrides configuration passing true to constructor
        self::$CI = new $class(true);
	}

	private static function _getDBObject() {
        $hostname = 'localhost';
        $username = 'root';
        $password = 'qwe123';
        $database = 'freeprint';

		if (empty(self::$dbObj)) {
			self::$dbObj = new mysqli($hostname, $username, $password, $database);
		}
		return self::$dbObj;
	}

	private static function _clearResults($results = null) {
		$mysqli = self::_getDBObject();
		$next = true;
		while ($next) {
			if ($result = $mysqli->store_result()) {
				if (is_array($results)) {
					$i = 0;
					$rows = array();
					while ($result->data_seek($i)) {
						$rows[] = $result->fetch_assoc();
						$i++;
					}
					$results[] = $rows;
				}
				$result->free();
			}
			$next = $mysqli->next_result();
			if (strlen($mysqli->error) > 0) {
				echo $mysqli->error."\n";
			}
		}
		return $results;
	}
}