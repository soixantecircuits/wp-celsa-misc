<?php
/**
 * ISL Form Class File
 *
 * LICENSE: The GNU General Public License ( GPL )
 *
 * @copyright 2009 Inmeres Solutions Ltd
 * @license GPL v2.0
 * @author Steven Raynham
 * @version 2.7.4
 * @link http://www.inmeres.com/
 * @since File available since Release 2.0
*/

/**
 * ISL Form Class
 *
 * @copyright 2009 Inmeres Solutions Ltd
 * @license GPL v2.0
 * @author Steven Raynham
 * @version 2.7.4
 * @link http://www.inmeres.com/
 * @since File available since Release 2.0
 */
class IslForm
{
    var $nameNumber;
    var $nameArray;
    var $idNumber;
    var $idArray;
    var $fieldNameArray;
    var $helpJs;
    var $classUrl;
    var $classPath;
    var $fieldSetFields;
    var $fieldSetName;
    var $defaultFieldName;
    var $form;
    var $session;
    var $populateFromSession;
    var $javascript;
    var $fields;
    var $request;
    var $valid;
    var $ajaxUpload;
    var $nicEdit;
    var $farbtastic;
    var $posted;

    /**
     * Constructor
     *
     * @author Steven Raynham
     * @since 2.6.8
     *
     * @param void
     * @return null
     */
    function IslForm()
    {
        $this->classUrl = ( isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . dirname( str_replace( $_SERVER['DOCUMENT_ROOT'], '', __FILE__ ) ) . '/';
        $this->classPath = dirname( __FILE__ ) . '/';
        $this->session = false;
        $this->populateFromSession = false;
        $this->helpJs = false;
        $this->defaultFieldName = 'fieldname';
        $this->nameArray = array();
        $this->nameNumber = 0;
        $this->idArray = array();
        $this->idNumber = 0;
        $this->fieldNameArray = array();
        $this->request = array();
        $this->posted = false;
        $this->addInitField();
        $this->fieldSetFields = 0;
        $this->fieldSetName = '';
    }

    /**
     * Setup form variable
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param array $parameters
     * @return null
     */
    function setForm( $parameters = '' )
    {
        $filterParameters['html'] = $parameters;
        $additionalAllowedParameters = array( 'action', 'accept', 'accept-charset', 'enctype', 'method', 'name', 'target',
                                              'onclick', 'ondblclick', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onreset', 'onsubmit' );
        $parameters = $this->cleanHtmlParameters( $filterParameters, $additionalAllowedParameters );
        $this->form = '<form';
        if ( count( $parameters['html'] ) > 0 ) {
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                $this->form .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
        }
        $this->form .= '>';
    }

    /**
     * Add initial form field for validation
     *
     * @author Steven Raynham
     * @since 2.1.4
     *
     * @param void
     * @return null
     */
    function addInitField()
    {
        if ( !isset( $this->fields ) ) {
            $this->addField( 'hidden', array( 'name' => 'islform',
                                              'forcedvalue' => 1 ) );
        }
    }

    /**
     * Add form field to fields variable
     *
     * @author Steven Raynham, Thomas McGregor
     * @since 2.7.4
     *
     * @param string $type
     * @param array $parameters
     * @return null
     */
    function addField( $type, $parameters = '' )
    {
        if ( isset( $_REQUEST['islform'] ) ) $this->posted = true;

        if ( isset( $parameters['name'] ) ) {
            $parameters['html']['name'] = $this->generateName( $parameters['name'] );
            unset( $parameters['name'] );
        } else {
            $parameters['html']['name'] = $this->generateName();
        }
        if ( isset( $parameters['html']['id'] ) ) {
            $parameters['html']['id'] = $this->generateId( $parameters['html']['id'] );
        } else {
            $parameters['html']['id'] = $this->generateId( $parameters['html']['name'] );
        }

        if ( $type == 'fieldset' ) {
            if ( $this->fieldSetFields > 0 )  {
                $this->fields[$this->fieldSetName . '_close']['input'] = '</fieldset>';
            }
            $fieldSetElement = $this->fieldset( $parameters );
            $this->fields[$fieldSetElement['name'] . '_open']['input'] = $fieldSetElement['input'];
            $this->fieldSetName = $fieldSetElement['name'];
            if ( isset( $parameters['fields'] ) ) {
                $this->fieldSetFields = $parameters['fields'];
            }
        } else {
            if ( isset( $parameters['forcedvalue'] ) ) {
                $parameters['value'] = $parameters['forcedvalue'];
            } else {
                if ( $this->populateFromSession ) {
                    $sessionRequestName = $this->convertFormFieldName( $parameters['html']['name'] );
                    eval( 'if ( isset( $_SESSION[$this->session]' . $sessionRequestName .' ) ) {
                        $parameters[\'value\'] = $_SESSION[$this->session]' . $sessionRequestName . ';
                        $parameters[\'validate\'][\'request\']' . $sessionRequestName . ' = $parameters[\'value\'];
                    }' );
                }
                if ( ( $requestValue = $this->requestValue( $parameters['html']['name'] ) ) !== false ) {
                    $parameters['value'] = $requestValue;
                    $parameters['validate']['request'][$parameters['html']['name']] = $parameters['value'];
                } else if ( isset( $parameters['validate']['required'] ) && $this->posted ) {
                    if ( !isset( $parameters['value'] ) ) $parameters['value'] = '';
                    $parameters['validate']['request'][$parameters['html']['name']] = $parameters['value'];
                }
            }
            if ( isset( $parameters['value'] ) ) {
                $parameters['html']['value'] = $parameters['value'];
                unset( $parameters['value'] );
            }
            if ( isset( $parameters['filter'] ) && $parameters['filter'] && isset( $parameters['html']['value'] ) ) {
                foreach ( $parameters['filter'] as $function => $filterParameters ) {
                    if ( is_array( $filterParameters ) ) {
                        $filterParameters[] = $parameters['html']['value'];
                    } else {
                        if ( $filterParameters != '' ) $filterParameters = array( $filterParameters, $parameters['html']['value'] );
                            else $filterParameters = array( $parameters['html']['value'] );
                    }
                    if ( method_exists( $this, $function ) ) {
                        $parameters['html']['value'] = call_user_func_array( array( &$this, $function ), $filterParameters );
                    } else if ( function_exists( $function ) ) {
                        $parameters['html']['value'] = call_user_func_array( $function, $filterParameters );
                    }
                }
            }
            if ( isset( $parameters['html']['value'] ) ) {
                $this->requestNameValue( $parameters['html']['name'], $parameters['html']['value'] );
            }
            if ( method_exists( $this, $type ) ) {
                $element = call_user_func( array( &$this, $type ), $parameters );
            } else {
                $element = array( 'html' => '', 'name' => '' );
            }
            $returnKeys = array( 'label', 'input' );
            foreach ( $returnKeys as $returnKey ) {
                $this->fields[$element['name']][$returnKey] = '';
                if ( isset( $element[$returnKey] ) ) $this->fields[$element['name']][$returnKey] = $element[$returnKey];
            }
            $this->fields[$element['name']]['error'] = '';
            if ( $this->posted ) {
                if ( isset( $parameters['validate'] ) && isset( $parameters['validate']['request'][$parameters['html']['name']] ) ) {
                    $validate = $this->isValid( $parameters['validate'], $parameters['html']['name'] );
                    if ( $validate !== true ) {
                        $this->fields[$element['name']]['error'] = $validate;
                        $this->valid = false;
                    } else if ( !isset( $this->valid ) ) {
                        $this->valid = true;
                    }
                }
            }
            if ( $this->session && isset( $parameters['html']['value'] ) ) {
                $this->sessionNameValue( $element['name'], $parameters['html']['value'] );
            }
            $this->fields[$element['name']]['help'] = '';
            if ( isset( $parameters['help'] ) ) {
                $this->fields[$element['name']]['help'] = $this->help( $parameters['html']['id'] . '_help', $parameters['help'] );
            }
            if ( isset( $parameters['label_prefix'] ) ) $this->fields[$element['name']]['label_prefix'] = $parameters['label_prefix'];
            if ( isset( $parameters['label_suffix'] ) ) $this->fields[$element['name']]['label_suffix'] = $parameters['label_suffix'];
            if ( isset( $parameters['field_prefix'] ) ) $this->fields[$element['name']]['field_prefix'] = $parameters['field_prefix'];
            if ( isset( $parameters['field_suffix'] ) ) $this->fields[$element['name']]['field_suffix'] = $parameters['field_suffix'];
            if ( ( $type != 'fieldset' ) && ( $this->fieldSetFields > 0 ) ) {
                $this->fieldSetFields--;
                if ( $this->fieldSetFields == 0 ) {
                    $this->fields[$this->fieldSetName . '_close']['input'] = '</fieldset>';
                    $this->fieldSetName = '';
                }
            }
        }
    }

    /**
     * Generate valid HTML label tag
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    function label( $name, $parameters = '' )
    {
        $return = '<label for="' . $name . '"';
        if ( is_array( $parameters ) ) {
            $additionalAllowedParameters = array( 'onblur', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup' );
            $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
            if ( isset( $parameters['html'] ) ) {
                if ( count( $parameters['html'] ) > 0 ) {
                    foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                        $return .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                    }
                }
            }
            $return .= '>' . $parameters['value'] . '</label>';
        } else {
            $return .= '>' . $parameters . '</label>';
        }
        return $return;
    }

    /**
     * Generate valid HTML label tag
     *
     * @author Steven Raynham
     * @since 2.7.1
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    function help( $id, $parameters = '' )
    {
        $showJs = true;
        if ( isset( $parameters['nonjs'] ) && ( $parameters['nonjs'] ) ) $showJs = false;
        if ( ( !$this->helpJs ) && ( $showJs ) ) {
/*var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function updateCursorPosition( e ){
    cX = e.pageX;
    cY = e.pageY;
}
function updateCursorPositionDocAll( e ){
    cX = event.clientX;
    cY = event.clientY;
}
if ( document.all ) {
    document.onmousemove = updateCursorPositionDocAll;
} else {
    document.onmousemove = updateCursorPosition;
}
function assignPosition( d ) {
    if ( self.pageYOffset ) {
        rX = self.pageXOffset;
        rY = self.pageYOffset;
    } else if( document.documentElement && document.documentElement.scrollTop ) {
        rX = document.documentElement.scrollLeft;
        rY = document.documentElement.scrollTop;
    } else if( document.body ) {
        rX = document.body.scrollLeft;
        rY = document.body.scrollTop;
    }
    if ( document.all ) {
        cX += rX;
        cY += rY;
    }
    d.style.left = ( cX+10 ) + "px";
    d.style.top = ( cY+10 ) + "px";
}
}*/

/*
    function hideContent( d ) {
        if( d.length < 1 ) {
            return;
        }
        document.getElementById( d ).style.display = "none";
    }    
    function showContent( d ) {
        if( d.length < 1 ) {
            return;
        }
        var dd = document.getElementById( d );
        dd.style.display = "block";
    }
*/

            $this->javascript .= <<<JS
<script type="text/javascript">
/* <![CDATA[ */

JS;
            if ( isset( $parameters['fix'] ) ) {
                $this->javascript .= <<<JS
function hideContent( d ){if( d.length<1 ){return}document.getElementById( d ).style.display="none"}function showContent( d ){if( d.length<1 ){return}var dd=document.getElementById( d );dd.style.display="block"}

JS;
            } else {
                $this->javascript .= <<<JS
var cX=0;var cY=0;var rX=0;var rY=0;function updateCursorPosition( e ){cX=e.pageX;cY=e.pageY}function updateCursorPositionDocAll( e ){cX=event.clientX;cY=event.clientY}if( document.all ){document.onmousemove=updateCursorPositionDocAll}else{document.onmousemove=updateCursorPosition}function assignPosition( d ){if( self.pageYOffset ){rX=self.pageXOffset;rY=self.pageYOffset}else if( document.documentElement&&document.documentElement.scrollTop ){rX=document.documentElement.scrollLeft;rY=document.documentElement.scrollTop}else if( document.body ){rX=document.body.scrollLeft;rY=document.body.scrollTop}if( document.all ){cX+=rX;cY+=rY}d.style.left=( cX+10 )+"px";d.style.top=( cY+10 )+"px"}function hideContent( d ){if( d.length<1 ){return}document.getElementById( d ).style.display="none"}function showContent( d ){if( d.length<1 ){return}var dd=document.getElementById( d );assignPosition( dd );dd.style.display="block"}

JS;
            }
            $this->javascript .= <<<JS
/* ]]> */
</script>

JS;

            $this->helpJs = true;
        }
        if ( !isset( $parameters['link'] ) ) $parameters['link'] = '?';
        if ( !empty( $id ) && !empty( $parameters['content'] ) ) {
            if ( $showJs ) {
                $return = '<a href="javascript:showContent(\'' . $id . '\')" onmousemove="showContent( \'' . $id . '\' ); return true;" onmouseover="showContent(\'' . $id . '\'); return true;" onmouseout="hideContent(\'' . $id . '\'); return true;"';
                if ( isset( $parameters['linkparameters'] ) ) {
                    foreach ( $parameters['linkparameters'] as $htmlParameter => $htmlValue ) {
                        $return .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                    }
                }
                $return .= '>' . $parameters['link'] . '</a>'."\r\n";
                $return .= '<div id="' . $id . '" onmouseover="showContent(\'' . $id . '\'); return true;" onmouseout="hideContent(\'' . $id . '\'); return true;" ';
                $style = 'style="display:none;position:absolute;z-index:1000;';
            } else {
                $return = '<div id="' . $id . '" ';
                $style = 'style="';
            }
            $content = '';
            if ( isset( $parameters['contentparameters'] ) ) {
                if ( isset( $parameters['contentparameters']['style'] ) ) {
                    $style .= $parameters['contentparameters']['style'];
                    unset( $parameters['contentparameters']['style'] );
                }
                foreach ( $parameters['contentparameters'] as $htmlParameter => $htmlValue ) {
                    $content .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                }
            }
            $style .= '"';
            $return .= $style . $content . '>' . $parameters['content'] . '</div>'."\r\n";
        } else {
            $return = '';
        }
        return $return;
    }

    /**
     * Generate valid HTML input hidden tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function hidden( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="hidden"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Generate valid HTML input text tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function text( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'maxlength', 'readonly', 'size', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="text"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Generate valid HTML input password tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function password( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'maxlength', 'readonly', 'size', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="password"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Generate valid HTML input textarea tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function textarea( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'cols', 'rows', 'disabled', 'readonly', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $parameters['html']['value'] ) ) {
            $value = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        } else {
            $value = '';
        }
        $return['input'] = '<textarea';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '>';
        $return['input'] .= $value;
        $return['input'] .= '</textarea>';
        if ( isset( $parameters['htmlarea'] ) ) {
            if ( isset( $this->nicEdit ) ) {
                if ( $this->nicEdit ) $this->javascript .= '<script type="text/javascript" src="' . $this->nicEdit . '"></script>';
            } else {
                $this->javascript .= '<script type="text/javascript" src="' . $this->classUrl . 'class-forms-includes/nicEdit.js"></script>';
            }
            if ( !isset( $parameters['htmlarea']['buttonlist'] ) ) {
                $useFullPanel = true;
            } else {
                $useFullPanel = false;
            }
            $return['input'] .= '
<script type="text/javascript">
/* <![CDATA[ */
    new nicEditor({iconsPath:\'' . $this->classUrl . 'class-forms-includes/nicEditorIcons.gif\',
                   ' . ( $useFullPanel ? 'fullPanel:true' : 'buttonList:[' . $parameters['htmlarea']['buttonlist'] . ']' ) . '}).panelInstance(\'' . $parameters['html']['id'] . '\');
/* ]]> */
</script>
';
        }
        return $return;
    }

    /**
     * Generate valid HTML input radio tag
     *
     * @author Steven Raynham
     * @since 2.7.4
     *
     * @param array $parameters
     * @return string
     */
    function radio( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'readonly', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        $id = $parameters['html']['id'];
        unset( $parameters['html']['id'] );
        if ( isset( $parameters['html']['value'] ) ) {
            $defaultValue = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        } else {
            $defaultValue = false;
        }
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $parameters['options'] ) && $parameters['options'] ) {
            $return['input'] = '<ul>';
            foreach ( $parameters['options'] as $label => $value ) {
                $return['input'] .= '<li><input type="radio" id="' . $id . '_' . $this->cleanId( $value ) . '"';
                foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                    $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                }
                $optionParameters = '<span';
                if ( isset( $parameters['optionparameters'] ) ) {
                    foreach ( $parameters['optionparameters'] as $optionTag => $optionValue ) {
                        $optionParameters .= ' ' . $optionTag . '="' . $optionValue . '"';
                    }
                }
                $optionParameters .= '>';
                $return['input'] .= ' value="' . $value . '"' . ( ( $defaultValue == $value )?' checked="checked"':'' ) . '/> ' . $optionParameters . $label . '</span></li>';
            }
            $return['input'] .= '</ul>';
        } else {
            $return = '';
        }
        return $return;
    }

    /**
     * Generate valid HTML input checkbox tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function checkbox( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'readonly', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $multiOption = false;
        if ( isset( $parameters['options'] ) && ( count( $parameters['options'] ) > 1 ) ) $multiOption = true;
        $parameters['html']['name'] .= ( $multiOption )?'[]':'';
        $return['name'] = $parameters['html']['name'];
        $id = $parameters['html']['id'];
        unset( $parameters['html']['id'] );
        if ( isset( $parameters['html']['value'] ) ) {
            $defaultValue = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        } else {
            $defaultValue = false;
        }
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $parameters['options'] ) ) {
            $return['input'] = ( $multiOption )?'<ul>':'';
            foreach ( $parameters['options'] as $label => $value ) {
                $return['input'] .= ( ( $multiOption )?'<li>':'' ) . '<input type="checkbox" id="' . $id . ( ( $multiOption )?'_' . $this->cleanId( $value ):'' ) . '"';
                foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                    $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                }
                $optionParameters = '<span';
                if ( isset( $parameters['optionparameters'] ) ) {
                    foreach ( $parameters['optionparameters'] as $optionTag => $optionValue ) {
                        $optionParameters .= ' ' . $optionTag . '="' . $optionValue . '"';
                    }
                }
                $optionParameters .= '>';
                $return['input'] .= ' value="' . $value . '"';
                if ( is_array( $defaultValue ) ) {
                    $return['input'] .= ( in_array( $value, $defaultValue ) ? ' checked="checked"' : '' );
                } else {
                    $return['input'] .= ( ( $defaultValue == $value )?' checked="checked"':'' );
                }
                $return['input'] .= '/> ' . $optionParameters . $label . '</span>' . ( ( $multiOption )?'</li>':'' );
            }
            $return['input'] .= ( $multiOption )?'</ul>':'';
        } else {
            $return = '';
        }
        return $return;
    }

    /**
     * Generate valid HTML input select tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function select( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'multiple', 'size', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['html']['value'] ) ) {
            $defaultValue = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        } else {
            $defaultValue = false;
        }
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $parameters['options'] ) ) {
            $return['input'] = '<select';
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                 $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $return['input'] .= '>';
            if ( isset( $parameters['defaulttext'] ) ) $return['input'] .= '<option value="">' . $parameters['defaulttext'] . '</option>';
            foreach ( $parameters['options'] as $label => $value ) {
                $return['input'] .= '<option value="' . $value . '"' . ( ( $defaultValue == $value )?' selected="selected"':'' ) . '> ' . $label . '</option>';
            }
            $return['input'] .= '</select>';
        } else {
            $return = '';
        }
        return $return;
    }

    /**
     * Generate valid HTML input multiselect tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function multiselect( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'multiple', 'size', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $parameters['html']['name'] .= '[]';
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['html']['value'] ) ) {
            $defaultValue = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        } else {
            $defaultValue = false;
        }
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $parameters['options'] ) ) {
            $return['input'] = '<select multiple="multiple"';
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                 $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $return['input'] .= '>';
            foreach ( $parameters['options'] as $label => $value ) {
                $return['input'] .= '<option value="' . $value . '"';
                if ( is_array( $defaultValue ) ) {
                    $return['input'] .= ( in_array( $value, $defaultValue )?' selected="selected"':'' );
                } else {
                    $return['input'] .= ( ( $defaultValue == $value )?' selected="selected"':'' );
                }
                $return['input'] .= '> ' . $label . '</option>';
            }
            $return['input'] .= '</select>';
        } else {
            $return = '';
        }
        return $return;
    }

    /**
     * Generate valid HTML input image tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function image( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'alt', 'src', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="image"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Generate valid HTML input file tag, AJAX version requires jQuery and ajaxupload.js to be referenced in the HTML head
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function file( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'accept', 'disabled', 'maxlength', 'readonly', 'size', 'value',
                                              'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        $name = $parameters['html']['name'];
        unset( $parameters['html']['name'] );
        if ( isset( $parameters['html']['value'] ) ) {
            $value = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        }
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<div class="input-image">';
        $showLegacy = true;
        if ( isset( $parameters['files'] ) ) $files = $parameters['files']; else $files = false;
        if ( isset( $parameters['remove'] ) ) $remove = $parameters['remove']; else $remove = ' X';
        if ( isset( $parameters['prefix'] ) ) $prefix = $parameters['prefix']; else $prefix = '';
        if ( isset( $parameters['ajax']['legacy'] ) && ( !$parameters['ajax']['legacy'] ) ) $showLegacy = false;
        if ( isset( $parameters['ajax'] ) ) {
            if ( isset( $parameters['ajax']['extensions'] ) ) $extensions = $parameters['ajax']['extensions']; else $extensions = false;
            $fileId = 0;
            if ( isset( $parameters['ajax']['multi'] ) && ( $parameters['ajax']['multi'] ) ) $addType = 'append'; else $addType = 'html';
            if ( isset( $this->ajaxUpload ) ) {
                if ( $this->ajaxUpload ) $this->javascript .= '<script type="text/javascript" src="' . $this->ajaxUpload . '"></script>';
            } else {
                $this->javascript .= '<script type="text/javascript" src="' . $this->classUrl . 'class-forms-includes/ajaxupload.js"></script>';
            }
            $this->ajaxUpload = false;
            $id = $parameters['html']['id'];
            unset( $parameters['html']['id'] );
            if ( !isset( $parameters['display'] ) ) $parameters['display'] = '';
            $return['input'] .= '<div id="' . $id . '_upload"></div><div id="' . $id . '_loader"></div><div id="' . $id . '_fields">';
            if ( $files ) {
                foreach ( $files as $file ) {
                    $return['input'] .= '<input id="' . $id . '_hidden' . $fileId . '" type="hidden" name="' . $name . ( ( $addType == 'append' )?'[]':'' ) . '" value="' . $file . '"/>';
                }
            }
            $return['input'] .= '</div>';
            switch ( $parameters['display'] ) {
                case 'inline':
                    $return['input'] .= '<div id="' . $id . '_display">';
                    if ( $files ) {
                        foreach ( $files as $file ) {
                            $return['input'] .= '<span id="' . $id . '_file' . $fileId . '">' . $file . '</span>';
                            $return['input'] .= '<a id="' . $id . '_remove' . $fileId . '" onclick="removeFile( ' . $fileId . ' );">' . $remove . '</a><noscript><input type="submit" name="removefile[' . $file . ']" value="Remove file"/></noscript>';
                            $fileId++;
                        }
                    }
                    $return['input'] .= '</div>';
                    break;
                case 'image':
                    $return['input'] .= '<div id="' . $id . '_display">';
                    if ( $files ) {
                        foreach ( $files as $file ) {
                            $return['input'] .= '<img id="' . $id . '_file' . $fileId . '" src="' . $parameters['imagepath'] . $file . '" alt="' . $file . '"/>';
                            $return['input'] .= '<a id="' . $id . '_remove' . $fileId . '" onclick="removeFile( ' . $fileId . ' );">' . $remove . '</a><noscript><input type="submit" name="removefile[' . $file . ']" value="Remove file"/></noscript>';
                            $fileId++;
                        }
                    }
                    $return['input'] .= '</div>';
                    break;
                case 'select':
                    $return['input'] .= '<select name="select_' . $name .'[]" id="' . $id . '_display" multiple="multiple">';
                    if ( $files ) {
                        foreach ( $files as $file ) {
                            $return['input'] .= '<option value="' . $file . '">' . $file . '</option>';
                        }
                    }
                    $return['input'] .= '</select>';
                    break;
                default:
                    $return['input'] .= '<ul id="' . $id . '_display">';
                    if ( $files ) {
                        foreach ( $files as $file ) {
                            $return['input'] .= '<li id="' . $id . '_file' . $fileId . '">' . $file;
                            $return['input'] .= ' <a id="' . $id . '_remove' . $fileId . '" onclick="removeFile( ' . $fileId . ' );">' . $remove . '</a><noscript><input type="submit" name="removefile[' . $file . ']" value="Remove file"/></noscript></li>';
                            $fileId++;
                        }
                    }
                    $return['input'] .= '</ul>';
            }
            $return['input'] .= '
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function() {
    var fileId = ' . $fileId . ';
    jQuery(\'#' . $id . '_upload\').html(\'<input type="button" id="' . $id . '_button" value="' . ( isset( $parameters['ajax']['label'] ) ? $parameters['ajax']['label'] : 'Upload File' ) . '"';
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $return['input'] .= '/>\' );
    new AjaxUpload(\'' . $id . '_button\', {
        action: \'' . $parameters['ajax']['action'] . '\',
        name: \'' . $id . '\',
        data: {'."\r\n";
            if ( isset( $parameters['ajax']['data'] ) ) {
                foreach ( $parameters['ajax']['data'] as $dataKey => $dataValue ) {
                    $return['input'] .= '            ' . $dataKey . ': \'' . $dataValue . '\','."\r\n";
                }
            }
            $return['input'] .= '        },
        autoSubmit: true,
        onChange: function() { this.disable(); },'."\r\n";
            if ( isset( $parameters['ajax']['loader'] ) ) {
                $return['input'] .= '
        onSubmit: function(file, ext) {'."\r\n";
            if ( $extensions ) $return['input'] .= '            if (!(ext && /^(' . $extensions . ')$/.test(ext))) {
                alert(\'File type \' + ext + \' is not allowed.\');
                this.enable();
                return false;
            }'."\r\n";
            $return['input'] .= '          jQuery(\'#' . $id . '_loader\').html(\'<img src="' . $parameters['ajax']['loader'] . '"/>\');
        },';
            }
            $return['input'] .= '
        onComplete: function(file, response) {
            jQuery(\'#' . $id . '_loader\').html(\'\');
            if (response==\'success\') {
                var newFile = file;'."\r\n";
            if ( isset( $parameters['ajax']['nospace'] ) && ( $parameters['ajax']['nospace'] ) ) $return['input'] .= '            newFile = newFile.replace(/ /g, \'_\');'."\r\n";
            if ( isset( $parameters['ajax']['lowercase'] ) && ( $parameters['ajax']['lowercase'] ) ) $return['input'] .= '            newFile = newFile.toLowerCase();'."\r\n";
            if ( isset( $parameters['ajax']['imagepath'] ) ) {
                if ( substr( $parameters['ajax']['imagepath'],-1 ) != '/' ) $parameters['ajax']['imagepath'] .= '/';
            } else {
                $parameters['ajax']['imagepath'] = '';
            }
            switch ( $parameters['display'] ) {
                case 'inline':
                    $return['input'] .= '
            jQuery(\'#' . $id . '_display\').' . $addType. '(\'<span id="' . $id . '_file\' + fileId + \'">' . $prefix . '\' + newFile + \'</span>\');
            jQuery(\'#' . $id . '_display\').append(\'<a id="' . $id . '_remove\' + fileId + \'" onclick="removeFile(\' + fileId + \');">' . $remove . '</a>\');
            jQuery(\'#' . $id . '_fields\').' . $addType. '(\'<input id="' . $id . '_hidden\' + fileId + \'" type="hidden" name="' . $name . ( ( $addType == 'append' )?'[]':'' ) . '" value="' . $prefix . '\' + newFile + \'"/>\');
            fileId+;'."\r\n";
                    break;
                case 'image':
                    $return['input'] .= '
            jQuery(\'#' . $id . '_display\').' . $addType. '(\'<img id="' . $id . '_file\' + fileId + \'" src="' . $parameters['imagepath'] . $prefix . '\' + newFile + \'" alt="' . $prefix . '\' + newFile + \'"/>\');
            jQuery(\'#' . $id . '_display\').append(\'<a id="' . $id . '_remove\' + fileId + \'" onclick="removeFile(\' + fileId + \');">' . $remove . '</a>\');
            jQuery(\'#' . $id . '_fields\').' . $addType. '(\'<input id="' . $id . '_hidden\' + fileId + \'" type="hidden" name="' . $name . ( ( $addType == 'append' )?'[]':'' ) . '" value="' . $prefix . '\' + newFile + \'"/>\');
            fileId++;'."\r\n";
                    break;
                case 'select':
                    $return['input'] .= '
            jQuery(\'#' . $id . '_display\').' . $addType. '(\'<option value="' . $prefix . '\' + newFile + \'">' . $prefix . '\' + newFile + \'</option>\');
            jQuery(\'#' . $id . '_fields\').' . $addType. '(\'<input id="' . $id . '_hidden\' + fileId + \'" type="hidden" name="' . $name . ( ( $addType == 'append' )?'[]':'' ) . '" value="' . $prefix . '\' + newFile + \'"/>\');'."\r\n";
                    break;
                default:
                    $return['input'] .= '
            jQuery(\'#' . $id . '_display\').' . $addType. '(\'<li id="' . $id . '_file\' + fileId + \'">' . $prefix . '\' + newFile + \' <a id="' . $id . '_remove\' + fileId + \'" onclick="removeFile(\' + fileId + \');">' . $remove . '</a></li>\');
            jQuery(\'#' . $id . '_fields\').' . $addType. '(\'<input id="' . $id . '_hidden\' + fileId + \'" type="hidden" name="' . $name . ( ( $addType == 'append' )?'[]':'' ) . '" value="' . $prefix . '\' + newFile + \'"/>\');
            fileId++;'."\r\n";
            }
                    $return['input'] .= '
            } else {
                alert(response);
            }
            this.enable();
        }
    } );
} )
function removeFile( id ) {
    jQuery(\'#' . $id . '_file' . '\' + id).remove();
    jQuery(\'#' . $id . '_remove' . '\' + id).remove();
    jQuery(\'#' . $id . '_hidden' . '\' + id).attr(\'value\', \' \');
}
/* ]]> */
</script>
';
            if ( $showLegacy ) $return['input'] .= '<noscript>';
        }
        if ( $showLegacy ) {
            if ( !isset( $parameters['display'] ) ) $parameters['display'] = '';
            $return['input'] .= '<input type="file" name="' . $name . '"' . ( isset( $value )?' value="' . $value . '"':'' );
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $return['input'] .= '/>';
        }
        if ( $showLegacy ) if ( isset( $parameters['ajax'] ) ) $return['input'] .= '</noscript>'."\r\n";
        $return['input'] .= '</div>';
        return $return;
    }

    /**
     * Generate valid HTML input calendar tag, requires jQuery, jQuery UI and jQuery Datepicker to be referenced in the head
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function date( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'maxlength', 'readonly', 'size', 'value',
                                              'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="text"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        $return['input'] .= '
<script type="text/javascript">
/* <![CDATA[ */
jQuery(function() {
    jQuery( \'#' . $parameters['html']['id'] . '\' ).datepicker( ';
        if ( isset( $parameters['datepicker'] ) ) {
            $return['input'] .= '{';
            $datePickerParameters = '';
            foreach ( $parameters['datepicker'] as $key => $value ) {
                if ( $datePickerParameters != '' ) $datePickerParameters .= ',';
                $datePickerParameters .= '
        ' . $key . ': ' . $value;
            }
            $return['input'] .= $datePickerParameters . '
    }';
        }
        $return['input'] .= ' );
    } );
