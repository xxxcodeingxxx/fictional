<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fictional_University
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="container">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			fictionaluniversity_posted_on();
			fictionaluniversity_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
</div> <!-- end of container -->
<div class="row">
	<div class="col-6 float-left">
		<?php the_post_thumbnail('professorPortrait'); ?>
	</div>
	<div class="col-6 float-right">
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div> <!-- end of row -->
	</div>
</div>
	<footer class="entry-footer">
		<?php fictionaluniversity_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
