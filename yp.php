<?php
class SystemExit extends Exception {}
try {
require_once('./crero-yp-config.php');
//starting for now, we do not want any PHP warning, since we may have to set a redirection header later in the code
error_reporting(0);
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

if (file_exists('./index.php-template')&&(!file_exists('./yp/index.php' || filectime('./index.php-template')>filectime('./yp/index.php')))){
	file_put_contents('./yp/index.php', file_get_contents('./index.php-template'));
	
}
//okay let's handle fixed header, that has to be non-fixed on GET with whitelisted parameters callback
//*********************************************NOTE for FUTURE mainteners of this code : Read the PLEASE note juste above. ****************************
$get_param_whitelist = array('l', 'm', 'a', 'bd', 'bs'); //PLEASE KEEP THIS LIST UP TO DATE UPON EACH NEW FEATURE that requires any kind of http get param pass to this yp.php script



$header_fixed_is_bottom=false; //for now, if needed if and elseif will true it

$footer_needs_to_be_pushed_down=false; //same as previous bool comment

$get_param_counter = count(array_diff(array_keys($_GET), $get_param_whitelist));
if ($get_param_counter>0){
	//uh we got a non-whilisted $_GET parameter
	//DONE : add a redirection to the proper canonical url and trash GAFAM tracking HTTP GET params that propagate from share to share to identify the original sharer and who is in relationnal network
	//f**** b****ds
	
	$redirect_proto='http';
	$querystring='?';
	
	foreach ($get_param_whitelist as $prm){
	
		if (in_array($prm, array_keys($_GET))){
			$querystring.=urlencode($prm).'='.urlencode($_GET[$prm]).'&';
		}
	}
	$querystring=substr($querystring, 0, strlen($querystring)-1);
	
	if (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!==''){
		$redirect_proto='https';
	}
	
	$anch = parse_url($redirect_proto.'://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'], PHP_URL_FRAGMENT);
	if (isset($anch)&&$anch!==false&&$anch!=''){
		$querystring.='#'.$anch;
	}
	
	header("Location: ".$redirect_proto.'://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$querystring, true, 302);
	throw new SystemExit();
	
} 
else if (count(array_keys($_GET))>0){
	//First point was seen before : any GET PARAM is ok with the param_witheliste
	//Second point : we got at least one whitelisted GET param
	//Conclusion : we don't want the header_fixed config option, if set, to be honored, because
	//we are not on the main page
	//so we need #anchor support
	//to have (especially mobile) user landing on a page auto-scrolled to what is useful for them to read
	//(mobile user could tend to think about a bug, with the same page re-diplaying, and not scroll)
	//and we cannot keep the header top-fixed, cuz it would hide the displayed content
	//then we'll set it bottom-fixed !
	
	$header_fixed_is_bottom=true;
	$footer_needs_to_be_pushed_down=true;//let's make room on the page to distinguish actual, requested content from usual, omnipresent footer
}



//now we wish again some information about warnings, and errors, since our header will no longer have to be sent
error_reporting(E_WARNING | E_ERROR | E_PARSE | E_DEPRECATED);

$supported_api_versions=array('1');//which crero_yp_api API versions this yp instance supports 

$remote_provided_api_versions=Array();

$available_on_both_side_api_versions=Array();

?>
<!DOCTYPE html>
<html><head>
	
	<title><?php echo htmlentities($site);?> Yellowpages</title>
	<link rel="icon" type="image/png" href="favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="charset" content="utf-8" />

<meta name="description" content="<?php echo htmlentities($site);?> Yellowpage of netlabels and labels using the CreRo CMS to propel their website"/>
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
	<div style="float:right;text-align:right;<?php
	
	
	if ($header_fixed&&!$header_fixed_is_bottom){
		echo 'margin-top:150px;';
	}
	
	
	?>">[<a href="./"><?php echo htmlentities($site);?></a>'s label sites yellowpages] 
</div>
<div style="float:left;<?php
	if($header_fixed){ 
		echo 'position:fixed;';
		
		if ($header_fixed_is_bottom) {
	
			echo 'bottom:0;';
		} 
	}?>background-color:#C0C0C0;">
<?php
	error_reporting (0);
	if (isset($header)){include ($header);}
	error_reporting (E_ERROR | E_PARSE | E_WARNING | E_DEPRECATED);
?>
</div><br style="clear:both;"/>	
<h1 style="text-align:center;"><?php echo htmlentities($site);?><br/><span style="font-size:68%;">Label &amp; Netlabels CreRo-enabled sites yellowpages</span></h1>
<?php if (array_key_exists('l', $_GET)){ echo '<a name="l" href="./yp.php">Home</a> &gt; '; } ?>
Here's <?php echo htmlentities($site);?> live yellowpage of CreRo-powered label, artist, or webradio websites :<hr/>

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

		$remote_api_version=file_get_contents($touch_proto.'://'.str_replace('http://', '', $label['url']).'/crero-yp-api.php?a=version');
		$remote_provided_api_versions=explode(' ', $remote_api_version);
		$available_on_both_side_api_versions=array_intersect($supported_api_versions, $remote_provided_api_versions);
		
		if (count($available_on_both_side_api_versions)>0){
			echo '<span style="text-align:right;"><a href="./yp.php?m='.urlencode(str_replace('.dat', '', $touch)).'#m">More item information...</a></span>';
			
			
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
		//*********** Here comes the API part
		$remote_api_version=file_get_contents($touch_proto.'://'.str_replace('http://', '', $label['url']).'/crero-yp-api.php?a=version');
		$remote_provided_api_versions=explode(' ', $remote_api_version);
		$available_on_both_side_api_versions=array_intersect($supported_api_versions, $remote_provided_api_versions);
		
		//Here ends the API part

		
		
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
				
		echo '<span><a name="m" href="./yp.php?l=bogo#l">Home</a> &gt; <strong> '.htmlentities($label['name']).'</strong> infos<br/>';
		
		//Here comes the crero-yp-api stuff
		if (count($available_on_both_side_api_versions)>0){
			$api_base=$touch_proto.'://'.str_replace('http://', '', $label['url'].'/crero-yp-api.php?');
			$hook_base='./yp.php?m='.urlencode(str_replace('.dat', '', $touch));
			
			
			///here starts the API Version 1-required queries
			if (in_array('1', $available_on_both_side_api_versions)){
				if (true){
					echo '<em>General styles:</em> '.htmlspecialchars(str_replace(' ', ', ', trim(file_get_contents($api_base.'a=styles')))).'<br/>';
					
				}
				else {
					echo 'There is no music styles defined by this item<br/>';
				}
				echo '<hr/><strong><em><a href="'.$hook_base.'#m" name="aall">'.htmlspecialchars($label['name']).'</a> artists: </em></strong>';
				
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
						if (array_key_exists($p, $soctokens)){
							$socialone['link']=$soctokens[$p];
						}
						$hlartists[$socialone['name']]=$socialone;
						$p++;
					}
				}
			
				
				
				
				
				
				
				$a_art=explode("\n", $artlist);
				foreach ($a_art as $art){
					
					if (!isset($_GET['a'])){
						echo '<hr/> <a href="'.$hook_base.'&a='.urlencode($art).'#a">'.htmlspecialchars($art).'</a> ';
						if (array_key_exists($art, $hlartists)){
							echo '(';
							echo htmlspecialchars(str_replace(' ', ', ', trim($hlartists[$art]['styles'])));
							
							echo ') '.htmlspecialchars($hlartists[$art]['infos']);
							
						}
					}
					else if ($_GET['a']==$art){
						echo '<hr/> <a name="a" href="'.$hook_base.'#m">'.htmlspecialchars($label['name']).'</a> &gt; <a name="a" href="'.$hook_base.'#aall">All artists</a> &gt; <span style="text-decoration:underline;">'.htmlspecialchars($art).'</span> ';
						if (array_key_exists($art, $hlartists)){
							echo '<br/>(';
							echo htmlspecialchars(str_replace(' ', ', ', trim($hlartists[$art]['styles'])));
							
							echo ') '.htmlspecialchars($hlartists[$art]['infos']);
							//Here comes the listing of albums for this artist
							echo '<br/>Albums by '.htmlspecialchars($art).':<hr/>';
							$streaming_alb=file_get_contents($api_base.'a=streaming_albums&streaming_albums='.urlencode($art));
							$dl_alb=file_get_contents($api_base.'a=download_albums&download_albums='.urlencode($art));
							
							if (false===$streaming_alb){$streaming_alb='';}
							if (false===$dl_alb){$dl_alb='';}
							
							
							while(strstr($streaming_alb, "\n\n") || strstr($dl_alb, "\n\n")) {	
								$streaming_alb=str_replace("\n\n", "\n", $streaming_alb);
								$dl_alb=str_replace("\n\n", "\n", $dl_alb);
							}
							
							$a_str=explode("\n", $streaming_alb);
							$a_dl=explode("\n", $dl_alb);
							
							
							
							
							//sort($a_str);
							//sort($a_dl);
							if (!array_key_exists('bs', $_GET) && !array_key_exists('bd', $_GET)){
								if (count($a_str)!==0&&$a_str[0]!=''){
										echo 'Streaming albums: ';
										echo '<hr/>';				
										for ($i=0;$i<count($a_str);$i++){
											$a=$a_str[$i];
											if ($a!=''){
										
												echo '';
												
												echo '<a name="as" href="'.$hook_base.'&a='.urlencode($art).'&bs='.urlencode($a).'#bs">'.htmlspecialchars($a).'</a>';
												
												echo '<hr/>';
											}	
									}
									echo '<hr/>';
								}
								
								if (count($a_dl)!==0&&$a_dl[0]!=''){
											
										echo 'Dowloadable albums: ';
										echo '<hr/>';				
										for ($i=0;$i<count($a_dl);$i++){
											$a=$a_dl[$i];
											if ($a!=''){
												echo '';
												
												echo '<a name="ad" href="'.$hook_base.'&a='.urlencode($art).'&bd='.urlencode($a).'#bd">'.htmlspecialchars($a).'</a>';
												
												echo '<hr/>';
											}
										}	
										echo '<hr/>';
								}
							}
							else {
								if (array_key_exists('bs', $_GET) && in_array ($_GET['bs'], $a_str)){
									echo '<a name="a" href="'.$hook_base.'#m">'.htmlspecialchars($label['name']).'</a> &gt; <a name="a" href="'.$hook_base.'#aall">All artists</a> &gt; <a href="'.$hook_base.'&a='.urlencode($art).'#a">'.htmlspecialchars($art).' </a>'.' &gt; <a name="bs">Albums</a> &gt; '.htmlspecialchars($_GET['bs']).'<br/>';
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
										echo '<li>'.htmlspecialchars($it['artist']).' - '.htmlspecialchars($it['title']).'</li>';
										
									}		
									echo '</ol>';
									echo 'Now, why not about taking a look at <a href="'.str_replace('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/?album='.urlencode($_GET['bs']).'">this album at '.htmlspecialchars($label['name']).'</a>?<hr/>';
								}
								else if (array_key_exists('bd', $_GET) && in_array ($_GET['bd'], $a_dl)){
									echo '<a name="a" href="'.$hook_base.'#m">'.htmlspecialchars($label['name']).'</a> &gt; <a name="a" href="'.$hook_base.'#aall">All artists</a> &gt; <a href="'.$hook_base.'&a='.urlencode($art).'#a">'.htmlspecialchars($art).' </a>'.' &gt; <a name="bd"> Albums</a> &gt; '.htmlspecialchars($_GET['bd']).'<br/>';
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
										echo '<li>'.htmlspecialchars($it['artist']).' - '.htmlspecialchars($it['title']).'</li>';
										
									}		
									echo '</ol>';
									echo 'Now, why not about taking a look at <a href="'.str_replace('"', '', $touch_proto.'://'.str_replace('http://', '', $label['url'])).'/?album='.urlencode($_GET['bd']).'">this album at '.htmlspecialchars($label['name']).'</a>?<hr/>';
								
								}
								
								
							}
							
						}
						
					}
				}
			}//here ends the available on both side API version 1-required commands
				
		}//If available_on_both_sides_api_versions
		
		
		
		//End of api stuf******************
		
		echo '<hr/></span><div></div>';
	}
	
}//foreach touch

?>
<hr style="float:none;clear:both;"/>
<?php
if (isset($footer)){
	if ($footer_needs_to_be_pushed_down){
	echo '<span style="text-align:center;margin-bottom:52%;width:100%;display:block;">⏬ Keep on scrolling down for '.htmlspecialchars($site).'\'s provided additionnal information about its YellowPages service ⏬</span>';	
		
	}
	include($footer);
	

	
	}
?>
<hr/>
Propelled by crero-yp, an AGPL cms for CreRo yellopages services. Code repo is <a href="https://github.com/shangril/crero-yp">here</a><hr style="<?php
	
	
	if ($header_fixed&&$header_fixed_is_bottom){
		echo 'margin-bottom:150px;';
	}
	
	
	?>"/>
</body>
</html><?php }//end of general try{} block

catch (SystemExit $e) {/*terminates the script cleanly on demanding CGI*/ }
