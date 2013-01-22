<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		
		// Decode URL
		if (isset($this->request->get['_route_'])) {

         if ($this->config->get('blogSetting_virDirName')) {
            $blogVirtualDir = $this->config->get('blogSetting_virDirName');
         } else {
            $blogVirtualDir = 'blog';
         }
         
			$parts = explode('/', $this->request->get['_route_']);
			
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					

         if ($url[0] == 'blog_article_id') {
            $this->request->get['article_id'] = $url[1];
         }
         if ($url[0] == 'blog_category_id') {
            if (!isset($this->request->get['category_id'])) {
               $this->request->get['category_id'] = $url[1];
            } else {
               $this->request->get['category_id'] .= '_' . $url[1];
            }
         }
         
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}	
				} else {
					$this->request->get['route'] = 'error/not_found';	
				}
			}
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';

         } elseif ($this->request->get['_route_'] == $blogVirtualDir || $this->request->get['_route_'] == $blogVirtualDir . '/') {
            $this->request->get['route'] = 'blog/category/home';
         } elseif (isset($this->request->get['article_id'])) {
            $this->request->get['route'] = 'blog/article';
         } elseif (isset($this->request->get['category_id'])) {
            $this->request->get['route'] = 'blog/category';
         
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer/info';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			}
			
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}
	
	public function rewrite($link) {
		if ($this->config->get('config_seo_url')) {

         if ($this->config->get('blogSetting_virDirName')) {
            $blogVirtualDir = $this->config->get('blogSetting_virDirName');
         } else {
            $blogVirtualDir = 'blog';
         }
         
			$url_data = parse_url(str_replace('&amp;', '&', $link));
		
			$url = ''; 
			
			$data = array();
			
			if (isset($url_data['query'])) { parse_str($url_data['query'], $data); }
			
			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
					
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
							
							unset($data[$key]);
						}					

         } elseif (isset($data['route']) && $data['route'] == 'blog/category/home') {
            $url .= '/' . $blogVirtualDir;
            unset($data['route']);
            
         } elseif ($key == 'article_id') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'blog_" . $this->db->escape($key . '=' . (int)$value) . "'");
            
            if($this->config->get('blogSetting_virDir')) { 
               $url .= '/' . $blogVirtualDir;
            }
            
            if ($query->num_rows) {
               $url .= '/' . $query->row['keyword'];
               $article_url = '/' . $query->row['keyword'];
            }
            unset($data[$key]);

         } elseif ($key == 'category_id') {
            $categories = explode('_', $value);
            $excludeCat = explode(',', $this->config->get('blogSetting_virDirExclude'));
            
            if($this->config->get('blogSetting_virDir')) {
               if (!in_array($categories[0], $excludeCat)) {
                  $url .= '/' . $blogVirtualDir;
               }
            }
            
            foreach ($categories as $category) {
               $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'blog_category_id=" . (int)$category . "'");
               if ($query->num_rows) {
                  $url .= '/' . $query->row['keyword'];
                  $category_url = $url;
               }
            }
            unset($data[$key]);
         
					} elseif ($key == 'path') {
						$categories = explode('_', $value);
						
						foreach ($categories as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
					
							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}							
						}
						
						unset($data[$key]);
					}
				}
			}
		

         if (isset($article_url) && $article_url && isset($category_url) && $category_url) {
            $url = $category_url . $article_url;
         }
         
			if ($url) {
				unset($data['route']);
			
				$query = '';
			
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					}
					
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				}

				return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query;
			} else {
				return $link;
			}
		} else {
			return $link;
		}		
	}	
}
?>