<?php get_header(); ?>

<?php
	$options = get_option('ct_coo_options');
	$default_page_heading_bg_alt = $options['default_page_heading_bg_alt'];
?>

<div class="row">
<div class="page-heading col-sm-12 clearfix alt-bg <?php echo $default_page_heading_bg_alt; ?>">
	<div class="heading-text">
		<h1><?php _e("404", "cootheme"); ?></h1>
	</div>
</div>
</div>

<div class="inner-page-wrap row has-right-sidebar has-one-sidebar clearfix">

	<article class="help-text col-sm-8">
		<?php _e("Sorry but we couldn't find the page you are looking for. Please check to make sure you've typed the URL correctly. You may also want to search for what you are looking for.", "cootheme"); ?>
		<form method="get" class="search-form" action="<?php echo home_url(); ?>/">
			<input type="text" placeholder="<?php _e("Search", "cootheme"); ?>" name="s" />
		</form>
		<a class="ct-button small accent slightlyroundedarrow" href="javascript:history.go(-1)" target="_self"><span><?php _e("Return to the previous page", "cootheme"); ?></span><span class="arrow"></span></a>
	</article>
	
	<aside class="sidebar right-sidebar col-sm-4">
		<?php dynamic_sidebar('Sidebar-1'); ?>
	</aside>
	
</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>