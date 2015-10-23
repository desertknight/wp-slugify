<?php

class WPSlugifyAdmin
{

    /**
     *
     * @var array
     */
    private $options;

    /**
     *
     * @var array
     */
    private $ignore_post_types = array('attachment', 'revision', 'nav_menu_item');

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_initialize'));
    }

    public function getOptions($name = null)
    {
        if (!$this->options) {
            $this->options = get_option('wp-slugify-options');
        }
        if (null === $name) {
            return $this->options;
        }
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    public function add_admin_menu()
    {
        add_options_page(__('WP Slugify'), __('WP Slugify'), 'manage_options', 'wp-slugify', array($this, 'render_page'));
    }

    public function admin_initialize()
    {
        register_setting('wp-slugify-settings', 'wp-slugify-options');

        add_settings_section('wp-slugify-header', __('WP Slugify', 'wp-slugify'), array($this, 'render_header'), 'wp-slugify');

        foreach (get_post_types() AS $post_type) :
            if (!in_array($post_type, $this->ignore_post_types)) :
                add_settings_field("{$post_type}_slugify", $post_type, array($this, 'render_checkbox'), 'wp-slugify', 'wp-slugify-header', array('post_type' => $post_type));
            endif;
        endforeach;
    }

    public function render_header()
    {
        return _e('Choose post type', 'wp-slugify');
    }

    public function render_checkbox($args)
    {
        $name = "wp-slugify-options[{$args['post_type']}_slugify]";
        $is_checked = checked($this->getOptions("{$args['post_type']}_slugify"), true, false);
        echo sprintf('<label for="%1$s"><input type="checkbox" name="%2$s" %3$s value="1" /> %1$s</label>', $args['post_type'], $name, $is_checked);
    }

    public function render_page()
    {
        ?>
        <div class="wrap">
            <form action="options.php" method="POST">
                <?php settings_fields('wp-slugify-settings'); ?>
                <?php do_settings_sections('wp-slugify'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

}
