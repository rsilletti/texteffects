/*
 * jQuery default class list effects  (textpattern)
 * @requires jQuery v1.2 or later
 *
 *   http://www.gnu.org/licenses/gpl.html
 *
//**
 * Assumes the following textpattern tag usage guidelines:
 *  1. Label and Labeltag attributes defined.
 *  2. Wraptag and Break (list style tag) attributes defined.
 *  3. Default classes applied (no class attribute defined in tag.)
 *
 * Tags defined:
 *  "linklist"
 *  "recent_articles"
 *  "recent_comments"
 *  "related_articles"
 *  "section_list"
 *  "category_list"
**/
$(document).ready(function() {
	var nonumber = $('.linklist').prev().text();
	$('.linklist').prev().addClass("link_placeholder").append('(' + $(".linklist li").length + ')');
	$('.linklist').hide();
	$('.link_placeholder').toggle(function() {
		$('.linklist').fadeIn('slow');
			$('.linklist').prev().text(nonumber);
	}, function() {
		$('.linklist').fadeOut('slow');
			$('.linklist').prev().addClass("link_placeholder").append('(' + $(".linklist li").length + ')');
	});
});
$(document).ready(function() {
	var nonumber = $('.recent_articles').prev().text();
	$('.recent_articles').prev().addClass("recent_placeholder").append('(' + $(".recent_articles li").length + ')');
	$('.recent_articles').hide();
	$('.recent_placeholder').toggle(function() {
		$('.recent_articles').fadeIn('slow');
			$('.recent_articles').prev().text(nonumber);
	}, function() {
		$('.recent_articles').fadeOut('slow');
			$('.recent_articles').prev().addClass("recent_placeholder").append('(' + $(".recent_articles li").length + ')');
	});
});
$(document).ready(function() {
	var nonumber = $('.recent_comments').prev().text();
	$('.recent_comments').prev().addClass("recentc_placeholder").append('(' + $(".recent_comments li").length + ')');
	$('.recent_comments').hide();
	$('.recentc_placeholder').toggle(function() {
		$('.recent_comments').fadeIn('slow');
			$('.recent_comments').prev().text(nonumber);
	}, function() {
		$('.recent_comments').fadeOut('slow');
			$('.recent_comments').prev().addClass("recentc_placeholder").append('(' + $(".recent_comments li").length + ')');
	});
});
$(document).ready(function() {
	var nonumber = $('.related_articles').prev().text();
	$('.related_articles').prev().addClass("related_placeholder").append('(' + $(".related_articles li").length + ')');
	$('.related_articles').hide();
	$('.related_placeholder').toggle(function() {
		$('.related_articles').fadeIn('slow');
			$('.related_articles').prev().text(nonumber);
	}, function() {
		$('.related_articles').fadeOut('slow');
			$('.related_articles').prev().addClass("related_placeholder").append('(' + $(".related_articles li").length + ')');
	});
});
$(document).ready(function() {
	var nonumber = $('.category_list').prev().text();
	$('.category_list').prev().addClass("cat_placeholder").append('(' + $(".category_list li").length + ')');
	$('.category_list').hide();
	$('.cat_placeholder').toggle(function() {
		$('.category_list').fadeIn('slow');
			$('.category_list').prev().text(nonumber);
	}, function() {
		$('.category_list').fadeOut('slow');
			$('.category_list').prev().addClass("cat_placeholder").append('(' + $(".category_list li").length + ')');
	});
});
$(document).ready(function() {
	var nonumber = $('.section_list').prev().text();
	$('.section_list').prev().addClass("section_placeholder").append('(' + $(".section_list li").length + ')');
	$('.section_list').hide();
	$('.section_placeholder').toggle(function() {
		$('.section_list').fadeIn('slow');
			$('.section_list').prev().text(nonumber);
	}, function() {
		$('.section_list').fadeOut('slow');
			$('.section_list').prev().addClass("section_placeholder").append('(' + $(".section_list li").length + ')');
	});
});

