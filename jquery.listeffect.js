/**
* jQuery list effect  (general)
* @requires jQuery v1.2 or later
*
*   http://www.gnu.org/licenses/gpl.html
*
**/
(function($) {
/**
 * Provides a list effect that collapses the list and appends the number of list items to the remaining label.
 * Assumes that list items will be wrapped in a list break tag such as <li>.
 * Assumes that lists will have tagged labels.
 * Operative class should be assigned to the ul element of the list, nested elements will not be reflected in the element count.
 *
 * @example html:
 *
 *      <h3>A Link List</h3>
 *        <ul class="linklist">
 *         <li> Link 1 </li>
 *         <li> Link 2 </li>
 *        </ul>
 *
 * @example $('.linklist').listeffect('open' , .69)
 * @result A list open on page load that when clicked will collapse and append the list item number, and reduce text opacity to .69
 *
 * @example $('.linklist').listeffect(.69)
 * @result A list collapsed on page load (default) with appended list item number, and reduced text opacity to .69
 *
 * Options include list open or collapsed on page load, label text opacity setting between 0 and 1
 *
**/
jQuery.fn.listeffect = function(startState , fadeStop) {
		var noNumber = this.prev().text();
		var thisLink = this.attr('class');
			if (startState == undefined) {
				startState = 'close';
			}
				if (fadeStop == undefined) {
					if (startState.constructor == Number) {
						fadeStop = startState;
						startState = 'close';
					} else {
						fadeStop = 1;
					}
				}
			if (startState == 'open') {
				$("." + thisLink  + "").prev().addClass("link_" + thisLink  + "");
				
				$(".link_" + thisLink  + "").toggle(function() {
					$("." + thisLink  + "").fadeOut('normal', function() {
						$("." + thisLink  + "").prev().append("(" + $("." + thisLink  + " > li").length + ")");
					});
					$(".link_" + thisLink  + "").fadeTo('normal', fadeStop);
				}, function() {
					$("." + thisLink  + "").fadeIn('normal', function() {
						$(".link_" + thisLink  + "").fadeTo('fast', 1 );
					});
					$("." + thisLink  + "").prev().text(noNumber);
				});			
			}
	if (startState == 'close') {
			$("." + thisLink  + "").prev().addClass("link_" + thisLink  + "").append("(" + $("." + thisLink  + " > li").length + ")").fadeTo('fast', fadeStop);
			$("." + thisLink  + "").hide();
			
		$(".link_" + thisLink  + "").toggle(function() {
			$("." + thisLink  + "").fadeIn('normal', function() {
				$(".link_" + thisLink  + "").fadeTo('fast', 1 );
			});
			$("." + thisLink  + "").prev().text(noNumber);
		}, function() {
			$("." + thisLink  + "").fadeOut('normal', function() {
				$("." + thisLink  + "").prev().append("(" + $("." + thisLink  + " > li").length + ")");
			});
			$(".link_" + thisLink  + "").fadeTo('normal', fadeStop);
		});
	}
		return this;
};

})(jQuery);
