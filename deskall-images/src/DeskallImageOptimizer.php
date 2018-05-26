<?php

class DeskallImageOptimiser {
	private static $api_key = 'gG1Tujhnd39tTlK5Wg8fKwbN6a3HVDA4';

	public function Optimise($image){
		\Tinify\setKey($this->api_key);
		$source = \Tinify\fromFile("unoptimized.jpg");
		$source->toFile("optimized.jpg");

		return file_get_contents("optimized.jpg");
	}
} 