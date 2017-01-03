<?php 

class Helpers{
	static function ccMasking($number, $maskingCharacter = '*') {
		return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
	}
}