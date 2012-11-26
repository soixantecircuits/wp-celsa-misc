/*
 * Facebox (for jQuery)
 * version: 1.2 (05/05/2008)
 * @requires jQuery v1.2 or later
 *
 * Examples at http://defunkt.io/facebox/
 *
 * Licensed under the MIT:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2007, 2008 Chris Wanstrath [ chris@ozmm.org ]
 *
 * Usage:
 *
 *  jQuery(document).ready(function() {
 *    jQuery('a[rel*=facebox]').facebox()
 *  })
 *
 *  <a href="#terms" rel="facebox">Terms</a>
 *    Loads the #terms div in the box
 *
 *  <a href="terms.html" rel="facebox">Terms</a>
 *    Loads the terms.html page in the box
 *
 *  <a href="terms.png" rel="facebox">Terms</a>
 *    Loads the terms.png image in the box
 *
 *
 *  You can also use it programmatically:
 *
 *    jQuery.facebox('some html')
 *    jQuery.facebox('some html', 'my-groovy-style')
 *
 *  The above will open a facebox with "some html" as the content.
 *
 *    jQuery.facebox(function($) {
 *      $.get('blah.html', function(data) { $.facebox(data) })
 *    })
 *
 *  The above will show a loading screen before the passed function is called,
 *  allowing for a better ajaxy experience.
 *
 *  The facebox function can also display an ajax page, an image, or the contents of a div:
 *
 *    jQuery.facebox({ ajax: 'remote.html' })
 *    jQuery.facebox({ ajax: 'remote.html' }, 'my-groovy-style')
 *    jQuery.facebox({ image: 'stairs.jpg' })
 *    jQuery.facebox({ image: 'stairs.jpg' }, 'my-groovy-style')
 *    jQuery.facebox({ div: '#box' })
 *    jQuery.facebox({ div: '#box' }, 'my-groovy-style')
 *
 *  Want to close the facebox?  Trigger the 'close.facebox' document event:
 *
 *    jQuery(document).trigger('close.facebox')
 *
 *  Facebox also has a bunch of other hooks:
 *
 *    loading.facebox
 *    beforeReveal.facebox
 *    reveal.facebox (aliased as 'afterReveal.facebox')
 *    init.facebox
 *    afterClose.facebox
 *
 *  Simply bind a function to any of these hooks:
 *
 *   $(document).bind('reveal.facebox', function() { ...stuff to do after the facebox and contents are revealed... })
 *
 */
