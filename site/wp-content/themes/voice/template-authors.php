<?php
/**
 * Template Name: Authors
 */
?>
<?php get_header(); ?>

<div id="content" class="container site-content">

	<?php global $vce_sidebar_opts; ?>
	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'left' ) { get_sidebar(); } ?>

	<div id="primary" class="vce-main-content">

		<div class="main-box">

			<div class="main-box-head">
				<h1 class="main-box-title"><?php the_title(); ?></h1>
			</div>

			<div class="main-box-inside">
			
			<?php
				//Detect only authors which have at least one post 
				$ids = get_users(array('fields' => 'ID', 'who' => 'authors'));
				$users_posts = count_many_users_posts( $ids, 'post');
				$users_with_posts = array_filter($users_posts);
			?>

			<?php $author_args = array( 'include' => array_keys($users_with_posts), 'order' => 'DESC', 'orderby' => 'post_count', 'fields' => 'ID' );
				  $authors = get_users( $author_args );
				  foreach ( $authors as $author ) : ?>
				 
				  <div class="vce-author-card">
						<div class="data-image">
							<?php echo get_avatar( $author, 112 ); ?>
						</div>
						<div class="data-content">
							<h4 class="author-title"><?php the_author_meta( 'display_name', $author ); ?></h4>
							<div class="data-entry-content">
								<?php echo wpautop( get_the_author_meta( 'description', $author ) ); ?>
							</div>
						</div>

						<div class="vce-content-outside">
							<div class="data-links">
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID', $author ) ); ?>" class="vce-author-link vce-button"><?php echo __vce( 'view_all_posts' ); ?></a>
							</div>
							<div class="vce-author-links">
								<?php if ( get_the_author_meta( 'url', $author ) ) {?> <a href="<?php the_author_meta( 'url', $author ); ?>" target="_blank" class="fa fa-link vce-author-website"></a><?php } ?>
								<?php $user_social = vce_get_social(); ?>
								<?php foreach ( $user_social as $soc_id => $soc_name ): ?>
									<?php if ( $social_meta = get_the_author_meta( $soc_id, $author ) ) : ?>
										<a href="<?php echo $social_meta; ?>" target="_blank" class="fa fa-<?php echo $soc_id.' soc_squared'; ?>"></a>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>

		</div>

	</div>

	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'right' ) { get_sidebar(); } ?>

</div>

<?php get_footer(); ?>