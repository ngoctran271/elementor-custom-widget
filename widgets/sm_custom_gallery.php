<?php
if (!defined('ABSPATH')) {
    exit;
}
class Elementor_SM_Custom_Gallery_Box_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'sm_custom_gallery';
    }
    public function get_title()
    {
        return esc_html__('Custom Gallery Slider Box', 'ecw');
    }
    public function get_icon()
    {
        return 'eicon-bullet-list';
    }
    public function get_categories()
    {
        return ['custom'];
    }
    // public function get_style_depends(){
    //     return ['elementor-icons-fa-brands','elementor-icons-fa-regular','elementor-icons-fa-solid'];
    // }
    // public function get_script_depends() {
    //     return ['slick'];
    // }
    // public function get_keywords()
    // {
    //     return ['list', 'slide', 'image', 'custom'];
    // }
    protected function register_controls()
    {
        //content
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'ecw'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'ecw' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'list_items',
            [
                'label' => esc_html__( 'List Items', 'ecw' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),           /* Use our repeater */
                // 'default' => [
                //     [
                //         'text' => esc_html__( 'List Item #1', 'elementor-list-widget' ),
                //         'link' => '',
                //     ],
                //     [
                //         'text' => esc_html__( 'List Item #2', 'elementor-list-widget' ),
                //         'link' => '',
                //     ],
                //     [
                //         'text' => esc_html__( 'List Item #3', 'elementor-list-widget' ),
                //         'link' => '',
                //     ],
                // ],
                // 'title_field' => '{{{ text }}}',
            ]
        );    
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        // echo 'List: <br>';
        // echo var_export($settings['list'], true);
        // echo '<br>';
        ob_start();
        //$testimonials = $settings['review_list'];
        //if(!empty($testimonials)):
        
?>
      
    <script>
        (function($){

        })(jQuery)
    </script>
<?php
        //endif;
        echo ob_get_clean();
    }
}
