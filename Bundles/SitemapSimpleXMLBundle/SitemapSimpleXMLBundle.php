<?php
class SitemapSimpleXMLBundle{
	private $db = NULL;
	public function __construct($services){
		$this->db = $services['db'];
	}
	public function sitemapAddURL($data){
		if (!$data['publish']) return;
		$durl = $this->db->hGet('app:info', 'url');
		$post_url = $this->db->hMGet("post:{$data['id']}", array('category_url', 'url'));
		$durl .= implode('/', $post_url);
		$urlset = simplexml_load_file('./sitemap.xml');
		$url = $urlset->addChild('url');
		$url->addChild('loc', $durl);
		file_put_contents('./sitemap.xml', $urlset->asXML());
	}
}