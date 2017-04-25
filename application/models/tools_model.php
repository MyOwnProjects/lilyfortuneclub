<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tools_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	static public function generate_key($min_len, $max_len){
		$len = rand($min_len, $max_len);
		$value = '';
		for($i = 0; $i < $len; ++$i){
			$type = rand(0, 2);
			switch($type){
				case 0://digit
					$value .= chr(rand(48, 57));
					
					break;
				case 1://lower case
					$value .= chr(rand(97, 122));
					break;
				case 2://upper case
					$value .= chr(rand(65, 90));
					break;
			}
		}
		return $value;
	}
}