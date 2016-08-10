<?php

use Chevron\Hash;

class HashTest extends PHPUnit_Framework_TestCase {

	protected $microtime = "0.98815300 1470055853";
	protected $example   = '$2y$10$eDMOVRf3jz9MVydPOMm3/OpQOJFcGfzfcL.2pqc0EEomFRgbnj0nS';

	/**
	 * @expectedException \OutOfBoundsException
	 */
	public function test_setAlgo(){
		$U = new Hash\Hash;
		$U->setAlgo("boom");
	}

	/**
	 * @expectedException \OutOfRangeException
	 */
	public function test_setCostLow(){
		(new Hash\Hash)->setCost(3);
	}

	/**
	 * @expectedException \OutOfRangeException
	 */
	public function test_setCostHigh(){
		(new Hash\Hash)->setCost(32);
	}

	public function test_getAlgo(){
		$U = new Hash\Hash;
		$this->assertEquals(\PASSWORD_DEFAULT, $U->getAlgo());
	}

	public function test_getCost(){
		$U = new Hash\Hash;
		$U->setCost(12);
		$this->assertEquals(12, $U->getCost());
	}

	public function test_getInfo(){
		$U = new Hash\Hash;
		$expected = [
			'algo'     => \PASSWORD_DEFAULT,
			'algoName' => "bcrypt",
			'options'  => ['cost' => 10],
		];
		$this->assertEquals($expected, $U->getInfo($this->example));
	}

	public function test_needsRehash(){
		$U = new Hash\Hash;
		$this->assertFalse($U->needsRehash($this->example));
	}

	public function test_verify(){
		$U = new Hash\Hash;
		$this->assertTrue($U->verify($this->microtime, $this->example));
	}

	public function test_quick(){
		$U = new Hash\Hash;
		$expected = '44287ddbedb6c8939db21d5da0cd3593ecd4945d277a825347b36c3b63e0afb6';
		$this->assertEquals($expected, $U->quick($this->microtime));
	}

	public function test_quickFile(){
		$U = new Hash\Hash;
		$expected = hash_file("sha256", __FILE__);
		$this->assertEquals($expected, $U->quickFile(__FILE__));
		$expected = hash_file("md5", __FILE__);
		$this->assertEquals($expected, $U->quickFile(__FILE__, 'md5'));
	}

}
