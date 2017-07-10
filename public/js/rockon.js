"use strict";
 
$(document).on("ready", function(){
     /* url  navigation active */

    /*var url = window.location;
    var element = $('.side-nav li a').filter(function() {
        return this.href == url;
    }).addClass('active').parent("li").addClass('active').parentsUntil("collapsible-body").slideDown().parent(".bold").addClass("active").children("a").addClass("active");
    
    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }*/
    
    $(".menu-collapse").on("click", function(){
        $("body").toggleClass("menuclose");
    });
    $(".menu-small").on("click",function(){
        $("body").toggleClass("menusmall");
    });

    $(".menuclosebtn").on("click",function(){
        $("body").removeClass("menusmall");
        $("body").removeClass("menuclose");
    });
    
     $(".chat-collapse").on("click", function(){
        $(".chat_panel").toggleClass("chatopen");
    });
    $(".chat-close").on("click", function(){
        $(".chat_panel").removeClass("chatopen");
    });
    
     $(".theme-collapse").on("click", function(){
        $(".theme_panel").toggleClass("themeopen");
    });
    $(".theme-close").on("click", function(){
        $(".theme_panel").removeClass("themeopen");
    });
    
    $(".theme_picker .theme_block").on("click", function(){
        var theme =$(this).attr("alt");
        $("body").removeClass().addClass(theme);
        
    });
    
});