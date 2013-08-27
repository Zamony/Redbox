<?php

function dashboard_menu($menu){
  $dmenu = '
  <div class="navbar navbar-inverse">
     <div class="container">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
          </button>
          <a href="#" class="navbar-brand"></a>
          <div class="nav-collapse collapse navbar-responsive-collapse">
          <ul class="nav navbar-nav pull-left">
          <li><a href="/"><<<</a></li></ul>
            <ul class="nav navbar-nav pull-right">
  ';
   $menu = array_reverse(json_decode($menu, True));
   foreach ($menu as $menu_title => $menu_link){
      if (is_array($menu_link)){
         $dmenu .= '
         <li class="dropdown">
         <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#">'.$menu_title.'<b class="caret"></b></a>';
         $dmenu .= '<ul aria-labelledby="drop3" role="menu" class="dropdown-menu">';
         foreach ($menu_link as $mt=>$ml)
         $dmenu .= '<li role="presentation"><a href="'.$ml.'" tabindex="-1" role="menuitem">'.$mt.'</a></li>';
         $dmenu .='</ul></li>';
      }else $dmenu .= "<li><a href=\"$menu_link\">$menu_title</a></li>";
   }
  $dmenu .= '</ul></div></div></div>';
  return $dmenu;
}

function dashboard_pagenavi($page, $total, $per_page) 
{
  $a['page'] = (int) $page;
  $a['total'] = $total;
  $a['per_page'] = $per_page;
  $a['count'] =  (int) ceil($total/$per_page);
  $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
  $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
  $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
  $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"
  if ($a['count']>1) echo '<div class="col-lg-6 col-offset-3 text-center">';
  echo dashboard_paginate_links($a);
  if ($a['count']>1) echo '</div>';
}
function dashboard_paginate_links($pg){
  $url = $_SERVER['REQUEST_URI'];
  $suffix = explode('?', $url, 2)[0];
  echo "<ul class='pagination'>";
  if ($pg['page'] !== 1)
    echo '<li><a href="'.$suffix.'?page='.($pg['page']-1).'" class="prev">'.$pg['prev_text'].'</a></li>';
  if ($pg['page']-$pg['mid_size']>0){
    for ($i=($pg['page']-$pg['mid_size']); $i!=$pg['page']; $i++)
      echo '<li><a href="'.$suffix.'?page='.$i.'">'.$i.'</a></li>';
  }else{
    for ($i=1; $i!=$pg['page']; $i++)
      echo '<li><a href="'.$suffix.'?page='.$i.'">'.$i.'</a></li>';
  }
  echo "<li><span class=\"current\">{$pg['page']}</span></li>";
  if ($pg['page']+$pg['mid_size']<$pg['count']){
    for ($i=0; $i<$pg['mid_size']; $i++)
      echo '<li><a href="'.$suffix.'?page='.$i.'">'.$link.'</a></li>';
  }else{
    for ($i=$pg['page'], $page=($pg['page']+1); $i!=$pg['count']; $i++, $page++)
      echo '<li><a href="'.$suffix.'?page='.$page.'">'.$page.'</a></li>';
  }
  if ($pg['page'] !== $pg['count'])
    echo '<li><a href="'.$suffix.'?page='.($pg['page']+1).'" class="next">'.$pg['next_text'].'</a></li>';
  echo "</ul>";
}

function print_error($msg = "Something went wrong...", $title = "Error!"){
  echo '<div class="alert alert-danger"><strong>'.$title.'</strong>'.$msg.'</div>';
}

function print_error_exit($msg = "Something went wrong...", $title = "Error!"){
  echo '<div class="alert alert-danger"><strong>'.$title.'</strong>'.$msg.'</div>';
  exit();
}

function print_warning($msg = "Something went wrong...", $title = "Warning!"){
  echo '<div class="alert alert-warning"><strong>'.$title.'</strong>'.$msg.'</div>';
}

function print_info($msg, $title = "Information."){
  echo '<div class="alert alert-info"><strong>'.$title.'</strong>'.$msg.'</div>';
}

function print_success($msg, $title = "Success!"){
  echo '<div class="alert alert-success"><strong>'.$title.'</strong>'.$msg.'</div>';
}