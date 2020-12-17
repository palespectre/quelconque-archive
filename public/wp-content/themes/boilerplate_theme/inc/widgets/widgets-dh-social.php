<?php

class DH_Social_Widget extends WP_Widget {

    var $icons = array(
        'facebook' => '<svg version="1.1" id="facebook-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 510 510" preserveAspectRatio="xMinYMin meet" style="enable-background:new 0 0 510 510;max-width:100%" xml:space="preserve">
        <path fill="##fillcolor##" d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z
             M433.5,51v76.5h-51c-15.3,0-25.5,10.2-25.5,25.5v51h76.5v76.5H357V459h-76.5V280.5h-51V204h51v-63.75
            C280.5,91.8,321.3,51,369.75,51H433.5z"/></svg>',
        'twitter' => '<svg version="1.1" id="twitter-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 510 510" preserveAspectRatio="xMinYMin meet" style="enable-background:new 0 0 510 510;max-width:100%" xml:space="preserve">
        <path fill="##fillcolor##" d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z
             M400.35,186.15c-2.55,117.3-76.5,198.9-188.7,204C165.75,392.7,132.6,377.4,102,359.55c33.15,5.101,76.5-7.649,99.45-28.05
            c-33.15-2.55-53.55-20.4-63.75-48.45c10.2,2.55,20.4,0,28.05,0c-30.6-10.2-51-28.05-53.55-68.85c7.65,5.1,17.85,7.65,28.05,7.65
            c-22.95-12.75-38.25-61.2-20.4-91.8c33.15,35.7,73.95,66.3,140.25,71.4c-17.85-71.4,79.051-109.65,117.301-61.2
            c17.85-2.55,30.6-10.2,43.35-15.3c-5.1,17.85-15.3,28.05-28.05,38.25c12.75-2.55,25.5-5.1,35.7-10.2
            C425.85,165.75,413.1,175.95,400.35,186.15z"/></svg>',
        'linkedin' => '<svg version="1.1" id="linkedin-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 510 510" preserveAspectRatio="xMinYMin meet" style="enable-background:new 0 0 510 510;max-width:100%" xml:space="preserve">
        <path fill="##fillcolor##" d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z
             M153,433.5H76.5V204H153V433.5z M114.75,160.65c-25.5,0-45.9-20.4-45.9-45.9s20.4-45.9,45.9-45.9s45.9,20.4,45.9,45.9
            S140.25,160.65,114.75,160.65z M433.5,433.5H357V298.35c0-20.399-17.85-38.25-38.25-38.25s-38.25,17.851-38.25,38.25V433.5H204
            V204h76.5v30.6c12.75-20.4,40.8-35.7,63.75-35.7c48.45,0,89.25,40.8,89.25,89.25V433.5z"/></svg>',
        'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 18.136 18.136" style="enable-background:new 0 0 18.136 18.136;max-width:100%;max-height:100%" preserveAspectRatio="xMinYMin meet" xml:space="preserve" width="512px" height="512px"><path d="M16.281,0.001H1.855C0.831,0.001,0,0.83,0,1.855v14.426c0,1.025,0.831,1.854,1.855,1.854h14.426   c1.024,0,1.855-0.828,1.855-1.854V1.855C18.136,0.83,17.306,0.001,16.281,0.001z M10.447,3.063h0.883v2.785   c0,0.535,0.017,0.519,0.035,0.586c0.019,0.071,0.083,0.238,0.29,0.238c0.22,0,0.281-0.176,0.298-0.251   c0.014-0.065,0.03-0.052,0.03-0.61V3.063h0.882v4.18h-0.894l0.011-0.211L11.71,6.919c-0.069,0.14-0.149,0.24-0.247,0.31   c-0.099,0.069-0.21,0.104-0.342,0.104c-0.152,0-0.276-0.033-0.37-0.098c-0.092-0.063-0.156-0.141-0.198-0.24   c-0.046-0.11-0.075-0.229-0.086-0.346c-0.013-0.135-0.02-0.414-0.02-0.83V3.063L10.447,3.063z M7.379,4.801   c0-0.436,0.037-0.773,0.107-1.012C7.552,3.568,7.669,3.394,7.844,3.26c0.178-0.139,0.413-0.208,0.699-0.208   c0.244,0,0.453,0.048,0.624,0.138c0.166,0.088,0.294,0.203,0.381,0.338C9.637,3.67,9.699,3.815,9.732,3.961   c0.034,0.152,0.051,0.398,0.051,0.73v0.736c0,0.432-0.017,0.747-0.048,0.941C9.705,6.546,9.639,6.716,9.54,6.872   C9.441,7.025,9.318,7.139,9.161,7.213C8.999,7.29,8.808,7.33,8.594,7.33c-0.244,0-0.451-0.034-0.617-0.104   C7.823,7.164,7.705,7.074,7.623,6.953C7.539,6.827,7.477,6.672,7.44,6.492C7.4,6.298,7.38,5.996,7.38,5.593L7.379,4.801z    M5.314,1.574l0.718,2.311c0.125-0.604,0.367-1.44,0.559-2.311h0.651L6.404,4.871L6.398,4.897v2.344H5.635V4.897L5.629,4.872   L4.663,1.574H5.314z M15.708,14.501c-0.114,1.04-1.037,1.892-2.072,1.962c-3.048,0.131-6.087,0.131-9.134,0   c-1.036-0.07-1.958-0.922-2.073-1.962c-0.113-1.646-0.113-3.263,0-4.907c0.114-1.04,1.037-1.89,2.073-1.963   c3.047-0.13,6.086-0.13,9.134,0c1.036,0.073,1.958,0.923,2.072,1.963C15.822,11.238,15.822,12.855,15.708,14.501z M8.581,6.83   c0.128,0,0.228-0.077,0.273-0.21C8.875,6.559,8.9,6.443,8.9,6.127V4.316c0-0.366-0.021-0.484-0.043-0.551   C8.812,3.629,8.713,3.55,8.584,3.55c-0.127,0-0.227,0.076-0.274,0.211C8.286,3.826,8.262,3.947,8.262,4.316v1.761   c0,0.346,0.025,0.465,0.047,0.532C8.355,6.749,8.454,6.83,8.581,6.83z M3.617,9.91h0.72H4.48v0.147v4.704h0.904v-4.704V9.91h0.142   h0.723V8.99H3.617V9.91z M7.892,13.105c0,0.521-0.015,0.65-0.027,0.705c-0.031,0.135-0.139,0.217-0.291,0.217   c-0.145,0-0.25-0.078-0.284-0.207c-0.015-0.055-0.031-0.184-0.031-0.68v-2.757H6.403v3.004c0,0.396,0.006,0.66,0.018,0.79   c0.012,0.119,0.043,0.237,0.091,0.348c0.043,0.1,0.108,0.177,0.199,0.236c0.088,0.061,0.205,0.09,0.346,0.09   c0.121,0,0.226-0.031,0.318-0.094c0.095-0.064,0.178-0.166,0.246-0.301l0.271,0.066L7.88,14.766h0.868v-4.383H7.893L7.892,13.105z    M11.678,10.605c-0.047-0.093-0.115-0.162-0.205-0.215c-0.093-0.053-0.207-0.078-0.338-0.078c-0.11,0-0.209,0.027-0.304,0.086   c-0.097,0.062-0.188,0.153-0.27,0.281L10.3,11.082v-0.486V8.991H9.444v5.771h0.808l0.05-0.257l0.07-0.358l0.19,0.308   c0.084,0.138,0.177,0.239,0.275,0.306c0.093,0.062,0.19,0.094,0.296,0.094c0.15,0,0.276-0.053,0.386-0.156   c0.115-0.112,0.186-0.237,0.217-0.389c0.034-0.168,0.051-0.434,0.051-0.416v-2.291c0,0.01,0.034-0.228-0.017-0.701   C11.761,10.803,11.73,10.706,11.678,10.605z M10.933,13.148c0,0.41-0.021,0.535-0.038,0.6c-0.04,0.141-0.141,0.223-0.277,0.223   c-0.132,0-0.233-0.078-0.275-0.215c-0.02-0.062-0.042-0.184-0.042-0.559v-1.161c0-0.39,0.02-0.507,0.038-0.563   c0.039-0.129,0.141-0.207,0.272-0.207c0.135,0,0.237,0.082,0.28,0.221c0.019,0.061,0.044,0.183,0.044,0.551v1.111L10.933,13.148   L10.933,13.148z M13.272,12.702h0.143h1.335v-0.476c0-0.431-0.04-0.925-0.119-1.156c-0.075-0.223-0.202-0.395-0.389-0.528   c-0.181-0.128-0.419-0.195-0.706-0.195c-0.233,0-0.441,0.054-0.618,0.163s-0.3,0.262-0.378,0.469   c-0.082,0.215-0.125,0.521-0.125,1.064v1.345c0,0.173,0.02,0.429,0.056,0.597c0.036,0.162,0.101,0.312,0.193,0.447   c0.087,0.127,0.214,0.23,0.374,0.305c0.164,0.076,0.358,0.115,0.576,0.115c0.223,0,0.409-0.039,0.551-0.113   c0.142-0.075,0.26-0.19,0.354-0.342c0.098-0.158,0.161-0.309,0.187-0.445c0.028-0.143,0.042-0.355,0.042-0.631v-0.205h-0.796v0.472   c0,0.25-0.017,0.413-0.052,0.511c-0.049,0.133-0.162,0.211-0.309,0.211c-0.129,0-0.229-0.064-0.274-0.179   c-0.022-0.054-0.047-0.151-0.047-0.452v-0.838v-0.138h0.002L13.272,12.702z M13.272,12.087v-0.495c0-0.364,0.019-0.309,0.035-0.358   c0.038-0.117,0.141-0.186,0.284-0.186c0.128,0,0.226,0.075,0.265,0.203c0.016,0.052,0.036,0.002,0.036,0.341v0.495v0.139h-0.143   h-0.333h-0.143C13.273,12.226,13.272,12.087,13.272,12.087z" fill="#FFFFFF"/></svg>',
        'vimeo' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 25.361 25.361" style="enable-background:new 0 0 25.361 25.361;max-width:100%;max-height:100%" preserveAspectRatio="xMinYMin meet" xml:space="preserve" width="512px" height="512px"><path d="M23.862,0H1.5C0.671,0,0,0.671,0,1.5v22.361c0,0.828,0.671,1.5,1.5,1.5h22.361c0.828,0,1.5-0.672,1.5-1.5V1.5   C25.362,0.673,24.689,0,23.862,0z M20.602,9.053c-0.896,5.037-5.891,9.3-7.394,10.275s-2.874-0.391-3.37-1.422   c-0.569-1.178-2.274-7.554-2.722-8.082c-0.446-0.527-1.787,0.528-1.787,0.528L4.681,9.499c0,0,2.721-3.25,4.791-3.657   c2.195-0.431,2.192,3.372,2.722,5.482c0.511,2.042,0.854,3.21,1.3,3.21c0.447,0,1.3-1.14,2.232-2.884   c0.936-1.747-0.039-3.291-1.867-2.193C14.588,5.072,21.494,4.016,20.602,9.053z" fill="#FFFFFF"/></svg>',
        'instagram' => '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m437 0h-362c-41.351562 0-75 33.648438-75 75v362c0 41.351562 33.648438 75 75 75h362c41.351562 0 75-33.648438 75-75v-362c0-41.351562-33.648438-75-75-75zm-180 390c-74.441406 0-135-60.558594-135-135s60.558594-135 135-135 135 60.558594 135 135-60.558594 135-135 135zm150-240c-24.8125 0-45-20.1875-45-45s20.1875-45 45-45 45 20.1875 45 45-20.1875 45-45 45zm0 0" fill="##fillcolor##"/><path d="m407 90c-8.277344 0-15 6.722656-15 15s6.722656 15 15 15 15-6.722656 15-15-6.722656-15-15-15zm0 0" fill="##fillcolor##"/><path d="m257 150c-57.890625 0-105 47.109375-105 105s47.109375 105 105 105 105-47.109375 105-105-47.109375-105-105-105zm0 0" fill="##fillcolor##"/></svg>'

    );


// Constructor //

