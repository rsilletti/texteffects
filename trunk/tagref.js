{ "tags" : 
	[ 
{
    "name" : "article",
	"atts" : [
			{"att" : "customfieldname" , "type" : "value" , "desc" : "Restrict to articles with specified value for specified custom field name. Value is the name of the custom field." } ,
			{"att" : "keywords" , "type" : "keyword(s)" , "desc" : "Restrict to articles with specified keyword(s)."  } ,
			{"att" : "status" , "type" : "status" , "desc" : "Restrict to articles with specified status. Available values: draft, hidden, pending, live, sticky. Default is live."  } ,
			{"att" : "time" , "type" : "time" , "desc" : "Restrict to articles posted within specified timeframe. Available values: past, future, or any (both past and future). Default is past."  } ,
			{"att" : "sort" , "type" : "sort value(s)" , "desc" : "How to sort resulting list. Available values: ID (article id#), AuthorID (author), LastMod (date last modified), LastModID (author of last modification), Posted (date posted), Title, Category1, Category2, comments_count, Status, Section, Keywords, Image (article image id#), url_title, custom_1 through custom_10, rand() (random). When viewing a search results list, score (how well the search terms match the article) is an additional value available. Default value is Posted desc (score desc for search results)."  } ,
			{"att" : "offset" , "type" : "integer" , "desc" : "The number of articles to skip. Default is 0."  } ,
			{"att" : "limit" , "type" : "integer" , "desc" : "The number of articles to display. Default is 10."  } ,
			{"att" : "pageby" , "type" : "integer" , "desc" : "The number of articles to jump forward or back when an older or newer link is clicked. Allows you to call the article tag several times on a page without messing up older/newer links. Default value matches the value assigned to limit."  } ,
			{"att" : "pgonly" , "type" : "boolean" , "desc" : "Do the article count, but do no display anything. Used when you want to show a search result count, or article navigation tags before the list of articles. Just Make sure that, other than pgonly, both article tags are identical (form-related attributes are the exception, they do not need to be assigned). Default is 0 (no)."  } ,
			{"att" : "allowoverride" , "type" : "boolean" , "desc" : "Whether to use override forms for the generated article list. Default is 1 (yes)."  } ,
			{"att" : "searchsticky" , "type" : "boolean" , "desc" : "When outputting search results, include articles with status sticky. Default is 0 (no)."  } ,
			{"att" : "form" , "type" : "form name" , "desc" : "Use specified form. Default is default."  } ,
			{"att" : "listform" , "type" : "form name" , "desc" : "Use specified form when page is displaying an article list."  } ,
			{"att" : "searchform" , "type" : "form name" , "desc" : "The form to be used for your customized search results output. Default is: search_results."  }
			] ,
	"tag_type" : "Single" ,
	"context" : "Page Template" ,
	"links" : [
			{" " : " " } ,
			{" " : " " }
			] ,
	"comments" : "Returns an article list using the defined article form"		
} ,
{
    "name" : "article_custom",
	"atts" : [
			{"att" : "id" , "type" : "article ID number" , "desc" : "Display specific article."  } ,
			{"att" : "customfieldname" , "type" : "value" , "desc" : "Restrict to articles with specified value for specified custom field name. Value is the name of the custom field." } ,
			{"att" : "section" , "type" : "section name" , "desc" : "Restrict to articles from specified sections. Default is unset, retrieves from all sections. "  } ,
			{"att" : "category" , "type" : "category name" , "desc" : "Restrict to articles from specified category. Default is unset, retrieves from all categories. "  } ,
			{"att" : "keywords" , "type" : "keyword(s)" , "desc" : "Restrict to articles with specified keyword(s)."  } ,
			{"att" : "excerpted" , "value" : "section name" , "desc" : "Restrict to articles with/without an excerpt. Available values: y (yes, return only those containing an excerpt) or n (no, return all). Default is n (no, return all)."  } ,
			{"att" : "status" , "type" : "status" , "desc" : "Restrict to articles with specified status. Available values: draft, hidden, pending, live, sticky. Default is live."  } ,
			{"att" : "time" , "type" : "time" , "desc" : "Restrict to articles posted within specified timeframe. Available values: past, future, or any (both past and future). Default is past."  } ,
			{"att" : "month" , "type" : "yyyy-mm" , "desc" : "Restrict to articles posted within the specified month. Default is unset."  } ,
			{"att" : "author" , "type" : "author`s name" , "desc" : "Restrict to articles by specified author. Default is unset. "  } ,
			{"att" : "sort" , "type" : "sort value(s)" , "desc" : "How to sort resulting list. Available values: ID (article id#), AuthorID (author), LastMod (date last modified), LastModID (author of last modification), Posted (date posted), Title, Category1, Category2, comments_count, Status, Section, Keywords, Image (article image id#), url_title, custom_1 through custom_10, rand() (random). When viewing a search results list, score (how well the search terms match the article) is an additional value available. Default value is Posted desc (score desc for search results)."  } ,
			{"att" : "offset" , "type" : "integer" , "desc" : "The number of articles to skip. Default is 0."  } ,
			{"att" : "limit" , "type" : "integer" , "desc" : "The number of articles to display. Default is 10."  } ,
			{"att" : "allowoverride" , "type" : "boolean" , "desc" : "Whether to use override forms for the generated article list. Default is 1 (yes)."  } ,
			{"att" : "form" , "type" : "form name" , "desc" : "Use specified form. Default is default."  } ,
			] ,
	"tag_type" : "Single" , 
	"context" : "Page Template" ,
	"links" : [
			{" " : " " } ,
			{" " : " " }
			] ,
	"comments" : "Unlike <Txp:article_/>, article_custom will always return an article list, and is not context-sensitive. This means that, while <Txp:article_/> can only see posts within the currently viewed section/category/author, etc, article_custom can see all posts from all sections, categories and authors, unless you restrict it via attributes (see below), and that context-sensitive navigation tags, such as <txp:older> and <txp:newer>, will not work."		
}
	]
}
