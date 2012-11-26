/* Author: 
Gabriel Delattre
23/12/2010
*/

//greg.iconset = "Handycons";
//greg.iconset = "web20rigami";
 greg = {};
 greg.iconset = "SocialHand";
 greg.promocpt = 0 ;
 greg.data=[];
 greg.result=[];

$(greg).
 bind("end", function(event, name){
  //alert(name);
  if(greg.promocpt < greg.promo.length){
        $.ajax({
                url: "data/" + greg.promo[greg.promocpt].name,
                cache: false,
                dataType: "json",
                success: function(studentlist){
                    greg.promocpt++;
                    greg.data.push(studentlist);
                    printstudents(studentlist);
                }
            });
   }
   else{
        $("ul.tabs").tabs("div.panes > div"); 
        $('#chargement').animate({opacity:0,height:'toggle'}, 500, function() {
          $('#annuaire').css('display','block');
          $('#annuaire').animate({opacity:1}, 1000);
  });
        //$('.panes').jScrollPane({showArrows:true,maintainPosition: false});
   }
 });
 
$(greg).
 bind("result", function(event, name){
  printresult(greg.result);
});

$(greg).
 bind("endresult", function(event, name){
   $("ul.tabs").tabs("div.panes > div");
   $('#search_handler').click();
 });
 
$('#target').keyup(function(event) {
  greg.result = [];
  if((event.which != 8)&&(event.which !=27)&&(event.which!=37)&&(event.which!=38)&&(event.which!=39)&&(event.which!=40)){
    var query = this.value; //+  String.fromCharCode(event.which);
  }
  else if(event.which == 8){
    var query = this.value;
  }
  else if(event.which == 27)
  {
    if(this.value.length <= 0){
      var query = "";
    }
    else{
      var query = this.value;
    }
  }
  else{
    var query = this.value;
  }
  
  query = query.toLowerCase();
  
  //console.log(query);
  
  $.each(greg.data,
  function(j, promo){
  $.each(promo.liste, 
    function(i, item) { 
     
     item.promo = promo.promo;
     

     if(item.firstname.toLowerCase().search(query)!=-1){
       greg.result.push(item);
     }
     else if(item.name.toLowerCase().search(query)!=-1){
       greg.result.push(item);
     }
     else if(item.resume_title.toLowerCase().search(query)!=-1){
       greg.result.push(item);
     }
     else if(item.interests != undefined){
      var found = $.grep( item.interests, function(n,i){
        return n.search(query) != -1;
       });
       if(found.length > 0){
          greg.result.push(item);
       }
     }
  });
  });

  $(greg).trigger("result");
  
  
});
  
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
    url: "data/list.json",
    cache: false,
    dataType: "json",
    success: function(data){
        greg.promo = data.promo;
        if(greg.promo.length > 0){
        $.ajax({
                url: "data/" + greg.promo[greg.promocpt].name,
                cache: false,
                dataType: "json",
                success: function(studentlist){
                    greg.promocpt++;
                    greg.data.push(studentlist);
                    printstudents(studentlist);
                }
            });
         }
    }
});

function printstudents(data){
    var slugpromo = makeSlug(data.promo);
    $("<div class='promo' id=promo_" + slugpromo + ">").html(
    "<div class='title_promo'><h2 style='display:none'>" + data.promo + "</h2></div><ul class='student_lst' id=title_" + slugpromo + "></ul>"
    ).appendTo("#main");

    $("<li class='prostudent'><a id='"+slugpromo+"' href='#'>"+data.promo+"</a></li>"
    ).appendTo("#promos_misc");

    $.each(data.liste, 
    function(i, item){
      var slugstudent = makeSlug(item.name + item.firstname);
      
      if((item.image == "")||(item.image == undefined)){
        item.image = 'default_avatar.png';
      }
      
      if(item.blog != ""){
        $("<li class='student'>").html(
        "<div class='photo'><img  class='photo' src='images/photos/" + item.image + "' title='" + item.name + "'/></div>" +
        "<div class='infosStudent'><h3>" + item.firstname + " <span style='text-transform: uppercase;'>" + item.name + "</span></h3>" +
        "<a target='_blank' href='" + item.blog + "' class='blog'>Blog</a>" +
        "<div class='block_blog' id=social_" + slugstudent + "></div>" +
        "</div>" +
        "<div class='meta_student'><h3>Titre du m&eacute;moire : </h3>" + item.resume_title + "<br/>" +
        "<h3>Centre d'int&eacute;r&ecirc;ts : </h3><p id='interest_" + slugstudent + "'></p></div>"
        ).appendTo("#title_" + slugpromo);
        }
        else{
        $("<li class='student'>").html(
        "<div class='photo'><img  class='photo' src='images/photos/" + item.image + "' title='" + item.name + "'/></div>" +
        "<div class='infosStudent'><h3>" + item.firstname + " <span style='text-transform: uppercase;'>" + item.name + "</span></h3>" +
        "<a target='_blank' href='#' style='visibility:hidden' class='blog'></a>" +
        "<div class='block_blog' id=social_" + slugstudent + "></div>" +
        "</div>" +
        "<div class='meta_student'><h3>Titre du m&eacute;moire : </h3>" + item.resume_title + "<br/>" +
        "<h3>Centre d'int&eacute;r&ecirc;ts : </h3><p id='interest_" + slugstudent + "'></p></div>"
        ).appendTo("#title_" + slugpromo);  
        }

        $.each(item.social,
        function(j, link){
            $("<a target='_blank' href='" + link.url + "'>").html("<img class='blog' src='images/icons/" +greg.iconset+ "/"+ link.name.toLowerCase() + ".png' title='" + link.name + "'/>"
            ).appendTo("#social_" + slugstudent);
        });

        $.each(item.interests,
        function(k, word){
            if (k != 0){
                $("<span>").html(', ' + word).appendTo("#interest_" + slugstudent);
            }
            else{
                $("<span>").html(word).appendTo("#interest_" + slugstudent);
            }
        });
        if(i==data.liste.length-1){
          $(greg).trigger("end", [slugpromo]);
        }
    }); 
}



