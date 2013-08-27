<?php
$this->add('post_view', array('PopularWidgetBundle', 'visit'));
$this->add('single_render', array('PopularWidgetBundle', 'getMostVisited'));
$this->add('index_render', array('PopularWidgetBundle', 'getMostVisited'));
$this->add('category_render', array('PopularWidgetBundle', 'getMostVisited'));
$this->add('tags_render', array('PopularWidgetBundle', 'getMostVisited'));
$this->add('page_render', array('PopularWidgetBundle', 'getMostVisited'));