<?php

class DeskallImageOptimiser {
	protected $api_key = 'gG1Tujhnd39tTlK5Wg8fKwbN6a3HVDA4';

	public function Optimise($path){
		// ob_start();
		// var_dump($resource);
		// $result = ob_get_clean();
		// file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt",$result);

		try {
    		\Tinify\setKey($this->api_key);
			$source = \Tinify\fromUrl($path);
			$source->toFile($path);
		} catch(\Tinify\AccountException $e) {
		    print("account: " . $e->getMessage());
		    // Verify your API key and account limit.
		} catch(\Tinify\ClientException $e) {
		    // Check your source image and request options.
		    print("client: " . $e->getMessage());
		} catch(\Tinify\ServerException $e) {
		    // Temporary issue with the Tinify API.
		     print("tiny server: " . $e->getMessage());
		} catch(\Tinify\ConnectionException $e) {
		    // A network connection error occurred.
		     print("connection: " . $e->getMessage());
		} catch(Exception $e) {
		    // Something else went wrong, unrelated to the Tinify API.
		     print("other: " . $e->getMessage());
		}
	}
} 