<?php

class DeskallImageOptimiser {
	protected $api_key = 'gG1Tujhnd39tTlK5Wg8fKwbN6a3HVDA4';

	public function Optimise($path){
		\Tinify\setKey($this->api_key);
		$source = \Tinify\fromFile($path);
		$source->toFile($path);
	}
} 