<?php get_header(); ?>

<div id="content">
	<?php if ( wptouch_have_posts() ) { ?>
		<?php wptouch_the_post(); ?>

		<div id="title-area" class="box <?php if ( has_post_thumbnail() && classic_should_show_thumbnail() ) { echo 'show-thumbnails'; } ?>">
			<?php if ( classic_should_show_thumbnail() ) { ?>
			<div class="icon-area">
				<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large' ); ?>
			</div>
			<?php } ?>
			<h2 class="post-title"><?php the_title(); ?></h2>
			<div class="post-meta">
				<?php if ( classic_should_show_date() ) { ?>
					<div class="time"><i class="icon-time"></i> <?php wptouch_the_time(); ?></div>
				<?php } if ( classic_should_show_author() ) { ?>
					<div class="author"><i class="icon-user"></i> <?php echo sprintf( __( 'Written by %s', 'wptouch-pro' ), get_the_author() ); ?></div>
				<?php } ?>
			</div>
		</div>

		<div id="content-area" class="<?php wptouch_post_classes(); ?> box">
			<?php wptouch_the_content(); ?>
		</div>
		
		<?php get_template_part( 'related-posts' ); ?>
		<?php get_template_part( 'nav-bar' ); ?>

		<p align="center">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- PoderPDA BoxBanner Mobile Footer 2014 -->
			<ins class="adsbygoogle"
			style="display:inline-block;width:300px;height:250px"
			data-ad-client="ca-pub-0579069280875606"
			data-ad-slot="2421027476"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		</p>

		<div id="comments">
			<?php comments_template(); ?>
		</div>

	<?php } ?>
</div>

<?php get_footer(); ?>
