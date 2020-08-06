<?php

require_once "less/lessc.inc.php";

$rootDir = substr(__DIR__,0,strpos(__DIR__,"/css"));

$theme = substr($rootDir,strrpos(__DIR__, "themes/"));


$filecore = str_replace(".min","",basename($_SERVER['REQUEST_URI'],".css"));
$filename = basename($_SERVER['REQUEST_URI'],".css").".css";

$filename_full = str_replace(".min", "", $filename);
$filename_min = str_replace(".css", ".min.css", $filename_full);
$filename_less = str_replace(".css", ".less", $filename_full);


if ($filename == "editortocompile.css"){
	$filename_min = "editor.min.css";
	$filename_less = "editor.less";
	$filename = "editor.css";
}


	$css_compiled = autoCompileLess($filename_less, $filename_full);

if($css_compiled){
		// set correct paths
		$fontdir = str_replace("/css","/fonts", dirname($_SERVER['REQUEST_URI']));
		$css_compiled = str_replace("url('/fonts","url('".$fontdir,$css_compiled);
		
		$css_compiled = str_replace($_SERVER['DOCUMENT_ROOT']."/themes/images/backgrounds/","/_resources/".$theme."/css/src/images/backgrounds/",$css_compiled);
		$css_live = str_replace("url('../fonts","url('/_resources/".$theme."/fonts",$css_compiled);
		
		
		

		// // optimize file
		// $url = 'http://optimizer-deskall.rhcloud.com/css';
		// $data = array('css' => $css_compiled);

		// // use key 'http' even if you send the request to https://...
		// $options = array(
		//     'http' => array(
		//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		//         'method'  => 'POST',
		//         'content' => http_build_query($data)
		//     )
		// );
		// $context  = stream_context_create($options);
		// $css_minified = file_get_contents($url, false, $context);
		// if ($css_minified === FALSE) {
		// 	echo "there has been an error.";
		// }else{
		// 	$css_minified = str_replace('filter:url("\'', 'filter:url(\'', $css_minified);
		// }

		// save files
		if ($filename == "editor.css"){
			file_put_contents($_SERVER['DOCUMENT_ROOT'].'/'.$theme.'/css/editor.css',$css_compiled);
		}
		else{
			file_put_contents($filename_full,$css_compiled);
			file_put_contents($filename_min,$css_compiled);
			file_put_contents($_SERVER['DOCUMENT_ROOT'].'/'.$theme."/templates/Includes/".ucfirst($filecore)."Css.ss","<style>".$css_live."</style>");
			
		}
			
		
	
}
header("Content-type: text/css");
echo file_get_contents( $filename );

function autoCompileLess($inputFile, $outputFile) {
  // load the cache
  $cacheFile = "cache/".$inputFile.".cache";

  if (file_exists($cacheFile)) {
    $cache = unserialize(file_get_contents($cacheFile));
  } else {
    $cache = $inputFile;
  }

  $less = new lessc;


  $less->setFormatter("compressed");
  $newCache = $less->cachedCompile($cache);

  if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
    file_put_contents($cacheFile, serialize($newCache));
    $css_compiled = $newCache['compiled'];
    return $css_compiled;
  }

  return false;
}

