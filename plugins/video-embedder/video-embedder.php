<?php /*
Plugin Name: Video Embedder
Plugin URI: http://www.gate303.net/2007/12/17/video-embedder/
Description: This allows you to embed videos from various sources in your blog without breaking validation. For settings and more information, visit <a href="options-general.php?page=video-embedder.php">Options/Video Embedder</a>.
Version: 1.7.1
Author: Kristoffer Forsgren
Author URI: http://www.gate303.net/

Copyright 2007  Kristoffer Forsgren */

defaultSettings();
add_filter('the_content', 'videoembedder_embed');
add_action('admin_menu', 'videoembedder_add_pages');

function videoembedder_add_pages() {
    add_options_page('Video Embedder Options', 'Video Embedder', 8, basename(__FILE__), 'videoembedder_options_page');	
}

function videoembedder_options_page() {
	if ($_POST){
		$options = array (
			"video_width"		=> $_POST["video_width"],
			"video_height"		=> $_POST["video_height"],
			"youtube_tag"		=> $_POST["youtube_tag"],
			"google_tag"		=> $_POST["google_tag"],
			"metacafe_tag"		=> $_POST["metacafe_tag"],
			"liveleak_tag"		=> $_POST["liveleak_tag"],
			"revver_tag"		=> $_POST["revver_tag"],
			"ifilm_tag"		=> $_POST["ifilm_tag"],
			"myspace_tag"		=> $_POST["myspace_tag"],
			"bliptv_tag"		=> $_POST["bliptv_tag"],
			"college_tag"		=> $_POST["college_tag"],
			"videojug_tag"		=> $_POST["videojug_tag"],
			"godtube_tag"		=> $_POST["godtube_tag"],
			"veoh_tag"		=> $_POST["veoh_tag"],
			"break_tag"		=> $_POST["break_tag"],
			"dailymotion_tag"	=> $_POST["dailymotion_tag"],
			"movieweb_tag"	=> $_POST["movieweb_tag"],
			"jaycut_tag"	=> $_POST["jaycut_tag"],
			"myvideo_tag"	=> $_POST["myvideo_tag"],
			"vimeo_tag"	=> $_POST["vimeo_tag"],
			"gtrailers_tag"	=> $_POST["gtrailers_tag"],
			"viddler_tag"	=> $_POST["viddler_tag"],
			"snotr_tag"	=> $_POST["snotr_tag"],
			"funnyordie_tag"	=> $_POST["funnyordie_tag"],

			"quicktime_tag"	=> $_POST["quicktime_tag"],
			"windowsmedia_tag"	=> $_POST["windowsmedia_tag"],
		);

		$updated=false;
		update_option('videoembedder_options', $options);
		defaultSettings();
	}

	$videoembedder_options = get_option(videoembedder_options);

	$video_height = $videoembedder_options["video_height"];
	$video_width = $videoembedder_options["video_width"];
	$youtube_tag = $videoembedder_options["youtube_tag"];
	$google_tag = $videoembedder_options["google_tag"];
	$metacafe_tag = $videoembedder_options["metacafe_tag"];
	$liveleak_tag = $videoembedder_options["liveleak_tag"];
	$revver_tag = $videoembedder_options["revver_tag"];
	$ifilm_tag = $videoembedder_options["ifilm_tag"];
	$myspace_tag = $videoembedder_options["myspace_tag"];
	$bliptv_tag = $videoembedder_options["bliptv_tag"];
	$college_tag = $videoembedder_options["college_tag"];
	$videojug_tag = $videoembedder_options["videojug_tag"];
	$godtube_tag = $videoembedder_options["godtube_tag"];
	$veoh_tag = $videoembedder_options["veoh_tag"];
	$break_tag = $videoembedder_options["break_tag"];
	$dailymotion_tag = $videoembedder_options["dailymotion_tag"];
	$movieweb_tag = $videoembedder_options["movieweb_tag"];
	$jaycut_tag = $videoembedder_options["jaycut_tag"];
	$myvideo_tag = $videoembedder_options["myvideo_tag"];
	$vimeo_tag = $videoembedder_options["vimeo_tag"];
	$gtrailers_tag = $videoembedder_options["gtrailers_tag"];
	$viddler_tag = $videoembedder_options["viddler_tag"];
	$snotr_tag = $videoembedder_options["snotr_tag"];
	$funnyordie_tag = $videoembedder_options["funnyordie_tag"];

	$quicktime_tag = $videoembedder_options["quicktime_tag"];
	$windowsmedia_tag = $videoembedder_options["windowsmedia_tag"];

	echo '<div class="wrap"><h2>Video Embedder Settings</h2>';
	echo "<form name='form' method='post' action=''>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<th width='20%'><strong>Video Width:</strong></th>
			<td width='80%'><input name='video_width' type='text' id='video_width' value='$video_width'> (Default: 425)</td>
		</tr>
		<tr>
			<th><strong>Video Height:</strong></th>
			<td><input name='video_height' type='text' id='video_height' value='$video_height'> (Default: 355)</td>
		</tr>
		<tr>
			<th><strong>Youtube tag:</strong></th>
			<td><input name='youtube_tag' type='text' id='youtube_tag' value='$youtube_tag'> Usage: [$youtube_tag]video_id[/$youtube_tag]</td>
		</tr>
		<tr>
			<th><strong>Google Video tag:</strong></th>
			<td><input name='google_tag' type='text' id='google_tag' value='$google_tag'> Usage: [$google_tag]video_id[/$google_tag]</td>
		</tr>
		<tr>
			<th><strong>Metacafe tag:</strong></th>
			<td><input name='metacafe_tag' type='text' id='metacafe_tag' value='$metacafe_tag'> Usage: [$metacafe_tag]video_id[/$metacafe_tag]</td>
		</tr>
		<tr>
			<th><strong>Liveleak tag:</strong></th>
			<td><input name='liveleak_tag' type='text' id='liveleak_tag' value='$liveleak_tag'> Usage: [$liveleak_tag]video_id[/$liveleak_tag]</td>
		</tr>
		<tr>
			<th><strong>Revver tag:</strong></th>
			<td><input name='revver_tag' type='text' id='revver_tag' value='$revver_tag'> Usage: [$revver_tag]video_id[/$revver_tag]</td>
		</tr>
		<tr>
			<th><strong>IFILM tag:</strong></th>
			<td><input name='ifilm_tag' type='text' id='ifilm_tag' value='$ifilm_tag'> Usage: [$ifilm_tag]video_id[/$ifilm_tag]</td>
		</tr>
		<tr>
			<th><strong>Myspace tag:</strong></th>
			<td><input name='myspace_tag' type='text' id='myspace_tag' value='$myspace_tag'> Usage: [$myspace_tag]video_id[/$myspace_tag]</td>
		</tr>
		<tr>
			<th><strong>Blip.tv tag:</strong></th>
			<td><input name='bliptv_tag' type='text' id='bliptv_tag' value='$bliptv_tag'> Usage: [$bliptv_tag]video_id[/$bliptv_tag]</td>
		</tr>
		<tr>
			<th><strong>CollegeHumor tag:</strong></th>
			<td><input name='college_tag' type='text' id='college_tag' value='$college_tag'> Usage: [$college_tag]video_id[/$college_tag]</td>
		</tr>
		<tr>
			<th><strong>Videojug tag:</strong></th>
			<td><input name='videojug_tag' type='text' id='videojug_tag' value='$videojug_tag'> Usage: [$videojug_tag]video_id[/$videojug_tag]</td>
		</tr>
		<tr>
			<th><strong>Godtube tag:</strong></th>
			<td><input name='godtube_tag' type='text' id='godtube_tag' value='$godtube_tag'> Usage: [$godtube_tag]video_id[/$godtube_tag]</td>
		</tr>
		<tr>
			<th><strong>Veoh tag:</strong></th>
			<td><input name='veoh_tag' type='text' id='veoh_tag' value='$veoh_tag'> Usage: [$veoh_tag]video_id[/$veoh_tag]</td>
		</tr>
		<tr>
			<th><strong>Break tag:</strong></th>
			<td><input name='break_tag' type='text' id='break_tag' value='$break_tag'> Usage: [$break_tag]video_id[/$break_tag]</td>
		</tr>
		<tr>
			<th><strong>Dailymotion tag:</strong></th>
			<td><input name='dailymotion_tag' type='text' id='dailymotion_tag' value='$dailymotion_tag'> Usage: [$dailymotion_tag]video_id[/$dailymotion_tag]</td>
		</tr>
		<tr>
			<th><strong>Movieweb tag:</strong></th>
			<td><input name='movieweb_tag' type='text' id='movieweb_tag' value='$movieweb_tag'> Usage: [$movieweb_tag]video_id[/$movieweb_tag]</td>
		</tr>
		<tr>
			<th><strong>Jaycut tag:</strong></th>
			<td><input name='jaycut_tag' type='text' id='jaycut_tag' value='$jaycut_tag'> Usage: [$jaycut_tag]video_id[/$jaycut_tag]</td>
		</tr>
		<tr>
			<th><strong>Myvideo tag:</strong></th>
			<td><input name='myvideo_tag' type='text' id='myvideo_tag' value='$myvideo_tag'> Usage: [$myvideo_tag]video_id[/$myvideo_tag]</td>
		</tr>
		<tr>
			<th><strong>Vimeo tag:</strong></th>
			<td><input name='vimeo_tag' type='text' id='vimeo_tag' value='$vimeo_tag'> Usage: [$vimeo_tag]video_id[/$vimeo_tag]</td>
		</tr>
		<tr>
			<th><strong>Gametrailers tag:</strong></th>
			<td><input name='gtrailers_tag' type='text' id='gtrailers_tag' value='$gtrailers_tag'> Usage: [$gtrailers_tag]video_id[/$gtrailers_tag]</td>
		</tr>
		<tr>
			<th><strong>Viddler tag:</strong></th>
			<td><input name='viddler_tag' type='text' id='viddler_tag' value='$viddler_tag'> Usage: [$viddler_tag]video_id[/$viddler_tag]</td>
		</tr>
		<tr>
			<th><strong>Snotr tag:</strong></th>
			<td><input name='snotr_tag' type='text' id='snotr_tag' value='$snotr_tag'> Usage: [$snotr_tag]video_id[/$snotr_tag]</td>
		</tr
		<tr>
			<th><strong>Funny or Die tag:</strong></th>
			<td><input name='funnyordie_tag' type='text' id='funnyordie_tag' value='$funnyordie_tag'> Usage: [$funnyordie_tag]video_id[/$funnyordie_tag]</td>
		</tr>
		<!-- local media -->
		<tr>
			<th><strong>Quicktime tag:</strong></th>
			<td><input name='quicktime_tag' type='text' id='quicktime_tag' value='$quicktime_tag'> Usage: [$quicktime_tag]URL[/$quicktime_tag]</td>
		</tr>
		<tr>
			<th><strong>Windows Media Player tag:</strong></th>
			<td><input name='windowsmedia_tag' type='text' id='windowsmedia_tag' value='$windowsmedia_tag'> Usage: [$windowsmedia_tag]URL[/$windowsmedia_tag]</td>
		</tr>
	</table>
	<input type='submit' name='Submit' value='Save'>";
	if ($updated==true) echo ' Settings updated';
	echo '</form></div>';

	echo '<div class="wrap"><h2>Help</h2>';
	echo '<h3>Youtube help</h3>';
	echo '<p>For Youtube movies, check the URL and use the red part: http://www.youtube.com/watch?v=<strong style="color:red;">zORv8wwiadQ</strong></p>';
	echo '<p>Type ['.$youtube_tag.']<strong style="color:red;">zORv8wwiadQ</strong>[/'.$youtube_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Google Video help</h3>';
	echo '<p>For Google Video, check the URL and use the red part: http://video.google.com/videoplay?docid=<strong style="color:red;">6063985264803214006</strong></p>';
	echo '<p>Type ['.$google_tag.']<strong style="color:red;">6063985264803214006</strong>[/'.$google_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Metacafe help</h3>';
	echo '<p>For Metacafe, check the URL and use the red part: http://www.metacafe.com/watch/<strong style="color:red;">975366/secrets_of_google_earth</strong>/ (the trailing slash should not be included)</p>';
	echo '<p>Type ['.$metacafe_tag.']<strong style="color:red;">975366/secrets_of_google_earth</strong>[/'.$metacafe_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Liveleak help</h3>';
	echo '<p>For Liveleak, check the URL and use the red part: http://www.liveleak.com/view?i=<strong style="color:red;">d62_1594640234</strong></p>';
	echo '<p>Type ['.$liveleak_tag.']<strong style="color:red;">d62_1594640234</strong>[/'.$liveleak_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Revver help</h3>';
	echo '<p>For Revver, check the URL and use the red part: http://revver.com/video/<strong style="color:red;">527514</strong>/ (the trailing slash should not be included)</p>';
	echo '<p>Type ['.$revver_tag.']<strong style="color:red;">527514</strong>[/'.$revver_tag.'] in the editor to embed the video.</p>';

	echo '<h3>IFILM help</h3>';
	echo '<p>For IFILM, check the URL and use the red part: http://www.ifilm.com/video/<strong style="color:red;">3521648</strong></p>';
	echo '<p>Type ['.$ifilm_tag.']<strong style="color:red;">3521648</strong>[/'.$ifilm_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Myspace help</h3>';
	echo '<p>For Myspace, check the URL and use the red part: http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=<strong style="color:red;">56884863</strong></p>';
	echo '<p>Type ['.$myspace_tag.']<strong style="color:red;">56884863</strong>[/'.$myspace_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Blip.tv help</h3>';
	echo '<p>For Blip.tv, check the URL and use the red part: http://blip.tv/file/<strong style="color:red;">254683</strong></p>';
	echo '<p>Type ['.$bliptv_tag.']<strong style="color:red;">254683</strong>[/'.$bliptv_tag.'] in the editor to embed the video.</p>';

	echo '<h3>CollegeHumor help</h3>';
	echo '<p>For CollegeHumor, check the URL and use the red part: http://www.collegehumor.com/video:<strong style="color:red;">3567863</strong></p>';
	echo '<p>Type ['.$college_tag.']<strong style="color:red;">3567863</strong>[/'.$college_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Videojug help</h3>';
	echo '<p>For Videojug, check the embed code and use the red part: &lt;object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="345" align="middle"&gt;&lt;param name="movie" value="http://www.videojug.com/film/player?id=<strong style="color:red;">3ff6e533-5eaf-4ff8-540e-02334f7ac808</strong>" /&gt;&lt;embed src (...)</p>';
	echo '<p>Type ['.$videojug_tag.']<strong style="color:red;">3ff6e533-5eaf-4ff8-540e-02334f7ac808</strong>[/'.$videojug_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Godtube help</h3>';
	echo '<p>For Godtube, check the URL and use the red part: http://www.godtube.com/view_video.php?viewkey=<strong style="color:red;">83abb6308b8842ca6f1f</strong></p>';
	echo '<p>Type ['.$godtube_tag.']<strong style="color:red;">83abb6308b8842ca6f1f</strong>[/'.$godtube_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Veoh help</h3>';
	echo '<p>For Veoh, check the URL and use the red part: http://www.veoh.com/videos/<strong style="color:red;">v1683095mYFrF3Xc</strong></p>';
	echo '<p>Type ['.$veoh_tag.']<strong style="color:red;">v1683095mYFrF3Xc</strong>[/'.$veoh_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Break help</h3>';
	echo '<p>For Break, check the embed code and use the red part:&lt;object width="464" height="392"&gt;&lt;param name="movie" value="http://embed.break.com/<strong style="color:red;">NDExNjU2</strong>"&gt;&lt;/para...</p>';
	echo '<p>Type ['.$break_tag.']<strong style="color:red;">NDExNjU2</strong>[/'.$break_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Dailymotion help</h3>';
	echo '<p>For Dailymotion, check the URL and use the red part: http://www.dailymotion.com/video/<strong style="color:red;">xoh8j</strong>_monty-python-dead-parrot-sketch_family</p>';
	echo '<p>Type ['.$dailymotion_tag.']<strong style="color:red;">xoh8j</strong>[/'.$dailymotion_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Movieweb help</h3>';
	echo '<p>For Movieweb, check the URL and use the red part: http://www.movieweb.com/video/<strong style="color:red;">V07L3flnvxMUWY</strong></p>';
	echo '<p>Type ['.$movieweb_tag.']<strong style="color:red;">V07L3flnvxMUWY</strong>[/'.$movieweb_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Jaycut help</h3>';
	echo '<p>For Jaycut, check the URL and use the red part: http://jaycut.se/mix/<strong style="color:red;">2493</strong>/preview</p>';
	echo '<p>Type ['.$jaycut_tag.']<strong style="color:red;">2493</strong>[/'.$jaycut_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Myvideo help</h3>';
	echo '<p>For Myvideo, check the URL and use the red part: http://www.myvideo.de/watch/<strong style="color:red;">3033737</strong></p>';
	echo '<p>Type ['.$myvideo_tag.']<strong style="color:red;">3033737</strong>[/'.$myvideo_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Vimeo help</h3>';
	echo '<p>For Vimeo, check the URL and use the red part: http://www.vimeo.com/<strong style="color:red;">367351</strong></p>';
	echo '<p>Type ['.$vimeo_tag.']<strong style="color:red;">367351</strong>[/'.$vimeo_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Gametrailers help</h3>';
	echo '<p>For Gametrailers, check the URL and use the red part: http://www.gametrailers.com/player/<strong style="color:red;">32532</strong>.html</p>';
	echo '<p>Type ['.$gtrailers_tag.']<strong style="color:red;">32532</strong>[/'.$gtrailers_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Viddler help</h3>';
	echo '<p>For Viddler, check the embed code and use the red part: &lt;object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="437" height="370" id="viddler"&gt;&lt;param name="movie" value="http://www.viddler.com/player/<strong style="color:red;">6708b741</strong>/" /&gt;&lt;param name</p>';
	echo '<p>Type ['.$viddler_tag.']<strong style="color:red;">6708b741</strong>[/'.$viddler_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Snotr help</h3>';
	echo '<p>For Snotr, check the URL and use the red part: http://www.snotr.com/video/<strong style="color:red;">1046</strong></p>';
	echo '<p>Type ['.$snotr_tag.']<strong style="color:red;">1046</strong>[/'.$snotr_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Funny or Die help</h3>';
	echo '<p>For Funny or Die, check the URL and use the red part: http://www.funnyordie.com/videos/<strong style="color:red;">1785f25c3f</strong></p>';
	echo '<p>Type ['.$funnyordie_tag.']<strong style="color:red;">1785f25c3f</strong>[/'.$funnyordie_tag.'] in the editor to embed the video.</p>';

	// Local media
	echo '<h3>Quicktime help</h3>';
	echo '<p>For Quicktime files, enclose the URL</p>';
	echo '<p>Type ['.$quicktime_tag.']<strong style="color:red;">http://www.yoursite.com/path/file.mov</strong>[/'.$quicktime_tag.'] in the editor to embed the video.</p>';

	echo '<h3>Windows Media Player help</h3>';
	echo '<p>For Windows Media files, enclose the URL</p>';
	echo '<p>Type ['.$windowsmedia_tag.']<strong style="color:red;">http://www.yoursite.com/path/file.wmv</strong>[/'.$windowsmedia_tag.'] in the editor to embed the video.</p>';

	echo '<h2>More help</h2>';
	echo '<p>Visit the <a href="http://www.gate303.net/2007/12/17/video-embedder/">home page for Video Embedder</a> for more help and support</p>';
	echo '<p>Video Embedder version '.$videoembedder_options["version"].'</p>';
	echo '</div>';
}

