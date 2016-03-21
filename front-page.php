<?php

get_header(); ?>
    <?php
$count_posts = baw_count_posts( 'post' );
$published_posts = $count_posts->publish;
?>
  <?php $all_items = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'publish',
    'numberposts' => -1,
        'tax_query' => array(
                array(
            'taxonomy'  => 'classification',
            'field'     => 'slug',
            'terms'     => array('details', 'items', 'covers', 'logotypes'),
            'operator'  => 'IN')
            ),
);  
$all_items_loop = get_posts($all_items);
$count_items = count($all_items_loop);
?>
<div class="row expanded CoverImage FlexEmbed FlexEmbed--16by9 alphalayer" style="background-image:url(<?php pg_medias_random_item_selected_src(); ?>);" >
	<div class="top-centered block padded">
	<h1 id="fattext" class="large-text-center text-white hide-for-small-only">
	<?php echo __('The PG Guide', 'FoundationPress'); ?>
	</h1>
	<h2 class="large-text-center text-white"><span><em><?php echo $published_posts; ?></em> </span><em><?php echo __('Seals of Quality', 'FoundationPress'); ?></em></span></h2>
<h4 class="large-text-center text-white">Une sélection de <a href="https://parisiangentleman.fr/" title="parisiangentleman.fr">Parisian Gentleman;</a></h4>
</div>
</div>
<div role="main" class="isotope-wrapper bg-red">
	<article class="main-content grid-isotope-seals row expanded">

    <?php

    $recentPosts = new WP_Query();

    $args_sticky = array(

    'posts_per_page'      => 1,
    'numberposts'    => 1,
    'post__in'            => get_option( 'sticky_posts' ),
    'ignore_sticky_posts' => 1,

    );

    $recentPosts->query($args_sticky);

    while ($recentPosts->have_posts()) : $recentPosts->the_post();

    ?>
<?php
     $defaults = array(
            'post_type'      => 'attachment',
            'post_parent'    => $post->ID,
            'post_mime_type' => 'image',
            'post_status'    => 'publish',
            'orderby' => 'rand',
            'numberposts'    => 1,
            'tax_query' => array(
                array(
                    'taxonomy'  => 'classification',
                    'field'     => 'slug',
                    'terms'     => 'items'
                    )
                    ),
        );
        $cover_info = get_posts($defaults);

        if ($cover_info) {
            foreach ($cover_info as $sealcover) {
                $attcover_large  = wp_get_attachment_image_src($sealcover->ID,'large');  
            }
        }
?>

<div class="small-12 medium-6 large-6 stamp seal">
<a class="text-white alpha" href="<?php the_permalink(); ?>" title="Voir <?php the_title_attribute(); ?>">
	<div class="row expanded CoverImage FlexEmbed FlexEmbed--2by1 alphalayer" style="background-image:url(<?php echo $attcover_large[0]; ?>);">
	<div class="small-4 medium-6 large-8 columns"></div>
	<div class="small-8 medium-6 large-4 columns">
	<br />
	   <div class="top-centered text-center block">
            <p class="lead">Featuring:</p>
            
		   <h3 id="fattext-bis" class="text-center"><?php the_title(); ?></h3>

	   </div>
	   </div>
    </div>
    </a>
 </div>  
    <?php endwhile; ?>

<?php wp_reset_postdata(); ?>

	<?php if ( have_posts() ) : ?>
		<?php $args_seals = array (
            'orderby' => 'rand',
            'post__not_in' => get_option('sticky_posts')
        );?>
		<?php query_posts($args_seals); ?>
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; // End have_posts() check. ?>

		<?php /* Display navigation to next/previous pages when applicable */ ?>
		<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>
			<nav id="post-nav">
				<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
				<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
			</nav>
		<?php } ?>

	</article>

</div>

<?php get_footer();
