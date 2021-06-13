<?php

// Don't Edit , any problems 
// @Avishkatpatil [ TG ]
// Star This Repo

$url =$_GET['c'];
if($url !=""){
$id = end(explode('/', $url));
$tlink ="https://gwapi.zee5.com/content/details/$id?translation=en&country=IN&version=2";
$token =file_get_contents("https://useraction.zee5.com/token/platform_tokens.php?platform_name=web_app");
$tokn =json_decode($token);
$tok =$tokn->token;
$vtoken =file_get_contents("http://useraction.zee5.com/tokennd/");
$vtokn =json_decode($vtoken);
$vtok =$vtokn->video_token;

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $tlink,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "x-access-token: $tok",
    "Content-Type: application/json"
  ),
));
$response = curl_exec($curl);
curl_close($curl);

$hls =json_decode($response);
$image =$hls->image_url;
$title =$hls->title;
$des =$hls->description;
$vhls =$hls->hls[0];
$sub =$hls->vtt_thumbnail_url[0];
$error =$hls->error_code;
$vidt = str_replace('drm', 'hls', $vhls);
$img = str_replace('270x152', '1170x658', $image); 

 $vid = "https://zee5vodnd.akamaized.net".$vidt.$vtok;
header("Content-Type: application/json");
$errr= array("error" => "Put Here Only ZEE5 Proper URL ,  Invalid Input " );
$err =json_encode($errr);
$apii = array("title" => $title, "description" => $des, "thumbnail" => $img, "video_url" => $vid, "subtitle_url" => $sub, "created_by" => "Avishkar Patil");
$api =json_encode($apii);
if($error ==101){
echo $err;
}
else{
echo $api;
}
}
else{
  echo "Hello There Is Problem In Your Link Or Check Your Link Format !!";
}

