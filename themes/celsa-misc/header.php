<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr-FR">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="Keywords" CONTENT="MISC, CELSA, Master, Degree, Numérique, Digital, communication, marketing, French, Internet, Web, formation, courses, cours, école, school, meilleur, stratégies, top, best, stratégie, Paris, Sorbonne, université, university, public, publique, meilleure, finest, réseaux, formations, initiale, grande école">
<meta name="description" content="Le site des étudiants du Master de stratégie numérique du CELSA - La Sorbonne. Retrouvez l'agenda du digital, de la formation, l'annuaire des MISC et bien d'autres choses" />
	<title><?php wp_title(''); ?></title>
		<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/style_celsa-misc.css" />
    <!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie.css" /><![endif]-->
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jQuery.equalHeights.js"></script>	
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.cycle.all.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/modernizr-1.5.min.js"></script>
    <?php echo '<!--[if lt IE 7]><script type="text/javascript" src="'.get_bloginfo('template_url').'/js/unitpngfix.js"></script><![endif]-->'; ?>    
<!--[if lt IE 9]>
  <script type="text/javascript" src="http://stan-js.googlecode.com/hg/version/0.1/stan.min.js"></script>
<![endif]-->
</head>
<body>
  
  <div id="header">
  		<div id="logo"><a href="http://www.celsa-misc.fr/"><img src="http://www.celsa-misc.fr/wp-content/uploads/2011/12/header.jpg" alt="Logo du site Celsa MISC"></a></div>

<!-- Donc on a affich� le logo. On va afficher le menu -->

        <div id="barre_bleu-header"></div>
       
        <div align="center">
            <div id="container_nav">
                <div id="nav">
                    <ul>
                    <li><a href="<?php echo get_option('home'); ?>">Accueil</a></li>
		  			
		    <li><a href="http://www.celsa.fr/formation-initiale-medias-master2-misc.php" target="_BLANK">Le Master</a>
			<ul class="children">
			<li><a href="http://www.celsa-misc.fr/le-parcours-du-futur-misc/">Le parcours</a></li>
			<li><a href="http://www.celsa-misc.fr/le-master-vu-par-les-etudiants/">T&eacute;moignages</a><li>
			<li><a href="http://www.celsa-misc.fr/bibliographie/">Bibliographie</a><li>
			<li><a href="http://www.celsa-misc.fr/newsletters">Newsletters</a><li>
			</ul>
			</li>
			
		    <li><a href="#">Les Etudiants</a>
                    <ul class="children">
                        <li><a href="http://www.celsa-misc.fr/annuaire-etudiants/">L'annuaire</a></li>
	                	<li><a href="http://www.celsa-misc.fr/le-master-misc/">Vie De Misc</a></li>	
						<li><a href="http://www.celsa-misc.fr/maps/">La MiscMap</a></li>
                        </ul>
           </li>
                       <li><a href="http://www.celsa-misc.fr/agenda-digital/">L'agenda du digital</a></li>

                    <li><a href="http://www.celsa-misc.fr/category/celsa-misc-le-blog/">Notre blog</a>
                    <ul class="children">
                    <li><a href="http://www.celsa-misc.fr/nos-videos/">Nos vid&eacute;os</a></li>   
                    </ul>
                    </li>

		                   
                    
                    <li><a href="http://www.celsa-misc.fr/contact/">Contact</a></li>
			
		    <!-- Hop! La barre de recherche. -->
               
                <div id="container_search">
              		<form action="<?php echo get_option('home'); ?>">
                     

               			<input type="text" name="s" class="s" value="Recherche..." onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
              			 <button type="submit">Chercher</button>
                        </form>
                </div>
               

		
                        <?php //wp_list_pages('title_li='); ?>
                    </ul>
                </div>


                
            </div>
        </div>
  
  </div>