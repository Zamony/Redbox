<div class="content cf">
  <section>
    <h1><?php echo $options['title']; ?></h1>
    <p><?php echo $options['content']; ?></p>
    <div class="post-info">
      <span class="tag">Редактировалось <?php echo date('d.m.Y', $options['time']); ?>, метки:
        <?php foreach($options['tags'] as $tag):?>
          <a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tags/<?php echo $options['tags_url'][$tag]; ?>" rel="tag">
            <?php echo $tag; ?>
          </a>,
        <?php endforeach;?>
      </span>
      <div class="navpost cf">
        <div class="prev"><a href="#" rel="prev">← Предыдущий пост</a></div>
        <div class="next"></div>
      </div>
    </div>
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