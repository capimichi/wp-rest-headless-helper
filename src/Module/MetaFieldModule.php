<?php

class MetaFieldModule implements ModuleInterface
{
    
    const CUSTOM_META_KEY = 'custom_meta';
    
    /**
     * @inheritDoc
     */
    public function getSort()
    {
        return 100;
    }
    
    /**
     * @inheritDoc
     */
    public function initModule()
    {
        add_action('rest_api_init', [$this, 'addCustomMetaToRestResponse']);
        
        $postTypes = get_post_types(['show_in_rest' => true], 'objects');
        foreach ($postTypes as $postType) {
            add_action('rest_after_insert_' . $postType->name, [$this, 'updateCustomMetaFromRest'], 10, 3);
        }
    }
    
    /**
     * Add custom meta to the REST response
     */
    protected function addCustomMetaToRestResponse()
    {
        $postTypes = get_post_types(['show_in_rest' => true], 'objects');
        foreach ($postTypes as $postType) {
            register_rest_field($postType->name, self::CUSTOM_META_KEY, [
                'get_callback' => function ($post_arr) {
                    $post_id = $post_arr['id'];
                    $post_meta = get_post_meta($post_id);
                    return $post_meta;
                },
                'schema'       => null,
            ]);
        }
    }
    
    /**
     * Update custom meta from REST request
     *
     * @param WP_Post $post
     * @param WP_REST_Request $request
     * @param bool $creating
     */
    protected function updateCustomMetaFromRest($post, $request, $creating)
    {
        if (isset($request[self::CUSTOM_META_KEY])) {
            $custom_meta = $request[self::CUSTOM_META_KEY];
            foreach ($custom_meta as $key => $value) {
                update_post_meta($post->ID, $key, $value);
            }
        }
    }
}