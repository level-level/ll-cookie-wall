<div class="llcw_rewrite_rules">
    
    <?php if( llcw_get_server_software() == 'apache' ){ ?>
        <p>After saving the settings page, WordPress automagicly adds the rewrite rules to your .htaccess</p>
        <p>This file is located at <code><?php echo plugin_dir_path( __FILE__ ) . 'config_files/.htaccess'; ?></code></p>
        <textarea cols="130" rows="17"><?php echo esc_html( llcw_read_config_file( $apache_config_path ) ); ?></textarea>
    <?php } ?>

    <?php if( llcw_get_server_software() == 'nginx' ){ ?>
        <div class="notice notice-info">
            <p><?php echo esc_html__( "Notice! When deactivating this plugin don't forget to remove the following nginx rules and reload your nginx server. WordPress doesn\n't have access to do this automatically.", $plugin_text_domain ) ?></p></div>
        <p>After saving the settings page, you <i>manually</i> need to add the Nginx rewrite rules to your own Nginx config file</p>
        <p>This file is locatie at <code><?php echo esc_url( plugin_dir_path( __FILE__ ) . 'config_files/nginx.conf' ); ?></code></p>
        <textarea cols="130" rows="17"><?php echo esc_html( llcw_read_config_file( $nginx_config_path ) ); ?></textarea>
    <?php } ?>

</div>