function videoembedder_embed($content)
{
	
	$tags = get_option(videoembedder_options);

	// Youtube
	$tag = $tags["youtube_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.youtube.com/v/".$video."&amp;rel=0");					
		$content = str_replace($replace, $new, $content);
	}

	// Google
	$tag = $tags["google_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://video.google.com/googleplayer.swf?docId=".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Metacafe
	$tag = $tags["metacafe_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.metacafe.com/fplayer/".$video.".swf");
		$content = str_replace($replace, $new, $content);
	}

	// Liveleak
	$tag = $tags["liveleak_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.liveleak.com/player.swf?autostart=false&amp;token=".$video);					
		$content = str_replace($replace, $new, $content);
	}

	// Revver
	$tag = $tags["revver_tag"];
	$height = $tags["video_height"];
	$width = $tags["video_width"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = '<script src="http://flash.revver.com/player/1.0/player.js?mediaId:'.$video.';width:'.$width.';height:'.$height.'" type="text/javascript"></script>';					
		$content = str_replace($replace, $new, $content);
	}

	// IFILM
	$tag = $tags["ifilm_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.ifilm.com/efp?flvbaseclip=".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Myspace
	$tag = $tags["myspace_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://lads.myspace.com/videos/vplayer.swf?m=".$video."&amp;v=2&amp;type=video");
		$content = str_replace($replace, $new, $content);
	}

	// Blip.tv
	$tag = $tags["bliptv_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://blip.tv/scripts/flash/showplayer.swf?autostart=false&#038;file=http%3A%2F%2Fcreationsnet%2Eblip%2Etv%2Ffile%2F".$video."%2F%3Fskin%3Drss%26sort%3Ddate&#038;fullscreenpage=http%3A%2F%2Fblip%2Etv%2Ffullscreen%2Ehtml&#038;fsreturnpage=http%3A%2F%2Fblip%2Etv%2Fexitfullscreen%2Ehtml&#038;showfsbutton=true&#038;brandlink=http%3A%2F%2Fcreationsnet%2Eblip%2Etv%2F&#038;brandname=cre%2Eations%2Enet&#038;showguidebutton=false&#038;showplayerpath=http%3A%2F%2Fblip%2Etv%2Fscripts%2Fflash%2Fshowplayer%2Eswf");
		$content = str_replace($replace, $new, $content);
	}

	// Collegehumor
	$tag = $tags["college_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id=".$video."&amp;fullscreen=1");
		$content = str_replace($replace, $new, $content);
	}

	// Videojug
	$tag = $tags["videojug_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.videojug.com/film/player?id=".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Godtube
	$tag = $tags["godtube_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://godtube.com/flvplayer.swf?viewkey=".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Veoh
	$tag = $tags["veoh_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&amp;type=v&amp;permalinkId=".$video."&amp;id=anonymous");
		$content = str_replace($replace, $new, $content);
	}

	// Break
	$tag = $tags["break_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://embed.break.com/".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Dailymotion
	$tag = $tags["dailymotion_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.dailymotion.com/swf/".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Movieweb
	$tag = $tags["movieweb_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.movieweb.com/v/".$video);
		$content = str_replace($replace, $new, $content);
	}

	// jaycut
	$tag = $tags["jaycut_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://jaycut.se/flash/preview.swf?file=http://jaycut.se/mixes/send_preview/".$video."&amp;type=flv&amp;autostart=false");
		$content = str_replace($replace, $new, $content);
	}

	// Myvideo
	$tag = $tags["myvideo_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.myvideo.de/movie/".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Vimeo
	$tag = $tags["vimeo_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.vimeo.com/moogaloop.swf?clip_id=".$video."&amp;server=www.vimeo.com&amp;fullscreen=1&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=");
		$content = str_replace($replace, $new, $content);
	}

	// Gametrailers
	$tag = $tags["gtrailers_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.gametrailers.com/remote_wrap.php?mid=".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Viddler
	$tag = $tags["viddler_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www.viddler.com/player/".$video."/");
		$content = str_replace($replace, $new, $content);
	}

	// Snotr
	$tag = $tags["snotr_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://videos.snotr.com/player.swf?video=".$video."&amp;embedded=true&amp;autoplay=false");
		$content = str_replace($replace, $new, $content);
	}

	// Funny or Die
	$tag = $tags["funnyordie_tag"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new = buildEmbed("http://www2.funnyordie.com/public/flash/fodplayer.swf?6045&amp;key=".$video);
		$content = str_replace($replace, $new, $content);
	}

	// Quicktime
	$tag = $tags["quicktime_tag"];
	$height = $tags["video_height"];
	$width = $tags["video_width"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new='<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="'.$width.'" height="'.$height.'">';
		$new.='<param name="src" value="'.$video.'" />';
		$new.='<param name="controller" value="true" />';
		$new.='<param name="autoplay" value="false" />';
		$new.='<param name="scale" value="aspect" />';
		$new.='<object type="video/quicktime" data="'.$video.'" width="'.$width.'" height="'.$height.'">'."\n";
		$new.='<param name="autoplay" value="false" />';
	 	$new.='<param name="controller" value="true" />';
		$new.='<param name="scale" value="aspect" />';
		$new.='</object>';
		$new.='</object>';
		$content = str_replace($replace, $new, $content);
	}

	// Windows media player
	$tag = $tags["windowsmedia_tag"];
	$height = $tags["video_height"];
	$width = $tags["video_width"];
	preg_match_all('/\['.$tag.'\](.*?)\[\/'.$tag.'\]/is', $content, $videocode);
	for ($i=0; $i < count($videocode['0']); $i++)
	{
		$video =  $videocode['1'][$i];
		$replace = $videocode['0'][$i];
		$new='<object classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" id="player" width="'.$width.'" height="'.$height.'">'."\n";
		$new.='<param name="url" value="'.$video.'" />'."\n";
		$new.='<param name="src" value="'.$video.'" />'."\n";
		$new.='<param name="showcontrols" value="true" />'."\n";
		$new.='<param name="autostart" value="false" />'."\n";
		$new.='<param name="stretchtofit" value="true" />'."\n";
		$new.='<!--[if !IE]>-->'."\n";
		$new.='<object type="video/x-ms-wmv" data="'.$video.'" width="'.$width.'" height="'.$height.'">'."\n";
		$new.='<param name="src" value="'.$video.'" />'."\n";
		$new.='<param name="autostart" value="false" />'."\n";
		$new.='<param name="controller" value="false" />'."\n";
		$new.='<param name="stretchtofit" value="true" />'."\n";
		$new.='</object>'."\n";
		$new.='<!--<![endif]-->'."\n";
		$new.='</object>'."\n";

		$content = str_replace($replace, $new, $content);
	}

	return $content;
}

