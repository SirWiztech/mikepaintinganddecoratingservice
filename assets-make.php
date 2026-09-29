<?php
/**
 * Generates the brand assets used by index.php from the master logo (images/logo.png).
 * Run with:  php assets-make.php
 * Safe to re-run: the master is read first and written back trimmed.
 */
$dir   = __DIR__ . '/images/';
$src   = $dir . 'logo.png';
$paper = [251, 250, 247]; // --paper in index.php

$im = imagecreatefrompng($src);
$w  = imagesx($im);
$h  = imagesy($im);

/* ---- 1. find the artwork bounds (alpha < 120 = visible) ---- */
$minX = $w; $minY = $h; $maxX = -1; $maxY = -1;
for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        if (((imagecolorat($im, $x, $y) >> 24) & 0x7F) < 120) {
            if ($x < $minX) $minX = $x;
            if ($x > $maxX) $maxX = $x;
            if ($y < $minY) $minY = $y;
            if ($y > $maxY) $maxY = $y;
        }
    }
}
$pad  = 6;
$minX = max(0, $minX - $pad); $minY = max(0, $minY - $pad);
$maxX = min($w - 1, $maxX + $pad); $maxY = min($h - 1, $maxY + $pad);
$cw = $maxX - $minX + 1; $ch = $maxY - $minY + 1;
echo "master {$w}x{$h} -> artwork {$cw}x{$ch} (aspect " . round($cw / $ch, 3) . ")\n";

/* ---- 2. trimmed transparent master (header / footer / structured data) ---- */
$trim = imagecreatetruecolor($cw, $ch);
imagealphablending($trim, false);
imagesavealpha($trim, true);
imagefill($trim, 0, 0, imagecolorallocatealpha($trim, 0, 0, 0, 127));
imagecopy($trim, $im, 0, 0, $minX, $minY, $cw, $ch);
imagepng($trim, $dir . 'logo.png', 9);
echo "wrote logo.png ({$cw}x{$ch})\n";

/* ---- 3. inverted copy for the dark footer ---- */
$light = imagecreatetruecolor($cw, $ch);
imagealphablending($light, false);
imagesavealpha($light, true);
for ($y = 0; $y < $ch; $y++) {
    for ($x = 0; $x < $cw; $x++) {
        $c = imagecolorat($trim, $x, $y);
        $a = ($c >> 24) & 0x7F;
        imagesetpixel($light, $x, $y, imagecolorallocatealpha(
            $light,
            255 - (($c >> 16) & 255),
            255 - (($c >> 8) & 255),
            255 - ($c & 255),
            $a
        ));
    }
}
imagepng($light, $dir . 'logo-light.png', 9);
echo "wrote logo-light.png\n";

/* ---- 4. large transparent copy for open graph fallbacks ---- */
$bigW = 800;
$bigH = (int) round($bigW * $ch / $cw);
$big  = imagecreatetruecolor($bigW, $bigH);
imagealphablending($big, false);
imagesavealpha($big, true);
imagefill($big, 0, 0, imagecolorallocatealpha($big, 0, 0, 0, 127));
imagecopyresampled($big, $trim, 0, 0, 0, 0, $bigW, $bigH, $cw, $ch);
imagealphablending($big, true);
imagepng($big, $dir . 'main-logo.png', 9);
echo "wrote main-logo.png ({$bigW}x{$bigH})\n";

/* ---- 5. square icons on the site's paper colour ---- */
function squareIcon($src, $srcW, $srcH, $size, $target, $fill = 0.80, $paper = null)
{
    $im = imagecreatetruecolor($size, $size);
    imagealphablending($im, true);
    imagesavealpha($im, true);
    if ($paper) {
        imagefill($im, 0, 0, imagecolorallocate($im, $paper[0], $paper[1], $paper[2]));
    } else {
        imagefill($im, 0, 0, imagecolorallocatealpha($im, 0, 0, 0, 127));
    }
    $tw = (int) round($size * $fill);
    $th = (int) round($tw * $srcH / $srcW);
    $tx = (int) round(($size - $tw) / 2);
    $ty = (int) round(($size - $th) / 2);
    imagecopyresampled($im, $src, $tx, $ty, 0, 0, $tw, $th, $srcW, $srcH);
    imagepng($im, $target, 9);
}

squareIcon($trim, $cw, $ch, 512, $dir . 'favicon.png', 0.80, $paper);
squareIcon($trim, $cw, $ch, 180, $dir . 'apple-touch-icon.png', 0.80, $paper);
squareIcon($trim, $cw, $ch, 32, $dir . 'favicon-32.png', 0.80, $paper);
echo "wrote favicon.png (512), apple-touch-icon.png (180), favicon-32.png (32)\n";

/* ---- 6. 1200x630 share image ---- */
$ogW = 1200; $ogH = 630;
$og  = imagecreatetruecolor($ogW, $ogH);
imagealphablending($og, true);
imagefill($og, 0, 0, imagecolorallocate($og, $paper[0], $paper[1], $paper[2]));
$ink = imagecolorallocate($og, 20, 20, 20);
$lw = 560;
$lh = (int) round($lw * $ch / $cw);
$lx = (int) round(($ogW - $lw) / 2);
imagecopyresampled($og, $trim, $lx, 118, 0, 0, $lw, $lh, $cw, $ch);
// brush stroke sweep along the bottom, echoing the hero
imagesetthickness($og, 24);
imageline($og, 90, 600, 1110, 572, $ink);
imagesetthickness($og, 7);
imageline($og, 90, 566, 1110, 538, $ink);
imagesetthickness($og, 1);
$font = 'C:/Windows/Fonts/arialbd.ttf';
$line = 'Devizes, Wiltshire  -  07493 041478  -  mikedodds24@icloud.com';
$cap  = 'PAINTER & DECORATOR - DOMESTIC & COMMERCIAL - INTERIOR & EXTERIOR';
if (is_file($font)) {
    $tw = imagettfbbox(22, 0, $font, $line);
    imagettftext($og, 22, 0, (int) round(($ogW - ($tw[2] - $tw[0])) / 2), 470, $ink, $font, $line);
    $cw2 = imagettfbbox(17, 0, $font, $cap);
    imagettftext($og, 17, 0, (int) round(($ogW - ($cw2[2] - $cw2[0])) / 2), 512, $ink, $font, $cap);
} else {
    imagestring($og, 5, 320, 470, $line, $ink);
}
imagepng($og, $dir . 'og-image.png', 9);
echo "wrote og-image.png ({$ogW}x{$ogH})\n";

/* ---- 7. optional dark-background preview of the light logo: php assets-make.php preview ---- */
if (($argv[1] ?? '') === 'preview') {
    $c = imagecreatetruecolor($cw, $ch);
    imagefill($c, 0, 0, imagecolorallocate($c, 20, 20, 20));
    imagecopy($c, $light, 0, 0, 0, 0, $cw, $ch);
    imagepng($c, sys_get_temp_dir() . '/check-light.png', 9);
    echo "preview: " . sys_get_temp_dir() . "/check-light.png\n";
}
