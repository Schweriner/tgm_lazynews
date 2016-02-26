var lazy_endReached = false;
var lazy_loading = false;

function lazyLoadNews(model, selector, offset, limit, pageid) {
    
    if(typeof(pageid)==='undefined') {
        pageid = false;
    } else {
        pageid = parseInt(pageid);
    }
    
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
    
    if(pageid) data['id'] = pageid;
    
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

// Example script for calling the function:
/*
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
            // Model = news, jQuery selected news-list-container, offset, limit and an optional page id if the root page is a shortcut
            lazyLoadNews('news',$('.news-list-view'), offset, 5, contraints, 666);
        } 
    });
}
*/