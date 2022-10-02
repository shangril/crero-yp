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
.label-wrapper {
	
	display:inline;
	float:left;
	border:solid 1px black;
	border-radius:5px;
	width:18%;
	padding:2px;
	

}
@media screen and (max-width:800px) {
	.label-wrapper {
		text-align:center;
		width:80%;
		padding:2px;
		background-color:#FAFAFA;
		border-radius:5px;
	}
	.label-description-wrapper {
		padding:2px;
		background-color:#FAFAFA;
		border-radius:5px;


}
}

.label-description-wrapper {
	text-align:center;
	padding:2px;
		background-color:#FAFAFA;
		border-radius:12px;



}

</style>
</head><body>
	<div style="float:right;text-align:right;margin-top:50px;">[<a href="./"><?php echo htmlentities($site);?></a>'s label sites yellowpages] 
</div>
<div style="float:right;position:fixed;background-color:#C0C0C0;">
<?php
	error_reporting (0);
	if (isset($header)){include ($header);}
?>
</div><br style="clear:both;"/>	
<h1 style="text-align:center;"><?php echo htmlentities($site);?> CreRo<br/><span style="font-size:68%;">label &amp; radio sites yellowpages</span></h1>
Here's a live yellowpage of CreRo-powered label, artist, or webradio websites :<br/>  
<?php
$touchs=array_diff(scandir ('./yp/d'), array ('.', '..', '.htaccess'));

foreach ($touchs as $touch){
	$label=unserialize(file_get_contents('./yp/d/'.$touch));
	echo '<span style="float:left;width:18%;border:solid 1px;border-radius:5px;margin:2px;" >';
	echo '<span >';
	
	
	
	echo '<h2 style="display:inline;">';
	if (file_get_contents(str_replace ('"', '', $label['url']).'/favicon.png')) {
		echo '<img style="width:10%;float:left;" src="'.str_replace ('"', '', $label['url']).'/favicon.png"/>';
	}
	echo '<a target="new" href="'.str_replace ('"', '', $label['url']).'">';
	echo htmlentities($label['name']);
	echo '</a>';
	echo '</h2><br/>';
	echo '<span style="border:solid 1px;border-radius:5px;display:block;padding:2px;margin:2px;">';
	
	echo htmlentities($label['description']);
	echo  '</span>';
	
	echo '<br/>'.htmlentities($label['ping']).'<em> points of instant popularity bogo score</em><br/>';
	
	
	echo '</span>';
	echo '</span>';
	
}

?>
<hr style="float:none;clear:both;"/>
<?php
if (isset($footer)){include($footer);}
?>
<hr/>
Propelled by crero-yp, an AGPL cms for CreRo yellopages services. Code repo is <a href="https://github.com/shangril/crero-yp">here</a>.
</body>
</html>
