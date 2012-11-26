<?php
/**
 * * Template Name: Eleves
 *  *
 *   * @package WordPress
 *    */
?>
<script type="text/javascript">

function closebox(box)
{
   document.getElementById(box).style.display='none';
   document.getElementById('shadowing').style.display='none';
}

function openbox(box)
{
  document.getElementById(box).style.display='block';
  document.getElementById('shadowing').style.display='block';
}

</script>

<?php get_header(); ?>

 <div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">

      <div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <?php if (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
	<?php endif; ?>
      </div>

<p style="margin-left:10px;margin-top:10px">Comment voyons-nous notre formation ? Cliquez sur les bulles pour le découvrir !
</p>
<br>
<img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/temoignages.png"  width="640" height="450" border="0" usemap="#map" />


<map name="map">
<area shape="circle" coords="109,85,87" href="#" onclick="openbox('box')" />
<area shape="circle" coords="460,84,79" href="#" onclick="openbox('box2')" />
<area shape="circle" coords="560,263,74" href="#" onclick="openbox('box4')" />
<area shape="circle" coords="94,364,79" href="#" onclick="openbox('box3')" />
<area shape="circle" coords="404,375,79" href="#" onclick="openbox('box1')" />
</map>


  </div>

<div style="float:right;">


  </div>
 <a href="#" id="boxclose" onclick="closebox('box')"><div id="shadowing"></div></a>

<div id="box">
  <a href="#" id="boxclose" onclick="closebox('box')">x</a>
    <div id="boxheader">
        <h4 id="boxtitle">WEB MARKETING
<p><em>(buzz & viralité / SEO & mesure d'audience / business model)</em></p>
</h4>
      
    </div>
    <div id="boxcontent">
<p><strong>→ Morgan Jerabek, analyste référencement indépendant, promo MISC ’12, évoque le SEO :</strong></p>
<br>
<p><strong>Qu’est ce que c’est ?</strong>
<br><br>
« Le SEO (Search Engine Optimization) est un ensemble de méthodes et processus visant à améliorer le positionnement de sites internet ou pages spécifiques  dans les résultats naturels des moteurs de recherche. »</p>
<br>
<p><strong>A quoi ça sert ?</strong>
<br><br>
« Les moteurs de recherche et plus particulièrement Google sont des vecteurs de trafic important et ont maintenant une influence non négligeable sur des questions d'image et de réputation, c'est pourquoi il est nécessaire d'améliorer sa visibilité sur ces outils. »</p>
<br>
<p><strong>Comment est-ce enseigné en MISC ?</strong>
<br><br>
« Lors des enseignements de conception de sites web, d'ergonomie ainsi que de recherche d'informations et search marketing, le SEO (ou Référencement Naturel en français) est abordé. »</p>
	</div>
</div>

<div id="box1">
  <a href="#" id="boxclose" onclick="closebox('box1')">x</a>
    <div id="boxheader">
        <h4 id="boxtitle">CULTURE DIGITALE
<p><em>(Théorie des médias / sociologie de l'innovation / imaginaires du numérique)</em></p></h4>
    </div>

    <div id="boxcontent"> 
<p><strong>→ Nicolas Marronnier, délégué général au Social Media Club France, promo MISC’12 évoque le réseau social Twitter :</strong></p> 
<br>
<p><strong>Qu’est ce que c’est ?</strong>
<br><br>
« L'usage de Twitter est quasiment généralisé chez les MISC, en tant que futurs communicants ou professionnels du web. Le site de microblogging nous intéresse particulièrement car c'est un dispositif de communication hybride, aux usages multiples : échanges interpersonnels, dévoilement de soi, partage de liens, couverture d'un événement en direct... Twitter voit s'agréger sur sa plateforme des informations de natures totalement différentes. »</p>
<br>

<p><strong>A quoi ça sert ?</strong>
<br><br>
« On a beaucoup parlé du site ces derniers mois (notamment lors des soulèvements populaires dans le monde Arabe), sans parfois prendre le recul nécessaire pour analyser les phénomènes qui lui sont liés (2011, année des "Révolutions 2.0" !)... Les apports théoriques des chercheurs en sciences de l'information et de la communication qui enseignent au Celsa nous permettent de mettre à distance les discours parfois idéalistes ou tout simplement erronés qui accompagnent les technologies dont nous faisons usage au quotidien. »</p>
<br>

<p><strong>Comment est-ce enseigné en MISC ?</strong>
<br><br>
« Dans le contexte professionnel qui est le notre, où les notions d'"interactivité", de "conversation" ou encore d'"influence" sont utilisées à tort et à travers à propos des stratégies de communication en ligne, ce regard critique développé au sein du Master est le bienvenu ! »</p>
	</div>
</div>


<div id="box2">
  <a href="#" id="boxclose" onclick="closebox('box2')">x</a>
    <div id="boxheader">
        <h4 id="boxtitle">CONCEPTION ET DEVELOPPELMENT D'OUTILS WEB</h4>
      
    </div>
    <div id="boxcontent">
<p><strong>
→ Oriane Piquer-Louis, web master freelance, promo MISC’12, évoque évoque le développement d’applications :</strong></p>
<br>
<p><strong>Qu’est ce que c’est ?</strong>
<br><br>
« La conception d'outils web, en soi, c'est très large. Cela va de la conception en termes d'ergonomie à la réalisation technique, en passant par le graphisme. Ce qui fait qu'un outil est bien conçu, c'est que toutes ces étapes s'imbriquent et vont dans le même sens. Tout est lié. Un bon outil ne vient pas tout seul !»</p>
<br>
<p><strong>A quoi ça sert ?</strong>
<br><br>
« Un outil web, peut-être un site web, une webapp, une application pour un smartphone...mais quel que soit le terminal ou la technique utilisés, il s’agit de bien concevoir cet outil car la satisfaction de l'utilisateur final dépend de la qualité de la conception. Il est donc primordial de réfléchir à son outil en amont, pendant et en aval de la conception. Sans une bonne orchestration de l'équipe (chef de projet, graphistes, développeurs, ergonomes...) un outil ne peut être bien conçu. »
</p><br>

<p><strong>Comment est-ce enseigné en MISC ?</strong>
<br><br>
« En MISC, nous sommes d’abord amenés à comprendre ces outils, avant de les appréhender de manière globale, à travers des cours d’ergonomie, design d’expérience ou d’initiation au développement d’application justement !<br>
 L'intérêt de l’approche du Celsa réside ici : quel que soit le métier que l'on veut exercer plus tard, il est nécessaire de connaître ce que la conception d’un outil mobilise comme compétences. Cela permet notamment d’interagir plus intelligemment avec l’équipe à qui l’on sous -traite le développement de l’outil web. »</p>
	</div>
</div>

<div id="box3">
  <a href="#" id="boxclose" onclick="closebox('box3')">x</a>
    <div id="boxheader">
        <h4 id="boxtitle">PRODUCTIONS MEDIATIQUES ET IMAGE DE MARQUE<br><p><em>(Plan de communication on & off line / brand content / connaissance des contraintes juridiques et économiques)</em></p></h4>
      
    </div>
    <div id="boxcontent">
<p><strong>→ Camille Lac, promo MISC’12, en CDI chez Ubisoft, évoque l’image de marque :</strong></p>
<br>
<p><strong>Qu’est ce que c’est ?</strong>
<br><br>
« L'image de marque, c'est tout simplement la perception que les consommateurs ont d'une marque, en termes de réputation, de qualité, d'innovation, de sympathie... Il y a des critères affectifs comme des critères matériels. Quand on travaille sur une image de marque, on ne cherche pas à vendre ses produits, on cherche à vendre un univers et des valeurs. »</p>
<br>
<p><strong>A quoi ça sert ?</strong>
<br><br>
« L'image d’une marque constitue sa valeur ajoutée par rapport à une autre marque. C'est en partie grâce à elle que l’on est prêt à dépenser 4€ pour un café chez Starbucks ! Le pouvoir évocateur d'une marque permet également de fidéliser un consommateur, quitte à le rendre "évangéliste" de la marque ! C'est un enjeu capital aujourd'hui, notamment sur les  réseaux sociaux, car  une mauvaise gestion de son image de marque peut avoir des conséquences désastreuses. On a tous en tête certains bad buzz célèbres : Nestlé, BP, et plus récemment Cora » </p>
<br>
<p><strong>Comment est-ce enseigné en MISC ?</strong>
<br><nr>
« Au Celsa, on nous apprend à monter des plans de communication bien sûr, mais également à penser plus large en réfléchissant sur le positionnement, les valeurs, l’ADN d’une marque, ce qui implique de raisonner en termes de contenu de marque ou « brand content ».Cette année dans nos travaux de groupe, nous avons dû notamment réfléchir à l’image du Master MISC, exercice pratique et engageant pour aborder ces questions stratégiques ! »</p>
	</div>
</div>

<div id="box4">
  <a href="#" id="boxclose" onclick="closebox('box4')">x</a>
    <div id="boxheader">
        <h4 id="boxtitle">COMMUNITY MANAGEMENT
<br><p><em>(Veille stratégique / animation des réseaux sociaux / gestion de communication de crise)</em></p></h4>
      
    </div>
    <div id="boxcontent">
<p><strong>→ Julien Santucci, en stage chez Goom Radio, promo MISC’12, évoque le community management</strong></p>
<br>
<p><strong>Qu’est ce que c’est ?</strong>
<br><br>
« C'est un terme un peu valise, englobant toutes les pratiques et les métiers associés aux médias sociaux, de l'animation d'une page Facebook ou d'un compte Twitter à l'élaboration d'une stratégie visant à établir une communauté autour d'une marque ou d'un produit, en passant par la fixation d'indicateurs de performance (KPI). »</p>
<br>
<p><strong>A quoi ça sert ?</strong>
<br><br>
« Cela est destiné à tous ceux souhaitant être présents sur les nouveaux médias, en se plaçant dans un processus de communication direct avec les consommateurs. On dépasse alors le cadre classique de la communication publicitaire, en installant potentiellement un dialogue avec le public. »
</p><br>
<p><strong>Comment est-ce enseigné en MISC ?</strong>
<br><br>
« Les cours d'Alban Martin (responsable social media chez Orange) sur les communautés en ligne et la viralité, nous ont  par exemple permis de voir comment peut être  établie  une stratégie de bouche à oreille via les réseaux sociaux, dans le cadre d'un lancement de produit. »</p>
	</div>

</div>
<!--end #contenu-->

</body>
<div class="clear"></div>
<?php get_footer(); ?>
