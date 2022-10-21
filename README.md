# crero-yp
A simple CMS to run a YellowPage service listing music label websites using CreRo CMS. See https://crero.clewn.org for more information about CreRo. 

See crero-yp working at https://clewn.org/yp/ ! You can also add this address to your CreRo instance in the "creroyservices" to get your CreRo advertised on this YP server. 

## note on 20221021 update
Starting with this update, crero-yp will no longer expect htmlentites-encoded data from <crero instance>/crero-yp-api. 

The move to non htmlentities for CreRo will happen for its 2022102X version (X is a number since to determinate). Crero owners, remember to purge your ./crero-yp-api-cache from any .dat files once you will have upgraded to 2022102X). 


## Server configuration security notice

Some parts of the scripts here rely on $_SERVER PHP superglobal's SERVER_NAME field to redirect void, parameterless calls to API to yp.php which is the human-targeted readable homepage. Make sure that your web server is passing correctly SERVER_NAME as set in your server's vhost configuration, and not rely on browser-provided server name data, which would be a security risk. As an example, on Apache >= 2, the correct behavior is achieved by setting UseCanonicalName = On and set ServerName to the proper name of your sever in your vhost configuratin (see "site-available", "site-enabled", in /etc/apache2, and the a2ensite and a2dissite utilites). 

### On most if not any commercial-grade hostings this setting will have been set for your host. But be aware of this if you administrate your webserver by yourself. 


## Deployment instructions

* clone with git or download manually the package from this GitHub page. 
* edit the 3 config.php variables with site name, path to a free form .php header file to include on top of every page (optional) and a footer (same thing)
* deploy on your web server the following files : yp.php ; config.php ; index.php.template

Point your web browser to yourserver/yp.php . The script will create the necessary ./yp/ and ./yp/d/ directories and create an index.php in ./yp/ based on index.php.template. 

Upon updates it will recreate this file if the template happens to be more recent. 

* go spread the word and tell CreRo instance owners to add yourserver/yp/ in the list of YellowPage servers to ping in their CreRo admin panel options (mind the trailing slash)

## Basic https thing scenario

By default, when pinging a crero-yp-server, CreRo will register itself with an http (not https) url in the yellowpage. The yp server will then take care of testing if https is enabled, and, in such case, will use https to a) provide an https link to the CreRo instance in its listing and b) communicate with the CreRo yp API. 

Note the following : 

* If the CreRo server serves its site only in http everything will work fine
* If the https is properly configured, that is to say that pointing to http cleanly redirects to the https version of the page it will work fine
* If the server serves both http and https as well it will work fine
* But if the server is available in https but fails to redirect or serve http, crero-yp will fallback to provide a non-working http link to users, and will be unable to communicate with the Crero YP API to fetch useful informations like artist list, albums names and so on. 

Note : in the case 4) (the worst) it is possible to workaround this by enabling YPForceHTTPS in the CreRo server. See section "Requirement for CreRo instance to be listed in a yp server". 

### A very secondary point
By default yp.php will include a link named after the "site" variable of config.php that will point to the index file in the same directory, on top of pages. 

### Requirement for CreRo instance to be listed in a yp server

#### The list of yellowpage servers that your CreRo instance will ping to register in their listings is defined in "creroypservers" option in your CreRo admin panel. Please refer to its online documentation for example server (the currently running and infamous https://clewn.org/yp.php )

The following admin panel option must mandatory be set for your CreRo instance to be properly displayed by the crero-yp servers you will ping:

* server - this option reflects the yourdomain.tld/optional/path/to/CreRo address of the CreRo instance. Anyway, CreRo will not be able to work if not set (or many features in it), and this is the first option that CreRo documentation indicates as to be set. 
* name - the name of your label/netlabel/etc. If not set, there will be no link, because of an empty name, in the YP listing in order to visit your instance
* description - Can be blank and is not absolutely mandatory but is nevertheless strongly recommended

The following setting is a good idea:

* Install a png image named favicon.png at the root of your Crero install. Firstly, you'll have a favicon, helping people to identify your site visually in their (maybe numerous) opened browser tab, in their bookmarks, history, and so on. Secondly, this label logo will be displayed for your entry in the yp service, which also helps identifying your label. Thirdly, your label will have a logo on its pages, and if it has a radio, will display this logo instead of a blank "broken image" square when the radio plays a title that hasn't a cover art linked ot its album. 

##### Trouble with misconfigured https hosts
Please read the above "Basic https thing scenario" section to understand a bit, firstly. 
If your CreRo instance falls into point 4) (misconfigured HTTPS), you have no other choice that to set in Crero admin panel the YPForceHTTPS option to get a working directory listing. 

#### The question of advanced information

##### The advanced information feature requires that your CreRo instance have a least crero-yp-api.php available with API version >= 1 ; this yp-api was introduced in CreRo for the 20221002 milestone. 

crero-yp is able to query back your CreRo instance to try to reach its crero-yp-api, which is used by the yp server to add a "more item informations..." link in your server entry in its listing, and this link can be used to learn more about your label:
* its general label style as defined in radio_genres
* its list of label's artist as defined in "artists" option in your admin panel, -or- if this option is not set, alike if your instance is an mp3-only (typically a playlist webradio/download service with and autobuildradiobase set and its free download tier operated by you containing only mp3 and no flac nor ogg audio files), the whole list of artists provided by the media tier
* additionnal artist information as defined in highlight-artist-list ; especially the styles for this artist and the free form "info" field that is mainly meant to indicate years active for the music project
* also, each album, for each artist (sorted by "streaming" and "downloadable" categories)
* for each album, the whole tracklist.
* More to come. 
 
Note that the mp3-only, undefined "artists" option scenario requires that ID3 tags are utf-8 encoded. That is to say that ID3v2.3 or above has been used to tag the audio files. If you got very old mp3 files, encoded with iso-latin-1, non-western or "newly added in utf-8" special alphabet characters will not display correctly and break things in both your Crero instance and in the yp server. Please take a look at https://www.mydigitallife.net/how-to-auto-convert-mp3-id3-tag-charset-to-unicode-utf-8/ to help batch reencoding of old mp3 pre-ID3v2.3 non-utf8 encoded tags. 


