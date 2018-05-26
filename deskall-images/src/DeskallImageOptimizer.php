<?php

class DeskallImageOptimiser {
	protected $api_key = 'gG1Tujhnd39tTlK5Wg8fKwbN6a3HVDA4';

	public function Optimise($resource){
		ob_start();
		var_dump($resource);
		$result = ob_get_clean();
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt",$result);

		//\Tinify\setKey($this->api_key);
		//$source = \Tinify\fromFile($path);
		//$source->toFile($path);
	}
} 