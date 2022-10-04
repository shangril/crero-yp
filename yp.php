<?php require_once('./crero-yp-config.php');

if (!file_exists('./yp')) {
	mkdir ('./yp');
}
else if (!is_dir('./yp')) {
	echo "Fatal error ! ./yp exists and is not a directory, but a regular file";
	exit(1);
}
if (!file_exists('./yp/d')) {
	mkdir ('./yp/d');
}
else if (!is_dir('./yp/d')) {
	echo "Fatal error ! ./yp/d exists and is not a directory, but a regular file";
	exit(1);
}

if (file_exists('./index.php-template')&&(!file_exists('./yp/index.php' || filemtime('./index.php-template')>filemtime('./yp/index.php')))){
	file_put_contents('./yp/index.php', file_get_contents('./index.php-template'));
	
}

$supported_api_versions=Array('1');



?>
<!DOCTYPE html>
<html><head>
	
	<title><?php echo htmlentities($site);?> Yellowpages</title>
	<link rel="icon" type="image/png" href="favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="charset" content="utf-8" />

<meta name="description" content="<?php echo htmlentities($site);?> Yellowpage of artists, labels and webradios that are using the CreRo CMS to propel their website"/>
<style>
body {
	font-family: Tahoma, Sans-serif;
}
h1 {
	font-size:320%;
	color:red;
	background-color:cyan;
	border-radius:12px;
	padding:7px;
}
.ligne {
	float:left;
	display:inline;
}

@media screen and (max-width:800px) {
	.label-wrapper {
		text-align:center;
		width:80%;
		padding:2px;
		background-color:#FAFAFA;
		border-radius:5px;
	}


}

@media screen and (min-width:801px){
	.label-wrapper {
	
	display:inline;
	float:left;
	border:solid 1px black;
	border-radius:5px;
	width:18%;
	padding:2px;
	

	}
	
	
	}

.label-description-wrapper {
	text-align:center;
	padding:2px;
		background-color:#FAFAFA;
		border-radius:5px;



}

