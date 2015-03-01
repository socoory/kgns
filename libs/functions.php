<?php

function createThumb($path, $src, $dstWidth, $dstHeight) {
    list($w,$h, $type) = getimagesize($path."/".$src);
	
	switch($type) {
		case 1:
			$img = imagecreatefromgif($path."/".$src);
			$type = "imagegif";
			break;
		case 2:
			$img = imagecreatefromjpeg($path."/".$src);
			$type = "imagejpeg";
			break;
		case 3:
			$img = imagecreatefrompng($path."/".$src);
			$type = "imagepng";
			break;
		case 15:
			$img = imagecreatefromwbmp($path."/".$src);
			$type = "imagewbmp";
			break;
		default: return false;
	}
	
	// 작은 변을 기준으로 먼저 보정
    if($w > $h) {
        $width = round($dstHeight*$w/$h);
        $height = $dstHeight;
    }
    else {
        $width = $dstWidth;
        $height = round($dstWidth*$h/$w);
    }
	
	// 긴 변의 길이가 썸네일의 해당 변의 길이보다 작을 경우 맞춰서 보정  
    if($width < $dstWidth) {
		$width = round($width*$dstWidth/$width);
		$height = round($height*$dstWidth/$width);
    }
    else if($height < $dstHeight) {
		$width = round($width*$dstHeight/$height);
		$height = round($height*$dstHeight/$height);
    }
	
	// 시작 점의 위치를 계산
    $srcX = round(($width - $dstWidth)/2);
    $srcY = round(($height - $dstHeight)/2);
	
	// 이미지 리사이즈 복제
    $thumb = imagecreatetruecolor($dstWidth, $dstHeight);
    $tempImg = imagecreatetruecolor($width, $height);
	imagecopyresized($tempImg, $img, 0, 0, 0, 0, $width, $height, $w, $h);
	imagecopy($thumb, $tempImg, 0, 0, $srcX, $srcY, $dstWidth, $dstHeight);
	
	// 썸네일저장
	$thumbName = "thumb_".$dstWidth."x".$dstHeight."_".$src;
	$type($thumb, $path."/".$thumbName);
	
    return $path."/".$thumbName;
}

function getThumb($src, $w=100, $h=100) {
	$pathInfo = pathinfo($src);
	return $pathInfo['dirname'].'/thumb_'.$w.'x'.$h.'_'.$pathInfo['basename'];
}

?>