/* ]]> */
</script>
';
        return $return;
    }

    /**
     * Generate valid HTML input date drop down tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function dateselect( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'maxlength', 'readonly', 'size', 'value',
                                              'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        if ( isset( $parameters['html']['value'] ) ) {
            $value = $parameters['html']['value'];
            unset( $parameters['html']['value'] );
        }
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $parameters['dateparameters'] ) ) {
            if ( !isset( $parameters['dateparameters']['yearstart'] ) ) $parameters['dateparameters']['yearstart'] = (int)date( 'Y' ) - 50;  
            if ( !isset( $parameters['dateparameters']['yearend'] ) ) $parameters['dateparameters']['yearend'] = (int)date( 'Y' ) + 50;
            if ( !isset( $parameters['dateparameters']['displayorder'] ) ) $parameters['dateparameters']['displayorder'] = '<YEAR><MONTH><DAY>';  
            if ( !isset( $parameters['dateparameters']['output'] ) ) $parameters['dateparameters']['output'] = 'Y-m-d';  
            if ( !isset( $parameters['dateparameters']['formatmonth'] ) ) $parameters['dateparameters']['formatmonth'] = 'F';  
        } else {
            $parameters['dateparameters']['yearstart'] = (int)date( 'Y' ) - 50;
            $parameters['dateparameters']['yearend'] = (int)date( 'Y' ) + 50;
            $parameters['dateparameters']['displayorder'] = '<YEAR><MONTH><DAY>';
            $parameters['dateparameters']['output'] = 'Y-m-d';
            $parameters['dateparameters']['formatmonth'] = 'F';
        }
        if ( isset( $value ) ) {
            $format = preg_replace( '/([aAdejuwUVWbBhmCgGyYHIlMpPrRSTXzZcDFsxnti]{1})/', '%$1', $parameters['dateparameters']['output'] );
            $search = array( '%i',
                             '%s' );
            $replace = array( '%M',
                              '%S' );
            $format = str_replace( $search, $replace, $format );
            $valueArray = @strptime( $value, $format );
        }
        $yearInput = '<select';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            if ( $htmlParameter == 'name' ) $htmlValue .= '[year]';
            if ( $htmlParameter == 'id' ) $htmlValue .= '_year';
            $yearInput .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $yearInput .= '>';
        for ( $i = $parameters['dateparameters']['yearend']; $i >= $parameters['dateparameters']['yearstart']; $i-- ) {
            $yearInput .= '<option value="' . $i . '"';
            if ( isset( $valueArray['tm_year'] ) && ( $i == ( $valueArray['tm_year'] + 1900 ) ) ) $yearInput .= ' selected="selected"';
            $yearInput .= '>' . $i . '</option>';
        }
        $yearInput .= '</select>';
        $monthInput = '<select';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            if ( $htmlParameter == 'name' ) $htmlValue .= '[month]';
            if ( $htmlParameter == 'id' ) $htmlValue .= '_month';
            $monthInput .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $monthInput .= '>';
        for ( $i = 1; $i <= 12; $i++ ) {
            $monthInput .= '<option value="' . $i . '"';
            if ( isset( $valueArray['tm_mon'] ) && ( $i == ( $valueArray['tm_mon'] + 1 ) ) ) $monthInput .= ' selected="selected"';
            $monthInput .= '>' . date( $parameters['dateparameters']['formatmonth'], mktime( 0, 0, 0, $i, 1, 2000 ) )  . '</option>';
        }
        $monthInput .= '</select>';
        $dayInput = '<select';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            if ( $htmlParameter == 'name' ) $htmlValue .= '[day]';
            if ( $htmlParameter == 'id' ) $htmlValue .= '_day';
            $dayInput .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $dayInput .= '>';
        for ( $i = 1; $i <= 31; $i++ ) {
            $dayInput .= '<option value="' . $i . '"';
            if ( isset( $valueArray['tm_mday'] ) && ( $i == $valueArray['tm_mday'] ) ) $dayInput .= ' selected="selected"';
            $dayInput .= '>' . $i  . '</option>';
        }
        $dayInput .= '</select>';

        if ( isset( $parameters['dateparameters']['showtime'] ) ) {
            $hourInput = '<select';
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                if ( $htmlParameter == 'name' ) $htmlValue .= '[hour]';
                if ( $htmlParameter == 'id' ) $htmlValue .= '_hour';
                $hourInput .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $hourInput .= '>';
            for ( $i = 0; $i <= 23; $i++ ) {
                $hourInput .= '<option value="' . $i . '"';
                if ( isset( $valueArray['tm_hour'] ) && ( $i == $valueArray['tm_hour'] ) ) $hourInput .= ' selected="selected"';
                $hourInput .= '>' . $i . '</option>';
            }
            $hourInput .= '</select>';
            $minuteInput = '<select';
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                if ( $htmlParameter == 'name' ) $htmlValue .= '[minute]';
                if ( $htmlParameter == 'id' ) $htmlValue .= '_minute';
                $minuteInput .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $minuteInput .= '>';
            for ( $i = 0; $i <= 59; $i++ ) {
                $minuteInput .= '<option value="' . $i . '"';
                if ( isset( $valueArray['tm_min'] ) && ( $i == $valueArray['tm_min'] ) ) $minuteInput .= ' selected="selected"';
                $minuteInput .= '>' . str_pad( $i, 2, '0', STR_PAD_LEFT )  . '</option>';
            }
            $minuteInput .= '</select>';
            $secondInput = '<select';
            foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                if ( $htmlParameter == 'name' ) $htmlValue .= '[second]';
                if ( $htmlParameter == 'id' ) $htmlValue .= '_second';
                $secondInput .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
            $secondInput .= '>';
            for ( $i = 0; $i <= 59; $i++ ) {
                $secondInput .= '<option value="' . $i . '"';
                if ( isset( $valueArray['tm_sec'] ) && ( $i == $valueArray['tm_sec'] ) ) $secondInput .= ' selected="selected"';
                $secondInput .= '>' . str_pad( $i, 2, '0', STR_PAD_LEFT )  . '</option>';
            }
            $secondInput .= '</select>';
        } else {
            $hourInput = '';
            $minuteInput = '';
            $secondInput = '';
        }
        $search = array( '<YEAR>', '<MONTH>', '<DAY>', '<HOUR>', '<MINUTE>', '<SECOND>' );
        $replace = array( $yearInput, $monthInput, $dayInput, $hourInput, $minuteInput, $secondInput );
        $return['input'] = str_replace( $search, $replace, $parameters['dateparameters']['displayorder'] );
        return $return;
    }

    /**
     * Generate valid HTML input color picker tag, requires jQuery and Farbtastic JS/CSS
     * to be referenced in your HTML header ( ensure Farbtastic files are all in the same folder, i.e. JS, CSS and images )
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function colour( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'maxlength', 'readonly', 'size', 'value' );
        $javascriptParameters = array( 'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, array_merge( $additionalAllowedParameters, $javascriptParameters ) );
        $return['name'] = $parameters['html']['name'];
        if ( !isset( $parameters['html']['value'] ) ) $parameters['html']['value'] = '#ffffff';
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        if ( isset( $this->farbtastic ) ) {
            if ( $this->farbtastic ) $this->javascript .= '<script type="text/javascript" src="' . $this->farbtastic . '"></script>';
        } else {
            $this->javascript .= '<script type="text/javascript" src="' . $this->classUrl . 'class-forms-includes/farbtastic.js"></script>';
        }
        $return['input'] = '<input type="text"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $id = $parameters['html']['id'] . '_colourpicker';
        $allowTriggers = array( 'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        if ( isset( $parameters['dropdown']['trigger'] ) ) {
            if ( !is_array( $parameters['dropdown']['trigger'] ) ) $parameters['dropdown']['trigger'][] = $parameters['dropdown']['trigger'];
            foreach ( $parameters['dropdown']['trigger'] as $dropDownTrigger ) {
                if ( !in_array( $dropDownTrigger, $allowTriggers ) ) {
                    $return['input'] .= ' onfocus="showPicker( \'' . $id . '\' );"';
                    break;
                }
                $return['input'] .= ' ' . $dropDownTrigger . '="showPicker( \'' . $id . '\' );"';
            }
        } else {
            $return['input'] .= ' onfocus="showPicker( \'' . $id . '\' );"';
        }
        $return['input'] .= '/>';
        $return['input'] .= '<div id="' . $id . '"';
        if ( isset( $parameters['dropdown'] ) && $parameters['dropdown'] ) {
            if ( isset( $parameters['dropdown']['html'] ) ) {
                $dropDownParameters = $this->cleanHtmlParameters( $parameters['dropdown'] );
                foreach ( $dropDownParameters['html'] as $htmlParameter => $htmlValue ) {
                    $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                }
            }
            if ( isset( $parameters['dropdown']['out'] ) ) {
                if ( !is_array( $parameters['dropdown']['out'] ) ) $parameters['dropdown']['out'][] = $parameters['dropdown']['out'];
                $return['input'] .= ' style="display:none;position:absolute;z-index:1000;"';
                foreach ( $parameters['dropdown']['out'] as $colorOutTrigger ) {
                    if ( !in_array( $colorOutTrigger, $allowTriggers ) ) {
                        $return['input'] .= ' style="display:none;position:absolute;z-index:1000;" onmouseup="hidePicker( \'' . $id . '\' );"';
                        break;
                    }
                    $return['input'] .= ' ' . $colorOutTrigger . '="hidePicker( \'' . $id . '\' );"';
                }
            } else {
                $return['input'] .= ' style="display:none;position:absolute;z-index:1000;" onmouseup="hidePicker( \'' . $id . '\' );"';
            }
        }
        $return['input'] .= '></div>';
        if ( isset( $parameters['dropdown']['callback'] ) ) $callBack = $parameters['dropdown']['callback']; else $callBack = '';
        $return['input'] .= '
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready( function() {
    jQuery(\'#' . $id . '\').farbtastic(' . ( !empty( $callBack ) ? 'function(colour){jQuery(\'#' . $parameters['html']['id'] . '\').val(colour); ' . $callBack . '}' : '\'#' . $parameters['html']['id'] . '\'' ) . ');
    
} );';
        if ( !isset( $this->farbtastic ) ) $this->farbtastic = true;
        if ( $this->farbtastic ) {
            $return['input'] .= '
function showPicker( id ) {
    jQuery( \'#\' + id ).css( \'display\', \'block\' );
}
function hidePicker( id ) {
    jQuery( \'#\' + id ).css( \'display\', \'none\' );
}';
            $this->farbtastic = false;
        }
        $return['input'] .= '
/* ]]> */
</script>
';
        return $return;
    }

    /**
     * Generate valid HTML input slider, requires jQuery and jQuery UI
     * to be referenced in your HTML header
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function slider( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'value',
                                              'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
            
        if ( isset( $parameters['display']['type'] ) ) {
            $type = $parameters['display']['type'];
        } else {
            $type = '';
        }
        
        if ( isset( $parameters['html']['value'] ) )
            $parameters['slider']['parameters']['value'] = $parameters['html']['value'];
        else if ( isset( $parameters['slider']['parameters']['value'] ) )
            $parameters['html']['value'] = $parameters['slider']['parameters']['value'];
        else {
            $parameters['html']['value'] = 0;
            $parameters['slider']['parameters']['value'] = 0;
        }

        switch ( $type ) {
            case 'text':
                if ( isset( $parameters['display']['parameters'] ) ) {
                    $inputBoxParameters = '';
                    if ( isset( $parameters['display']['parameters']['html'] ) ) {
                        foreach ( $parameters['display']['parameters']['html'] as $key => $value ) {
                            if ( !empty( $inputBoxParameters ) ) $inputBoxParameters .= ' ';
                            $inputBoxParameters .= $key . '="' . $value . '"';
                        }
                    }
                    if ( isset( $parameters['display']['parameters']['display'] ) ) {
                        switch ( $parameters['display']['parameters']['display'] ) {
                            case 'div':
                                $inputBox = '<div id="' . $parameters['html']['id'] . '_text" ' . $inputBoxParameters . '>' . $parameters['html']['value'] . '</div>';
                                break;
                            default:
                                $inputBox = '<span id="' . $parameters['html']['id'] . '_text" ' . $inputBoxParameters . '>' . $parameters['html']['value'] . '</span>';
                        }
                    } else {
                        $inputBox = '<span id="' . $parameters['html']['id'] . '_text" ' . $inputBoxParameters . '>' . $parameters['html']['value'] . '</span>';
                    }
                    $inputBox .= '<input type="hidden"';
                } else {
                    $inputBox = '<span id="' . $parameters['html']['id'] . '_text" class="slider_text">' . $parameters['html']['value'] . '</span><input type="hidden"';
                }
                break;
            case 'input':
                $inputBox = '<input type="text"';
                break;
            default:
                $inputBox = '<input type="hidden"';
        }
        
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $inputBox .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $inputBox .= '/>';
        
        
        $inputSlider = '<div id="' . $parameters['html']['id'] . '_slider"';
        if ( count( $parameters['slider']['html'] ) > 0 ) {
            foreach ( $parameters['slider']['html'] as $htmlParameter => $htmlValue ) {
                $inputSlider .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
            }
        }
        $inputSlider .= '></div>';
        
        if ( isset( $parameters['display']['position'] ) ) $position = $parameters['display']['position']; else $position = '';

        switch ( $position ) {
            case 'before':
                $return['input'] = $inputBox . $inputSlider;
                break;
            default:
                $return['input'] = $inputSlider . $inputBox;
        }

        $return['input'] .= '
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function(){
    jQuery(\'#' . $parameters['html']['id'] . '_slider\').slider(';
        if ( count( $parameters['slider']['parameters'] ) > 0 ) {
            $return['input'] .= '{';
            $sliderParameters = '';
            if ( isset( $parameters['slider']['parameters']['onslide'] ) ) $onSlide = $parameters['slider']['parameters']['onslide']; else $onSlide = '';
            unset( $parameters['slider']['parameters']['onslide'] );
            foreach ( $parameters['slider']['parameters'] as $key => $value ) {
                if ( $sliderParameters != '' ) $sliderParameters .= ',';
                $sliderParameters .= '
        ' . $key . ': ' . $value;
            }
            $return['input'] .= $sliderParameters . ',';
            if ( $type == 'text' ) {
                $return['input'] .= '
        slide: function(ev, ui) {
            jQuery(\'#' . $parameters['html']['id'] . '_text\').html(ui.value);
            jQuery(\'#' . $parameters['html']['id'] . '\').val(ui.value);
            ' . $onSlide . '
        }';
            } else {
                $return['input'] .= '
        slide: function(ev, ui) {
            jQuery(\'#' . $parameters['html']['id'] . '\').val(ui.value);
            ' . $onSlide . '
        }';
            }
            $return['input'] .= '
    }';
        }
        $return['input'] .= ');
} );
/* ]]> */
</script>
';
        return $return;
    }

    /**
     * Generate content
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param mixed $parameters
     * @return string
     */
    function content( $parameters = '' )
    {
        $return['name'] = $parameters['html']['name'];
        $return['input'] = $parameters['content'];
        return $return;
    }

    /**
     * Generate fieldset
     *
     * @author Steven Raynham
     * @since 2.1.5
     *
     * @param mixed $parameters
     * @return string
     */
    function fieldset( $parameters = '' )
    {
        $return['input'] = '<fieldset';
        $additionalAllowedParameters = array( 'name', 'legend', 'fields',
                                              'onclick', 'ondblclick', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        unset( $parameters['html']['name'] );
        if ( isset( $parameters['legend'] ) ) $legend = $this->legend( $parameters['legend'] );
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '>';
        if ( isset( $legend ) ) $return['input'] .= $legend;
        return $return;
    }

    /**
     * Generate legend
     *
     * @author Steven Raynham
     * @since 2.1.5
     *
     * @param mixed $parameters
     * @return string
     */
    function legend( $parameters = '' )
    {
        if ( isset( $parameters['value'] ) ) {
            $return = '<legend';
            if ( is_array( $parameters ) ) {
                $additionalAllowedParameters = array( 'onclick', 'ondblclick', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup' );
                $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
                foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
                    $return .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
                }
                $return .= '>' . $parameters['value'] . '</legend>';
            } else {
                $return .= '>' . $parameters . '</legend>';
            }
        } else {
            $return = '';
        }
        return $return;
    }

    /**
     * Generate valid HTML input submit tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function submit( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'size', 'value',
                                              'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="submit"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Generate valid HTML input reset tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function reset( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'size', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="reset"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Generate valid HTML input button tag
     *
     * @author Steven Raynham
     * @since 2.7.3
     *
     * @param array $parameters
     * @return string
     */
    function button( $parameters = '' )
    {
        $additionalAllowedParameters = array( 'name', 'disabled', 'size', 'value',
                                             'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress', 'onkeyup', 'onselect' );
        $parameters = $this->cleanHtmlParameters( $parameters, $additionalAllowedParameters );
        $return['name'] = $parameters['html']['name'];
        if ( isset( $parameters['label'] ) ) $return['label'] = $this->label( $parameters['html']['id'], $parameters['label'] );
        $return['input'] = '<input type="button"';
        foreach ( $parameters['html'] as $htmlParameter => $htmlValue ) {
            $return['input'] .= ' ' . $htmlParameter . '="' . $htmlValue . '"';
        }
        $return['input'] .= '/>';
        return $return;
    }

    /**
     * Clean HTML tag parameters, based on W3C standards
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param array $parameters
     * @param array $additionalAllowedParameters
     * @return array
     */
    function cleanHtmlParameters( $parameters = '', $additionalAllowedParameters = '' )
    {
        $return = $parameters;
        unset( $return['html'] );
        $allowedParameters = array( 'accesskey', 'class', 'dir', 'id', 'lang', 'style', 'title', 'xml:lang' );
        if ( is_array( $additionalAllowedParameters ) ) $allowedParameters = array_merge( $allowedParameters, $additionalAllowedParameters );
        if ( isset ( $parameters['html'] ) ) {
            if ( count( $parameters['html'] ) > 0 ) {
                foreach ( $parameters['html'] as $parameter => $value ) {
                    if ( in_array( $parameter, $allowedParameters ) ) $return['html'][$parameter] = $value;
                }
                ksort( $return['html'] );
            }
        }
        return $return;
    }

    /**
     * Generate input field name if one does not exist
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param void
     * @return string
     */
    function generateName( $name = '' )
    {
        if ( strpos( $name, '[]' ) ) {
            // this only works on one occurrance of [] in the field name, should work on multiple occurrances at their correct heirarchy in the array
            $name = str_replace( '[]', '', $name );
            if ( array_key_exists( $name, $this->fieldNameArray ) ) {
                $this->fieldNameArray[$name]++;
                $name .= '[' . $this->fieldNameArray[$name] . ']';
            } else {
                $this->fieldNameArray[$name] = 0;
                $name .= '[0]';
            }
            $return = $name;
        } else {
            if ( $name == '' ) {
                $return = $this->defaultFieldName . $this->nameNumber;
                $this->nameNumber++;
            } else {
                $return = $name;
            }
            while ( @in_array( $return, $this->nameArray ) ) {
                $return .= $this->nameNumber;
                $this->nameNumber++;
            }
            $this->nameArray[] = $return;
        }
        return $return;
    }

    /**
     * Generate input field id if one does not exist
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param string $id
     * @return string
     */
    function generateId( $id = '' )
    {
        if ( $id == '' ) {
            $return = $this->defaultFieldName . $this->idNumber;
            $this->idNumber++;
        } else {
            $return = $id;
        }
        $search = array( '[]',
                        '[',
                        ']',
                        ' ' );
        $replace = '_';
        $return = str_replace( $search, $replace, $return );
        $return = trim( $return, '_' );
        while ( @in_array( $return, $this->idArray ) ) {
            $return .= $this->idNumber;
            $this->idNumber++;
        }
        $this->idArray[] = $return;
        return $return;
    }

    /**
     * Cleans tag ids
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param string $id
     * @return string
     */
    function cleanId( $id )
    {
        $search = array( ' ' );
        $replace = array( '_' );
        $return = str_replace( $search, $replace, $id );
        return $return;
    }

    /**
     * Validates the passed value
     *
     * @author Steven Raynham
     * @since 2.6.10
     *
     * @param array $parameters
     * @param string $name
     * @return bool
     */
    function isValid( $parameters, $name )
    {
        $return = false;
        if ( isset( $parameters['request'][$name] ) ) {
            if ( is_array( $parameters['request'][$name] ) ) $requestArray =  $parameters['request'][$name]; else $requestArray[0] =  $parameters['request'][$name];
            unset( $parameters['request'][$name] );
        } else {
            $requestArray[0] = '';
        }
        if ( isset( $parameters['required'] ) ) {
            $required = $parameters['required'];
            unset( $parameters['required'] );
        } else {
            $required = false;
        }
        if ( !array_key_exists( 0, $parameters ) ) $validateParameters[0] = &$parameters; else $validateParameters = &$parameters;
        foreach ( $validateParameters as $parameter ) {
            if ( isset( $parameter['type'] ) ) $type = $parameter['type']; else $type = 'string';
            if ( isset( $parameter['field'] ) ) $field = $parameter['field'];
            if ( isset( $parameter['fieldvalue'] ) ) $fieldValue = $parameter['fieldvalue']; else $fieldValue = '';
            if ( isset( $type ) && isset( $requestArray ) ) {
                foreach ( $requestArray as $request ) {
                    if ( $required || ( !empty( $request ) && !$required ) ) {
                        if ( isset( $field ) ) {
                            $requestName = $this->convertFormFieldName( $field );
                            eval
                            (
                           'if ( isset( $_REQUEST' . $requestName .' ) && ( $_REQUEST' . $requestName .' == \'' . $fieldValue . '\' ) ) {
                                $runValidation = true;
                            } else {
                                $runValidation = false;
                                $return = true;
                            }'
                            );
                        } else {
                            $runValidation = true;
                        }
                        if ( $runValidation ) {
                            switch ( $type ) {
                                case 'regexp':
                                    if ( isset( $parameter['pattern'] ) ) $return = preg_match( $parameter['pattern'], $request );
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Incorrect entry';
                                    break;
                                case 'integer':
                                    $return = $this->is_integer( $request );
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Integer number required';
                                    break;
                                case 'number':
                                case 'float':
                                    $return = $this->is_floating( $request );
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Decimal number required';
                                    break;
                                case 'integerrange':
                                    if ( isset( $parameter['start'] ) ) $start = $parameter['start'];
                                    if ( isset( $parameter['end'] ) ) $end = $parameter['end'];
                                    if ( isset( $start ) && isset( $end ) && $this->is_integer( $request ) ) {
                                        if ( ( $this->is_integer( $start ) && $this->is_integer( $end ) ) && ( ( $request >= $start ) && ( $request <= $end ) ) ) $return = true;
                                    }
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Integer out of range';
                                    break;
                                case 'numberrange':
                                    if ( isset( $parameter['start'] ) ) $start = $parameter['start'];
                                    if ( isset( $parameter['end'] ) ) $end = $parameter['end'];
                                    if ( isset( $start ) && isset( $end ) ) {
                                        if ( ( is_numeric( $start ) && is_numeric( $end ) ) && ( ( $request >= $start ) && ( $request <= $end ) ) ) $return = true;
                                    }
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Number out of range';
                                    break;
                                case 'date':
                                    $return = strtotime( $request ) ? true : false;
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Date required';
                                    break;
                                case 'daterange':
                                    if ( isset( $parameter['start'] ) ) $start = strtotime( $parameter['start'] );
                                    if ( isset( $parameter['end'] ) ) $end = strtotime( $parameter['end'] );
                                    if ( isset( $start ) && isset( $end ) ) {
                                        $request = strtotime( $request );
                                        if ( ( $start && $end && $request ) && ( ( $request >= $start ) && ( $request <= $end ) ) ) $return = true;
                                    }
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Date out of range';
                                    break;
                                case 'email':
                                    $return = $this->validateEmail( $request, 'email' );
                                    /*$regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
                                    if ( eregi( $regexp, $request ) ) {
                                        list( $username, $domaintld ) = split( "@", $request );
                                        if ( getmxrr( $domaintld, $mxrecords ) ) {
                                            $return = true;
                                        } else {
                                            $url = 'http://' . trim( $domaintld );
                                            $file = @fopen( $url, "r" );
                                            if ( $file ) $return = true; else $return = false;
                                        }
                                    } else {
                                        $return = false;
                                    }*/
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Invalid email address';
                                    break;
                                case 'emailmx':
                                    $return = $this->validateEmail( $request, 'emailmx' );
                                    /*$regExp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
                                    if ( eregi( $regExp, $request ) ) {
                                        list( $userName, $domainTld ) = split( "@", $request );
                                        if ( getmxrr( $domainTld, $mxRecords ) ) $return = true; $return = false;
                                    } else {
                                        $return = false;
                                    }*/
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Invalid email address';
                                    break;
                                case 'emailre':
                                    $return = $this->validateEmail( $request, 'emailre' );
                                    /*$regExp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
                                    if ( eregi( $regExp, $request ) ) $return = true; else $return = false;
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Invalid email address';*/
                                    break;
                                case 'url':
                                    if ( substr( trim( $request ),0,4 ) != 'http' ) $request = 'http://'.trim( $request );
                                    if ( strlen( $request ) ) {
                                        if ( $this->validateUrl( $request ) ) $return = true; else $return = false;
                                    } else {
                                        $return = false;
                                    }
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Invalid URL';
                                    break;
                                case 'hexcolour':
                                    $request = trim( $request,'#' );
                                    if ( ( strlen( $request ) == 6 ) || ( strlen( $request ) == 3 ) ) {
                                       if ( preg_match( "/^[A-F0-9]+$/i", $request ) === false ) $return = false; else $return = true;
                                    } else {
                                        $return = false;
                                    }
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Invalid hex colour code';
                                    break;
                                case 'question':
                                    $request = trim( strtolower( $request ) );
                                    if ( isset( $parameter['answer'] ) ) {
                                        if ( is_array( $parameter['answer'] ) ) $answerArray = $parameter['answer']; else $answerArray[] = $parameter['answer'];
                                        foreach ( $answerArray as $answer ) {
                                            $answer = trim( strtolower( $answer ) );
                                            if ( ( $request != $answer ) && ( $return !== true ) ) $return = false; else $return = true;
                                        }
                                    } else {
                                        if ( $request == '' ) $return = true; else $return = false;
                                    }
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Incorrect answer';
                                    break;
                                case 'datedropdown';
                                        if ( isset ( $request ) && !empty( $request ) ) $day = (int) $request;
                                        if ( isset ( $parameter['month'] ) && !empty( $parameter['month'] ) ) $month = (int) $parameter['month'];
                                        if ( isset ( $parameter['year'] ) && !empty( $parameter['year'] ) ) $year = (int) $parameter['year'];
                                        if ( isset ( $day ) && isset ( $month ) && isset ( $year ) )
                                            if ( checkdate( $month, $day, $year ) !== true ) $return = false; else $return = true;
                                        break;
                                default:
                                    if ( $required && ( trim( $request ) == '' ) ) $return = false; else $return = is_string( $request );
                                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'String required';
                            }
                        }
                    } else {
                        $return = true;
                    }
                }
                if ( !$return ) $return = $parameter['error'];
            }
            if ( isset( $parameter['maxlength'] ) ) {
                if ( strlen( $request ) > (int)$parameter['maxlength'] ) {
                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Incorrect length';
                    $return = $parameter['error'];
                }
            }
            if ( isset( $parameter['minlength'] ) ) {
                if ( strlen( $request ) < (int)$parameter['minlength'] ) {
                    if ( !isset( $parameter['error'] ) ) $parameter['error'] = 'Incorrect length';
                    $return = $parameter['error'];
                }
            }
            if ( $return !== true ) break;
        }
//echo '<pre>' . print_r($name, true) . '</pre>';
//echo '<pre>' . print_r($type, true) . '</pre>';
//echo '<pre>' . print_r($request, true) . '</pre>';
//echo '<pre>';
//var_dump($return);
//echo '</pre>';
        return $return;
    }
    
    /**
     * Validate email address
     *
     * @author Steven Raynham
     * @since 2.6.10
     *
     * @param void
     * @return null
     */
    function validateEmail( $email, $type = 'email' )
    {
        $regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
        if ( eregi( $regexp, $email ) ) {
            if ( $type == 'emailre' ) $return = true;
            else {
                list( $username, $domaintld ) = split( "@", $email );
                if ( getmxrr( $domaintld, $mxrecords ) ) $return = true;
                else if ( $type == 'email' ) {
                    $url = 'http://' . trim( $domaintld );
                    $return = $this->validateUrl( $url );
                } else {
                    $return = false;
                }
            }
        } else {
            $return = false;
        }
        return $return;
    }
    
    /**
     * Validate url
     *
     * @author Steven Raynham
     * @since 2.6.10
     *
     * @param void
     * @return null
     */
    function validateUrl( $url )
    {
        if ( ( $file = @get_meta_tags( $url ) ) !== false )
            $return = true;
        else
            $return = false;
        return $return;
    }
    
    /**
     * Clear the form fields
     *
     * @author Steven Raynham
     * @since 2.7.4
     *
     * @param void
     * @return null
     */
    function clearFields()
    {
        unset( $this->fields );
        $this->nameArray = array();
        $this->nameNumber = 0;
        $this->idArray = array();
        $this->idNumber = 0;
        $this->fieldNameArray = array();
        $this->posted = false;
        $this->addInitField();
    }
    
    /**
     * Resets the posted true request
     *
     * @author Steven Raynham
     * @since 2.7.4
     *
     * @param void
     * @return null
     */
    function freshRequest()
    {
        unset( $_REQUEST['islform'] );
    }

    /**
     * Convert form field name to php array
     *
     * @author Steven Raynham
     * @since 2.1.3
     *
     * @param string $value
     * @return bool
     */
    function is_integer( $value = '' )
    {
        $value = trim( $value );
        if ( $value != '' ) {
            $int = (string)(int)$value;
            return ( $int === $value );
        } else {
            return false;
        }
    }

    /**
     * Convert form field name to php array
     *
     * @author Steven Raynham
     * @since 2.1.3
     *
     * @param string $value
     * @return bool
     */
    function is_floating( $value = '' )
    {
        $value = ($value == 0 ? $value : trim( $value, "0." ));
        if ( $value != '') {
            $float = (string)(float)$value;
            if ( $float === $value ) return true; return false;
        } else {
            return false;
        }
    }

    /**
     * Convert form field name to php array
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $requestName
     * @return mixed
     */
    function convertFormFieldName( $requestName )
    {
        $requestName = preg_replace( "/\[{0,1}([\w\d_-]+)\]{0,1}/i", "['$1']", $requestName );
        return $requestName;
    }


    /**
     * Return request value
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $requestName
     * @return mixed
     */
    function requestValue( $requestName )
    {
        $requestName = $this->convertFormFieldName( $requestName );
//echo '<pre>$return = isset( $_REQUEST' . $requestName . ' ) ? $_REQUEST' . $requestName . ' : false;</pre>';
        eval( '$return = isset( $_REQUEST' . $requestName . ' ) ? $_REQUEST' . $requestName . ' : false;' );
        return $return;
    }

    /**
     * Return request
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $requestName
     * @param string $requestValue
     * @return mixed
     */
    function requestNameValue( $requestName, $requestValue )
    {
        $requestName = $this->convertFormFieldName( $requestName );
//echo '<pre>$this->request' . $requestName . ' = $requestValue;</pre>';
        eval( '$this->request' . $requestName . ' = $requestValue;' );
    }

    /**
     * Return request
     *
     * @author Steven Raynham
     * @since 2.6.7
     *
     * @param string $requestName
     * @param string $requestValue
     * @return mixed
     */
    function sessionNameValue( $requestName, $requestValue )
    {
        if ( !empty( $requestName ) ) {
            $requestName = $this->convertFormFieldName( $requestName );
            eval( '$_SESSION[\'' . $this->session . '\']' . $requestName . ' = $requestValue;' );
        }
    }

    /**
     * Substring function for filtering request
     *
     * @author Steven Raynham
     * @since 2.0
     *
     * @param int $start
     * @param int $length
     * @param string $string
     * @return string
     */
    function substring( $start = 0, $length, $string = '' )
    {
        $return = substr( $string, $start, $length );
        return $return;
    }

    /**
     * Date format function for filtering request
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $format
     * @param string $string
     * @return string
     */
    function dateformat( $format = 'Y-m-d', $string = '' )
    {
        $return = $string;
        if ( $date = strtotime( $string ) ) {
            $return = date( $format, $date );
        }
        return $return;
    }

    /**
     * Hex colour function for filtering request
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $string
     * @return string
     */
    function hexcolour( $string = '' )
    {
        $return = $string;
        $string = trim( $string,'#' );
        if ( ( strlen( $string ) == 6 ) || ( strlen( $string ) == 3 ) ) {
            if ( preg_match( "/^[A-F0-9]+$/i", $string ) ) {
                $return = '#' . $string;
            }
        }
        return $return;
    }

    /**
     * HTMLPurifier function for filtering request
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $string
     * @return string
     */
    function htmlpurify( $string = '' )
    {
        require_once( $this->classPath . '/class-forms-includes/HTMLPurifier.auto.php' );
        $purifier = new HTMLPurifier();
        $return = $purifier->purify( $string );
        return $return;
    }

    /**
     * HTML line breaks to text line breaks for filtering request
     *
     * @author Steven Raynham
     * @since 2.1
     *
     * @param string $string
     * @return string
     */
    function br2nl( $string = '' )
    {
        $return = str_replace( array( '<br/>', '<br />', '<br>' ), "\n", $string );
        return $return;
    }
    
    /**
     * Adds http to url for filtering request
     *
     * @author Steven Raynham
     * @since 2.2
     *
     * @param string $string
     * @return string
     */
    function addhttp( $string = '' )
    {
        if ( !empty( $string ) ) {
            if ( substr( trim( $string ), 0, 7 ) != 'http://' ) $string = 'http://'.trim( $string );
        }
        return $string;
    }
}
