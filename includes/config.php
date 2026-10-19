<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=shop;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/** Resize an uploaded image (jpg/png/gif) to fit within $maxW x $maxH using GD. */
function resize_image($src, $dest, $maxW = 300, $maxH = 300) {
    [$w, $h, $type] = getimagesize($src);
    switch ($type) {
        case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($src); break;
        case IMAGETYPE_PNG:  $img = imagecreatefrompng($src);  break;
        case IMAGETYPE_GIF:  $img = imagecreatefromgif($src);  break;
        default: return false;
    }
    $ratio = min($maxW / $w, $maxH / $h, 1);
    $nw = (int)($w * $ratio); $nh = (int)($h * $ratio);
    $out = imagecreatetruecolor($nw, $nh);
    if ($type == IMAGETYPE_PNG) { imagealphablending($out, false); imagesavealpha($out, true); }
    imagecopyresampled($out, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);
    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($out, $dest, 85); break;
        case IMAGETYPE_PNG:  imagepng($out, $dest); break;
        case IMAGETYPE_GIF:  imagegif($out, $dest); break;
    }
    return true;
}
