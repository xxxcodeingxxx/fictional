<?php
/**
 * The template for displaying program archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fictional_University
 */

get_header();
pageBanner( array(
	'title' => 'All Programs',
	'subtitle' => 'Take a look at our curriculum.'
) );
?>

<div class="container container--narrow page-section">
  <ul class="link-list min-list">
<?php while(have_posts()) {
	the_post(); ?>
  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php }
echo paginate_links();
?>

</div>

<?php

get_footer();
