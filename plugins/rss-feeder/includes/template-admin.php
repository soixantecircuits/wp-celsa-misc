<div class="wrap">
    <div id="rss-feeder-admin">
        <?php if ( !empty( $elements->message ) ) echo '<div id="message" class="updated fade"><p><strong>' . $elements->message . '</strong></p></div>'; ?>
        <?php if ( !empty( $elements->title ) ) echo '<h2>' . $elements->title . '</h2>'; ?>
        <?php if ( !empty( $elements->instructions ) ) echo '<p>' . $elements->instructions . '</p>'; ?>
        <?php echo $elements->javascript; ?>
        <?php if ( count( $elements->fields ) > 1 ) { ?> 
            <?php echo $elements->form; ?>
                <?php $submit = '<p class="submit">' . $elements->fields['rss_feeder[submit]']['input'] . '</p>'; unset( $elements->fields['rss_feeder[submit]'] ); ?>
                <?php echo $elements->fields['nonce']['input']; unset( $elements->fields['nonce'] ); ?>
                <?php echo $elements->fields['action']['input']; unset( $elements->fields['action'] ); ?>
                <?php echo $elements->fields['islform']['input']; unset( $elements->fields['islform'] ); ?>
                <table class="form-table">
                    <tbody>
                    <?php foreach ( $elements->fields as $name => $field ) { ?>
                        <?php if ( substr( $name, 0, 5 ) == 'plain' ) { echo $field['input']; ?>
                        <?php } elseif ( strpos( $field['input'], 'type="hidden"' ) !== false ) { echo $field['input']; ?>
                        <?php } elseif ( substr( $name, 0, 14 ) == 'container-open' ) { ?>
                    </tbody>
                    <tbody id="<?php echo $name; ?>">
                        <?php } elseif ( substr( $name, 0, 15 ) == 'container-close' ) { ?>
                    </tbody>
                    <tbody>
                        <?php } else { ?>
                            <tr valign="top">
                                <th scope="row">
                                    <?php if ( $field['label']!='' ) echo $field['label']; ?><?php if ( $field['help']!='' ) echo ' ' . $field['help']; ?>
                                    <?php if ( $field['error']!='' ) echo '<br/><small style="color:red;">' . $field['error'] . '<small>'; ?>
                                </th>
                                <td><?php echo $field['input']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                <?php echo $submit; ?>
            </form>
        <?php } ?>
        <?php if ( $elements->pagination ) echo $elements->pagination; ?>
        <?php if ( $elements->table ) echo $elements->table; ?> 
        <?php if ( $elements->pagination ) echo $elements->pagination; ?>
    </div>
</div>
