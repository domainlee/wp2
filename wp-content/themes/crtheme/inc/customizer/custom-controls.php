<?php
/**
 * Custom Control Class
 *
 * This class doesn't dirty behind stuffs for other custom classes
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Customize_Control' ) ) :

class Fox_Customize_Control extends WP_Customize_Control
{
    
    /**
     * Compress to reduce size
     */
    protected function render() {
        $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
        $class = 'fox-customize-control customize-control-' . $this->type;

        ?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php $this->render_content(); ?></li><?php
    }
    
    /*
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {}
    
    /**
     * Function to extend
     */
    public function js_content() {}
    
    /*
     * Render the content on the theme customizer page
     */
    public function content_template()
    {
        ob_start();
        ?>
        <label>
            <# if ( data.label ) { #>
                <span class="customize-control-title">{{{ data.label }}}</span>
            <# } #>
            <?php $this->js_content(); ?>
            <# if ( data.description ) { #>
                <span class="description">{{{ data.description }}}</span>
            <# } #>
        </label>
        <?php
        echo ob_get_clean();
    }
    
}

endif;

/**
 * Text Control
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Text_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Text_Control' );

class Fox_Text_Control extends Fox_Customize_Control
{
    
    public $type = 'fox_text';
    
    public function js_content() { ?>
                
                <input type="text" data-customize-setting-link="{{ data.settings.default }}" placeholder="{{ data.placeholder }}" />
        
    <?php }
    
}

endif;

/**
 * Textarea Control
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Textarea_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Textarea_Control' );

class Fox_Textarea_Control extends Fox_Customize_Control
{
    
    public $type = 'fox_textarea';
    
    public function js_content() { ?>
                
                <textarea rows="5" data-customize-setting-link="{{ data.settings.default }}" placeholder="{{ data.placeholder }}"></textarea>
        
    <?php }
    
}

endif;

/**
 * Select Control
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Select_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Select_Control' );

class Fox_Select_Control extends Fox_Customize_Control
{
    
    public $type = 'fox_select';
    
    public function js_content() { ?>
                
                <select data-customize-setting-link="{{ data.settings.default }}">
                
                <# _.each( data.choices, function( value, key, obj ) { #>
                    
                    <option value="{{ key }}">{{{ value }}}</option>
                    
                <# }) #>
                    
                </select>
                    
                <span class="select-value"></span>
                
                    <span class="select-arrow">
                        <i class="dashicons dashicons-arrow-down"></i>
                    </span>
    <?php }
    
}

endif;

/**
 * Radio Control
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Radio_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Radio_Control' );

class Fox_Radio_Control extends Fox_Customize_Control
{
    
    public $type = 'fox_radio';
    
    public function js_content() { ?>
                    
                    <div class="customize-control-content">
                    
                <# _.each( data.choices, function( value, key, obj ) { #>
                    
                    <label>
                        <input value="{{ key }}" type="radio" name="_customize-radio-{{ data.settings.default }}" data-customize-setting-link="{{ data.settings.default }}" />
                        {{{ value }}}<br/>
                    </label>
                    
                <# }) #>
                    
                    </div>
        
    <?php }
    
}

endif;

/**
 * Checkbox Control
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Checkbox_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Checkbox_Control' );

class Fox_Checkbox_Control extends Fox_Customize_Control
{
    
    public $type = 'fox_checkbox';
    
    public function content_template()
    {
        ob_start();
        ?>
        <label>
            <input type="checkbox" data-customize-setting-link="{{ data.settings.default }}" />
            {{{ data.label }}}
            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
        </label>
        <?php
        echo ob_get_clean();
    }
    
}

endif;

/**
 * Custom Heading Control
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Heading_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Heading_Control' );

class Fox_Heading_Control extends Fox_Customize_Control
{
    
    public $type = 'heading';
    
    /*
     * Render the content on the theme customizer page
     */
    public function content_template()
    {
        ?>
        <div class="fox-customize-heading">
            <# if ( data.label ) { #>
                <h2>{{{ data.label }}}</h2>
            <# } #>
            <# if ( data.description ) { #>
                <div class="heading-desc">{{{ data.description }}}</div>
            <# } #>
        </div>
        <?php
    }
    
}

endif;

