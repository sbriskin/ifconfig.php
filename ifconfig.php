<?php
/*
 * User connection info
 *
 * Version: 1.1 2014/03/08
 * License: GPL v2 (https://www.gnu.org/licenses/gpl-2.0.html)
 *
 * Copyright (C) 2014  Sergey Briskin (http://briskin.org)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 */

// Create array of values
$user = array(
	'ip' 		=> $_SERVER['REMOTE_ADDR'],
	'host' 		=> (isset($_SERVER['REMOTE_ADDR']) ? gethostbyaddr($_SERVER['REMOTE_ADDR']) : ""),
	'port' 		=> $_SERVER['REMOTE_PORT'],
	'ua' 		=> $_SERVER['HTTP_USER_AGENT'],
	'lang' 		=> $_SERVER['HTTP_ACCEPT_LANGUAGE'],
	'mime' 		=> $_SERVER['HTTP_ACCEPT'],
	'encoding' 	=> $_SERVER['HTTP_ACCEPT_ENCODING'],
	'charset' 	=> $_SERVER['HTTP_ACCEPT_CHARSET'],
	'connection' => $_SERVER['HTTP_CONNECTION'],
	'cache' 	=> $_SERVER['HTTP_CACHE_CONTROL'],
	'cookie' 	=> $_SERVER['HTTP_COOKIE'],
	'referer' 	=> $_SERVER['HTTP_REFERER'],
	'real_ip' 	=> $_SERVER['HTTP_X_REAL_IP'],
	'fwd_ip' 	=> $_SERVER['HTTP_X_FORWARDED_FOR'],
	'fwd_host' 	=> (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']) : ""),
	'dnt' 		=> $_SERVER['HTTP_DNT']
	);

// Check request (ex. ifconfig.php?q=ip)
$query=trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($_GET['q'])))))); 

// Return single value on request & die
if (isset($query) && !empty($user[$query]) && array_key_exists($query, $user)) {
	die($user[$query]."\n");
}
// Return full output in one of supported formats (html, text, xml, json. default: html)
elseif (isset($query) && ($query=="text")) {
	header('Content-Type: text/plain');
	foreach($user as $key => $value) {
		echo $key.": ".$value."\n";
	}
	die();

} elseif (isset($query) && ($query=="xml")) {
	header('Content-Type: text/xml');

// Function for SimpleXML creation
function array_to_xml(array $arr, SimpleXMLElement $xml)
{
    foreach ($arr as $k => $v) {
        is_array($v)
            ? array_to_xml($v, $xml->addChild($k))
            : $xml->addChild($k, $v);
    }
    return $xml;
}
echo array_to_xml($user, new SimpleXMLElement('<info/>'))->asXML();

} elseif (isset($query) && ($query=="json")) {
	header('Content-Type: application/json');
	die(json_encode($user));

} else {
	header('Content-Type: text/html');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>info</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
	<style>
		body {
			background: #FDFDFD;
			color: #111;
			font-size: .9em;
		}
		p {
			font-family: "Source Code Pro", "Droid Mono", "Courier New", "Consolas", "Terminal", fixed;
			line-height: 1em;
		}
		.small, .small > a {
			font-size: 9pt;
			color: #777;
			text-align: center;
			text-decoration: none;
		}
	</style>
</head>
<body>
<?
	foreach($user as $key => $value) {
		echo '	<p id='.$key.'>'.$key.': '.$value.'</p>'."\n";
	}
?>
<br/>
<p class="small">Copyright &copy; 2014 <a href="http://briskin.org">Sergey Briskin</a>.<br/>
<a href="https://github.com/sbriskin/ifconfig.php">Get Source code on GitHub</a></p>
</body>
</html>
<?
}
die();
?>