/* <![CDATA[ */



/* JCAROUSEL CALLBACK FUNCTIONS =========================== */


function jcarousel_initCallback(carousel) {
    
    //GENERATE THE slide indicators and jcarousel-control div
    //create jcarousel-control div
    var label =  (carousel.options.indicator_label!="") ? "<span class='features-label'>"+carousel.options.indicator_label+" </span>" : "" ;
    //alert(carousel.container.context.id);
    $(carousel.options.skin+' .jcarousel-clip #'+carousel.container.context.id).before("<div id='"+carousel.container.context.id+"-control' class='jcarousel-control features-control'>"+label+"</div>");
    
    //get the UL's id that hosts the carousel, then add a feature indicator for each slide
    //alert(carousel.options.indicator_type );
    if (carousel.options.indicator_type != "int") {
        var ul_id = carousel.container.context.id;
        //alert(ul_id );
        $(carousel.options.skin+" #"+ul_id).find("li").not("li ul li").each(function(i) {
            $(carousel.options.skin+' #'+ul_id+'-control.features-control').append( "<a href='#' title='" + (i+1) +"'><span id=\""+ul_id+"_link_"+(i+1)+"\" class='features-indicator'>&nbsp;</span></a>");
        });
    } else {
        //alert(carousel.options.skin);
        $(carousel.options.skin+' #'+carousel.container.context.id+'-control').append( "<span class='indicator-num'>"+carousel.options.offset+" of "+carousel.options.size+"</span>");
    }
    
    //bind action to links
    $(carousel.options.skin+' .features-control a').bind('click', function() {
        carousel.scroll($.jcarousel.intval($(this).attr('title')));
        return false;
    });
    
    

    $(carousel.options.skin+' #features-next').bind('click', function() {
        carousel.next();
        return false;
    });

    $(carousel.options.skin+' #features-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
    
    //pausing the carousel on mouse over when auto is activated
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
    
    $('#searchterms2').focus(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
    
    if (carousel.options.wrap=='circular') {
        $('#'+carousel.container.context.id).clone().appendTo('#wrapper').attr('id',carousel.container.context.id+'-copy').attr('class','').hide();
    }
};

// FUNCTION for making the feature indicators active
function jcarousel_itemFirstInCallback(carousel, item, idx, state) {
    var i = carousel.index(idx, carousel.options.size);
    
    //if indicator type is not integer
    if (carousel.options.indicator_type != "int") {
        var ul_id = carousel.container.context.id;
        $(carousel.options.skin+' #'+ul_id+'-control .features-indicator').removeClass("active");
        for (var j = 0; j < carousel.options.visible; j++) {
            $(carousel.options.skin+' #'+ul_id+'_link_'+(i+j)).addClass("active");
        }
    } else {
        //if indicator_type is int
        $(carousel.options.skin+' #'+carousel.container.context.id+'-control span').html(i+" of "+carousel.options.size+" <a href='#' class='carouselReset' title='Reset Slides'>&nbsp;</a>");
        //bind reset
        $(carousel.options.skin+' #'+carousel.container.context.id+'-control span a.carouselReset').bind('click', function() {
            carousel.scroll($.jcarousel.intval(1));
            return false;
        });
    }
    
};
// FUNCTION FOR TRUE CIRCULAR CAROUSEL
function jcarousel_itemVisibleInCallback(carousel, item, i, state, evt)
{
    var idx = carousel.index(i, carousel.options.size);
    carousel.add(i, $('#'+carousel.container.context.id+'-copy li').eq(idx-1).html());
};
// FUNCTION FOR TRUE CIRCULAR CAROUSEL
function jcarousel_itemVisibleOutCallback(carousel, item, i, state, evt)
{
    carousel.remove(i);
};

function holdPic(i, div) {
    //event.preventDefault();
    if (i>=0) {
        if ($("#holdPic").length < 1){
            $('#id_similar_spp').after("<div id='holdPic'></div>");
            $('#holdPic').css("padding","10px");
            $('#holdPic').css("width","210px");
            if (!jQuery.browser.msie) { $('#holdPic').corners("5px transparent"); }
            $("#holdPic").append("<div class='small white'>Drag me around!</div>");
            $("#holdPic").append("<div class='small whitelinks' style='text-align:right'><a href='#' onclick='holdPic(-3);return false;'>X Close</a></div>");
            $("#holdPic").append("<div class='holdme'></div>");
            $('#holdPic').draggable();
        }
        $("#holdPic .holdme:eq(0)").empty();
        $('#'+div+' li:not(".annotations li"):eq('+(i)+') > *:not(.photo_controls)').clone().appendTo("#holdPic .holdme:eq(0)");
        tb_init('#holdPic a.thickbox');
        return false;
        
        
    } else {
        //reset the holdPic
        $('#holdPic').remove();
        //$('#holdPic').hide();
        return false;
    }
}

function initNotes () {
    var heights = new Array();
    //get heights from annotation divs
    //alert($('#id_field_marks .annotations').outerHeight());
    
    
    $('#field_marks .annotations2, #similar_spp .annotations2').each(function(i) {
        heights[i] = $(this).height();
        //alert(heights[i]);
    });
    heights.sort(function(a, b){return b - a});
    var highest = heights[0];
    
    //set the initial styles for annotations
    $('#field_marks .annotations2, #similar_spp .annotations2').css("position","absolute");
    $('#field_marks .annotations2, #similar_spp .annotations2').css("left","0");
    $('#field_marks .annotations2, #similar_spp .annotations2').css("top", (400-highest)+"px");
    $('#field_marks .annotations2, #similar_spp .annotations2').css("height",highest+"px");
    
    showHideNotes();
}
/* show hide annotation in the species photo viewer */
function showHideNotes () {
    //if hidden, then show
    var top = $('#field_marks .annotations2:eq(0)').css("top");
    //alert(top);
    moveHeight = 425 - parseInt($('#field_marks .annotations2:eq(0)').height()) - 10; //-10px for padding
    //alert(moveHeight);
    if (top != moveHeight+"px") {
        $('#field_marks .annotations2, #similar_spp .annotations2').animate( {top:moveHeight+"px"} , {easing:'easeOutSine', duration:800});
        $('.annotations2 .show_hide').html('<a href=\"#\" onclick=\"showHideNotes();return false;\">X Hide</a>');
    //if shown, then hide
    } else {
        $('#field_marks .annotations2, #similar_spp .annotations2').animate( {top:"400px"} , {easing:'easeOutSine', duration:800});
        $('.annotations2 .show_hide').html('<a href=\"#\" onclick=\"showHideNotes();return false;\">^ Show</a>');
    }
    
    //alert($('.jcarousel-skin-spp2 div.annotations2:eq(5) ul').find('li:eq(1)').text());
}

function replaceAll(str, oldstr, newstr) {
    var i =0;
    while (i != -1) {
        str = str.replace(oldstr, newstr);
        i = str.indexOf( oldstr );
    }
    return str;
}

function goToBird(name) {
    //alert(name+"1");
    if (name=="" || name == null) {
        //alert(name+"2");
        return false;
    } else { 
        name = replaceAll(name,"'","");
        name = replaceAll(name," ","_");                
        //alert(name+"3");
        location.href = "/guide/"+name+"/id";
        return false;
    }
    //alert(name+"4");
    return false;
}
function sortByName(a, b) {
    var x = a.name.toLowerCase();
    var y = b.name.toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}
function goToUrl(url) {
    location.href = url;
}
function get_rss(xml) {
    $(xml).find('item').each(function(){
        var $item = $(this);   
        var title = $item.find('title').text();
        var link = $item.find('link').text();
        var description = $item.find('description').text(); 
        var pubDate = $item.find('pubDate').text();
             
        var html = '<dd>';  
        html += '<p class="title">' + title + '</p>'; 
        html += '<p> ' + pubDate + '</p>';
        html += '<p> ' + description + '</p>' ;  
        html += '<a href="' + link + '" target="_blank">Read More</a>';
        html += '</dd><hr/>';  

        $('#jrss').append($(html));  
    });
}
/* ]]> */