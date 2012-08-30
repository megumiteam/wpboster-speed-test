<?php
/*
Plugin Name: WP Booster Speed Test
Description: You can compare the display speed of images between your server and WP Booster.
Author: Digital Cube Co.,Ltd (Takayuki Miyauchi)
Version: 1.4.0
Author URI: http://wpbooster.net/
Domain Path: /languages
Text Domain: wpbooster-speed-test
*/


new WPBoosterDemo();

class WPBoosterDemo {

function __construct()
{
    add_action("plugins_loaded", array(&$this, "plugins_loaded"));
    add_action("wp_enqueue_scripts", array(&$this, "enqueue_style"));
    add_shortcode("wpbooster_speed_test", array(&$this, 'shortcode'));
    add_filter('plugin_row_meta',   array(&$this, 'plugin_row_meta'), 10, 2);
    add_action("admin_menu", array(&$this, "admin_menu"));
}


public function admin_menu()
{
    $hook = add_menu_page(
        "Speed Test",
        "Speed Test",
        "update_core",
        "wpbooster-speed-test",
        array(&$this, "admin_panel"),
        plugins_url('img/icon.png', __FILE__),
        9999
    );
    add_action('admin_print_styles-'.$hook, array(&$this, 'enqueue_style'));
}


public function admin_panel()
{
    $html = $this->shortcode();
    echo '<div class="wrap" id="speed-test-admin">';
    echo '<h2>'.__("WP Booster Speed Test", "wpbooster-speed-test").'</h2>';
    echo '<p>'.__('You can compare the display speed of images between your server and <a href="http://wpbooster.net/">WP Booster</a>.', 'wpbooster-speed-test').'</p>';
    echo '<p>'.__('Please copy &amp; paste shortcode in the editor like below, if you want to display speed test on your post.', 'wpbooster-speed-test').'</p>';
    echo '<pre>[wpbooster_speed_test]</pre>';
    echo $html;
    echo '</div>';
}

public function plugins_loaded()
{
    load_plugin_textdomain(
        'wpbooster-speed-test',
        false,
        dirname(plugin_basename(__FILE__)).'/languages'
    );
}



public function enqueue_style()
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
    $this->enqueue_script();

    add_action("wp_footer", array(&$this, "wp_footer"));
    add_action("admin_footer", array(&$this, "wp_footer"));

    $html = '<table id="wpbooster-speed-test"><tr><th>';
    $html .= __("Before using the WP Booster", "wpbooster-speed-test");
    $html .= "</th><th>";
    $html .= __("After using the WP Booster", "wpbooster-speed-test");
    $html .= "</th></tr><tr><td id=\"booster-stopped\">";
    $html .= "</td><td id=\"booster-running\">";
    $html .= '</td></tr></table>';

    $html .= '<a id="speed-test-start" class="btn-fire">Booster Fire!</a>';
    $html .= '<p id="get-booster"><a href="http://ja.wpbooster.net/">Get WP Booster</a></p>';
    return $html;
}


public function enqueue_script()
{
    wp_enqueue_script(
        'wpbooster-speed-test',
        plugins_url('speed-test.js', __FILE__),
        array('jquery'),
        filemtime(dirname(__FILE__).'/speed-test.js'),
        true
    );
}


public function wp_footer()
{
    $script = "<script type=\"text/javascript\">var plugins_url = '%s';</script>";
    printf($script, esc_html(plugins_url('', __FILE__)));
}


public function plugin_row_meta($links, $file)
{
    $pname = plugin_basename(__FILE__);
    if ($pname === $file) {
        $link = '<a href="%s">%s</a>';
        $url = __("http://wpbooster.net/", 'wpbooster-speed-test');
        $links[] = sprintf($link, esc_url($url), __("Make WordPress Site Load Faster", "wpbooster-speed-test"));
    }
    return $links;
}

}

// EOF
