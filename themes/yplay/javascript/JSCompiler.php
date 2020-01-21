<?php


$url = $_SERVER['REQUEST_URI'];
$uri = strtok($url, '?');
$filename = basename($uri,".js").".js";
$filename_full = str_replace(".min", "", $filename);
$filename_min = str_replace(".js", ".min.js", $filename_full);

$srcDir = 'vendor';

$js_compiled = autoCompileJs($srcDir,$filename);

if($js_compiled){
	//minify via google closure api
		$url = 'https://closure-compiler.appspot.com/compile';
		$params = array(
			'js_code' => $js_compiled['to_minify'],
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
	file_put_contents($filename_full,$js_compiled['minified'].$js_compiled['to_minify']);
	file_put_contents($filename_min,$js_compiled['minified'].$js_minified);
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
		$main = fopen("main.js","w");
		$handle = fopen("compiled.js","w");
		$minify = fopen("tocompile.js","w");
		foreach($srcFiles as $key => $file) {
			// file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", "\n".$file." : ".strpos($file,".min.js")."\n",FILE_APPEND);
			$in = fopen($srcDir."/".$file, "r");
	        while ($line = fgets($in)){
	            if (!strpos($file,".min.js")){
	            	fwrite($minify, $line);
	            }
	            else{
	            	
	            	fwrite($handle, $line);
	            } 
	            fwrite($main, $line);
	        }
          	fclose($in);
		}
		fclose($handle);
		fclose($minify);
		fclose($main);

		$js_compiled = file_get_contents("compiled.js");

		$toMinifiy = file_get_contents("tocompile.js");

		return ['minified' => $js_compiled, 'to_minify' => $toMinifiy];
	}
	return false;

}