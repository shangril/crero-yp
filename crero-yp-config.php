<?php
//here comes what you need to configure for your instance of crero-yp

$site=""; //your site name goes here. Can be empty string. Cannot be null. 

$header=null; //can be null ; or can be a string containing a relative path of a .php file that will be included as header of each page of the site

$footer=null; //can be null ; or can be a string containing a relative path of a .php file that will be included as footer of each page of the site

//Completely optional header_fixed option. Can be =true; or =false; default being =false;
//if set to true, the optional header inserted with $header option will have its CSS attribut to Fixed, that is to say that il will remain on top of screen even
//when the user will scroll down the page. If this is your choise, make sure that your header size, in pixels, does not exceed 150px or a little more ; please test with a reduced viewport
//That is to say a window size not much large, as the width of those from mobile phone as an example, to check that your header doesn't overlays the beginning of the page content.  
//cannot bel null

$header_fixed=false;

?>
