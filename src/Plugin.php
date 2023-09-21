<?php declare(strict_types=1);

namespace SR;

class Plugin
{
    /** @var $singleton */
    private static $singleton = null;

    public function __construct()
    {
        new \SR\PostTypes\Request();
        new \SR\Shortcodes\Request();
    }
    public static function instantiate() : \SR\Plugin
    {
        if(self::$singleton === null)
        {
            self::$singleton = new self;
        }
        return self::$singleton;
    }
}