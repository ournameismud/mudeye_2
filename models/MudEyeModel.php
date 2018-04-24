<?php
/**
 * MudEye plugin for Craft CMS
 *
 * MudEye Model
 *
 * --snip--
 * Models are containers for data. Just about every time information is passed between services, controllers, and
 * templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 * --snip--
 *
 * @author    @cole007
 * @copyright Copyright (c) 2017 @cole007
 * @link      http://ournameismud.co.uk/
 * @package   MudEye
 * @since     1.0.0
 */

namespace Craft;

class MudEyeModel extends BaseModel
{
    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'seoTitle'     => array(AttributeType::String),
            'seoDesc'     => array(AttributeType::Mixed),
            'seoRobots'     => array(AttributeType::Mixed),
        ));
    }

}