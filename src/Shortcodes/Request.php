<?php declare(strict_types=1);

namespace SR\Shortcodes;

use SR\Shortcode;

class Request extends Shortcode
{
    public string $shortcodeName;
    public function __construct()
    {
        $this->shortcodeName = 'sr_request';
        $this->addShortcode();
    }

    public function doLogic($atts, $content)
    {
        ob_start();
        $atts = shortcode_atts(
        array(
            'id' => '',
            'field' => '',
        ), $atts, $this->shortcodeName );
        $url = get_post_meta( $atts['id'], 'request_url', true );
        $method = get_post_meta( $atts['id'], 'method', true );
        $res= wp_remote_request( $url, ['method' => $method] );
        if(!$res instanceof \WP_Error && is_array($res))
        {
            $responseArray = json_decode($res['body'], true);
            // TODO: support for multiple fields?
            echo($responseArray[$atts['field']]);
        }
        return ob_get_clean();
    }
}