<?php
/**
 * MudEye plugin for Craft CMS
 *
 * MudEye Service
 *
 * --snip--
 * All of your plugin’s business logic should go in services, including saving data, retrieving data, etc. They
 * provide APIs that your controllers, template variables, and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 * --snip--
 *
 * @author    @cole007
 * @copyright Copyright (c) 2017 @cole007
 * @link      http://ournameismud.co.uk/
 * @package   MudEye
 * @since     1.0.0
 */

namespace Craft;

class MudEyeService extends BaseApplicationComponent
{
    /**
     * This function can literally be anything you want, and you can have as many service functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     craft()->mudEye->exampleService()
     */
    public function getTags($options, $title = '')
    {
    	$settings = craft()->plugins->getPlugin('mudEye')->getSettings();
         
        $html = "";
        $html .= "<!-- MudEye SEO: start -->\r\n";

        // $title = "";
        $desc = "";
        $url = "";
        
        // build out title
        if (is_array($options) && array_key_exists('title',$options)) {
            if (gettype($options['title']) == 'array') $title = implode(' | ', $options['title']);
            else $title = $options['title'];
        } elseif (is_array($options) && array_key_exists('entry',$options) && $options['entry'] !== null) {
            $element = $options['entry'];
            // Craft::dd($element);
            if ($element->seo['seoTitle'] && strlen(trim($element->seo['seoTitle'])) > 0) $title = $element->seo['seoTitle'];
            else $title = $element->title;
        } elseif (strlen($title) > 0) {
            $title = $title;
        } 
        $html .= "<title>";
        $html .= strlen($title) > 0 ? $title . ' | ' : '';
        $html .= craft()->getSiteName() . "</title>\r\n";
                  
        // build out description
        if (is_array($options) && array_key_exists('desc',$options)) $desc = $options['desc'];
        elseif (is_array($options) && array_key_exists('entry',$options) && $options['entry'] !== null) {
            $element = $options['entry'];
            if ($element->seo['seoDesc'] && strlen(trim($element->seo['seoDesc'])) > 0) $desc = $element->seo['seoDesc'];
            else $desc = $settings['seoDesc'];
        }

        $html .= "<meta name=\"description\" content=\"" . $desc . "\">\r\n";

        // build out canonical URL
        if (is_array($options) && array_key_exists('url',$options)) $url = $options['url'];
        elseif (is_array($options) && array_key_exists('entry',$options) && $options['entry'] !== null) {
            $element = $options['entry'];
            $url = $element->url;
        }
        $html .= "<link rel=\"canonical\" href=\"" . $url . "\" />\r\n";
                      
        // build out tracking code
        if (!craft()->config->get('devMode') && strpos(craft()->request->serverName,'mudbank.uk' === false) && strlen(trim($settings['analyticsCode'])) > 0) { 
            $code = $settings['analyticsCode'];
            $html .= "<!--Global Site Tag (gtag.js) - Google Analytics -->";
            $html .= '<script async src="https://www.googletagmanager.com/gtag/js?id='.$code.'"></script>';
            $html .= '<script>';
            $html .= 'window.dataLayer = window.dataLayer || [];';
            $html .= 'function gtag(){dataLayer.push(arguments);}';
            $html .= "gtag('js', new Date());";
            $html .= "gtag('config', '$code');";
            $html .= '</script>';
        }

        // build out robots
        if(craft()->config->get('devMode') OR (is_array($options) && array_key_exists('entry',$options) && $options['entry'] !== null && $options['entry']->getElementType() == ElementType::Entry && $options['entry']->seo['seoRobots'])) {
            $html .= "<meta name=\"robots\" content=\"noindex\">\r\n";
            $html .= "<meta name=\"googlebot\" content=\"noindex\">\r\n";
            $html .= "<!-- robots: dev mode  -->\r\n";
        }
        
        // build out social media links
        if (is_array($options) && array_key_exists('social',$options)) {
            $html .= "<meta name=\"twitter:card\" content=\"summary\" />\r\n";
            $html .= "<meta name=\"twitter:title\" content=\"" . $title . "\" />\r\n";
            $html .= "<meta name=\"twitter:description\" content=\"" . $desc . "\" />\r\n";
            $html .= "<meta name=\"og:title\" content=\"" . $title . "\" />\r\n";
            $html .= "<meta name=\"og:url\" content=\"" . $url . "\" />\r\n";
        }

        $html .= "<!-- MudEye SEO: end -->\r\n";
        return $html;       
    }

}