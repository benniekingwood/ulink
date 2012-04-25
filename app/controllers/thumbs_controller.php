<?php

class ThumbsController extends AppController {

    var $name = 'Thumbs';
    var $uses = null;
    var $helpers = array('Html', 'Form', 'Javascript', 'Ajax', 'Jquery', 'Session');
    var $layout = null;
    var $autoRender = false;

    function index() {
        //Configure::write('debug', 0);
        if (empty($this->params['url']['src'])) {
            $this->log('thumbs_controller->index() - file: ' . $this->params['url']['src'] . ', does not exist', 'debug');
            die('File does not exist');
        }
        unset($this->params['url']['url']);

        $this->params['url']['src'] = ROOT . $this->params['url']['src'];

        if (is_readable($this->params['url']['src'])) {
            uses('folder');
            App::import('Vendor', 'phpthumb', array('file' => 'phpthumb' . DS . 'phpthumb.class.php'));
            $phpThumb = new phpThumb();
            $allowedParameters = array('src', 'new', 'w', 'h', 'wp', 'hp', 'wl', 'hl', 'ws', 'hs', 'f', 'q', 'sx', 'sy', 'sw', 'sh', 'zc', 'bc', 'bg', 'bgt', 'fltr', 'xto', 'ra', 'ar', 'aoe', 'far', 'iar', 'maxb', 'down', 'phpThumbDebug', 'hash', 'md5s', 'sfn', 'dpi', 'sia', 'nocache');
            foreach ($this->params['url'] as $key => $value):
                if (in_array($key, $allowedParameters)) {
                    $phpThumb->setParameter($key, $value);
                } else {
                    $phpThumb->ErrorImage('parameter prohibited: ' . $key);
                }
            endforeach;
            $phpThumb->config_imagemagick_path = '/usr/bin/convert';
            $phpThumb->config_prefer_imagemagick = true;
            $phpThumb->config_error_die_on_error = true;
            $phpThumb->config_document_root = '';
            $phpThumb->config_temp_directory = APP . 'tmp';
            $folder = &new Folder(CACHE . 'thumbs', false);
            if ($folder !== false) {
                $folder = &new Folder(CACHE . 'thumbs', true, 0777);
            }
            $phpThumb->config_cache_directory = CACHE . 'thumbs' . DS;
            $phpThumb->config_cache_disable_warning = false;
            $cacheFilename = md5($_SERVER['REQUEST_URI']);
            $phpThumb->cache_filename = $phpThumb->config_cache_directory . $cacheFilename;

            if (!is_file($phpThumb->cache_filename)) {
                if ($phpThumb->GenerateThumbnail()) {
                    $phpThumb->RenderToFile($phpThumb->cache_filename);
                } else {
                    $this->log('thumbs_controller->index() - failure: ' . $phpThumb->error, 'debug');
                    die('Failure: ' . $phpThumb->error);
                }
            }
            $modified = filemtime($phpThumb->cache_filename);
            if (headers_sent()) {
                $phpThumb->ErrorImage('Headers already sent (' . basename(__FILE__) . ' line ' . __LINE__ . ')');
                exit;
            }
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modified) . ' GMT');
            if (@$_SERVER['HTTP_IF_MODIFIED_SINCE'] && ($modified == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) && @$_SERVER['SERVER_PROTOCOL']) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
                exit;
            } elseif (is_file($phpThumb->cache_filename)) {
                if ($cachedImage = getimagesize($phpThumb->cache_filename)) {
                    header('Content-Type: ' . $cachedImage['mime']);
                } elseif (eregi('\.ico$', $phpThumb->cache_filename)) {
                    header('Content-Type: image/x-icon');
                }
                readfile($phpThumb->cache_filename);
                exit;
            }
        } else {
            $this->log('thumbs_controller->index() - cannot read file: ' . $sourceFilename, 'debug');
            return "";
        }
    }

}

?>