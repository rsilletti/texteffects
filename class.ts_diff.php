<?php

/**
* Returns diff values in seconds between current server time
* and values set to runtime arrays drawn from settings in the
* database via static functions defined for each value.
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
* 02110-1301 USA
*
* @package txpdiff
* @author Rick Silletti
* @copyright 2009 Rick Silletti
*/

abstract class ts_diff {

/**
* Article posting time diff to server current time. 
* Static call ts_diff::apos_diff()
* @global $thisarticle
* @return integer   0 on failure
*/
 public static function apos_diff() {
 
	global $thisarticle;
	assert_article();
	
	if($thisarticle['posted']) {
		return time() - $thisarticle['posted'] ;
	} else {
		return 0;
		}
 }

/**
* Article expiration time diff to server current time. 
* Static call ts_diff::axpr_diff()
* @global $thisarticle
* @return integer   0 on failure
*/
 public static function axpr_diff() {
 
	global $thisarticle;
	assert_article();
	
	if($thisarticle['expires']) {
		return time() - $thisarticle['expires'] ;
	} else {
		return 0;
		}
 }

/**
* Article modified time diff to server current time. 
* Static call ts_diff::amdf_diff()
* @global $thisarticle
* @return integer   0 on failure
*/
 public static function amdf_diff() {
 
	global $thisarticle;
	assert_article();
	
	if($thisarticle['modified']) {
		return time() - $thisarticle['modified'] ;
	} else {
		return 0;
		}
 }

/**
* Comment posting time diff to server current time. 
* Static call ts_diff::cpos_diff()
* @global $thiscomment
* @return integer   0 on failure
*/
 public static function cpos_diff() {
 
	global $thiscomment;
	assert_comment();
	
	if($thiscomment['posted']) {
		return time() - $thiscomment['posted'] ;
	} else {
		return 0;
		}
 }

/**
* File creation time diff to server current time. 
* Static call ts_diff::fpos_diff()
* @global $thisfile
* @return integer   0 on failure
*/
 public static function fpos_diff() {
 
	global $thisfile;
	assert_file();
	
	if($thisfile['created']) {
		return time() - $thisfile['created'] ;
	} else {
		return 0;
		}
 }

/**
* File modified time diff to server current time. 
* Static call ts_diff::fmdf_diff()
* @global $thisfile
* @return integer   0 on failure
*/
 public static function fmdf_diff() {
 
	global $thisfile;
	assert_file();
	
	if($thisfile['modified']) {
		return time() - $thisfile['modified'] ;
	} else {
		return 0;
		}
 }

/**
* Link created time diff to server current time. 
* Static call ts_diff::lpos_diff()
* @global $thislink
* @return integer   0 on failure
*/
 public static function lpos_diff() {
 
	global $thislink;
	assert_link();
	
	if($thislink['date']) {
		return time() - $thislink['date'] ;
	} else {
		return 0;
		}
 }
 }
?>