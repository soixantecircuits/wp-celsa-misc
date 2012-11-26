<div id='sam' style="margin-top:0px; width:300px; text-align:center">
<p style="font-size:14px; font-variant:small-caps; font-weight:bold">Promo actuelle</p>
<script src="<?php bloginfo('template_url'); ?>/js/twitter.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'list',
  rpp: 30,
  interval: 6000,
  title: '',
  subject: '',
  width: 300,
  height: 352,
  theme: {
    shell: {
      background: '#fffff',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#b740c2'
    }
  },
  features: {
    scrollbar: true,
    loop: false,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    behavior: 'all'
  }
}).render().setList('tooptoop', 'master-misc-09-10-celsa').start();
</script>




<?php //echo 'foo'; ?>

<?php if ( function_exists ( dynamic_sidebar(3) ) ) : ?>
<?php dynamic_sidebar (1); ?>
<?php endif; ?>
</div>

<div style="float:right; margin-top:-370px; text-align:center">
<p style="font-size:14px; font-variant:small-caps; font-weight:bold">Anciens étudiants</p>
<script>
new TWTR.Widget({
  version: 3,
  type: 'list',
  rpp: 30,
  interval: 6000,
  title: '',
  subject: '',
  width: 300,
  height: 352,
  theme: {
    shell: {
      background: '#fffff',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#b740c2'
    }
  },
  features: {
    scrollbar: true,
    loop: false,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    behavior: 'all'
  }
}).render().setList('willbord', 'student').start();
</script>


</div>