function buildEmbed($code)
{
	$options = get_option(videoembedder_options);
	$width = $options["video_width"];
	$height = $options["video_height"];
	$object = '';
	if(is_feed()) {
		$object  = '<object width="'.$width.'" height="'.$height.'">';
		$object .= '<param name="movie" value="'.$code.'"></param>';
		$object .= '<param name="wmode" value="transparent"></param>';
		$object .= '<embed src="'.$code.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'"></embed>';
		$object .= '</object>';
	} else {
		$object  = '<object type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" data="'.$code.'">';
		$object .= '<param name="movie" value="'.$code.'" />';
		$object .= '<param name="wmode" value="transparent" />';
		$object .= '<param name="quality" value="high" />';
		$object .= '</object>';
	}
	return $object;
}

function defaultSettings() {
	if(get_option('videoembedder_version') != ""){
			importOldSettings();
	}
	
	$option = get_option('videoembedder_options');
	if($option["version"] != "1.7.1")		$option["version"] = "1.7.1";
	if($option["video_width"]=="")		$option["video_width"] = "425";
	if($option["video_height"]=="")		$option["video_height"] = "355";
	if($option["youtube_tag"]=="")		$option["youtube_tag"] = "youtube";
	if($option["google_tag"]=="")		$option["google_tag"] = "google";
	if($option["metacafe_tag"]=="")		$option["metacafe_tag"] = "metacafe";
	if($option["liveleak_tag"]=="")		$option["liveleak_tag"] = "liveleak";
	if($option["revver_tag"]=="")		$option["revver_tag"] = "revver";
	if($option["ifilm_tag"]=="")		$option["ifilm_tag"] = "ifilm";
	if($option["myspace_tag"]=="")		$option["myspace_tag"] = "myspace";
	if($option["bliptv_tag"]=="")		$option["bliptv_tag"] = "bliptv";
	if($option["college_tag"]=="")		$option["college_tag"] = "college";
	if($option["videojug_tag"]=="")		$option["videojug_tag"] = "videojug";
	if($option["godtube_tag"]=="")		$option["godtube_tag"] = "godtube";
	if($option["veoh_tag"]=="")		$option["veoh_tag"] = "veoh";
	if($option["break_tag"]=="")		$option["break_tag"] = "break";
	if($option["dailymotion_tag"]=="")	$option["dailymotion_tag"] = "daily";
	if($option["movieweb_tag"]=="")		$option["movieweb_tag"] = "movieweb";
	if($option["jaycut_tag"]=="")		$option["jaycut_tag"] = "jaycut";
	if($option["myvideo_tag"]=="")		$option["myvideo_tag"] = "myvideo";
	if($option["vimeo_tag"]=="")		$option["vimeo_tag"] = "vimeo";
	if($option["gtrailers_tag"]=="")	$option["gtrailers_tag"] = "gtrailer";
	if($option["viddler_tag"]=="")	$option["viddler_tag"] = "viddler";
	if($option["snotr_tag"]=="")	$option["snotr_tag"] = "snotr";
	if($option["funnyordie_tag"]=="")	$option["funnyordie_tag"] = "funnyordie";
	//Local
	if($option["quicktime_tag"]=="")	$option["quicktime_tag"] = "quicktime";
	if($option["windowsmedia_tag"]=="")	$option["windowsmedia_tag"] = "windowsmedia";
	update_option('videoembedder_options', $option);
}