</style>
</head><body>
	<div style="float:right;text-align:right;margin-top:150px;">[<a href="./"><?php echo htmlentities($site);?></a>'s label sites yellowpages] 
</div>
<div style="float:right;<?php if($header_fixed){ echo 'position:fixed;';} ?>background-color:#C0C0C0;">
<?php
	error_reporting (0);
	if (isset($header)){include ($header);}
?>
</div><br style="clear:both;"/>	
<h1 style="text-align:center;"><?php echo htmlentities($site);?><br/><span style="font-size:68%;">CreRo-propelled label &amp; radio sites yellowpages</span></h1>
Here's a live yellowpage of CreRo-powered label, artist, or webradio websites :<hr/>  
<?php
$touchs=array_diff(scandir ('./yp/d'), array ('.', '..', '.htaccess'));
//sort($touchs);
foreach ($touchs as $touch){
	
	if (!isset($_GET['m']))
	{	
		$touch_proto='http';
		
		$label=unserialize(file_get_contents('./yp/d/'.$touch));
		
		
		if (array_key_exists('protoHTTPS', $label)){
			if (boolval($label['protoHTTPS'])===true||(array_key_exists('forceHTTPS', $label)&&boolval($label['forceHTTPS'])===true)){
				$touch_proto='https';
			}
			
		}
		
		echo '<span class="label-wrapper">';
		echo '<span >';
		
		
		
		echo '<h2 style="display:inline;">';
		if (file_get_contents(str_replace ('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/favicon.png')) {
			echo '<img style="width:10%;float:left;" src="'.str_replace ('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/favicon.png"/>';
		}
		echo '<a target="_blank" href="'.str_replace ('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'">';
		echo htmlentities($label['name']);
		echo '</a>';
		echo '</h2><br/>';
		echo '<span style="border:solid 1px;border-radius:5px;display:block;padding:2px;margin:2px;">';
		
		echo htmlentities($label['description']);
		echo  '</span>';
		
		//*********** Here comes the API part
		
		if ($remote_api_version=file_get_contents($touch_proto.'://'.str_replace('http://', '', $label['url']).'/crero_yp_api.php?a=version')!==''){
			if (in_array($remote_api_version, $supported_api_versions)){
				echo '<span style="text-align:right;"><a href="./yp.php?m='.urlencode(str_replace('.dat', '', $touch)).'">More item information...</a></span>';
				
				
			}
		
		}	
		//Here ends the API part
		
		echo '<br/>'.htmlentities($label['ping']).'<em> points of instant popularity bogo score</em><br/>';
		
		
		echo '</span>';
		echo '</span>';
	}
	else if ($_GET['m'].'.dat'==$touch) {
		$touch_proto='http';
		
		$label=unserialize(file_get_contents('./yp/d/'.$touch));
		
		
		
		
		if (array_key_exists('protoHTTPS', $label)){
			if (boolval($label['protoHTTPS'])===true||(array_key_exists('forceHTTPS', $label)&&boolval($label['forceHTTPS'])===true)){
				$touch_proto='https';
			}
			
		}
		
		
		echo '<span class="label-wrapper" >';
		echo '<span >';
		
		
		
		echo '<h2 style="display:inline;">';
		if (file_get_contents(str_replace ('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/favicon.png')) {
			echo '<img style="width:10%;float:left;" src="'.str_replace ('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/favicon.png"/>';
		}
		echo '<a target="_blank" href="'.str_replace ('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'">';
		echo htmlentities($label['name']);
		echo '</a>';
		echo '</h2><br/>';
		echo '<span style="border:solid 1px;border-radius:5px;display:block;padding:2px;margin:2px;">';
		
		echo htmlentities($label['description']);
		echo  '</span>';
		
		
		echo '<br/>'.htmlentities($label['ping']).'<em> points of instant popularity bogo score</em><br/>';
		
		
		echo '</span>';
		echo '</span>';
		//It's time to update touch_proto
		
		if((!(array_key_exists('forceHTTPS', $label)&&boolval($label['forceHTTPS'])===true))||file_get_contents($label['url'].'/style.css')===file_get_contents(str_replace('http://', 'https://', $label['url']).'/style.css'))
			{
				$label['protoHTTPS']=true;
			}
			else
			{
				$label['protoHTTPS']=false;
			}
				
		file_put_contents('./yp/d/'.$touch, serialize($label));	
				
		echo '<span><a href="./yp.php">Home</a> &gt; <strong> '.htmlentities($label['name']).'</strong> infos<br/>';
		
		//Here comes the crero-yp-api stuff
		$api_base=$touch_proto.'://'.str_replace('http://', '', $label['url'].'/crero-yp-api.php?');
		$hook_base='./yp.php?m='.urlencode(str_replace('.dat', '', $touch));
		
		if (file_get_contents($api_base.'a=styles_defined')=='1'){
			echo '<em>General styles:</em> '.htmlspecialchars(str_replace(' ', ', ', trim(file_get_contents($api_base.'a=styles')))).'<br/>';
			
		}
		else {
			echo 'There is no music styles defined by this item<br/>';
		}
		echo '<hr/><strong><em>'.htmlspecialchars($label['name']).' artists: </em></strong>';
		
		$artlist='';
		
		if(trim(file_get_contents($api_base.'a=list_artists'))!=''){
			$artlist=trim(file_get_contents($api_base.'a=list_artists'));
			}
			else	{
				//no artist declared by the label, fallback to list_all_artists (likely a playlist webradio item)
				if (trim(file_get_contents($apibase.'a=list_all_artists'))!=''){
					$artlist=file_get_contents($api_base.'a=list_all_artists');
				}
				
			} 
		$artlist=trim($artlist);
		if ($artlist==''){
			echo 'currently unavailable, sorry...';
		}
		
		$hlartists=Array();
		$socdata=trim(file_get_contents($api_base.'a=artist_info'));
		$soctokens=explode("\n", $socdata);
		for ($p=0;$p<count($soctokens);$p++){
			
			while ($p<count($soctokens)){
				$socialone=Array();
				$socialone['name']=$soctokens[$p];
				$p++;
				$socialone['styles']=$soctokens[$p];
				$p++;
				$socialone['infos']=$soctokens[$p];
				$p++;
				$socialone['link']=$soctokens[$p];
				$hlartists[$socialone['name']]=$socialone;
				$p++;
			}
		}
	
		
		
		
		
		
		
		$a_art=explode("\n", $artlist);
		foreach ($a_art as $art){
			
			if (!isset($_GET['a'])){
				echo '<hr/> <a href="'.$hook_base.'&a='.urlencode($art).'">'.htmlspecialchars($art).'</a> ';
				if (array_key_exists($art, $hlartists)){
					echo '(';
					echo htmlspecialchars(str_replace(' ', ', ', trim($hlartists[$art]['styles'])));
					
					echo ') '.htmlspecialchars($hlartists[$art]['infos']);
					
				}
			}
			else if ($_GET['a']==$art){
				echo '<hr/> <a href="'.$hook_base.'">All artists</a> &gt; <span style="text-decoration:underline;">'.htmlspecialchars($art).'</span> ';
				if (array_key_exists($art, $hlartists)){
					echo '(';
					echo htmlspecialchars(str_replace(' ', ', ', trim($hlartists[$art]['styles'])));
					
					echo ') '.htmlspecialchars($hlartists[$art]['infos']);
					//Here comes the listing of albums for this artist
					echo '<br/>Albums by '.htmlspecialchars($art).':<hr/>';
					$streaming_alb=trim(file_get_contents($api_base.'a=streaming_albums&streaming_albums='.urlencode($art)));
					$dl_alb=trim(file_get_contents($api_base.'a=download_albums&download_albums='.urlencode($art)));
					
					$a_str_i=explode("\n", $streaming_alb);
					$a_dl_i=explode("\n", $dl_alb);
					
					
					
					$a_str=array_diff ($a_str_i, Array('', ' '));
					$a_dl=array_diff ($a_dl_i, Array('', ' '));
					
					sort($a_str);
					sort($a_dl);
					if (!array_key_exists('bs', $_GET) && !array_key_exists('bd', $_GET)){
						if (count($a_str)!=0){
								echo 'Streaming albums: ';
								echo ' ';				
								foreach ($a_str as $a){
									echo ' [';
									
									echo '<a href="'.$hook_base.'&a='.urlencode($art).'&bs='.urlencode($a).'">'.strip_tags($a).'</a>';
									
									echo '] ';
									
							}
							echo '<hr/>';
						}
						
						if (count($a_dl)!=0){
									
								echo 'Dowloadable albums: ';
								echo ' ';				
								foreach ($a_dl as $a){
									echo '[';
									
									echo '<a href="'.$hook_base.'&a='.urlencode($art).'&bd='.urlencode($a).'">'.strip_tags($a).'</a>';
									
									echo '] ';
									
								}	
								echo '<hr/>';
						}
					}
					else {
						if (array_key_exists('bs', $_GET) && in_array ($_GET['bs'], $a_str)){
							echo '<a href="'.$hook_base.'&a='.urlencode($art).'">'.strip_tags($art).' Albums</a> &gt;'.strip_tags($_GET['bs']).'<br/>';
							$tracklist=explode("\n", trim(file_get_contents($api_base.'a=album_streaming&album_streaming='.urlencode($_GET['bs']))));
							$tracks=Array();
							foreach ($tracklist as $tr){
								$item=Array();
								$item['artist']=trim(file_get_contents($api_base.'a=track_artist_streaming&track_artist_streaming='.urlencode($tr)));
								$item['title']=trim(file_get_contents($api_base.'a=title_streaming&title_streaming='.urlencode($tr)));
								array_push($tracks, $item);
							}
							echo '<ol>'; 
							foreach ($tracks as $it){
								echo '<li>'.strip_tags($it['artist']).' - '.strip_tags($it['title']).'</li>';
								
							}		
							echo '</ol>';
							echo 'Now, why not about taking a look at <a href="'.str_replace('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/?album='.urlencode($_GET['bd']).'">this album at '.htmlspecialchars($label['name']).'</a>?<hr/>';
						}
						else if (array_key_exists('bd', $_GET) && in_array ($_GET['bd'], $a_dl)){
							echo '<a href="'.$hook_base.'&a='.urlencode($art).'">'.strip_tags($art).' Albums</a> &gt;'.strip_tags($_GET['bd']).'<br/>';
							$tracklist=explode("\n", trim(file_get_contents($api_base.'a=album_download&album_download='.urlencode($_GET['bd']))));
							$tracks=Array();
							foreach ($tracklist as $tr){
								$item=Array();
								$item['artist']=trim(file_get_contents($api_base.'a=track_artist_download&track_artist_download='.urlencode($tr)));
								$item['title']=trim(file_get_contents($api_base.'a=title_download&title_download='.urlencode($tr)));
								array_push($tracks, $item);
							}
							echo '<ol>'; 
							foreach ($tracks as $it){
								echo '<li>'.strip_tags($it['artist']).' - '.strip_tags($it['title']).'</li>';
								
							}		
							echo '</ol>';
							echo 'Now, why not about taking a look at <a href="'.str_replace('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/?album='.urlencode($_GET['bd']).'">this album at '.htmlspecialchars($label['name']).'</a>?<hr/>';
						
						}
						
						
					}
					
				}
				
			}
		}
		
		
		
		
		//End of api stuf******************
		
		echo '<hr/></span>';
	}
	
}//foreach touch

?>
<hr style="float:none;clear:both;"/>
<?php
if (isset($footer)){include($footer);}
?>
<hr/>
Propelled by crero-yp, an AGPL cms for CreRo yellopages services. Code repo is <a href="https://github.com/shangril/crero-yp">here</a>.
</body>
</html>
