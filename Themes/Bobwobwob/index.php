      <div class="feed cf">
        <section class="cf">
          <h3>Новое</h3>
          <?php foreach($options['posts'] as $post):?>
          <article class="thumb-medium">
          	<a href="<?php echo $post['url']; ?>" title="Подробнее"><?php if ($post['preview']):?>
              <img src="<?php echo $post['preview']; ?>">
              <?php else:?>
              <img src="<?php echo $options['home'].'Themes/Bobwobwob/assets/img/265x149.gif'; ?>">
            </a>
            <span class="genre"><a href="<?php echo $options['home'].'/'.$post['category']; ?>"><?php echo $category[0]->cat_name; ?></a></span>
            <p><?php custom_excerpt(110); ?></p>
            <span class="date"><?php the_time('j F Y'); ?></span>
          </article>
          <?php endforeach; ?>
        <?php if (function_exists('pagenavi')) pagenavi(); ?>
        </section>
        <aside>
          <div class="popular">
            <h3>Рекомендуем</h3>
            <?php query_posts('cat=35&posts_per_page=5&sort=DESC'); ?>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php $category = get_the_category(); ?>
            <article class="thumb-little cf">
              <a href="<?php the_permalink(); ?>" title="Подробнее"><?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail'); } else { echo '<img src="'; bloginfo('template_url'); echo '/assets/img/50x50.gif">'; } ?></a>
              <h4><a href="<?php echo home_url(); echo ('/category/'.$category[0]->slug.'/'); ?>"><?php echo $category[0]->cat_name; ?></a><span class="divider">→</span><a href="<?php the_permalink(); ?>" title="Подробнее"><?php the_title(); ?></a></h4>
              <p><?php custom_excerpt(100); ?></p>
            </article>
            <?php endwhile; endif; ?>
          </div>
          <?php if (is_active_sidebar('main-sidebar')) {
            dynamic_sidebar('main-sidebar');
          } ?>
        </aside>
      </div>
    </div>