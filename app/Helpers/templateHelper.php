<?php

/**
 * helper class for templates
 */
class templateHelper
{
    /**
     * get advert by type
     * @param string $type
     * @return mixed
     */
    public static function getAdvert($type)
    {
        return \App\Models\Advert::getByType($type);
    }

    /**
     * get menu items nested style
     * @param mixed $position menu position
     * @return array
     */
    public static function getMenu($position)
    {
        return \App\Models\Menu::getTree($position);
    }

    /**
     * get template settings
     *
     * @return array
     */
    public static function getTemplateSettings()
    {
        $template = config('app.template');
        $settings = [];
        $settings = @include resource_path(
            'views/templates/' . $template . '/' . $template . '.php'
        );
        return $settings;
    }

    /** get meta data
     * @param string $name
     *
     * return string
     */
    public static function getMeta($name)
    {
        return \App\Models\Meta::getByName($name);
    }

    /**
     * retieve seo data
     * @param mixed $route
     * @return mixed
     */
    public static function getSeo($route, $page_id = null)
    {
        return \App\Models\Seo::getRoute($route, $page_id);
    }
}
