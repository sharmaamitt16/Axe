This module is used to provide json output of page type nodes. 
You need to configure the api key on system site configuration page once
and can provide json data to others.

Installation:
----------------
1. Install and Enable Axe Assignemnt module.

Configuration:
---------------
1. Go to admin/config/system/site-information and set site API key.

Usage:
--------------
Browse http://localhost/page_json/apikey/nodeid

You will get the json data if parameter is appropriate otherwise
it will return access denied.
