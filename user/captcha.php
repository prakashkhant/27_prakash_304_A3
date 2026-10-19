<?php
session_start();
$code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
$_SESSION['captcha'] = $code;
$img = imagecreatetruecolor(120, 40);
imagefill($img, 0, 0, imagecolorallocate($img, 240, 240, 240));
for ($i = 0; $i < 6; $i++) imageline($img, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), imagecolorallocate($img, rand(100, 200), rand(100, 200), rand(100, 200)));
imagestring($img, 5, 25, 12, implode(' ', str_split($code)), imagecolorallocate($img, 30, 30, 30));
header('Content-Type: image/png'); imagepng($img);