function importOldSettings(){
	$old_options=array(
		"video_width" => get_option('videoembedder_video_width'),
		"video_height" => get_option('videoembedder_video_height'),
		"youtube_tag" => get_option('videoembedder_youtube_tag'),
		"google_tag" => get_option('videoembedder_google_tag'),
		"metacafe_tag" => get_option('videoembedder_metacafe_tag'),
		"liveleak_tag" => get_option('videoembedder_liveleak_tag'),
		"revver_tag" => get_option('videoembedder_revver_tag'),
		"ifilm_tag" => get_option('videoembedder_ifilm_tag'),
		"myspace_tag" => get_option('videoembedder_myspace_tag'),
		"bliptv_tag" => get_option('videoembedder_bliptv_tag'),
		"college_tag" => get_option('videoembedder_college_tag'),
		"videojug_tag" => get_option('videoembedder_videojug_tag'),
		"godtube_tag" => get_option('videoembedder_godtube_tag'),
		"veoh_tag" => get_option('videoembedder_veoh_tag'),
		"break_tag" => get_option('videoembedder_break_tag'),
	);
	update_option('videoembedder_options', $old_options);

	delete_option('videoembedder_version');
	delete_option('videoembedder_video_width');
	delete_option('videoembedder_video_height');
	delete_option('videoembedder_youtube_tag');
	delete_option('videoembedder_google_tag');
	delete_option('videoembedder_metacafe_tag');
	delete_option('videoembedder_liveleak_tag');
	delete_option('videoembedder_revver_tag');
	delete_option('videoembedder_ifilm_tag');
	delete_option('videoembedder_myspace_tag');
	delete_option('videoembedder_bliptv_tag');
	delete_option('videoembedder_college_tag');
	delete_option('videoembedder_videojug_tag');
	delete_option('videoembedder_godtube_tag');
	delete_option('videoembedder_veoh_tag');
	delete_option('videoembedder_break_tag');
}
?>