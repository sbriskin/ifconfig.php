ifconfig.php
============

**Simple PHP script to show IP address, UserAgent and other info**

It works exactly the same as [ifconfig.me](http://ifconfig.me) and [ifconfig.co](http://ifconfig.co).

Available all basic features such as output in HTML, plain text, XML and JSON.
By default it will be in HTML. Also it is possible to request single values.

Visit some of the links below to view it in action:
* [all in plain text](http://briskin.org/ifconfig/text)
* [all in xml](http://briskin.org/ifconfig/xml)
* [ip address only](http://briskin.org/ifconfig/ip)
* [useragent only](http://briskin.org/ifconfig/ua)



This is example of .htaccess rules, to make this script more user friendly:

	RewriteEngine On

	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^ifconfig$ ifconfig.php [L]
	RewriteRule ^ifconfig/(.*)$ /ifconfig.php?q=$1 [L]

With this code in .htaccess file there is no need to type long line 'ifconfig.php?q='.
Now just enough to open 'ifconfig/xml' to get XML output or 'ifconfig/ua' to determine useragent.

Run `curl briskin.org/ifconfig/text` in Linux terminal to get some info.
