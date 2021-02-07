<?php
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

$xurl = curl_init();
curl_setopt_array($xurl, array(
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
$response = curl_exec($xurl);
curl_close($xurl);

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
$errr= array("error" => "error provide proper input!" );
$err =json_encode($errr);
$apii = array("title" => $title, "description" => $des, "thumbnail" => $img, "video_url" => $vid, "subtitle_url" => $sub);
$api =json_encode($apii);
if($error ==101){
echo $err;
}
else{
header("Content-Type: application/json");

echo  "Title : ${title}\n\n";
echo "Description : ${des}\n\n\n\n";
echo "Image URL : ${img}\n\n";
echo "Video URL : ${vid}\n\n";
echo "Subtitle URL : ${sub}\n\n";

}
}
else{
  echo "Hello There Is Problem In Your Link Or Check Your Link Format !!";
}
