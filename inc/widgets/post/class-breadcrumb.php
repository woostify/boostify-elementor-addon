<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Boostify_Elementor\Core\Global_Breadcrumb as BoostifyBreadcrumb;
use Elementor\Controls_Manager;
/**
 * Breadcrumb
 *
 * Elementor widget for Breadcrumb.
 * Author: ptp
 */
class Breadcrumb extends Base_Widget {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function name() {
		return 'breadcrumb';
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'boostify eicon-product-breadcrumbs';
	}

	public function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_breadcrumb',
			array(
				'label' => __( 'Breadcrumb', 'boostify' ),
			)
		);

		$this->add_control(
			'custom_separator',
			array(
				'label'        => __( 'Custom Separator', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'boostify' ),
				'label_off'    => __( 'No', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'separator',
			array(
				'label'     => __( 'Separator', 'boostify' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '/',
				'condition' => array(
					'custom_separator' => 'yes',
				),
			)
		);

		$this->add_control(
			'home_label',
			array(
				'label'   => __( 'Home Label', 'boostify' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => __( 'Default', 'boostify' ),
					'site'    => __( 'Site', 'boostify' ),
				),
			)
		);

		$this->add_control(
			'show_link',
			array(
				'label'        => __( 'Link', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'boostify' ),
				'label_off'    => __( 'No', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'custom_class',
			array(
				'label' => __( 'Custom Class', 'boostify' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Style', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'color_breadcrumb',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000000',
				'scheme'    => array(
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .item-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .separator'       => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'color_active',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cd2653',
				'scheme'    => array(
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-item-breadcrumb:last-child .item-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'separator_space',
			array(
				'label'              => __( 'Separator Space', 'boostify' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => array( 'px', '%', 'em' ),
				'allowed_dimensions' => array( 'right', 'left' ),
				'selectors'          => array(
					'{{WRAPPER}} .separator' => 'margin: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .default-separator .boostify-item-breadcrumb:not(:last-child) .item-title:after' => 'margin: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}


	/**
	 * Render Copyright output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	protected function render() {

		$settings        = $this->get_settings_for_display();
		$class_custom    = ( ! empty( $settings['custom_class'] ) ? $settings['custom_class'] : '' );
		$crumb           = new BoostifyBreadcrumb();
		$separator_class = ( ! $settings['separator'] ) ? 'default-separator' : '';
		if ( 'default' == $settings['home_label'] ) { //phpcs:ignore
			$crumb->add_crumb( 'Home', home_url() );
		} else {
			$crumb->add_crumb( get_bloginfo( 'name' ), home_url() );
		}

		$list_crumb = $crumb->generate();
		$length     = count( $list_crumb );
		bcn_display();
		?>
		<div class="boostify-addon-breadcrumb widget-breadcrumb <?php echo esc_attr( $class_custom ); ?>">
			<div class="widget-breadcrumb--wrapper">
				<ul class="list-breadcrumb-item <?php echo esc_attr( $separator_class ); ?>">

					<?php foreach ( $list_crumb as $key => $item ) : ?>
						<li class="boostify-item-breadcrumb">
						<?php if ( $key < ( $length - 1 ) && 'yes' == $settings['show_link'] ) {
								?>
								<a href="<?php echo esc_url( $item[1] ); ?>" class="item-title link">
									<?php echo esc_html( $item[0] ); ?>
								</a>
								<?php
								if ( $settings['separator'] ) {
									?>
									<span class="separator"><?php echo esc_html( $settings['separator'] ); ?></span>
									<?php
								}
							} else {
								?>
								<span class="item-title"><?php echo esc_html( $item[0] ); ?></span>
								<?php
							}
						?>
						</li>

					<?php endforeach ?>
				</ul>
			</div>
		</div>
		<?php
	}

}
