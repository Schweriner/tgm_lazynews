.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _start:

=============
Documentation
=============


What does it do?
==================

.. tip::

	You can find a german documentation about this extension at http://blog.teamgeist-medien.de/?p=1162

This extension provides a "type" page to request news records from "news" for lazy loading with jQuery.

Just install the extension and include the static Typoscript. Then you should study the provides example template of the extension 
inside the Resources directory of the extension. Modify the template to make the resulting output look exacly like the output of the news without beeing lazy loaded!

The extension will include the following Javascript / jQuery function to your page::

	var lazy_endReached = false;
	var lazy_loading = false;
	 
	function lazyLoadNews(model, selector, offset, limit, constraints) {
	     
	    if(typeof(constraints)==='undefined') constraints = false;
	     
	    $loader = '<div class="ajax_loader" style="padding: 30px 0; text-align: center; float: left; width: 100%;"><img src="typo3conf/ext/tgm_lazynews/Resources/Public/Image/ajax-loader.gif" alt="Loading..." /></div>';
	    selector.append($loader);
	     
	    var data = 
	        { 
	            "type" : "6363", 
	            "tx_tgmlazynews_ajax[action]" : "ajax", 
	            "tx_tgmlazynews_ajax[controller]" : "News",
	            "tx_tgmlazynews_ajax[model]" : model, 
	            "tx_tgmlazynews_ajax[offset]" : offset,
	            "tx_tgmlazynews_ajax[limit]" : limit,
	        };
	     
	    if(constraints) data['tx_tgmlazynews_ajax[constraints]'] = constraints;
	     
	    $.ajax({
	        type: "GET",
	        dataType: "text",
	        url: $('base').attr('href'),
	        data: data,
	        success: function (d) {
	            $('.ajax_loader').remove();
	             
	            if(d=='end') {
	                lazy_endReached = true;
	                return;
	            }
	            $(d).appendTo(selector).fadeIn();
	            lazy_loading = false;
	        }
	    });
	}

You just have to call the function if if you want to add News to your list view. Heres an example for calling the function including comments and the possible parameters::

	$(document).ready(function() {
	   if($('.news-list-view').length) initLazyLoading(); 
	});
	 
	function initLazyLoading() {
	 
	    $(window).scroll(function() {
	         
	        // Lazy load when user reaches the end of the news-list
	        if($(window).scrollTop()+$(window).height() > $('.news-list-view').position().top+$('.news-list-view').outerHeight(true) && lazy_endReached==false && !lazy_loading) {
	             
	            // The offset can be the count of currently visible articles
	            var offset = $('.news-list-view .article').length;
	             
	            // Set lazy loading true to prevend multiple lazy loading at the same time
	            lazy_loading = true;
	 
	            // Constraints must be a JSON Object like this: 
	            //var contraints = {'categories' : "1,2,3"};
	            var contraints = false;
	             
	            // Call the function
	            // Model = news, jQuery selected news-list-container, offset, limit and optional constraints
	            lazyLoadNews('news',$('.news-list-view'), offset, 5, contraints);
	        } 
	    });
	}


Thats it. Have fun.

Templating
==================

Since version 0.1.4 the extension includes the Typoscript and language data of the original news extension.
This allows you to use the ViewHelpers of news in Fluid using the {settings} array.

For access to the language files of news, use the attribute extensionName="News" in the f:translate tag.

Changelog
==================

You can find the changelog on github https://github.com/Schweriner/tgm_lazynews/commits/master