<?php $item = $feed->items[0] ?>
<h3><?php echo empty( $item->link ) ? '' : '<a title="' . $item->title . '" href="' . $item->link . '">'; ?><?php echo $item->title; ?><?php echo empty( $item->link ) ? '' : '</a>'; ?></h3>
<small><?php echo date( 'F jS, Y \a\t g:ia', strtotime( $item->pubdate ) ); ?></small>
<p><?php echo empty( $item->content_encoded ) ? $item->description : $item->content_encoded; ?></p>
<?php if ( !empty( $item->categories ) ) { ?><p><?php echo $item->categories; ?></p><?php } ?>
