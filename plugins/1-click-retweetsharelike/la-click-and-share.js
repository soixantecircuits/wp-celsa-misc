jQuery(document).ready(function() {
	jQuery.receiveMessage(
		function(e){
			jQuery("#networkpub_postbox").height(e.data.split("=")[1]+'px');
		},
		'http://www.linksalpha.com'
	);
	jQuery("#site_links").live("change", function(event) {
		jQuery.postMessage(
			jQuery(this).val(),
			'http://www.linksalpha.com/post',
			parent
		);
	});
});


function oneclick_msg_fade(this_elem) {
	setTimeout(function(){
		this_elem.fadeOut();
	}, 5000);
}