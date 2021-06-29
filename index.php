<?php

// Don't Edit , any problems 
// ©  @Avishkatpatil [ TG ]
// Star This Repo

$url =$_GET['c'];
if($url !=""){
$id = end(explode('/', $url));
$tlink ="https://gwapi.zee5.com/content/details/$id?translation=en&country=IN&version=2";
$tokenurl =file_get_contents("https://useraction.zee5.com/token/platform_tokens.php?platform_name=web_app");
$tok =json_decode($tokenurl, true);
$token =$tok['token'];

$vtok =file_get_contents("http://useraction.zee5.com/tokennd/");
$vtokn =json_decode($vtok, true);
$vtoken =$vtokn['video_token'];


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $tlink,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "x-access-token: $token",
    "Content-Type: application/json"
  ),
));
$response = curl_exec($curl);
curl_close($curl);

$z5 =json_decode($response, true);
$image =$z5['image_url'];
$title =$z5['title'];
$des =$z5['description'];
$vhls =$z5['hls'][0];
$sub =$z5['vtt_thumbnail_url'][0];
$error =$z5['error_code'];
$vidt = str_replace('drm', 'hls', $vhls);
$img = str_replace('270x152', '1170x658', $image); 

$hls = "https://zee5vodnd.akamaized.net".$vidt.$vtoken;

header("Content-Type: application/json");
$errr= array("error" => "Put Here Only ZEE5 Proper URL ,  Invalid Input " );
$err =json_encode($errr);
$apii = array("title" => $title, "description" => $des, "thumbnail" => $img, "video_url" => $hls, "subtitle_url" => $sub, "created_by" => "Avishkar Patil");
$api =json_encode($apii, JSON_UNESCAPED_SLASHES);
if($error ==101){
echo $err;
}
else{
echo $api;
}
}
else{
  header("Content-Type: application/json");
  echo "Hello There Is Problem In Your Link Or Check Your Link Format !!";
  // © Avishkar Patil 
}
?>
