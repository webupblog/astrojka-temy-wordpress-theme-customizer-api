<?php

add_action( 'customize_register', 'cd_customizer_settings' );

function cd_customizer_settings( $wp_customize ) {
    $wp_customize->add_section( 'cd_colors' , array(
        'title'      => 'Цвета',
        'priority'   => 30,
    ));
    $wp_customize->add_setting( 'background_color' , array(
        'default'     => '#43C6E4',
        'transport'   => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
        'label'        => 'Цвет фона',
        'section'    => 'cd_colors',
        'settings'   => 'background_color',
    )));

    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    $wp_customize->add_section( 'cd_button' , array(
        'title'      => 'Кнопка',
        'priority'   => 20,
    ) );
  
    $wp_customize->add_setting( 'cd_button_display' , array(
        'default'     => true,
        'transport'   => 'refresh',
    ) );
  
    $wp_customize->add_control( 'cd_button_display', array(
    'label' => 'Видимость кнопки',
    'section' => 'cd_button',
    'settings' => 'cd_button_display',
    'type' => 'radio',
    'choices' => array(
      'show' => 'Показать',
      'hide' => 'Скрыть',
    ),
    ));

    $wp_customize->add_setting( 'cd_button_text' , array(
        'default'     => 'Вперед!',
        'transport'   => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'cd_button_text', array(
        'label' => 'Текст кнопки',
        'section'	=> 'cd_button',
        'type'	 => 'text',
    ) );

    $wp_customize->selective_refresh->add_partial( 'cd_button_display', array(
        'selector' => '#button-container',
        'render_callback' => 'cd_show_main_button',
    ) );

    $wp_customize->add_setting( 'cd_photocount' , array(
        'default'     => 0,
        'transport'   => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'cd_photocount', array(
        'label'	=>  'Количество фото',
        'min' => 10,
        'max' => 9999,
        'step' => 10,
        'section' => 'title_tagline',
    ) ) );
}

function cd_show_main_button() {
    if( get_theme_mod( 'cd_button_display', 'show' ) == 'show' ) {
        echo "<a href='' class='button'>" . get_theme_mod( 'cd_button_text', 'Вперед!' ) . "</a>";
    }
}

if( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Range extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'min' => 0,
                'max' => 10,
                'step' => 1
            );
            $args = wp_parse_args( $args, $defaults );

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
        }

		public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input class='range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
            <input onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() )" type='text' value='<?php echo esc_attr( $this->value() ); ?>'>
		</label>
		<?php
		}
	}
}