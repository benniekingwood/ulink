<?php
/** $Id: jquery.php 1941 2008-10-30 09:24:09Z francis $ */

// works fine if RequestHandler is loaded && !disabled in controller
class JqueryHelper extends AppHelper {
	var $helpers = array('Html', 'Javascript', 'Form');

    // used files for jQuery includer plugin
    var $_uses = array();

    // used scripts for jQuery document.ready handler
    var $_scripts = array();

    // autoloaded files
    //var $config = array('uses' => array('jquery', 'jquery_includer'));
	var $config = array('uses' => array('jquery-1.2.6.min'));

    // used file for jQuery includer plugin
    function uses() {
        $args = func_get_args();
        if (!empty($args)) {
            $this->_uses = am($this->_uses, $args);
        }
    }

    // add used script for jQuery document.ready handler
    function addScript() {
        $args = func_get_args();
        if (!empty($args)) {
            $this->_scripts = am($this->_scripts, $args);
        }
    }


/**
 * Executed after a view has rendered, used to include bufferred code
 * blocks.
 *
 * @access public
 */
    // observe <head> scripts and document.ready
    function afterRender() {
        $isAjax = !empty($this->params['isAjax']);

        if ($isAjax) {
            // echo JS block with includeScriptOnce
            if (!empty($this->_uses)) {
                $out = "\n";
                foreach ($this->_uses as $file) {
                    $url = $this->webroot . $this->themeWeb . JS_URL . $file . '.js';
                    $out .= "jQuery.includeScriptOnce('".$url."');\n";
                }
                $out = sprintf($this->Javascript->tags['javascriptblock'], $out);
                e($out);
            }
        } else {
            // add links to JS files to script_for_layout
            $files = array_merge($this->config['uses'], $this->_uses);
            foreach ($files as $file) {
                //$url = $this->webroot . $this->themeWeb . JS_URL . $file . '.js';
				$url = $this->webroot . JS_URL . $file . '.js';
                $out = sprintf($this->Javascript->tags['javascriptlink'], $url);
				$view =& ClassRegistry::getObject('view');
				if($view) {
					$view->addScript($out);
				}
            }
        }

        if (!empty($this->_scripts)) {
            // document.ready handler
            $out = "\n\$(document).ready(function() { \n";
            foreach ($this->_scripts as $script) {
                $out .= $script;
            }
            $out .= "\n});\n";
            $out = sprintf($this->Javascript->tags['javascriptblock'], $out);

            if ($isAjax) {
                e($out);
            } else {
				$view =& ClassRegistry::getObject('view');
				if($view) {
					$view->addScript($out);
				}
            }
        }
    }

/**
 * Ajax delete link
 *
 */
//ajax	function link($title, $href = null, $options = array(), $confirm = null, $escapeTitle = true) {
//html	function link($title, $url = null, $htmlAttributes = array(), $confirmMessage = false, $escapeTitle = true) {
	function link($title, $url = null, $htmlAttributes = array(), $confirmMessage = false, $escapeTitle = true){
		if ($url !== null) {
			$url = $this->url($url);
		} else {
			$url = $this->url($title);
			$title = $url;
			$escapeTitle = false;
		}

		if (isset($htmlAttributes['escape'])) {
			$escapeTitle = $htmlAttributes['escape'];
			unset($htmlAttributes['escape']);
		}

		if ($escapeTitle === true) {
			$title = h($title);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}

		if (!empty($htmlAttributes['confirm'])) {
			$confirmMessage = $htmlAttributes['confirm'];
			unset($htmlAttributes['confirm']);
		}
		$output = '';
		if ($confirmMessage) {

		}



		$htmlOptions = $this->_parseAttributes($htmlAttributes);
		$return = $this->Html->link($title, $url, $htmlOptions, null, $escapeTitle);
		return $return;
	}


/**
 * Autocomplete
 * @todo: implement this
 */
	function autocomplete($name, $options = array()){
		echo $this->Form->input($name, $options);
	}
}
?>