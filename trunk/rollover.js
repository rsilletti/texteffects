/*
 * jQuery rollover text effect (general use)
 * @requires jQuery v1.1 or later
 *
 *   http://www.gnu.org/licenses/gpl.html
 */
/**
 * Applies text as defined in the "name" attribute of any source element of class "rollover_src"
 * to a single element set to html id "rollover_dest" for the duration of the hover state 
 * sustained within the source element.
 *
 * @example  destination link initial setting : <p id="rollover_dest">&nbsp;</p>
 *
 * @example  first source link : <a href="mysite.com" class="rollover_src" name="My Site Info" title="Home">My Link</a>
 * @result  html : <p id="rollover_dest">My Site Info</p> on mouseover <p id="rollover_dest">Thanks for dropping by!</p> on mouseout.
 *
 * @example  second source link : <a href="exitlink.com" class="rollover_src" name="Alternate Site Info" title="Aternate">Alternate Site</a>
 * @result  html : <p id="rollover_dest">Alternate Site Info</p> on mouseover <p id="rollover_dest">Thanks for dropping by!</p> on mouseout.
**/

$(document).ready(function() {
	$(".rollover_src").hover(function(){
		$("#rollover_dest").html($(this).attr("name"));
		},function(){
		$("#rollover_dest").html("Thanks for dropping by!");
	});

});