<?php
//header("Content-type: image/jpeg");
//$arr=array("one", "two", "three");
//$img = file_get_contents('http://mimg2.127.net/index/hwmail/img/bg.jpg');
//file_put_contents("test.jpg",$img);
function resizeimg($imgsrc,$w){
	$imgdata = getimagesize($imgsrc);
	$h = $w * $imgdata[1] / $imgdata[0];
	$res_img = imagecreatetruecolor($w,$h);
	$src_img = imagecreatefromjpeg($imgsrc);
	imagecopyresampled($res_img, $src_img, 0, 0, 0, 0, $w, $h, $imgdata[0], $imgdata[1]);
	return $res_img;
}
$dst_img = imagecreatefromjpeg($_POST['dst_url']);
$json = json_decode($_POST['src_url'], true);
$info = json_decode($_POST['con_info'], true);
$o_pos = json_decode($_POST['img_pos'], true);
$font = json_decode($_POST['font_info'], true);
for($i=0;$i<count($json);$i++){
	if($json[$i] != "undefined"){
		imagecopy($dst_img, resizeimg($json[$i],$o_pos[$i]['width']), $info[$i]['left'], $info[$i]['top'], $o_pos[$i]['left'], $o_pos[$i]['top'], $info[$i]['width'], $info[$i]['height']);
	}
}
for($i=0;$i<count($font);$i++){
	$font_color = imagecolorallocate($dst_img, $font[$i]['color'][0], $font[$i]['color'][1], $font[$i]['color'][2]);
	imagettftext($dst_img, $font[$i]['size'], 0, $font[$i]['left'], $font[$i]['top'], $font_color, $font[$i]['file'], $font[$i]['text']);
}
imagejpeg($dst_img,'images/save.jpg');
imagedestroy($dst_img);
echo 'images/save.jpg';
?>