(function($) {
  $.facebox = function(data, klass, images_info) {
	$.facebox.init()
    $.facebox.loading()

    if (data.ajax) fillFaceboxFromAjax(data.ajax, klass)
    else if (data.image) fillFaceboxFromImage(data.image, klass, images_info)
    else if (data.div) fillFaceboxFromHref(data.div, klass)
    else if ($.isFunction(data)) data.call($)
    else $.facebox.reveal(data, klass)
  }

  /*
   * Public, $.facebox methods
   */

  $.extend($.facebox, {
    settings: {
      opacity      : 0.2,
      overlay      : true,
      loadingImage : '/facebox/loading.gif',
      closeImage   : '/facebox/closelabel.png',
      imageTypes   : [ 'png', 'jpg', 'jpeg', 'gif' ],
	  next_image    : '/facebox/next.gif',
    prev_image    : '/facebox/prev.gif',
    play_image    : '/facebox/play.gif',
    pause_image   : '/facebox/pause.gif',
    slide_duration: 6,
      faceboxHtml  : '\
    <div id="facebox" style="display:none;"> \
      <div class="popup"> \
		<div class="body"> \
			<div class="content"> \
			</div> \
			<div class="info_title"> \
				<div class="info"></div> \
				<div class="title"></div> \
			</div> \
			<div class="footer"> \
				<div class="navigation"></div> \
				<div class="caption"></div> \
			</div> \
			<a href="#" class="close"><img src="/facebox/closelabel.png" title="close" class="close_image" /></a> \
		</div> \
      </div> \
    </div>'
    },

	init: function() {
		init();
	},
    loading: function() {
      //init()
      if ($('#facebox .loading').length == 1) return true
      showOverlay()

      $('#facebox .content, #facebox .info, #facebox .navigation, #facebox .title, #facebox .caption').empty()
      $('#facebox .body').children().hide().end().
        append('<div class="loading"><img src="'+$.facebox.settings.loadingImage+'"/></div>')

      $('#facebox').css({
        top:	getPageScroll()[1] + (getPageHeight() / 10),
        left:	$(window).width() / 2 - 205
      }).show()

      $(document).bind('keydown.facebox', function(e) {
        if (e.keyCode == 27) $.facebox.close()
        return true
      })
      $(document).trigger('loading.facebox')
    },

    reveal: function(data, klass, extra_setup) {
      $(document).trigger('beforeReveal.facebox')
      if (klass) $('#facebox .content').addClass(klass)
      $('#facebox .content').append(data)
      $('#facebox .loading').remove()
	  if ($.isFunction(extra_setup)) extra_setup.call(this)
      $('#facebox .body').children().fadeIn('normal')
      $('#facebox').css('left', $(window).width() / 2 - ($('#facebox .popup').width() / 2))
      $(document).trigger('reveal.facebox').trigger('afterReveal.facebox')
    },

    close: function() {
      $(document).trigger('close.facebox')
      return false
    }
  })

  /*
   * Public, $.fn methods
   */

  $.fn.facebox = function(settings) {
    if ($(this).length == 0) return

    init(settings)

	// suck out the images
    var images = [];
    var images_info = [];
    $(this).each(function() {
      if (this.href.match($.facebox.settings.imageTypesRegexp) && $.inArray(this.href, images) == -1) {
        images.push(this.href)

        // get last inserted index
        var last_index = images.length - 1;

        // get image info
        var $image = $('img', this);
        var title = $image.attr('title') ? $image.attr('title') : '';
        var caption = $image.attr('alt') ? $image.attr('alt') : '';

        // add image info here
        var image_info = {
            title : title,
            caption: caption
        };

        images_info[last_index] = image_info;
      }
    })
    if (images.length == 1) images = null

    function clickHandler() {
      $.facebox.loading(true)

      // support for rel="facebox.inline_popup" syntax, to add a class
      // also supports deprecated "facebox[.inline_popup]" syntax
      var klass = this.rel.match(/facebox\[?\.(\w+)\]?/)
      if (klass) klass = klass[1]

      fillFaceboxFromHref(this.href, images, klass, images_info)
      return false
    }

    return this.bind('click.facebox', clickHandler)
  }

  /*
   * Private methods
   */

  // called one time to setup facebox on this page
  function init(settings) {
    if ($.facebox.settings.inited) return true
    else $.facebox.settings.inited = true

    $(document).trigger('init.facebox')
    makeCompatible()

    var imageTypes = $.facebox.settings.imageTypes.join('|')
    $.facebox.settings.imageTypesRegexp = new RegExp('\.(' + imageTypes + ')$', 'i')

    if (settings) $.extend($.facebox.settings, settings)
    $('body').append($.facebox.settings.faceboxHtml)

    var preload = [ new Image(), new Image() ]
    preload[0].src = $.facebox.settings.closeImage
    preload[1].src = $.facebox.settings.loadingImage

    $('#facebox').find('.b:first, .bl').each(function() {
      preload.push(new Image())
      preload.slice(-1).src = $(this).css('background-image').replace(/url\((.+)\)/, '$1')
    })

    $('#facebox .close').click($.facebox.close)
    $('#facebox .close_image').attr('src', $.facebox.settings.closeImage)
  }

  // getPageScroll() by quirksmode.com
  function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;
    }
    return new Array(xScroll,yScroll)
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }
    return windowHeight
  }

  // Backwards compatibility
  function makeCompatible() {
    var $s = $.facebox.settings

    $s.loadingImage = $s.loading_image || $s.loadingImage
    $s.closeImage = $s.close_image || $s.closeImage
    $s.imageTypes = $s.image_types || $s.imageTypes
    $s.faceboxHtml = $s.facebox_html || $s.faceboxHtml
  }

  // Figures out what you want to display and displays it
  // formats are:
  //     div: #id
  //   image: blah.extension
  //    ajax: anything else
  function fillFaceboxFromHref(href, images, klass, images_info) {
    // div
    if (href.match(/#/)) {
      var url    = window.location.href.split('#')[0]
      var target = href.replace(url,'')
      if (target == '#') return
      $.facebox.reveal($(target).html(), klass)

    // image
    } else if (href.match($.facebox.settings.imageTypesRegexp)) {
      fillFaceboxFromImage(href, images, klass, images_info)
    // ajax
    } else {
      fillFaceboxFromAjax(href, klass)
    }
  }

  function fillFaceboxFromImage(href, images, klass, images_info) {
	if (images) var extra_setup = facebox_setup_gallery(href, images, klass, images_info);
    var image = new Image()
    image.onload = function() {
      $.facebox.reveal('<div class="image"><img src="' + image.src + '" /></div>', klass, extra_setup)

	  if (images) {
        var position = $.inArray(href, images)
        var next = new Image()
        next.src = images[position+1] ? images[position+1] : images[0]
      }
    }
    image.src = href
	if (!images) {
		$('#facebox .title').append(images_info[0].title);
		$('#facebox .caption').append(images_info[0].caption);
	}
  }

  function fillFaceboxFromAjax(href, klass) {
    $.get(href, function(data) { $.facebox.reveal(data, klass) })
  }

  function skipOverlay() {
    return $.facebox.settings.overlay == false || $.facebox.settings.opacity === null
  }

  function showOverlay() {
    if (skipOverlay()) return

    if ($('#facebox_overlay').length == 0)
      $("body").append('<div id="facebox_overlay" class="facebox_hide"></div>')

    $('#facebox_overlay').hide().addClass("facebox_overlayBG")
      .css('opacity', $.facebox.settings.opacity)
      .click(function() { $(document).trigger('close.facebox') })
      .fadeIn(200)
    return false
  }

  function hideOverlay() {
    if (skipOverlay()) return

    $('#facebox_overlay').fadeOut(200, function(){
      $("#facebox_overlay").removeClass("facebox_overlayBG")
      $("#facebox_overlay").addClass("facebox_hide")
      $("#facebox_overlay").remove()
    })

    return false
  }

  function facebox_setup_gallery(href, images, klass, images_info) {
    var position = $.inArray(href, images)

    var jump = function(where) {
      $.facebox.loading()
      if (where >= images.length) where = 0
      if (where < 0) where = images.length - 1
      fillFaceboxFromImage(images[where], images, klass, images_info)
    }

    var get_image_title = function(href, image_info) {
        if ( image_info.title ) {
            return image_info.title;
        }

        var parts = href.split('/');
        var basename = parts[parts.length-1];
        var name_parts = basename.split('.');
        var name = name_parts.slice(0, name_parts.length-1).join('.');

        return name;
    }

    var get_image_caption = function(image_info) {
        if ( image_info.caption ) {
            return image_info.caption;
        } else {
            return '&nbsp;';
        }
    }

    return function() {
	  var $s = $.facebox.settings;
      $('#facebox .image').click(function() { jump(position + 1) }).css('cursor', 'pointer');
      $('#facebox .info').append('Image ' + (position + 1) + ' of ' + images.length);
      $('#facebox .title').append(get_image_title(href, images_info[position]));
      $('#facebox .caption').append(get_image_caption(images_info[position]));
      $('#facebox .navigation').
        append('<img class="prev" src="' + $s.prev_image + '"/>' +
          '<img class="play" src="' + ($s.playing ? $s.pause_image : $s.play_image) + '"/>' +
          '<img class="next" src="' + $s.next_image + '"/>').
        find('img').css('cursor', 'pointer').end().
        find('.prev').click(function() { jump(position - 1); return false }).end().
        find('.next').click(function() { jump(position + 1); return false }).end()

      $('#facebox .play').bind('click.facebox', function() {
        $s.playing ? facebox_stop_slideshow() : facebox_start_slideshow()
        return false
      })

	  $(document).unbind('keydown.facebox');
      $(document).bind('keydown.facebox', function(e) {
        if (e.keyCode == 39) jump(position + 1) // right
        if (e.keyCode == 37) jump(position - 1) // left
      })
    }
  }

  function facebox_start_slideshow() {
	var $s = $.facebox.settings;
    $('#facebox .play').attr('src', $s.pause_image)
    $s.playing = setInterval(function() { $('#facebox .next').click() }, $s.slide_duration * 1000)
  }

  function facebox_stop_slideshow() {
	var $s = $.facebox.settings;
    $('#facebox .play').attr('src', $s.play_image)
    clearInterval($s.playing)
    $s.playing = false
  }

  /*
   * Bindings
   */

  $(document).bind('close.facebox', function() {
    $(document).unbind('keydown.facebox')
    $('#facebox').fadeOut(function() {
      $('#facebox .content').removeClass().addClass('content')
      $('#facebox .loading').remove()
	  if ($.facebox.settings.playing) facebox_stop_slideshow()
      $(document).trigger('afterClose.facebox')
    })
    hideOverlay()
  })

})(jQuery);
