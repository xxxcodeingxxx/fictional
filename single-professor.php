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
						<?php
						$likeCount = new WP_Query(array(
							'post_type' => 'like',
							'meta_query' => array(
								array(
									'key' => 'liked_professor_id',
									'compare' => '=',
									'value' => get_the_ID()
								)
							)
						));

						$existStatus = 'no';

						if (is_user_logged_in()) {
							$existingLikes = new WP_Query(array(
								'author' => get_current_user_id(),
								'post_type' => 'like',
								'meta_query' => array(
									array(
										'key' => 'liked_professor_id',
										'compare' => '=',
										'value' => get_the_ID()
									)
								)
							));

							if ($existingLikes->found_posts) {
								$existStatus = 'yes';
							}
						}



						?>

						<span class="like-box" data-like="<?php echo $existingLikes->posts[0]->ID; ?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">
							<i class="fa fa-heart-o" aria-hidden="true"></i>
							<i class="fa fa-heart" aria-hidden="true"></i>
							<span class="like-count"><?php echo $likeCount->found_posts; ?></span>
						</span>
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
