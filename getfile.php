<?php $database = file(".htsongs",FILE_IGNORE_NEW_LINES |  FILE_SKIP_EMPTY_LINES );
$filename = $database[$_GET['index']*1];
$filepath = dirname($filename);
switch($_GET['typ']*1){
case 0:header('Content-type: audio/mpeg');
if(!is_readable($filename)){header("Content-length: ".filesize("error.mp3"));
readfile("error.mp3");die();}header("Content-length: ".filesize($filename));
break;
case 1:header("Content-type: image/jpeg");
$pictures = glob($filepath."/*.jpg");
readfile($pictures[0]);
die();
case 2:header("Content-type: image/jpeg");
$pictures = glob($filepath."/*.jpeg");
readfile($pictures[0]);
die();
case 3:header("Content-type: image/gif");
$pictures = glob($filepath."/*.gif");
readfile($pictures[0]);
die();
case 4:header("Content-type: image/png");
$pictures = glob($filepath."/*.png");
readfile($pictures[0]);
die();
}
readfile($filename);?>