<form method="post" class="llcw_settings">
    <?php wp_nonce_field('llcw_save_settings'); ?>
    <input type="hidden" name="page" value="ll-cookie-wall-settings" />
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="logo"><?php echo esc_html__( "Logo", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <input type="text" name="logo" value="<?php echo esc_attr($logo); ?>" id="logo" class="regular-text">
                <input type="button" name="upload-btn" id="upload-btn2" class="button-secondary" value="<?php esc_attr_e('Upload Image', 'll-cookie-wall'); ?>">
                <br>
                <span class="description" ><?php echo esc_html__( "If provided, this image will appear above the title.", 'll-cookie-wall' ) ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="title"><?php echo esc_html__( "Title", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <input class="regular-text" id="title" type="text" name="llcw_title" value="<?php echo esc_attr( $title ); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php echo esc_html__( "Cookies description", 'll-cookie-wall' ).' *' ?></label>
            </th>
            <td>

                <?php wp_editor( $description, 'llcw_description', $description_editor_settings ); ?>
                <br>
                <span class="description" ><?php echo esc_html__( "By European law, you must inform your visitors about all the cookies you have implemented in your website.", 'll-cookie-wall' ) ?></span>
                <span class="description" ><?php echo esc_html__( "Extra info can be inserted below a [read-more] tag in the content.", 'll-cookie-wall' ) ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="button_text"><?php echo esc_html__( "Agree button text", 'll-cookie-wall' ).' *' ?></label>
            </th>
            <td>
                <input class="regular-text" id="button_text" type="text" name="llcw_btn_text" value="<?php echo esc_attr($button_text); ?>" required />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="readmore_text"><?php echo esc_html__( "Read more text", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <input class="regular-text" id="readmore_text" type="text" name="llcw_readmore_text" value="<?php echo esc_attr($readmore_text); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="analytics"><?php echo esc_html__( "Google Analytics tracking code", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <input class="regular-text" id="analytics" type="text" placeholder="**-**********" name="llcw_tracking_code" value="<?php echo esc_attr($tracking_code); ?>" />
                <br>
                <span class="description" ><?php echo esc_html__( "This will include the Google Analytics tracking code to your cookie-wall (this is allowed if anonimised, which this plugin will do automatically as well).", 'll-cookie-wall' ) ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="custom_css"><?php echo esc_html__( "Custom CSS", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <?php wp_editor( $custom_css, 'llcw_custom_css', $css_editor_settings ); ?>
                <br>
                <span class="description" ><?php echo esc_html__( "You can add CSS rules here to customize the look of your cookie-wall.", 'll-cookie-wall' ) ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="image_url"><?php echo esc_html__( "Background image", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <input type="text" name="image_url" value="<?php echo esc_attr( $image_url ); ?>" id="image_url" class="regular-text">
                <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="<?php esc_attr_e('Upload Image', 'll-cookie-wall'); ?>">
                <br>
                <span class="description" ><?php echo esc_html__( "Add a background image for your Cookie Wall page, this plugin will make the image blurry. ", 'll-cookie-wall' ) ?></span>
                <span class="description" ><?php echo esc_html__( "For a better looking page, just capture a screenshot of your homepage with a resolution of about 1000px X 1200px.", 'll-cookie-wall' ) ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blurry"><?php echo esc_html__( "Make background image blurry", 'll-cookie-wall' ) ?></label>
            </th>
            <td>
                <input id="blurry" type="checkbox" <?php if( $blurry_background == '1' ) { echo "checked"; } ?> name="llcw_blurry_background" value="1" />
                <span class="description" ><?php echo esc_html__( "Enable if you want a blurry background (only on newer browsers with CSS3)", 'll-cookie-wall' ) ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <input class="button button-primary" type="submit" name="llcw_submit" value="<?php esc_attr_e('Save Changes', 'll-cookie-wall'); ?>" />
                <span class="description">* <?php echo __('Required', 'll-cookie-wall'); ?></span>

            </th>
        </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#upload-btn').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: '<?php echo __('Upload Image', 'll-cookie-wall'); ?>',
                    multiple: false
                }).open()
                    .on('select', function(e){
                        var uploaded_image = image.state().get('selection').first();
                        var image_url = uploaded_image.toJSON().url;
                        $('#image_url').val(image_url);
                    });
            });
        });

        jQuery(document).ready(function($){
            $('#upload-btn2').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: '<?php echo __('Upload Image', 'll-cookie-wall'); ?>',
                    multiple: false
                }).open()
                    .on('select', function(e){
                        var uploaded_image = image.state().get('selection').first();
                        var image_url = uploaded_image.toJSON().url;
                        $('#logo').val(image_url);
                    });
            });
        });
    </script>
</form>