function printresult(data){
    var slugpromo = makeSlug('result');
    var valquery = $('#target').val()
    if(valquery == ""){
      valquery = "la totalit&eacute; des listes, pensez &agrave; effectuer une recherche..."
    }   
    else{
      valquery = "&quot;"+valquery+"&quot;";
    }
    $('#'+slugpromo).remove();
   
    $("<div class='promo' id=" + slugpromo + ">").html(
    "<div class='title_promo' style='padding: 0px 9px;'><h2><b>" + data.length+" </b> r&eacute;sultats pour "+valquery+"</h2></div><ul class='student_lst' id=title_" + slugpromo + "></ul>"
    ).appendTo("#main");

    if($('#search_result').length==0){
    $("<li class='prostudent' id='search_result'><a id='search_handler' href='#'>Recherche</a></li>"
    ).appendTo("#promos_misc");
    }

    $.each(data, 
    function(i, item){
      var slugstudent = makeSlug('result'+item.name + item.firstname);
      
      if((item.image == "")||(item.image == undefined)){
        item.image = 'default_avatar.png';
      }
      
      if(item.blog != ""){
        $("<li class='student'>").html(
        "<div class='photo'><img  class='photo' src='images/photos/" + item.image + "' title='" + item.name + "'/><div class='promo_legend'>"+item.promo+"</div></div>" +
        "<div class='infosStudent'><h3>" + item.firstname + " <span style='text-transform: uppercase;'>" + item.name + "</span></h3>" +
        "<a target='_blank' href='" + item.blog + "' class='blog'>Blog</a>" +
        "<div class='block_blog' id=social_" + slugstudent + "></div>" +
        "</div>" +
        "<div class='meta_student'><h3>Titre du m&eacute;moire : </h3>" + item.resume_title + "<br/>" +
        "<h3>Centre d'int&eacute;r&ecirc;ts : </h3><p id='interest_" + slugstudent + "'></p></div>"
        ).appendTo("#title_" + slugpromo);
        }
        else{
        $("<li class='student'>").html(
        "<div class='photo'><img  class='photo' src='images/photos/" + item.image + "' title='" + item.name + "'/><div class='promo_legend'>"+item.promo+"</div></div>" +
        "<div class='infosStudent'><h3>" + item.firstname + " <span style='text-transform: uppercase;'>" + item.name + "</span></h3>" +
        "<a target='_blank' href='#' style='visibility:hidden' class='blog'></a>" +
        "<div class='block_blog' id=social_" + slugstudent + "></div>" +
        "</div>" +
        "<div class='meta_student'><h3>Titre du m&eacute;moire : </h3>" + item.resume_title + "<br/>" +
        "<h3>Centre d'int&eacute;r&ecirc;ts : </h3><p id='interest_" + slugstudent + "'></p></div>"
        ).appendTo("#title_" + slugpromo);  
        }

        $.each(item.social,
        function(j, link){
            $("<a target='_blank' href='" + link.url + "'>").html("<img class='blog' src='images/icons/" +greg.iconset+ "/"+ link.name.toLowerCase() + ".png' title='" + link.name + "'/>"
            ).appendTo("#social_" + slugstudent);
        });

        $.each(item.interests,
        function(k, word){
            if (k != 0){
                $("<span>").html(', ' + word).appendTo("#interest_" + slugstudent);
            }
            else{
                $("<span>").html(word).appendTo("#interest_" + slugstudent);
            }
        });
       if(i==data.length-1){
          $(greg).trigger("endresult", [slugpromo]);
       }
    }); 
}



