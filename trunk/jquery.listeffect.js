/**
 *
**/

jQuery.fn.listeffect = function() {
	var noNumber = $(this).prev().text();
	var thislink = $(this).attr('class');
		$("." + thislink  + "").prev().addClass("link_" + thislink  + "").append("(" + $("." + thislink  + " li").length + ")").fadeTo('fast', 0.67);
		$("." + thislink  + "").hide();
		$(".link_" + thislink  + "").toggle(function() {
			$("." + thislink  + "").fadeIn('normal', function() {
				$(".link_" + thislink  + "").fadeTo('fast', 0.89);
			});
			$("." + thislink  + "").prev().text(noNumber);
		}, function() {
			$("." + thislink  + "").fadeOut('normal', function() {
				$("." + thislink  + "").prev().append("(" + $("." + thislink  + " li").length + ")");
			});
			$(".link_" + thislink  + "").fadeTo('normal', 0.66);
		});
};
