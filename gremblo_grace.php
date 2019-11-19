<?php
/*
 * Plugin Name: Gremblo Images
 * Description: With this plugin you can see a fresh image of our lord and saviour Gremblo each time you go to the Dashboard!
 * Version: 0.1
 * Author: Viðar Vignisson
 * Author URL: https://prep4this.com
 * Text Domain: 
*/

if ( ! function_exists( 'add_action')) {
    echo "You being here is in direct violation of our lord Gremblos' will, leave or die!";
    exit;
}

class avatarOfGremblo {
    function __construct()
    {
        add_action('wp_dashboard_setup', array($this, 'my_custom_dashboard_widgets'));
        add_action( 'admin_init', array($this, 'styling'));
    }

    function my_custom_dashboard_widgets() {
        global $wp_meta_boxes;
         
        wp_add_dashboard_widget('gremblo_dashboard', 'Gremblo Image of the Day', array($this, 'gremblo_dashboard'));
    }

    function gremblo_dashboard() {
        $data = file_get_contents (esc_url('http://grembloapi.test/api/images'));
        $image = json_decode($data);

        if ($image == true) 
        {          
            // style="background-image: url(\'' . $image->data->image_link . '\')"
            echo '<div class="gremblo-widget"><a href="' . $image->data->image_link . '" target="_blank"><img src="' . $image->data->image_link . '"></a></div>';
        }
        else {
            echo '<div class="gremblo-widget"></div>';
        }

        echo '<h2 class="gremblo-title">' . $image->data->title . '</h2>';
        
    }

    function styling(){
        wp_enqueue_style( 'grembloStyle', plugins_url('gremblo.css', __FILE__ ));
    }
}

if (class_exists('avatarOfGremblo')) {
    $grembloCreate = new avatarOfGremblo();
}
