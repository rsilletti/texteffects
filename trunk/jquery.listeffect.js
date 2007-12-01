/**
 *
**/
(function($) {
/**
 *
**/
jQuery.fn.listeffect = function() {
		var noNumber = this.prev().text();
		var thisLink = this.attr('class');
		$("." + thisLink  + "").prev().addClass("link_" + thisLink  + "").append("(" + $("." + thisLink  + " > li").length + ")").fadeTo('fast', 0.67);
		$("." + thisLink  + "").hide();
		$(".link_" + thisLink  + "").toggle(function() {
			$("." + thisLink  + "").fadeIn('normal', function() {
				$(".link_" + thisLink  + "").fadeTo('fast', 0.89);
			});
			$("." + thisLink  + "").prev().text(noNumber);
		}, function() {
			$("." + thisLink  + "").fadeOut('normal', function() {
				$("." + thisLink  + "").prev().append("(" + $("." + thisLink  + " > li").length + ")");
			});
			$(".link_" + thisLink  + "").fadeTo('normal', 0.66);
		});
};

})(jQuery);
