<?php
/**
 * The template for displaying all single professors
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-professor
 *
 * @package Fictional_University
 */

get_header();
?>
		<?php
		while ( have_posts() ) :
			the_post();
			pageBanner();
			?>
			<div class="container container--narrow page-section">

			<div class="generic-content">
				<div class="row group">
					<div class="one-third">
						<?php the_post_thumbnail( 'professorPortrait' ); ?>
					</div>
					<div class="two-thirds">
						<?php the_content(); ?>
					</div>
				</div>
			</div>

			<?php

			$relatedPrograms = get_field( 'related_programs' );

			if ( $relatedPrograms ) {

				echo '<hr class="section-break">';
				echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
				echo '<ul class="link-list min-list">';
				foreach( $relatedPrograms as $program ) { ?>
					<li><a href="<?php echo get_the_permalink( $program ); ?>"><?php echo get_the_title( $program ); ?></a></li>
			<?php	}
			echo '</ul>';

			}
 ?>

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
