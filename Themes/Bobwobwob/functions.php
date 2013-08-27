<?php

// Постраничная навигация
function pagenavi($page, $total, $per_page) 
{
  $a['page'] = $page;
  $a['total'] = $total;
  $a['per_page'] = $per_page;
  $a['count'] =  (int) ceil($total/$per_page);
  $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
  $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
  $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
  $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"
  if ($a['count']>1) echo '<div class="pagination">';
  echo paginate_links($a);
  if ($a['count']>1) echo '</div>';
}
function paginate_links($pg){
  $url = $_SERVER['REQUEST_URI'];
  $suffix = preg_replace('/\/page[0-9]$/', '', $url);
  $suffix = $suffix === '/' ? '' : $suffix;
  echo "<ul>";
  if ($pg['page'] !== 1)
    echo '<li><a href="'.$suffix.'/page'.($pg['page']-1).'" class="prev">'.$pg['prev_text'].'</a></li>';
  if ($pg['page']-$pg['mid_size']>0){
    for ($i=($pg['page']-$pg['mid_size']); $i!=$pg['page']; $i++)
      echo '<li><a href="'.$suffix.'/page'.$i.'">'.$i.'</a></li>';
  }else{
    for ($i=1; $i!=$pg['page']; $i++)
      echo '<li><a href="'.$suffix.'/page'.$i.'">'.$i.'</a></li>';
  }
  echo "<li><span class=\"current\">{$pg['page']}</span></li>";
  if ($pg['page']+$pg['mid_size']<$pg['count']){
    for ($i=0; $i<$pg['mid_size']; $i++)
      echo '<li><a href="'.$suffix.'/page'.$i.'">'.$link.'</a></li>';
  }else{
    for ($i=$pg['page'], $page=($pg['page']+1); $i!=$pg['count']; $i++, $page++)
      echo '<li><a href="'.$suffix.'/page'.$page.'">'.$page.'</a></li>';
  }
  if ($pg['page'] !== $pg['count'])
    echo '<li><a href="'.$suffix.'/page'.($pg['page']+1).'" class="next">'.$pg['next_text'].'</a></li>';
  echo "</ul>";
}