<?php


$filename = basename($_SERVER['REQUEST_URI'],".js").".js";
$filename_full = str_replace(".min", "", $filename);
$filename_min = str_replace(".js", ".min.js", $filename_full);

$srcDir = 'vendor';

$js_compiled = autoCompileJs($srcDir,$filename);

if($js_compiled){
	//minify via google closure api
		$url = 'https://closure-compiler.appspot.com/compile';
		$params = array(
			'js_code' => $js_compiled,
			'compilation_level' => 'SIMPLE_OPTIMIZATIONS',
			'output_format' => 'text',
			'output_info' => 'compiled_code'
		);

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($params)
		    )
		);
		$context  = stream_context_create($options);
		$js_minified = file_get_contents($url, false, $context);

		if ($js_minified === FALSE) {
			echo "there has been an error.";
		}

		// save files
	file_put_contents($filename_full,$js_compiled);
	file_put_contents($filename_min,$js_minified);
}


header("Content-type: application/javascript");
echo file_get_contents($filename);

function autoCompileJs($srcDir,$filename){
	$srcFiles = array_diff(scandir($srcDir), array('.', '..'));
	$modified = false;
	foreach($srcFiles as $key => $file) {
		if( filemtime($filename) < filemtime($srcDir."/".$file))
		{
			$modified = true;
		}
	}
	if ($modified){
		//Concatenate all src files in main
		$handle = fopen("main.js","w");
		foreach($srcFiles as $key => $file) {
			$in = fopen($srcDir."/".$file, "r");
	        while ($line = fgets($in)){
	            fwrite($handle, $line);
	        }
          	fclose($in);
		}
		fclose($handle);

		$js_compiled = file_get_contents("main.js");

		return $js_compiled;
	}
	return false;

}