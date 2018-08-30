<?php

$filename=__DIR__."/models/downloadfiles/file.txt";
$file_name='file.txt';
header("Cache-control: private");
header("Content-type: application/force-download");
header("Content-Length: ".filesize($filename));
header("Content-Disposition: filename=".$file_name);
readfile($filename);