    function __construct() {
        $widget_ops = array( 'classname' => 'social_widget', 'description' => 'Affiche la liste des Réseaux sociaux sous forme de pictos' ); // Widget Settings
        $control_ops = array( 'id_base' => 'social_widget' ); // Widget Control Settings
        parent::__construct( 'social_widget', 'Social Widget', $widget_ops, $control_ops ); // Create the widget
    }

// Extract Args //

    function widget($args, $instance) {

        extract( $args );
        $title  = apply_filters('widget_title', $instance['title']); // the widget title
        $rs['twitter']    = $instance['twitter'];
        $rs['facebook']    = $instance['facebook'];
        $rs['linkedin']    = $instance['linkedin'];
        $rs['youtube']    = $instance['youtube'];
        $rs['instagram']    = $instance['instagram'];
        $rs['vimeo']    = $instance['vimeo'];
        $color    = $instance['color'];
        $size    = $instance['size'];


// Before widget //

        echo $before_widget;


        if(!empty($title))
            echo '<h3>'.$title.'</h3>';

        if(!empty($rs)){

            echo '<ul class="social-networks">';
            foreach($rs as $name => $r){
                if(!empty($r))
                    echo '<li style="width:'.intval($size).'px;height:'.intval($size).'px"><a href="'.$r.'" target="_blank">'.str_replace('##fillcolor##', $color, $this->icons[$name]).'</a></li>';
            }

            echo '</ul>';

        }

// After widget //

        echo $after_widget;

    }

// Update Settings //

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['twitter'] = strip_tags($new_instance['twitter']);
        $instance['facebook'] = strip_tags($new_instance['facebook']);
        $instance['linkedin'] = strip_tags($new_instance['linkedin']);
        $instance['youtube'] = strip_tags($new_instance['youtube']);
        $instance['vimeo'] = strip_tags($new_instance['vimeo']);
        $instance['instagram'] = strip_tags($new_instance['instagram']);
        $instance['color'] = strip_tags($new_instance['color']);
        $instance['size'] = strip_tags($new_instance['size']);
        return $instance;
    }

