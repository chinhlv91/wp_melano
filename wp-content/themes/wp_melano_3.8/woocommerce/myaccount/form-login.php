<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$options = get_option('ct_coo_options');

?>

<?php $woocommerce->show_messages(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<div class="my-account-login-wrap">
	
	<div class="col2-set" id="customer_login">
	
		<div class="col-1">
	
			<div class="login-wrap">
				<h4 class="lined-heading"><span><?php _e( 'Registered customers', 'cootheme' ); ?></span></h4>
				<form method="post" class="login">
					<p class="form-row form-row-first">
						<label for="username"><?php _e( 'Username or email', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" />
					</p>
					<p class="form-row form-row-last">
						<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" />
					</p>
					<div class="clear"></div>
		
					<p class="form-row">
						<?php $woocommerce->nonce_field('login', 'login') ?>
						<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
						<a class="lost_password" href="<?php
		
						$lost_password_page_id = woocommerce_get_page_id( 'lost_password' );
		
						if ( $lost_password_page_id )
							echo esc_url( get_permalink( $lost_password_page_id ) );
						else
							echo esc_url( wp_lostpassword_url( home_url() ) );
		
						?>"><?php _e( 'Lost Password?', 'woocommerce' ); ?></a>
					</p>
				</form>
			</div>
			
		</div>
		
		<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>
	
		<div class="col-2">
	
			<h4 class="lined-heading"><span><?php _e( 'Not registered? No problem', 'cootheme' ); ?></span></h4>
			
			<div class="new-user-text"><?php echo $options['checkout_new_account_text']; ?></div>
			
			<a class="ct-button ct-icon-reveal alt-button create-account-button" href="#create-account" data-toggle="modal"><i class="ss-compose"></i><span class="text"><?php _e('Create an account', 'cootheme'); ?></span></a>
							
			<div id="create-account" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="create-account-modal" aria-hidden="true">
				<div class="modal-dialog">
				    <div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ss-delete"></i></button>
							<h3 id="create-account-modal"><?php _e("Register", "cootheme"); ?></h3>
						</div>
						<div class="modal-body">
						
							<form method="post" class="register">
						
							<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>
				
								<p class="form-row form-row-first">
									<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
									<input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
								</p>
				
								<p class="form-row form-row-last">
				
							<?php else : ?>
				
								<p class="form-row form-row-wide">
				
							<?php endif; ?>
				
								<label for="reg_email"><?php _e( 'Email', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
							</p>
				
							<div class="clear"></div>
				
							<p class="form-row form-row-first">
								<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
							</p>
							<p class="form-row form-row-last">
								<label for="reg_password2"><?php _e( 'Re-enter password', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
							</p>
							<div class="clear"></div>
				
							<!-- Spam Trap -->
							<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
		
							<?php do_action( 'register_form' ); ?>
							
							<?php $woocommerce->nonce_field('register', 'register') ?>
							<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
							
							</form>					
						</div>
					</div>
				</div>
			</div>
	
		</div>
		
		<?php endif; ?>
		
	</div>

</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>