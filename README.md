# crero-yp
A simple CMS to run a YellowPage service listing music label websites using CreRo CMS. See http://crero.clewn.org for more information about CreRo. 

See crero-yp working at https://clewn.org/yp.php

## Deployment instructions

* clone with git or download manually the package from this GitHub page. 
* edit config.php with site name, path to a header free form .php file to include on every page (optional) and a footer (same thing)
* deploy on your web server the following files : yp.php ; config.php ; index.php.template

Point your web browser to yourserver/yp.php . The script will create the necessary ./yp/ and ./yp/d/ directories and create an index.php in ./yp/ based on index.php.template. 

Upon updates it will recreate this file if the template happens to be more recent. 

* go spread the word and tell CreRo instance owners to add yourserver/yp/ in the list of YellowPage servers to ping in their CreRo admin panel options (mind the trailing slash)

## Basic https thing scenario

By default, when pinging a crero-yp-server, CreRo will register itself with an http (not https) url in the yellowpage. The yp server will then take care of testing if https is enabled, and, in such case, will use https to a) provide an https link to the CreRo instance in its listing and b) communicate with the CreRo yp API. 

Note the following : 

* If the CreRo server serves its site only in http everything will work fine
* If the https is properly configured, that is to say that pointing to http cleanly redirects to the https version of the page it will work fine
* If the server serves both http and https as weel it will work fine
* But if the server is available in https but fails to redirect or serve http, crero-yp will fallback to provide a non-working http link to users, and will be unable to communicate with the Crero YP API to fetch useful informations like artist list, albums names and so on. 

