<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('blogpost-entry seal small-4 medium-2 large-2'); ?>>
<a class="alpha" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

		<?php the_post_thumbnail('full'); ?>
			
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
				$attcover_med  = wp_get_attachment_image_src($sealcover->ID,'medium');	
				echo '<img src="';
				echo $attcover_med[0];
				echo '" alt="" />';
			}
		}
		?>
		</a>
</div>
