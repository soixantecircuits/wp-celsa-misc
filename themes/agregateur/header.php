<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
		<?php wp_head(); ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
    <!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie.css" /><![endif]-->
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.cycle.all.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    <?php echo '<!--[if lt IE 7]><script type="text/javascript" src="'.get_bloginfo('template_url').'/js/unitpngfix.js"></script><![endif]-->'; ?>    
</head>

<body>
  <div id="wide-header">
  	<div id="header">
  			
  		<div id="logo_search">
        <div id="logo"><!-- <a href="<?php //echo get_option('home'); ?>"><?php //bloginfo('name'); ?></a> --> </div>
  			<div id="search">
          <form action="<?php echo get_option('home'); ?>">
            <input type="text" name="s" class="s" value="<?php the_search_query(); ?>" />
            <button type="submit">Search</button>
  				</form>
  			</div>
  		</div>
  		
      <div id="nav">
  			<ul>
  				<li><a href="<?php echo get_option('home'); ?>">Accueil</a></li>
  				<?php wp_list_pages('title_li='); ?>
  			</ul>
      </div>
  		
  	</div>
  </div>

<!-- END header -->
	
