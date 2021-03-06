<?php

namespace Sweep;

class Sweep
{

    /**
     * Returns a new instance of Sweep
     *
     * @return static
     */
    public static function create(): self
    {
        return new static();
    }

    /**
     * Removes Emoji loader from the HEAD.
     *
     * @return $this
     */
    public function removeEmojis(): self
    {
        static::stopIfAdminPage();

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');

        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );

        return $this;
    }

    /**
     * Removes the admin bar.
     *
     * @return $this
     */
    public function removeAdminBar(): self
    {
        static::stopIfAdminPage();

        show_admin_bar(false);

        return $this;
    }

    /**
     * Removes the block editor CSS from the front-end.
     *
     * @return $this
     */
    public function removeBlockEditorCss(): self
    {
        static::stopIfAdminPage();

        add_action('wp_enqueue_scripts', static function () {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style');
        });

        return $this;
    }

    /**
     * Removes the prefetch for s.w.org from the HEAD.
     *
     * @return $this
     */
    public function removeWpDnsPrefetch(): self
    {
        static::stopIfAdminPage();

        remove_action('wp_head', 'wp_resource_hints', 2);

        return $this;
    }

    /**
     * Removes the XML-RPC link from the HEAD.
     *
     * @return $this
     */
    public function removeXmlRpcLink(): self
    {
        static::stopIfAdminPage();

        remove_action ('wp_head', 'rsd_link');

        return $this;
    }

    /**
     * Removes the WordPress version from the HEAD.
     *
     * @return $this
     */
    public function removeWordPressVersion(): self
    {
        static::stopIfAdminPage();

        add_filter('the_generator', '__return_empty_string');

        return $this;
    }

    /**
     * Removes the wlwmanifest link from the HEAD.
     *
     * @return $this
     */
    public function removeWindowsLiveWriterLink(): self
    {
        static::stopIfAdminPage();

        remove_action('wp_head', 'wlwmanifest_link');

        return $this;
    }

    /**
     * Removes the api.w.org WP-JSON link from the HEAD.
     *
     * @return $this
     */
    public function removeWpJsonLink(): self
    {
        static::stopIfAdminPage();

        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);

        return $this;
    }

    /**
     * Removes the recent comments CSS from the HEAD.
     *
     * @return $this
     */
    public function removeRecentCommentsCSS(): self
    {
        static::stopIfAdminPage();

        add_action('widgets_init', static function () {
            global $wp_widget_factory;
            remove_action(
                'wp_head',
                [
                    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
                    'recent_comments_style'
                ]
            );
        });

        return $this;
    }

    /**
     * Removes jQuery and jQuery Migrate
     *
     * @return $this
     */
    public function removeJQuery(): self
    {
        static::stopIfAdminPage();

        add_action('init', static function () {
            wp_deregister_script('jquery');
            wp_register_script('jquery', false);
        });

        return $this;
    }

    /**
     * Disables the block editor.
     *
     * @return $this
     */
    public function removeBlockEditor(): self
    {
        static::stopIfAdminPage();

        add_filter('use_block_editor_for_post', '__return_false', 10);

        return $this;
    }

    /**
     * Removes any oEmbed functionality.
     *
     * @return $this
     */
    public function removeOEmbed(): self
    {
        static::stopIfAdminPage();

        add_action('wp_footer', static function () {
            wp_deregister_script('wp-embed');
        });

        // Remove the REST API endpoint.
        remove_action('rest_api_init', 'wp_oembed_register_route');

        // Turn off oEmbed auto discovery.
        add_filter('embed_oembed_discover', '__return_false');

        // Don't filter oEmbed results.
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

        // Remove oEmbed-specific JavaScript from the front-end
        remove_action('wp_head', 'wp_oembed_add_host_js');

        // Remove all embeds rewrite rules.
        add_filter('rewrite_rules_array', static function (array $rules) {
            foreach($rules as $rule => $rewrite) {
                if(false !== strpos($rewrite, 'embed=true')) {
                    unset($rules[$rule]);
                }
            }
            return $rules;
        });

        return $this;
    }

    /**
     * Executes all the removal functions
     *
     * @return $this
     */
    public function removeAll(): self
    {
        static::stopIfAdminPage();

        return $this->removeEmojis()
                    ->removeAdminBar()
                    ->removeBlockEditorCss()
                    ->removeWpDnsPrefetch()
                    ->removeXmlRpcLink()
                    ->removeWordPressVersion()
                    ->removeWindowsLiveWriterLink()
                    ->removeWpJsonLink()
                    ->removeRecentCommentsCSS()
                    ->removeJQuery()
                    ->removeBlockEditor()
                    ->removeOEmbed();
    }

    /**
     * Stops the execution if we're in an admin page.
     *
     * @return void
     */
    protected static function stopIfAdminPage(): void
    {
        if(is_admin()) {
            return;
        }
    }
}