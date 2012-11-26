<?php
/**
 * ISL Template Class File
 *
 * LICENSE: The GNU General Public License ( GPL )
 *
 * @copyright 2009 Inmeres Solutions Ltd
 * @license GPL v2.0
 * @author Steven Raynham
 * @version 1.1
 * @link http://www.inmeres.com/
 * @since File available since Release 1.0
*/

/**
 * ISL Template Class
 *
 * @copyright 2009 Inmeres Solutions Ltd
 * @license GPL v2.0
 * @author Steven Raynham
 * @version 1.1
 * @link http://www.inmeres.com/
 * @since File available since Release 1.0
 */
class IslTemplate
{
    var $files, $elements, $outputVariable;

    function IslTemplate()
    {
        $this->outputVariable = 'elements';
    }

    /**
     * Output the template with the variables
     *
     * @param bool $echo
     * @return mixed
     */
    function output( $echo = false )
    {
        if ( is_array( $this->files ) ) $files = $this->files; else $files[] = $this->files;
        $temp = $this->outputVariable;
        $$temp = &$this->elements;
        unset( $temp );
        $return = '';
        foreach ( $files as $file ) {
            if ( file_exists( $file ) ) {
                ob_start();
                @include( $file );
                $return .= ob_get_contents();
                ob_end_clean();
            }
        }
        if ( ( $return!='' ) && ( $echo ) ) echo $return; else return $return;
    }
}