/**
 * Custom Message Control
 *
 * Prints an instruction for ease of customization
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Message_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Message_Control' );

class Fox_Message_Control extends Fox_Customize_Control
{
    
    public $type = 'message';
    
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $unset = array( 'label', 'description' );
        foreach ( $unset as $un ) {
            if ( isset( $this->json[ $un ] ) )
                unset( $this->json[ $un ] );
        }
        $this->json['message'] = $this->setting->default;
    }
    
    public function content_template() {
        ?>
        <div class="fox-message">{{{ data.message }}}</div>
        <?php
    }
}

endif;

/**
 * Custom HTML
 *
 * Prints html
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_HTML_Control' ) ) :

$wp_customize->register_control_type( 'Fox_HTML_Control' );

class Fox_HTML_Control extends Fox_Customize_Control
{
    
    public $type = 'html';
    
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $unset = array( 'label', 'description' );
        foreach ( $unset as $un ) {
            if ( isset( $this->json[ $un ] ) )
                unset( $this->json[ $un ] );
        }
        $this->json['html'] = $this->setting->default;
    }
    
    public function content_template() {
        ?>
        {{{ data.html }}}
        <?php
    }
}

endif;

/**
 * Image Radio: Prints radio input fields with image labels for ease of selection
 *
 * @since 1.0
 */
if ( !class_exists( 'Fox_Image_Radio_Control' ) ) :

$wp_customize->register_control_type( 'Fox_Image_Radio_Control' );

class Fox_Image_Radio_Control extends Fox_Customize_Control
{
    public $type = 'image_radio';
    
    public function to_json() {
        parent::to_json();
        $this->json['choices'] = $this->choices;
    }
    
    public function js_content() {
        ?>
        <div class="customize-control-content control-image-radio">
            
            <# var src, width, height, title,
               id = data.settings.default,
               name = '_customize-radio-' + id;
               
               _.each( data.choices, function ( value, key, obj ) {
               if ( 'object' === typeof value ) {
                    src = value.src || '',
                    width = value.width || '',
                    height = value.height || '',
                    title = value.title || '';
               } else {
                    src = value;
                    width = height = title = '';
                }
               #>
                <label>
                    <input type="radio" value="{{ key }}" name="{{ name }}" data-customize-setting-link="{{ id }}" />
                    <img src="{{ src }}" width="{{ width }}" height="{{ height }}" /><br />
                    <# if ( title ) { #>
                    <small>{{{ title }}}</small>
                    <# } #>
                </label>
                        
            <# }) #>

        </div>
        <?php
    }

}

endif;

if ( !class_exists( 'Fox_Multicheckbox_Control' ) ) :
/**
 * Multicheckbox Control
 *
 * @since 1.0
 */
$wp_customize->register_control_type( 'Fox_Multicheckbox_Control' );

class Fox_Multicheckbox_Control extends Fox_Customize_Control
{
    
    public $type = 'multicheckbox';
    
    public function to_json() {
        parent::to_json();
        $this->json['choices'] = $this->choices;
    }
    
    public function js_content() {
        ?>
        <ul>
            <# if ( ! jQuery.isArray( data.choices ) ) { for ( key in data.choices ) { value = data.choices[ key ]; #>
                
            <li>
                <label>
                    <input type="checkbox" value="{{ key }}" />
                    {{{ value }}}
                </label>
            </li>
                
            <# } } else { jQuery.each( data.choices, function( key, value ) { #>
                
            <li>
                <label>
                    <input type="checkbox" value="{{ value }}" />
                    {{{ value }}}
                </label>
            </li>

            <# }); } #>
        </ul>
        <input type="hidden" class="checkbox-result" data-customize-setting-link="{{ data.settings.default }}" />
    <?php
    }
}

endif;

if ( !class_exists( 'Fox_Slide_Control' ) ) :
/**
 * Slide Control
 *
 * @since 1.0
 */
$wp_customize->register_control_type( 'Fox_Slide_Control' );

class Fox_Slide_Control extends Fox_Customize_Control
{
    
    public $type = 'slide';
    
    public function js_content() {
        ?>
                <div class="slide-container">
                    
                    <div class="slide-input-area">
                        
                        <input type="text" class="slide-input" data-customize-setting-link="{{ data.settings.default }}" placeholder="{{ data.placeholder }}" />
                        <# if ( data.unit ) { #> <span class="unit">{{ data.unit }}</span> <# } #>
                            
                    </div><!-- .slide-input-area -->
                            
                    <div class="slide-control"></div>
                    
                </div><!-- .slide-container -->
    <?php
    }
}

endif;