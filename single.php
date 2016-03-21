<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<div role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
		<?php 
		$cover = array(
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => 1,
			'tax_query'	=> array(
		        array(
		            'taxonomy'  => 'classification',
		            'field'     => 'slug',
		            'terms'     => 'covers'
		            )
		            ),
		);
		$cover_info = get_posts($cover);

		if ($cover_info) {
			foreach ($cover_info as $sealcover) {
				$attcover_full   = wp_get_attachment_image_src($sealcover->ID,'full');	
			}
		}
		?>

		<article <?php post_class('row expanded') ?> id="post-<?php the_ID(); ?>">
		<h1 id="fattext" class="text-center"><?php the_title(); ?></h1>
			<header class="row typo-large">
			<div class="large-12 columns">
			<?php the_content(); ?>
			</div>
			</header>
<?php if ($attcover_full) { ?>
<div class="wrapper CoverImage FlexEmbed FlexEmbed--16by9" style="background-image:url(<?php echo $attcover_full[0]; ?>);" ></div>
<?php } ?>
<div class="wrapper" id="items">
<div class="row expanded">
<div class="large-2 large-push-10 columns show-for-large" data-sticky-container>
<nav class="columns sticky" data-sticky data-anchor="items" data-options="marginTop:4;anchor:items;" data-btm-anchor="items:bottom" data-margin-top="4" data-margin-bottom="0" data-sticky-on="large">
<?php the_post_thumbnail('full'); ?>
<?php 
				$args = array(
					'orderby'          => 'rand',
					'post_type'      => 'attachment',
					'post_parent'    => $post->ID,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => -1,
					'tax_query'	=> array(
				        array(
				            'taxonomy'  => 'classification',
				            'field'     => 'slug',
				            'terms'     => 'items',
				            'operator'  => 'IN')
				            ),
				);
				$attachments = get_posts($args);
				?>


<ul class="vertical menu" data-magellan data-threshold="100">

				<?php
				if ($attachments) {
					foreach ($attachments as $attachment) {
						$dest_title = apply_filters('the_title', $attachment->post_title);
						$destattslug = sanitize_title($dest_title);

						echo '<li><a href="#'.$destattslug.'-item-'.$attachment->ID.'">'.$dest_title.'</a></li>';
				}
			}
				?>
</ul>
</nav>
</div>

<div class="medium-12 large-10 large-pull-2 columns">
<?php 
if ($attachments) {
    foreach ($attachments as $attachment) {

	$img = wp_get_attachment_thumb_url($attachment->ID);
	$title = get_the_title($attachment->post_parent);
	$attimg_th = wp_get_attachment_image_src($attachment->ID,'thumbnail');
	$attimg_medium = wp_get_attachment_image_src($attachment->ID,'medium');
    $attimg_large = wp_get_attachment_image_src($attachment->ID,'large');
    $attimg_full = wp_get_attachment_image_src($attachment->ID,'full');
	$atturl = wp_get_attachment_url($attachment->ID);
	$attlink = get_attachment_link($attachment->ID);
	$atttitle = apply_filters('the_title',$attachment->post_title);
	$attslug = sanitize_title($atttitle);
	$parent_id = $attachment->post_parent;
	$parent_title = get_the_title( $parent_id );
	$parent_permalink = get_permalink( $parent_id );
	$detail1_th = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'thumbnail');
	$detail2_th = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'thumbnail');
	$detail3_th = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'thumbnail');
	$detail1_large = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'large');
	$detail2_large = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'large');
	$detail3_large = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'large');
	$detail1_full = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'full');
	$detail2_full = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'full');
	$detail3_full = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'full');
	
        echo '<div id="'.$attslug.'-item-'.$attachment->ID.'" data-magellan-target="'.$attslug.'-item-'.$attachment->ID.'" class="typo-large">';
        echo '<h3 class="typo-large">'.$atttitle.'</h3>';
        echo apply_filters('the_title', $attachment->post_content);
        echo '<ul class="no-bullet">';
        echo '<li><img src="'.$attimg_full[0].'" alt="'.$atttitle.'"/></li>';
	if ($detail1_th) {echo '<li><img src="'.$detail1_large[0].'" alt="'.$atttitle.'" /></li>'; }
	if ($detail2_th) {echo '<li><img src="'.$detail2_large[0].'" alt="'.$atttitle.'" /></li>'; }
	if ($detail3_th) {echo '<li><img src="'.$detail3_large[0].'" alt="'.$atttitle.'" /></li>'; }
        echo '</ul>';
        echo '</div><hr />';
    }
 
} ?>
</div>
</div>
</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>	
			</footer>

		</article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>
<?php get_footer();
