/**
 *
**/
(function($) {
/**
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
