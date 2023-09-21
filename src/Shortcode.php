<?php declare(strict_types=1);

namespace SR;

abstract class Shortcode
{
    public string $shortcodeName;
    protected function addShortcode() : void
    {
        $shortcodeName = $this->shortcodeName;
        add_action('init', function() use ($shortcodeName)
        {
            add_shortcode($shortcodeName, [$this, 'doLogic']);
        });
    }

    public function doLogic($atts, $content) { }
}