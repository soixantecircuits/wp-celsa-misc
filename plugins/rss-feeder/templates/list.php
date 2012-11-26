<h2><a title="<?php echo $feed->title; ?>" href="<?php echo $feed->link; ?>"><?php echo $feed->title; ?></a></h2>
<p><?php echo $feed->description; ?></p>
<?php if ( !empty( $feed->categories ) ) { ?><p><?php echo $feed->categories; ?></p><?php } ?>
<?php foreach ( $feed->items as $item ) { ?>
    <h3><?php echo empty( $item->link ) ? '' : '<a title="' . $item->title . '" href="' . $item->link . '">'; ?><?php echo $item->title; ?><?php echo empty( $item->link ) ? '' : '</a>'; ?></h3>
    <small><?php echo date( 'F jS, Y \a\t g:ia', strtotime( $item->pubdate ) ); ?></small>
    <p><?php echo $item->description; ?></p>
    <p><?php echo $item->content_encoded; ?></p>
    <?php if ( !empty( $item->categories ) ) { ?><p><?php echo $item->categories; ?></p><?php } ?>
<?php } ?>
