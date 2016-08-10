<?php

namespace Chevron\Hash;

class Hash {

	/** the default cost */
	const KEY_COST = "cost";

	/** the default password algo */
	protected $algo = \PASSWORD_DEFAULT;

	/** the default cost */
	protected $cost = 10;

	/** set the algo to use */
	public function setAlgo($algo){
		if(!in_array($algo, hash_algos())){
			throw new \OutOfBoundsException("unknown algorithm: {$algo}");
		}
		$this->algo = $algo;
	}

	/** get the algo being used */
	public function getAlgo(){
		return $this->algo;
	}

	/** set the cost to use */
	public function setCost($cost){
		if($cost < 04 || $cost > 31){
			throw new \OutOfRangeException("cost should be 04 <= $cost <= 31: {$cost}");
		}
		$this->cost = $cost;
	}

	/** get the cost being used */
	public function getCost(){
		return $this->cost;
	}

	/** a passthru to `password_get_info` */
	public function getInfo($hash){
		return password_get_info($hash);
	}

	/** a passthru to `password_hash` */
	public function hash($string){
		return password_hash($string, $this->algo, [static::KEY_COST => $this->cost]);
	}

	/** a passthru to `password_needs_rehash` */
	public function needsRehash($hash){
		return password_needs_rehash($hash, $this->algo, [static::KEY_COST => $this->cost]);
	}

	/** a passthru to `password_verify` */
	public function verify($password, $hash){
		return password_verify($password, $hash);
	}

	/** a passthru to `hash` */
	public function quick($string, $algo = "sha256"){
		return hash($algo, $string);
	}

	/** a passthru to `hash_file` */
	public function quickFile($string, $algo = "sha256"){
		return hash_file($algo, $string);
	}

}