// Widget Control Panel //

    function form($instance) {

    $defaults = array( 
        'title' => '',
        'twitter' => '',
        'facebook' => '',
        'linkedin' => '',
        'youtube' => '',
        'vimeo' => '',
        'instagram' => '',
        'color' => '',
        'size' => '',
    );
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Titre :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>'" type="text" value="<?php echo $instance['twitter']; ?>" />
    </p>    
    <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>'" type="text" value="<?php echo $instance['facebook']; ?>" />
    </p>    
    <p>
        <label for="<?php echo $this->get_field_id('linkedin'); ?>">Linkedin :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>'" type="text" value="<?php echo $instance['linkedin']; ?>" />
    </p>  
    <p>
        <label for="<?php echo $this->get_field_id('youtube'); ?>">Youtube :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>'" type="text" value="<?php echo $instance['youtube']; ?>" />
    </p>  
    <p>
        <label for="<?php echo $this->get_field_id('vimeo'); ?>">Viméo :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>'" type="text" value="<?php echo $instance['vimeo']; ?>" />
    </p>    
    <p>
        <label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>'" type="text" value="<?php echo $instance['instagram']; ?>" />
    </p>  
    <p>
        <label for="<?php echo $this->get_field_id('color'); ?>">Couleur hexa :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>'" type="text" value="<?php echo $instance['color']; ?>" />
    </p>  
    <p>
        <label for="<?php echo $this->get_field_id('size'); ?>">Taille en pixel :</label>
        <input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>'" type="text" value="<?php echo $instance['size']; ?>" />
    </p>
    <?php }

}

add_action( 'widgets_init', function(){
    register_widget( 'DH_Social_Widget' );
});