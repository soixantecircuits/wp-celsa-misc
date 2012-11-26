/* Author: 
Gabriel Delattre
23/12/2010
*/

//greg.iconset = "Handycons";
//greg.iconset = "web20rigami";
 greg = {};
 greg.iconset = "SocialHand";
 greg.promocpt = 0 ;

/*taken from netvivs.com*/
function makeSlug(slugcontent)
{
    // convert to lowercase (important: since on next step special chars are defined in lowercase only)
    slugcontent = slugcontent.toLowerCase();
    // convert special chars
    var   accents={a:/\u00e1/g,e:/u00e9/g,i:/\u00ed/g,o:/\u00f3/g,u:/\u00fa/g,n:/\u00f1/g}
    for (var i in accents) slugcontent = slugcontent.replace(accents[i],i);

  var slugcontent_hyphens = slugcontent.replace(/\s/g,'-');
  var finishedslug = slugcontent_hyphens.replace(/[^a-zA-Z0-9\-]/g,'');
    finishedslug = finishedslug.toLowerCase();
    finishedslug = finishedslug.replace(/-+/g,'-'); 
    finishedslug = finishedslug.replace(/(^-)|(-$)/g,'');
    return finishedslug;
}

$.ajax({
    url: "../wp-content/themes/agregateur/data/list.json",
    //url:"http://graph.facebook.com/4906324581/feed",
    cache: false,
    dataType: "json",
    success: function(data){
        greg.promocpt = data.promo.length; 
        
        $.each(data.promo,
        function(a, promo){
            $.ajax({
                url: "data/" + promo.name,
                cache: false,
                dataType: "json",
                success: function(studentlist){
                    printstudents(studentlist);
                     if(a==greg.promocpt-1){
                      $("ul.tabs").tabs("div.panes > div");}
                }
            });
           
        });  
    }
});

function printstudents(data){
    
    $("<div class='promo' id=promo_" + makeSlug(data.promo) + ">").html(
    "<div class='title_promo'><h2 style='display:none'>" + data.promo + "</h2></div><ul class='student_lst' id=title_" + makeSlug(data.promo) + "></ul>"
    ).appendTo("#main");

    $("<li><a href='#'>"+data.promo+"</a></li>"
    ).appendTo("#promos_misc");


    cptliste = data.liste.length;
    $.each(data.liste, function(i, item){
        $("<li class='student'>").html(
        "<div class='photo'><img  class='photo' src='images/photos/" + item.image + "' title='" + item.name + "'/></div>" +
        "<div class='infosStudent'><h3>" + item.firstname + " <span style='text-transform: uppercase;'>" + item.name + "</span></h3>" +
        "<a href='" + item.blog + "' class='blog'>Blog</a>" +
        "<div class='block_blog' id=social_" + makeSlug(item.name + item.firstname) + "></div>" +
        "</div>" +
        "<div class='meta_student'><h3>Titre du m&eacute;moire : </h3>" + item.resume_title + "<br/>" +
        "<h3>Centre d'int&eacute;r&ecirc;ts : </h3><p id='interest_" + makeSlug(item.name + item.firstname) + "'></p></div>"
        ).appendTo("#title_" + makeSlug(data.promo));

        $.each(item.social,
        function(j, link){
            $("<a href='" + link.url + "'>").html("<img class='blog' src='images/icons/" +greg.iconset+ "/"+ link.name.toLowerCase() + ".png' title='" + link.name + "'/>"
            ).appendTo("#social_" + makeSlug(item.name + item.firstname));
        });

        $.each(item.interests,
        function(k, word){
            if (k != 0){
                $("<span>").html(', ' + word).appendTo("#interest_" + makeSlug(item.name + item.firstname));
            }
            else{
                $("<span>").html(word).appendTo("#interest_" + makeSlug(item.name + item.firstname));
            }
        });
    });
    
}