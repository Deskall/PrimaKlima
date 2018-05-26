<?php

class DeskallImageOptimiser {
	protected $api_key = 'gG1Tujhnd39tTlK5Wg8fKwbN6a3HVDA4';

	public function Optimise($path){
		// ob_start();
		// var_dump($resource);
		// $result = ob_get_clean();
		// file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt",$result);

		file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt",$path);

		try {
    		\Tinify\setKey($this->api_key);
			$source = \Tinify\fromUrl($path);
			$source->toFile($path);
		} catch(\Tinify\AccountException $e) {
		    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","account: " . $e->getMessage(), FILE_APPEND);
		    // Verify your API key and account limit.
		} catch(\Tinify\ClientException $e) {
		    // Check your source image and request options.
		    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","client: " . $e->getMessage(), FILE_APPEND);
		} catch(\Tinify\ServerException $e) {
		    // Temporary issue with the Tinify API.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","tiny server: " . $e->getMessage(), FILE_APPEND);
		} catch(\Tinify\ConnectionException $e) {
		    // A network connection error occurred.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","connection: " . $e->getMessage(), FILE_APPEND);
		} catch(Exception $e) {
		    // Something else went wrong, unrelated to the Tinify API.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","other: " . $e->getMessage(), FILE_APPEND);
		}
	}
} 