<?php
class WpAdminTable
{
    var $nonce;
    var $name;
    var $form;
    var $headings;
    var $data;
    var $bulkActions;
    var $dataActions;
    var $javascript;

    public function __construct()
    {
        $this->nonce = array();
        $this->name = '';
        $this->form = array();
        $this->headings = array();
        $this->data = array();
        $this->bulkActions = array();
        $this->dataActions = array();
        $this->javascript = '';
    }

    public function output( $echo = false )
    {
        ob_start();
        if ( ( !empty( $this->name ) ) && ( count( $this->headings ) > 0 ) ) {
?>
<form<?php if ( count( $this->form ) == 0 ) { ?> method="post" action=""<? } else { foreach ( $this->form as $name => $value ) echo ( ' ' . $name . '="' . $value . '"' ); } ?>>
    <?php if ( count( $this->nonce ) == 2 ) wp_nonce_field( $this->nonce[0], $this->nonce[1], true, true ); else wp_nonce_field( $this->name . '-nonce', $this->name . '-nonce', true, true ); ?>
    <input type="hidden" name="action" value="save"/>
    <input type="hidden" name="<?php echo $this->name; ?>-form" value="true"/>
    <?php if ( count( $this->data ) > 0 ) { ?>
    <?php if ( count( $this->bulkActions ) > 0 ) { ?>
    <div class="tablenav">
        <div class="alignleft actions">
            <select name="action">
                <option selected="selected" value=""><?php _e( 'Bulk Actions' ); ?></option>
                <?php foreach ( $this->bulkActions as $name => $value ) { ?>
                <option value="<?php echo $value; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
            <input class="button-secondary action" type="submit" value="<?php _e( 'Apply' ); ?>" name="doaction_<?php echo $this->name; ?>" id="doaction_<?php echo $this->name; ?>"/>
        </div>
    </div>
    <?php } ?>
    <div class="clear"></div>
    <table id="<?php echo $this->name; ?>-table" class="widefat" cellspacing="0">
        <thead>
            <tr>
                <?php if ( count( $this->bulkActions ) > 0 ) { ?><th class="check-column" scope="col"><input type="checkbox"/></th><?php } ?>
                <?php foreach ( $this->headings as $heading ) { ?>
                <th scope="col"><?php echo $heading; ?></th>
                <?php } ?>
                <?php if ( count( $this->dataActions ) > 0 ) { ?><th class="action-links" scope="col"><?php _e( 'Actions' ); ?></th><?php } ?>
            </tr>
        </thead>
        <tbody class="<?php echo $this->name; ?>-data">
            <?php foreach ( $this->data as $action => $dataRow ) { ?>
            <tr>
                <?php if ( count( $this->bulkActions ) > 0 ) { ?><th class="check-column" scope="row"><input type="checkbox" value="<?php echo $action; ?>" name="checked[]"/></th><?php } ?>
                <?php foreach ( $dataRow as $data ) { ?><td class="name"><?php echo ( !empty( $data ) ? $data : '&nbsp;' ); ?></td><?php } ?>
                <?php if ( isset( $this->dataActions[$action] ) ) { ?><td class="togl action-links"><?php foreach ( $this->dataActions[$action] as $dataAction ) { ?><?php echo $dataAction; ?>&nbsp;&nbsp;&nbsp;<?php } ?></td><?php } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php if ( !empty( $this->javascript ) ) { ?>
    <script type="text/javascript">
    /* <![CDATA[ */
        <?php echo $this->javascript; ?>
    /* ]]> */
    </script>
    <?php } ?>
    <?php } else { ?>
    <p><?php _e( 'There are currently no links set.' ); ?></p>
    <?php } ?>
</form>
<?php   }
        $return = ob_get_contents();
        ob_end_clean();
        if ( $echo ) echo $return; else return $return;
    }
    
    function dateTimeFormat( $dateTime ) {
        require_once( ABSPATH . WPINC . '/formatting.php' );
        $dateTimeArray = explode( ' ', $dateTime );
        $dateArray = explode( '-', $dateTimeArray[0] );
        $timeArray = explode( ':', $dateTimeArray[1] );
        $time = mktime( intval( $timeArray[0] ), intval( $timeArray[1] ), intval( $timeArray[2] ), intval( $dateArray[1] ), intval( $dateArray[2] ), intval( $dateArray[0] ) );
        if ( ( abs( time() - $time ) ) < 86400 ) {
            $humanTime = sprintf( __( '%s ago' ), human_time_diff( $time ) );
        } else {
            $humanTime = mysql2date( __( 'd/m/Y g:i:s A' ), $dateTime );
        }
        $return = '<abbr title="' . mysql2date( __( 'd/m/Y' ), $dateTime ) . '">' . $humanTime . '</abbr>';
        return $return;
    }
}
