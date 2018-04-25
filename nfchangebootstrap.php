<?php
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;

/**
 * Class plgSystemNfchangebootstrap
 *
 * This Joomla! Plugin helps to quickly remove the default Bootstrap 2 JS/CSS.
 * On the other hand, it directly adds Bootstrap 4 CSS and JS files from CDN.
 *
 * @author Alex Schmid <schmid@netfant.ch>
 * @version 1.0.0
 * @since 1.0.0
 */
class plgSystemNfchangebootstrap extends CMSPlugin
{
    public function onBeforeCompileHead()
    {
        // Application Object
        try {
            $app = Factory::getApplication();
        } catch (Exception $e) {
        }

        // Front only
        if( $app instanceof SiteApplication )
        {
            $doc = Factory::getDocument();
            //$headData = $doc->getHeadData();
            $scripts = $doc->_scripts;
            $styleSheets = $doc->_styleSheets;
            // Remove Bootstrap 2
            unset($styleSheets[Uri::root(true).'/media/jui/css/bootstrap.min.css']);
            unset($styleSheets[Uri::root(true).'/media/jui/css/bootstrap-responsive.min.css']);
            foreach ($scripts as $key => $value) {
                if(substr($key, 0, strlen(Uri::root(true).'/media/jui/js/bootstrap.min.js'))
                    === Uri::root(true).'/media/jui/js/bootstrap.min.js') {
                    unset($scripts[$key]);
                }
            }
            $doc->_scripts = $scripts;
            $doc->_styleSheets = $styleSheets;
            // Add bootstrap 4
            $doc->addStyleSheet('https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css', [], []);
            $doc->addScript('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js');
            $doc->addScript('https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js');
        }
    }
}
