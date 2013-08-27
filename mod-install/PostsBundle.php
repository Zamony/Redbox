<?php
class PostsBundle{
	public $id=NULL;
	public $redis_mode;
	private $redis=NULL;
	private $hooks = NULL;
	public function __construct($services){
		$this->redis = $services['db'];
		$this->redis_mode = $services['db']::MULTI;
	}
	public function addOne($post){
		$this->id=$this->getMaxID() + 1;
		$post['id'] = $this->id;
		$post['time'] = time();
		$this->updateOne($post);
		$this->redis->set('posts:max_id', $post['id']);
	}
	public function updateOne($post){
		$post['url'] = $this->rusToLat($post['title']);
		$post['category_url'] = $this->rusToLat($post['category']);
		$tags = array_map(array(&$this, 'rusToLat'), explode(', ', $post['tags']));
		$this->redis->multi($this->redis_mode)
			->hMSet("post:{$this->id}", $post)
			->sAdd("posts:cat:{$post['category_url']}", $post['id'])
			->hSet('posts:url', $post['url'], $post['id'])
			->hSetNx('app:routes', '/'.$post['category_url'], '/posts/single/view')
			->exec();
		$all_tags = $this->redis->keys("posts:tag:*");
		foreach ($all_tags as $tag) $this->redis->sRem("posts:tag:$tag", $post['id']);
		foreach ($tags as $tag) $this->redis->sAdd("posts:tag:$tag", $post['id']);
	}
	public function deleteOne(){
		$id = $this->id;
		$cats = $this->redis->hmGet("post:{$this->id}", array('category_url', 'tags', 'url'));
		$category_url = $cats['category_url'];
		$tags = $cats['tags'];
		$tags = array_map(array(&$this, 'rusToLat'), explode(', ', $tags));
		$this->redis->multi($this->redis_mode)
			->sRem("posts:cat:$category_url", $id)
			->hDel('posts:url', $cats['url'])
			->del("post:$id")
			->exec();
		if (!$this->redis->sCard("posts:cat:$category_url")) $this->redis->hDel('app:routes', $cats['category_url']);
		foreach ($tags as $tag) $this->redis->sRem("posts:tag:$tag", $id);
	}
	public function getAll($limit = array(0, -1), $sort = 'desc'){
		list($start, $stop) = $limit;
		$posts = $this->redis->zRevRangeByScore('posts:publish', '+inf', '-inf');
		return $posts;
	}
	public function getAllFromTag($tag, $limit = array(0, -1), $sort = 'desc'){
		$posts = $this->redis->multi($this->redis_mode)
			->zInter('out', array("posts:tag:$tag", "posts:publish"), array(1, 1),'max')
			->zRevRangeByScore('out', '+inf', '-inf', array('limit'=>$limit))
			->exec();
		return end($posts);
	}
	public function getAllFromCategory($cat, $data, $limit = array(0, -1), $sort = 'desc'){
		$posts = $this->redis->multi($this->redis_mode)
			->zInter('out', array("posts:cat:$cat", "posts:publish"), array(1, 1),'max')
			->zRevRangeByScore('out', '+inf', '-inf', array('limit'=>$limit))
			->exec();
		return end($posts);
	}
	public function getPosts($posts, $data){
		foreach ($posts as &$post) $post = $this->redis->hMGet("post:$post", $data);
		return $posts;
	}

	//Get count of elements
	public function getTotalPublish(){
		return $this->redis->zCard("posts:publish");
	}
	public function getTotalUnpublish(){
		return $this->redis->zCard("posts:unpublish");
	}		
	public function getTotalByTag($tag){
		return end($this->redis->multi($this->redis_mode)
			->zInter('out', array("posts:tag:$tag", "posts:publish"), array(1, 1),'max')
			->zCard('out')
			->exec());
	}
	public function getTotalByCategory($cat){
		return end($this->redis->multi($this->redis_mode)
			->zInter('out', array("posts:cat:$cat", "posts:publish"), array(1, 1),'max')
			->zCard('out')
			->exec());
	}
	private function getMaxID(){
		if (!$this->redis->exists('posts:max_id'))
			$this->redis->set('posts:max_id', 0);
		return $this->redis->get('posts:max_id');
	}
	public function getAllCategories(){
		$prefix = 'posts:cat:';
		$fcat = $this->redis->keys($prefix.'*');
		$prefix = strlen($prefix);
		foreach ($fcat as &$cat)
			$cat = substr($cat, $prefix);
		return $fcat;
	}
	public function getAllTags(){
		$prefix = 'posts:tag:';
		$fcat = $this->redis->keys($prefix.'*');
		$prefix = strlen($prefix);
		foreach ($fcat as &$cat)
			$cat = substr($cat, $prefix);
		return $fcat;
	}
	public function getIdsByCategory($category){
		return $this->redis->sMembers("posts:categories:$category");
	}
	public function getIdsByTag($tag){
		return $this->redis->sMembers("posts:tags:$tag");
	}
	public function checkTitle($title){
		return $this->redis->hGet('posts:url', $title);
	}
	public function checkCategory($key){
		if ($this->redis->exists("posts:cat:$key")) return True; 
			else return False;
	}
	public function checkTag($tag){
		if ($this->redis->exists("posts:tag:$tag")) return True;
		else return False;
	}
	public function publish($time_change = False){
		$time = !$time_change ? $this->redis->hGet("post:{$this->id}", 'time') : time();
		$this->redis->multi($this->redis_mode)
				->zRem('posts:unpublish', $this->id)
				->zAdd('posts:publish', $time, $this->id)
				->hSet("post:{$this->id}", 'publish', 1)
				->exec();
	}
	public function unpublish(){
		$time = $this->redis->hGet("post:{$this->id}", 'time');
		$this->redis->multi($this->redis_mode)
				->zRem('posts:publish', $this->id)
				->zAdd('posts:unpublish', $time, $this->id)
				->hSet("post:{$this->id}", 'publish', 0)
				->exec();
	}
	public function rusToLat($str){
	    $tr = array(
	    	"а"=>"a","б"=>"b",
	        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
	        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
	        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
	        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
	        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
	        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
	        " "=> "-", "."=> "", "/"=> "_","?"=>"","!"=>"",":"=>""
	    );
	    return strtr(mb_strtolower($str, 'utf8'),$tr);
	}
}