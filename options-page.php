<?php
class MDC_SettingsPage
{
    private $options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'mdc_add_menu_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function mdc_add_menu_page()
    {
        add_menu_page('Adf.ly Setting Page', 'Adf.ly', 'manage_options', 'mdc-adfly', array( $this, 'mdc_menu_page_content' ), plugins_url('/images/adfly.png',__FILE__), 3.05);
    }

    public function mdc_menu_page_content()
    {
        // Set class property
        $this->options = get_option( 'mdc_adfly_options' );
        ?>
        <div class="wrap mdc_adfly_options">
            <h2>Adf.ly Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'mdc_adfly_options_group' );   
                do_settings_sections( 'mdc-settings-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting('mdc_adfly_options_group', 'mdc_adfly_options', array( $this, 'sanitize' ));

        add_settings_section('mdc_adfly_authentication', 'Authentication<span class="adfly_help"><img alt="Help" title="Help" src="'.plugins_url('/images/help_icon.gif',__FILE__).'"></span>', array( $this, 'adfly_authentication_section' ), 'mdc-settings-admin'); 
    
        add_settings_field('api_key', 'API Key', array( $this, 'adfly_api_key_callback' ), 'mdc-settings-admin', 'mdc_adfly_authentication' );      
        add_settings_field('user_id', 'User ID', array( $this, 'adfly_user_id_callback' ), 'mdc-settings-admin', 'mdc_adfly_authentication');      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['api_key'] ) ) $new_input['api_key'] = sanitize_text_field( $input['api_key'] );
        if( isset( $input['user_id'] ) ) $new_input['user_id'] = absint( $input['user_id'] );
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function adfly_authentication_section()
    { ?>
        <div class="mdc_adfly_help hidden">
            <p>This plugin requires an <abbr title="A string of 32 characters">API Key</abbr> and a <abbr title="A 5 digit number">User ID</abbr> to authenticate. To get your API Key and User ID, <a href="https://adf.ly/publisher/tools#tools-api" target="_blank">click this link</a>.<br />You need to login to access this page. (See the image below to get an idea!)</p>
            <img src="<?php echo plugins_url('/images/help.png',__FILE__);?>">
        </div>
    <?php }
    public function adfly_settings_section(){
        print '';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function adfly_api_key_callback(){ ?>
        <input type="text" id="api_key" class="regular-text" name="mdc_adfly_options[api_key]" value="<?php echo isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''; ?>" />
    <?php }

    public function adfly_user_id_callback(){ ?>
        <input type="text" id="user_id" class="regular-text" name="mdc_adfly_options[user_id]" value="<?php echo isset( $this->options['user_id'] ) ? esc_attr( $this->options['user_id']) : ''; ?>" />
    <?php }
}

if( is_admin() )
    $my_settings_page = new MDC_SettingsPage();

