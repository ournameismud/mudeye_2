<?php
/**
 * MudEye plugin for Craft CMS
 *
 * MudEye Variable
 *
 * --snip--
 * Craft allows plugins to provide their own template variables, accessible from the {{ craft }} global variable
 * (e.g. {{ craft.pluginName }}).
 *
 * https://craftcms.com/docs/plugins/variables
 * --snip--
 *
 * @author    @cole007
 * @copyright Copyright (c) 2017 @cole007
 * @link      http://ournameismud.co.uk/
 * @package   MudEye
 * @since     1.0.0
 */

namespace Craft;

class MudEyeVariable
{
    public $settings;

    public function tags($opts = null, $title = null)
    {
        $settings = craft()->plugins->getPlugin('mudEye')->getSettings();
        $element = craft()->urlManager->getMatchedElement();
        if ($element && $element->getElementType() == ElementType::Entry) {
            // $opts['entry'] = $element;
            // Craft::dd($opts);
            $result = craft()->mudEye->getTags(array('entry'=>$element), null);
        } else {
            $result = craft()->mudEye->getTags($opts, $title);
        }
        return TemplateHelper::getRaw($result);
        
    }
    public function trackingCode()   
    {
        $output = array();
        $settings = craft()->plugins->getPlugin('mudEye')->getSettings();
        $code = $settings['trackingCode'];
        $output['head'] = TemplateHelper::getRaw("<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','".$code."');</script>
<!-- End Google Tag Manager -->");
        $output['body'] = TemplateHelper::getRaw('<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$code.'"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->');
        return $output;
    }
}