<?php get_header(); ?>

<main>
  <div class="container">
    <h1>Accueil</h1>
    <h2 class="screen-reader-text">Nos actualités</h2>
    <section class="posts-container">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
          <div class="card">
            <div class="top">
							<?php the_post_thumbnail('full'); ?>
            </div>
            <div class="bot">
              <h3><?php the_title(); ?></h3>
              <div><?php the_excerpt(); ?></div>
              <a href="<?php the_permalink(); ?>">Lire la suite</a>
            </div>
          </div>
				<?php endwhile; ?>
			<?php endif; ?> 
    </section>
  </div>
</main>
<?php get_footer(); ?>
