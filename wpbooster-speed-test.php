<?php
/*
Plugin Name: WP Booster Speed Test
Description: WP Booster Speed Test
Author: Digital Cube Co.,Ltd (Takayuki Miyauchi)
Domain Path: /languages
Text Domain: wpbooster-speed-test
*/


new WPBoosterDemo();

class WPBoosterDemo {

function __construct()
{
    add_action("plugins_loaded", array(&$this, "plugins_loaded"));
    add_action("wp_enqueue_scripts", array(&$this, "wp_enqueue_scripts"));
    add_shortcode("wpbooster_speed_test", array(&$this, 'shortcode'));
}

public function plugins_loaded()
{
    load_plugin_textdomain(
        'wpbooster-speed-test',
        false,
        dirname(plugin_basename(__FILE__)).'/languages'
    );
}

public function wp_enqueue_scripts()
{
    wp_enqueue_style(
        'wpbooster-speed-test',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(dirname(__FILE__).'/style.css')
    );
}

public function shortcode()
{

    wp_enqueue_script(
        'wpbooster-speed-test',
        plugins_url('speed-test.js', __FILE__),
        array('jquery'),
        filemtime(dirname(__FILE__).'/speed-test.js'),
        true
    );

    add_action("wp_footer", array(&$this, "wp_footer"));

    $div = '<div id="%s"></div>';
    $html = '<div id="wpbooster-speed-test">';
    $html .= sprintf($div, 'booster-stopped');
    $html .= sprintf($div, 'booster-running');
    $html .= '</div>';

    $html .= '<a id="speed-test-start" class="btn-fire">Booster Fire!</a>';
    $html .= '<p id="get-booster"><a href="http://ja.wpbooster.net/">Get WP Booster</a></p>';
    return $html;
}


public function wp_footer()
{
    $script = "<script type=\"text/javascript\">var plugins_url = '%s';</script>";
    printf($script, esc_html(plugins_url('', __FILE__)));
}

}

// EOF
