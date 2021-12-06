<?php
/**
 * Plugin Class File
 */ 
if ( !class_exists( 'BW_Support' ) ) {
	/**
	 * BW_Support Class
	 */
	class BW_Support {

		protected $plugin_name;
		protected $version;
		
		public function __construct() {
			if ( defined( 'BW_SUPPORT_VERSION' ) ) {
				$this->version = BW_SUPPORT_VERSION;
			} else {
				$this->version = '1.0.0';
			}
			$this->plugin_name = 'Best Website Footer Link';
			$this->load_actions();
		}

		public function load_actions() {
			if (is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'bw_enqueue_admin_scripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'bw_enqueue_public_scripts' ) );
			add_action( 'admin_menu', array( $this , 'create_options_page' ) );
			add_action( 'wp_footer', array( $this, 'display_footer_brand_credits' ) );
		}

		public function bw_enqueue_admin_scripts() {
			wp_enqueue_style( 'bw-support-admin-styles', '/wp-content/mu-plugins/footer-link/assets/admin/css/bw-support.css' );
			wp_enqueue_script( 'bw-support-admin-scripts', '/wp-content/mu-plugins/footer-link/assets/admin/js/admin.js', array( 'jquery' ), false, null );
		}

		public function bw_enqueue_public_scripts() {
			wp_enqueue_style( 'bw-support-admin-styles', '/wp-content/mu-plugins/footer-link/assets/public/css/bw-support.css' );
			wp_enqueue_script( 'bw-support-admin-scripts', '/wp-content/mu-plugins/footer-link/assets/public/js/bw-support.js', array( 'jquery' ), false, null );	
		}

		public function create_options_page() {
			add_options_page(
				__('Best Website Footer Link', 'bw-support'),
				'Footer Link',
				'manage_options',
				'bw-support-settings',
				array( $this, 'admin_page_content' ),
				'dashboard-tagcloud',
				5
			);

			add_action( 'admin_init', array( $this, 'register_bw_support_settings' ) );
		}

		public function register_bw_support_settings() {
			
			# code...

			register_setting(
				'bw_support_settings_group',
				'bw_support_settings'
			);

			add_settings_section(
				'bw_support_settings_page',
				'Manage Footer Link Settings',
				array( $this, 'bw_support_settings_text' ),
				'bw-support-settings'
			);

			add_settings_field(
				'bw_support_show_credits',
				'Enable Footer Link?',
				array( $this, 'bw_support_settings_credits' ),
				'bw-support-settings',
				'bw_support_settings_page'
			);

			add_settings_field(
				'bw_support_credits_type',
				'What Kind of Link?',
				array( $this, 'bw_support_settings_credits_type' ),
				'bw-support-settings',
				'bw_support_settings_page'
			);
			
			add_settings_field(
				'bw_support_credits_svg_color',
				'Logo Color',
				array( $this, 'bw_support_settings_credits_svg_color' ),
				'bw-support-settings',
				'bw_support_settings_page'
			);

		}

		public function bw_support_settings_text() {
			printf('<p>Manage Footer Link Settings</p>');
		}

		public function bw_support_settings_credits() {
			printf( '<select name="bw_support_show_credits">
				<option value="yes" '.(($this->options['bw_support_show_credits'] === "yes") ? 'selected': '').'>Enable</option>
				<option value="no" '.(($this->options['bw_support_show_credits'] === "no") ? 'selected': '').'>Disable</option>
				</select>' );
		}

		public function bw_support_settings_credits_type() {
			printf( '<select name="bw_support_settings_credits_type">
				<option value="text" '.(($this->options['bw_support_settings_credits_type'] === "text") ? 'selected': '').'>Plain Text</option>
				<option value="image" '.(($this->options['bw_support_settings_credits_type'] === "image") ? 'selected': '').'>Text with Logo</option>
				</select>' );
		}

		public function bw_support_settings_credits_svg_color() {
			printf( '<select name="bw_support_credits_svg_color">
				<option value="blue" '.(($this->options['bw_support_credits_svg_color'] === "blue") ? 'selected': '').'>Blue</option>
				<option value="white" '.(($this->options['bw_support_credits_svg_color'] === "white") ? 'selected': '').'>White</option>
				</select>' );
		}

		public function admin_page_content() {
			$this->options = get_option('bw_support_settings');
			?>

			<div class="wrapper">
				<div class="bw-modules-container">
					<div class="bw-modules-header">
						<h2>Best Website Nashville</h2>
						<a href="https://bestwebsite.com/contact/" target="_blank">Contact Us</a>
					</div>
					<div class="bw-modules-body">
						<h2 class="module-title">Manage Footer Link Settings</h2>
						<form action="options.php" role="form" method="POST">
							<?php
							settings_fields('bw_support_settings_group');
							$bw_support_show_credits = $this->options['bw_support_show_credits'];
							$bw_support_credits_type = $this->options['bw_support_credits_type'];
							$bw_support_credits_svg_color = $this->options['bw_support_credits_svg_color'];
							//print_r($bw_support_show_credits);
							?>
							<p>
								<label for="bw_support_show_credits"> Enable Footer Link? <br />
									<select name="bw_support_settings[bw_support_show_credits]" id="bw_support_show_credits" class="widefat">
										<option value="yes"  <?php echo ($bw_support_show_credits === "yes" ? 'selected': ''); ?>>Enable</option>
										<option value="no" <?php echo ($bw_support_show_credits === "no" ? 'selected': ''); ?>>Disable</option>
									</select>
								</label>
							</p>
							<div id="footer-credit-options" style="display: <?php echo ($bw_support_show_credits === "yes" ) ? "block" : "none";  ?>">
								<p>
									<label for="bw_support_credits_type">What Kind of Link?<br />
										<select name="bw_support_settings[bw_support_credits_type]" id="bw_support_credits_type" class="widefat">
											<option value="text"  <?php echo ($bw_support_credits_type === "text" ? 'selected': ''); ?>>Text Only</option>
											<option value="image" <?php echo ($bw_support_credits_type === "image" ? 'selected': ''); ?>>Text &amp; Logo</option>
										</select>
									</label>
								</p>
								<p id="bw_support_show_credits_logo_color" style="display: <?php echo ($bw_support_credits_type === "image" ) ? "block" : "none";  ?>">
									<label for="bw_support_credits_svg_color"><br />What Color Logo?
										<select name="bw_support_settings[bw_support_credits_svg_color]" id="bw_support_credits_svg_color" class="widefat">
											<option value="blue"  <?php echo ($bw_support_credits_svg_color === "blue" ? 'selected': ''); ?>>Blue</option>
											<option value="white" <?php echo ($bw_support_credits_svg_color === "white" ? 'selected': ''); ?>>White</option>
										</select>
									</label>
								</p>
							</div>
							<?php submit_button(); ?>
						</form>
					</div>
				</div>
			</div>

			<?php
		}

		public function display_footer_brand_credits() {
			$bw_settings = get_option( 'bw_support_settings' );
			$show_bw_credits = $bw_settings['bw_support_show_credits'];
			$bw_credits_type = $bw_settings['bw_support_credits_type'];
			$bw_credits_svg_color = $bw_settings['bw_support_credits_svg_color'];
			$relattr = '';
			if (!is_home() && !is_front_page()) {
				$relattr = "nofollow";
			}
			if ( $show_bw_credits === "yes" || $show_bw_credits != "no" ) {
				if ($bw_credits_type === "text") {
					$credits_html = '<div class="bestwebsite_footer_credits"><p>Another website by <a href="https://bestwebsite.com?referred_by='.get_site_url().'" target="_blank" rel="'.$relattr.'">Best Website Nashville</a></p></div>';
					echo $credits_html;
				} else if ($bw_credits_type === "image") {
					if ($bw_credits_svg_color === "blue") {
						$image = 'https://bestwebsite.com/assets/best-website-logo-blue.svg';
					} else {
						$image = 'https://bestwebsite.com/assets/best-website-logo-white.svg';
					}
					$credits_html = '<div class="bestwebsite_footer_credits"><p>Another website by <a class="bw-logo" href="https://bestwebsite.com?referred_by='.get_site_url().'" target="_blank" rel="'.$relattr.'"><img src="'.$image.'" height="25" width="94" style="width: auto; height: 25px;" alt="Best Website Nashville" /></a></p></div>';
					echo $credits_html;
				} else {
					$credits_html = '<div class="bestwebsite_footer_credits"><p>Another website by <a href="https://bestwebsite.com?referred_by='.get_site_url().'" target="_blank" rel="'.$relattr.'">Best Website Nashville</a></p></div>';
					echo $credits_html;
				}
			}
		}
	}
}
