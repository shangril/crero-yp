<?php
//here comes what you need to configure for your instance of crero-yp

$site=""; //your site name goes here. Can be empty string. Cannot be null. 

$header=null; //can be null ; or can be a string containing a relative path of a .php file that will be included as header of each page of the site

$footer=null; //can be null ; or can be a string containing a relative path of a .php file that will be included as footer of each page of the site

//Completely optional header_fixed option. Can be =true; or =false; default being =false;
//if set to true, the optional header inserted with $header option will have its CSS attribut to Fixed, that is to say that il will remain on top of screen even
//when the user will scroll down the page ON THE HOMEPAGE ONLY (not on possible subsections of the site, as, as an example, additionnal information about a particular label, if available).
//If this is your choise, make sure that your header size, in pixels, does not exceed 150px or a little more ; please test with a reduced viewport
//That is to say a window size not much large, as the width of those from mobile phone as an example, to check that your header doesn't overlays the beginning of the page content.  

//This will apply on the homepage only - on subsections, the header will be present, but on top on the page, and not fixed, which means that when scrolling it will not remain omnipresent on screen
//This is whishable, because subsesction will automatically scroll down with #anchor HTML feature set to have the user straight directed to what is new and requested
//It was a concern for mobile user ; the displaying of an non-#anchor page, with the page reloading, displaying its top, and new things requiring to scroll down
//was counter-intuitive, mobile user may have thought that they found a bug and that their request displayed nothing. 
//cannot be null

$header_fixed=false;

//*****Here comes the options that ./api will deal with
//most install will not need them

$yp_api_force_https=false; //Boolean. If set to true, the api will reply to the pinging CreRo instance that it should prefer HTTPS protocol to communicate with this crero-yp server
//this is mainly used to provide links to pingued servers at bottom of instance pages with HTTPS properly set, regardless of which protocol is specified in the intance list of YP server to ping
//this can be reverted to false at any time if your instance no longer supports HTTPS
//but please note that this won't change the behavior of the CreRo instance when pinging the yp server. It will always use the protocol defined by the instance administrator it his/her own list of
//yp servers to ping

$yp_api_listing="public"; //String. The two valid values can be "public" or "private". If set to public, it indicates that your YP server accept to be listed (typically at the bottom of page) as a server 
//that the CreRo instance pingued recently and successfully.If set to private, it indicates that your instance wish to not be listed. This is indicative only. The CreRo instance can do what it wants, 
//regardless of what this setting is. Note that if the setting is not exacty set to a valid value, the CreRo server will likely default to "public". 
?>
