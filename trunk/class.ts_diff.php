<?php
/**
* @license http://www.gnu.org/licenses/licenses.html#GPL
* @package txpdiff
*/

/**
* Returns diff values in seconds between current server time
* and values set to runtime arrays drawn from settings in the
* database via static functions defined for each value.
*
* @package txpdiff
* @author Rick Silletti
* @copyright 2009 Rick Silletti
*/

abstract class ts_diff {

/**
* Article posting time diff to server current time. 
* Static call ts_diff::apos_diff()
* @return integer   false on failure
*/
 static function apos_diff() {
 
	global $thisarticle;
	assert_article();
	
	if($thisarticle['posted']) {
		return time() - $thisarticle['posted'] ;
	} else {
		return false;
		}
 }

/**
* Article expiration time diff to server current time. 
* Static call ts_diff::axpr_diff()
* @return integer   false on failure
*/
 static function axpr_diff() {
 
	global $thisarticle;
	assert_article();
	
	if($thisarticle['expires']) {
		return time() - $thisarticle['expires'] ;
	} else {
		return false;
		}
 }

/**
* Article modified time diff to server current time. 
* Static call ts_diff::amdf_diff()
* @return integer   false on failure
*/
 static function amdf_diff() {
 
	global $thisarticle;
	assert_article();
	
	if($thisarticle['modified']) {
		return time() - $thisarticle['modified'] ;
	} else {
		return false;
		}
 }

/**
* Comment posting time diff to server current time. 
* Static call ts_diff::cpos_diff()
* @return integer   false on failure
*/
 static function cpos_diff() {
 
	global $thiscomment;
	assert_comment();
	
	if($thiscomment['posted']) {
		return time() - $thiscomment['posted'] ;
	} else {
		return false;
		}
 }

/**
* File creation time diff to server current time. 
* Static call ts_diff::fpos_diff()
* @return integer   false on failure
*/
 static function fpos_diff() {
 
	global $thisfile;
	assert_file();
	
	if($thisfile['created']) {
		return time() - $thisfile['created'] ;
	} else {
		return false;
		}
 }

/**
* File modified time diff to server current time. 
* Static call ts_diff::fmdf_diff()
* @return integer   false on failure
*/
 static function fmdf_diff() {
 
	global $thisfile;
	assert_file();
	
	if($thisfile['modified']) {
		return time() - $thisfile['modified'] ;
	} else {
		return false;
		}
 }

/**
* Link created time diff to server current time. 
* Static call ts_diff::lpos_diff()
* @return integer   false on failure
*/
 static function lpos_diff() {
 
	global $thislink;
	assert_link();
	
	if($thislink['date']) {
		return time() - $thislink['date'] ;
	} else {
		return false;
		}
 }
?>