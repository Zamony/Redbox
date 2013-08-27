<div class="feed cf">
  <section>
    <h3>Тайтл</h3>
    <?php foreach($options['posts'] as $post): ?>
    <article class="thumb-medium">
      <a href="http://<?php echo $options['home'].$post['category_url'].'/'.$post['url']; ?>" title="Подробнее">
        <?php if ($post['preview'] and file_exists("shared/{$post['preview']}")) :?>
        <img src="http://<?php echo "{$options['home']}shared/{$post['preview']}";?>">
        <?php endif; ?>
      </a>
      <span class="genre"><a href="http://<?php echo $options['home'].$post['category_url']; ?>">
        <?php echo $post['category']?>
      </a></span>
      <h4><a href="http://<?php echo "{$options['home']}{$post['category_url']}/{$post['url']}";?>" title="Подробнее"><?php echo $post['title']; ?></a></h4>
      <p><?php echo $post['content']; ?></p>
      <span class="date"><?php echo $post['time']; ?></span>
    </article>
    <?php endforeach; ?>
    <?php if (isset($_GET['page']) and $options['total']>sizeof($options['posts'])) pagenavi($_GET['page'], $options['total'], 8); ?>
  </section>
  <aside>
    <div class="popular">
      <div class="popular">
            <h3>Рекомендуем</h3>
            <?php foreach ($options['popular'] as $mpost): ?>
            <article class="thumb-little cf">
              <a href="http://<?php echo $options['home'].$mpost['category_url'].'/'.$mpost['url']; ?>" title="Подробнее">
                <img height="50" width="50" alt="<?php echo $mpost['title']; ?>" src="http://<?php echo $options['home'].'/shared/'.$mpost['preview']?>">
              </a>
              <h4><a title="Подробнее" href="http://<?php echo $options['home'].$mpost['category_url'].'/'.$mpost['url']; ?>"><?php echo $mpost['title'];?></a></h4>
              <p><?php echo post_excerpt($mpost['content']); ?></p>
            </article>
          <?php endforeach; ?>
      </div>
    </div>
  </aside>
</div>
</div>