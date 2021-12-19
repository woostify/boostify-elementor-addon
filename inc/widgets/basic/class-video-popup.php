<?php
/**
 * Video Popup
 *
 * Elementor widget for \FAQs.
 *
 * @package Boostify_Header_Footer
 * Author: ptp
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Embed;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Control_Media;
use Elementor\Icons_Manager;

/**
 * \FAQs
 *
 * Elementor widget for \FAQs.
 * Author: ptp
 */
class Video_Popup extends Base_Widget {
	// Exit if accessed directly.

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget Name.
	 */
	public function name() {
		return 'video-popup';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Video Popup', 'boostify' );
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
		return 'boostify eicon-video-playlist';
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'boostify-video-popup' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_video_popup',
			array(
				'label' => esc_html__( 'Video', 'boostify' ),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'boostify' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image_overlay',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'source',
			array(
				'label'   => esc_html__( 'Source', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'youtube' => esc_html__( 'Youtube', 'boostify' ),
					'vimeo'   => esc_html__( 'Vimeo', 'boostify' ),
				),
				'default' => 'youtube',
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'       => esc_html__( 'URL', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'https://www.youtube.com/watch?v=9uOETcuFjbE',
				'placeholder' => esc_attr__( 'Enter URL Youtube', 'boostify' ),
				'condition'   => array(
					'source' => 'youtube',
				),
			)
		);

		$this->add_control(
			'vimeo_url',
			array(
				'label'       => esc_html__( 'URL', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'https://vimeo.com/235215203',
				'placeholder' => esc_attr__( 'Enter URL Vimeo', 'boostify' ),
				'condition'   => array(
					'source' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'icon_play',
			array(
				'label'   => __( 'Icon', 'text-domain' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'image_align',
			array(
				'label'     => esc_html__( 'Align', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'boostify' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'boostify' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'boostify' ),
						'icon'  => 'eicon-text-align-right',
					),
				),

				'selectors' => array(
					'{{WRAPPER}} .boostify-video-popup' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => esc_html__( 'Image', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs(
			'style_overlay_image'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'overlay_image',
			array(
				'label'     => esc_html__( 'Overlay', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'boostify' ),
				'label_off' => esc_html__( 'Hide', 'boostify' ),
				'default'   => 'no',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'label'     => esc_html__( 'Background', 'boostify' ),
				'name'      => 'Background_overlay_image',
				'condition' => array(
					'overlay_image' => 'yes',
				),
				'selector'  => '{{WRAPPER}} .boostify-box .btn-play',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'overlay_image_hover',
			array(
				'label'     => esc_html__( 'Overlay', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'boostify' ),
				'label_off' => esc_html__( 'Hide', 'boostify' ),
				'default'   => 'no',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'label'     => esc_html__( 'Background', 'boostify' ),
				'name'      => 'Background_overlay_image_hover',
				'condition' => array(
					'overlay_image' => 'yes',
				),
				'selector'  => '{{WRAPPER}} .boostify-box:hover .btn-play',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => esc_html__( 'Box Shadow', 'boostify' ),
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .boostify-box',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Lightbox', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lightbox-width',
			array(
				'label'   => esc_html__( 'Lightbox Width', 'boostify' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min' => 900,
						'max' => 1170,
					),
				),
				'default' => array(
					'size' => '976',
				),

			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'   => esc_html__( 'Aspect Ratio', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'0.5625'  => '16:9',
					'0.42857' => '21:9',
					'0.75'    => '4:3',
					'0.66666' => '3:2',
					'1'       => '1:1',
				),
				'default' => '0.5625',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style-icon-play',
			array(
				'label' => esc_html__( 'Icon Play', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'color_icon',
			array(
				'label'     => esc_html__( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .btn-video-play-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .btn-video-play-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .btn-video-play-icon svg g' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'size_icon',
			array(
				'label'      => esc_html__( 'Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 15,
						'max' => 100,
					),
					'em' => array(
						'min' => 1,
						'max' => 4,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '36',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-video-play-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'label'    => esc_html__( 'Border', 'boostify' ),
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .boostify-box .btn-video-play-icon',
			)
		);

		$this->add_control(
			'button-border-radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .btn-video-play-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'padding-icon',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .btn-video-play-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background_icon',
				'label'    => esc_html__( 'Background Icon', 'boostify' ),
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .btn-video-play-icon',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'icon_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .btn-video-play-icon',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$url      = $settings[ $settings['source'] . '_url' ];
		$icon     = $settings['icon_play'];
		if ( 'vimeo' == $settings['source'] ) { //phpcs:ignore
			$url = str_replace( 'https://vimeo.com', 'https://player.vimeo.com/video', $settings['vimeo_url'] );
		}
		$video_html = Embed::get_embed_html( $url, array(), array( 'lazy_load' => '' ) );
		$image_url  = Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'image_overlay', $settings );
		if ( empty( $image_url ) ) {
			$image_url = $settings['image']['url'];
		}

		$image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $settings['image'] ) ) . '" />';
		$this->add_render_attribute( 'light-box', 'href', esc_url( $url ) );
		$this->add_render_attribute( 'light-box', 'data-html5player', 'true' );
		$this->add_render_attribute( 'light-box', 'class', 'html5lightbox boostify-video-box' );
		$this->add_render_attribute( 'light-box', 'data-width', $settings['lightbox-width']['size'] );
		$this->add_render_attribute( 'light-box', 'data-height', (int) $settings['lightbox-width']['size'] * (float) $settings['aspect_ratio'] );
		?>
		<div class="boostify-video-popup">

			<a <?php echo $this->get_render_attribute_string( 'light-box' ); //phpcs:ignore ?>>
				<?php echo $image_html; //phpcs:ignore?>
				<span class="btn-play">
						<?php
						if ( ! empty( $icon['value'] ) ) :
							if ( is_string( $icon['value'] ) ) :
								?>
								<span class="btn-video-play-icon <?php echo esc_attr( $icon['value'] ); ?>"></span>
							<?php else : ?>
								<span class="btn-video-play-icon play-icon-svg">
									<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
								</span>
								<?php
							endif;
						endif;
						?>
				</span>
			</a>
		</div>

		<?php

	}

}
