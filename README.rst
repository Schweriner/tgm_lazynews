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

	    // JS Constraints are removed since 0.2.0 see Typoscript
	    // if(constraints) data['tx_tgmlazynews_ajax[constraints]'] = constraints;
	     
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
	 
	            // JS CONSTRAINTS ARE NO LONGER SUPPORTET! SEE TYPOSCRIPT!
	            // var contraints = {'categories' : "1,2,3"};

	            // Call the function
	            // Model = news, jQuery selected news-list-container, offset, limit and optional constraints
	            lazyLoadNews('news',$('.news-list-view'), offset, 5);
	        } 
	    });
	}


Thats it. Have fun.

Templating
==================

Since version 0.1.4 the extension includes the Typoscript and language data of the original news extension.
This allows you to use the ViewHelpers of news in Fluid using the {settings} array.

For access to the language files of news, use the attribute extensionName="News" in the f:translate tag.

Filtering of news by constraints / conditions
==================

Due to security and configuration-possibilities, the **constraints have been removed from the Javascript since version 0.2.0 and now placed inside Typoscript**.
You can configure additional conditions on the repository request in plugin.tx_tgmlazynews.settings.lazy_constraints.

The following example configuration will **exclude News-Events of EXT:eventnews** from beeing fetched by the repository::

	plugin.tx_tgmlazynews {
		settings {
			lazy_constraints {
				0 {
					property = is_event
					value = 0
					intval = 1
					operator = equals
				}
			}
		}
	}
You can use the "lazy_constraints" part of the settings like an array [0,1,3] - all conditions will be combined with AND!
Property = the field the value must match with. At the moment you can use the operators:

* contains
* equals
* greaterThan
* greaterThanOrEqual
* lessThan
* lessThanOrEqual

Please make sure the property you are using really exists in the database!

Changelog
==================

You can find the changelog on github https://github.com/Schweriner/tgm_lazynews/commits/master