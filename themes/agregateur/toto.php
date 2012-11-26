<?php 
/*
Template Name: toto
*/
?>


 <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS : implied media="all" -->
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style.css?v=1">

  <!-- For the less-enabled mobile browsers like Opera Mini -->
  <link rel="stylesheet" media="handheld" href="<?php bloginfo('template_url'); ?>/css/handheld.css?v=1">

 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="<?php bloginfo('template_url'); ?>/js/modernizr-1.5.min.js"></script>

</head>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->

  <div id="container">
    <header>
        <h1>L'annuaire des &eacute;tudiants</h1>
    </header>
    
    <div id="annuaire">
    <ul id="promos_misc" class="tabs">
   </ul>
    
    <div class="panes" id="main">
    </div>
    </div>
    
    <footer>

    </footer>
  </div> <!--! end of #container -->


  <!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')</script>

  <script src="<?php bloginfo('template_url'); ?>/js/jquery.tools.min.js?v=1"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/plugins.js?v=1"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/script.js?v=1"></script>

  <!--[if lt IE 7 ]>
    <script src="js/dd_belatedpng.js?v=1"></script>
  <![endif]-->


  <!-- yui profiler and profileviewer - remove for production -->
  <script src="<?php bloginfo('template_url'); ?>/js/profiling/yahoo-profiling.min.js?v=1"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/profiling/config.js?v=1"></script>
  <!-- end profiling code -->


<?php get_header(); ?>
 

  
		<?php if (have_posts()) : the_post(); ?>
		<!-- begin latest -->
		<div class="latest single">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><br>
		<?php the_content('Read More'); ?>
		<div class="break"></div></div>
		<!-- end latest -->
		
		<?php else : ?>
		<div class="notfound">
			<h2>Not Found</h2>
			<p>Sorry, but you are looking for something that is not here.</p>
		</div>
		<?php endif; ?>
		<div id="comments"><?php comments_template(); ?></div>
		
		
		
	</div>
	<?php get_sidebar(); ?>
	</div>
	<!-- END content -->
    <div class="clear" style="clear:both"></div>
<?php get_footer(); ?>
