# crero-yp
A simple CMS to run a YellowPage service listing music label websites using CreRo CMS. See http://crero.clewn.org for more information about CreRo. 

See crero-yp working at https://clewn.org/yp.php

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

### A very secondary point
By default yp.php will include a link named after the "site" variable of config.php that will point to the index file in the same directory, on top of pages. 

### Requirement for CreRo instance to be listed in a yp server
The following admin panel option must mandatory be set for your CreRo instance to be properly displayed by the crero-yp servers you will ping:

* server - this option reflects the yourdomain.tld/optional/path/to/CreRo address of the CreRo instance. Anyway, CreRo will not be able to work if not set (or many features in it), and this is the first option that CreRo documentation indicates as to be set. 
* name - the name of your label/netlabel/etc. If not set, there will be no link, because of an empty name, in the YP listing in order to visit your instance
* description - Can be blank and is not absolutely mandatory but is nevertheless strongly recommended

The following setting is a good idea:

* Install a png image named favicon.png at the root of your Crero install. Firstly, you'll have a favicon, helping people to identify your site visually in there (maybe numerous) opened browser tab, in their bookmarks, history, and so on. Secondly, this label logo will be displayed for your entry in the yp service, which also helps identifying your label

The question of advanced information

* crero-yp is able to query back your CreRo instance to try to reach its crero-yp-api, which is used by the yp server to add a "more item informations..." link in your server entry in its listing, and this link can be used to learn more about your label:
** its general label style as defined in radio_genres
** its list of artist as defined in artists -or- if your instance is an mp3-only (typically a playlist webradio/download service with and autobuildradiobase set and its free download tier operated by you containing only mp3 and no flac nor ogg audio files) and artists option undefined, the whole list of artist provided by the media tier
** additionnal artist information as defined in highlight-artist-list ; especially the styles for this artist and the free form "info" field that is mainly meant to indicate years active for the music project
** also, each album, for each artist (sorted by "streaming" and "downloadable" categories)
** for each album, the whole tracklist.
** More to come. 
*** Note that mp3-only scenario requires that ID3 tags are utf-8 encoded. That is to say that ID3v2.3 or above has been used to tag the audio files. If you got very old mp3 files, encoded with iso-latin-1, non-western or "newly added in utf-8" special alphabet characters will not display correctly and break things in both your Crero instance and in the yp server. Please take a look at https://www.mydigitallife.net/how-to-auto-convert-mp3-id3-tag-charset-to-unicode-utf-8/ to help batch reencoding of old mp3 pre-ID3v2.3 non-utf8 encoded tags. 

The advanced information feature requires that your CreRo instance have a least crero-yp-api.php available with API version >= 1 ; this yp-api was introduced in CreRo for the 20221002 milestone. 
