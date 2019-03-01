<?php
/**
 * The template for displaying all single events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-event
 *
 * @package Fictional_University
 */

get_header();
?>
		<?php
		while ( have_posts() ) :
			the_post(); ?>
			<div class="page-banner">
			<div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
			<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
			<div class="page-banner__intro">
				<p>Don't forget to replace me!</p>
			</div>
			</div>
			</div>

			<div class="container container--narrow page-section">
				<div class="metabox metabox--position-up metabox--with-home-link">
					<p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'event' ); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home </a>
						<span class="metabox__main"><?php the_title(); ?></p></span></p>
				</div>
			<div class="generic-content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php
		// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
<?php

get_footer();
