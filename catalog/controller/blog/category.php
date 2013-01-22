<?php  
class ControllerBlogCategory extends Controller {
   public function index() {
      $this->load->model('blog/setting');
      $this->load->model('blog/article');
      $this->load->model('blog/category');
      $this->data = $this->language->load('blog/blog');
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog.css')) {
         $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
      } else {
         $this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
      }
      
      $blogSetting = $this->model_blog_setting->getSettings();
      
      // Redirect page if Blog Manager is not installed
      if (!isset($blogSetting['blogName'])) { $this->redirect($this->url->link('common/home')); }
      
      if (isset($this->request->get['page'])) {
         $page = $this->request->get['page'];
      } else { 
         $page = 1;
      }
      $limit = $blogSetting['articleCat'];

      $this->data['breadcrumbs'] = array();
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home'),
         'separator' => false
      );
      
      if (isset($this->request->get['category_id'])) {      
         $parts      = explode('_', (string)$this->request->get['category_id']);

         if (!isset($blogSetting['virDir']) || $blogSetting['virDir']) {
            if (isset($blogSetting['virDirExclude']) && $blogSetting['virDirExclude']) {
               $excludeCat = explode(',', $blogSetting['virDirExclude']);
            } else {
               $excludeCat = array();
            }
            
            if (!in_array($parts[0], $excludeCat)) {
               $this->data['breadcrumbs'][] = array(
                  'text'      => $this->language->get('text_blog'),
                  'href'      => $this->url->link('blog/category/home'),
                  'separator' => $this->language->get('text_separator')
               );
            }
         }
      
         $path       = '';
         foreach ($parts as $path_id) {
            if (!$path) {
               $path = $path_id;
            } else {
               $path .= '_' . $path_id;
            }
            
            $categoryData = $this->model_blog_category->getCategory($path_id);
            if ($categoryData) {
               $this->data['breadcrumbs'][] = array(
                  'text'      => $categoryData['name'],
                  'href'      => $this->url->link('blog/category', 'category_id=' . $path),
                  'separator' => $this->language->get('text_separator')
               );
            }
         }     
      
         $category_id = array_pop($parts);
      } else {
         $this->redirect($this->url->link('blog/category/home'));
      }

      $categoryData = $this->model_blog_category->getCategory($category_id);
      
      if ($categoryData) {
         $this->load->model('tool/image');
         
         $this->document->setTitle($categoryData['name']);
         $this->document->setKeywords($categoryData['meta_keyword']);
         $this->document->setDescription($categoryData['meta_description']);
         
         $this->data['suffix']            = $categoryData['suffix'];
         $this->data['heading_title']     = $categoryData['name'];
         $this->data['catImage']          = $this->model_tool_image->resize($categoryData['image'], $blogSetting['articleFeatWidth'], $blogSetting['articleFeatHeight']);
         $this->data['catDescription']    = html_entity_decode($categoryData['description'], ENT_QUOTES, 'UTF-8');
         
         if ($categoryData['desc_limit']) {
            $characterLimit = $categoryData['desc_limit'];
         } else {
            $characterLimit = $blogSetting['articleDesc'];
         }
         
         if ($categoryData['width'] && $categoryData['height']) {
            $imageWidth    = $categoryData['width'];
            $imageHeight   = $categoryData['height'];
         } else {
            $imageWidth    = $blogSetting['articleFeatWidth'];
            $imageHeight   = $blogSetting['articleFeatHeight'];
         }
         
         //== Child Category
         $this->data['categories'] = array();
         $results = $this->model_blog_category->getCategories($category_id);
         
         foreach ($results as $result) {
            $this->data['categories'][] = array(
               'name'  => $result['name'],
               'href'  => $this->url->link('blog/category', 'category_id=' . $this->request->get['category_id'] . '_' . $result['category_id'])
            );
         }
         
         $data = array(
            'filter_category_id'    => $category_id,
            'article_order'         => $categoryData['article_order'],
            'start'                 => ($page - 1) * $limit,
            'limit'                 => $limit
         );
         
         $catID = 'category_id=' . $this->request->get['category_id'];
         
         //== Article
         $article_total = $this->model_blog_article->getTotalArticles($data);
         $this->data['articles'] = array();
         $results = $this->model_blog_article->getArticles($data);
         
         if ($results) {
            foreach ($results as $result) {
               $catArticle = array();
               $catDisabled = array();
               $catDatas = $this->model_blog_article->getCategoriesByArticle($result['article_id']);
               foreach ($catDatas as $catData) {
                  $catArticle[]     = '<a href="' . $this->url->link('blog/category', 'category_id=' . $catData['category_id']) . '">'. $catData['name'] . '</a>';
                  $catDisabled[]    = $catData['category_id'];
               }
               
               if (isset($blogSetting['artInfoName'])) {
                  $art_infoName = sprintf($this->language->get('text_art_infoName'), $result['author']);
               } else {
                  $art_infoName = '';
               }
               if (isset($blogSetting['artInfoCategory'])) {
                  $art_infoCategory = sprintf($this->language->get('text_art_infoCategory'), implode(", ", $catArticle));
               } else {
                  $art_infoCategory = '';
               }
               if (isset($blogSetting['artInfoDate'])) {
                  $art_InfoDate = sprintf($this->language->get('text_art_InfoDate'), date($this->language->get('date_format'), strtotime($result['created'])));
               } else {
                  $art_InfoDate = '';
               }
               if ($blogSetting['commentStatus']) {
                  $groupDisabled = explode(',',$blogSetting['commentDisableGroup']);
                  if (array_intersect($catDisabled, $groupDisabled)) {
                     $comments = '';
                  } else {
                     $comments = sprintf($this->language->get('text_comments'), $this->model_blog_article->getTotalCommentsByArticleId($result['article_id']));
                  }
               } else { $comments = ''; }
               
               $separator = '<!--more-->';
               $short_desc = explode($separator, html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
               if(isset($short_desc[1])) {
                  $description = $short_desc[0];
               } else {
                  $description = $this->truncate(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), $characterLimit);
               }
               
               $this->data['articles'][] = array(
                  'articlet_id'        => $result['article_id'],
                  'title'              => $result['title'],
                  'modified'           => date($this->language->get('date_format'), strtotime($result['modified'])),
                  'description'        => strip_tags($description,'<b><i><em><u><a><strong><p><strike><div><span><ul><ol><li><br>'),
                  'image'              => $this->model_tool_image->resize($result['image'], $imageWidth, $imageHeight),
                  'comments'           => $comments,
                  'comments_href'      => $this->url->link('blog/article', $catID . '&article_id=' . $result['article_id']),
                  'readmore'           => $this->url->link('blog/article', $catID . '&article_id=' . $result['article_id']),
                  'art_infoName'       => $art_infoName,
                  'art_infoCategory'   => $art_infoCategory,
                  'art_infoDate'       => $art_InfoDate,
                  'art_infoComment'    => isset($blogSetting['artInfoComment']) ? $blogSetting['artInfoComment'] : false
               );
            }
            
            $pagination          = new Pagination();
            $pagination->total   = $article_total;
            $pagination->page    = $page;
            $pagination->limit   = $limit;
            $pagination->text    = $this->language->get('text_pagination');
            $pagination->url     = $this->url->link('blog/category', $catID . '&page={page}', 'SSL');
               
            $this->data['pagination'] = $pagination->render();
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/category.tpl')) {
               $this->template = $this->config->get('config_template') . '/template/blog/category.tpl';
            } else {
               $this->template = 'default/template/blog/category.tpl';
            }
            
            $this->children = array(
               'common/column_left',
               'common/column_right',
               'common/content_top',
               'common/content_bottom',
               'common/footer',
               'common/header'
            );
         
            $this->response->setOutput($this->render());
         } else {
            $this->data['breadcrumbs'][] = array(
               'text'      => $this->language->get('text_error_art'),
               'href'      => $this->url->link('blog/category', 'category_id=' . $category_id),
               'separator' => $this->language->get('text_separator')
            );
            
            $this->document->setTitle($this->language->get('text_error_art'));
            $this->data['heading_title'] = $this->language->get('text_error_art');
            $this->data['text_error'] = $this->language->get('text_error_art');

            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
               $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
               $this->template = 'default/template/error/not_found.tpl';
            }
            
            $this->children = array(
               'common/column_left',
               'common/column_right',
               'common/content_top',
               'common/content_bottom',
               'common/footer',
               'common/header'
            );
                  
            $this->response->setOutput($this->render());
         }
       } else {
         $this->data['breadcrumbs'][] = array(
            'text'         => $this->language->get('text_error_cat'),
            'href'         => $this->url->link('blog/category', 'category_id=' . $category_id),
            'separator'    => $this->language->get('text_separator')
         );
         
         $this->document->setTitle($this->language->get('text_error_cat'));
         $this->data['heading_title'] = $this->language->get('text_error_cat');
         $this->data['text_error'] = $this->language->get('text_error_cat');

         $this->data['button_continue'] = $this->language->get('button_continue');

         $this->data['continue'] = $this->url->link('common/home');

         if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
         } else {
            $this->template = 'default/template/error/not_found.tpl';
         }
         
         $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
         );
         
         $this->response->setOutput($this->render());
       }
   }
   
   public function home() {
      $this->load->model('blog/setting');
      $this->load->model('blog/article');
      $this->load->model('blog/category');
      $this->load->model('tool/image');
      $this->data = $this->language->load('blog/blog');
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog.css')) {
         $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
      } else {
         $this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
      }
      
      $blogSetting = $this->model_blog_setting->getSettings();
      
      if (isset($this->request->get['page'])) {
         $page = $this->request->get['page'];
      } else { 
         $page = 1;
      }
      $limit = $blogSetting['articleCat'];
      
      $this->data['breadcrumbs'] = array();
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home'),
         'separator' => false
      );
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('text_blog'),
         'href'      => $this->url->link('blog/category/home'),
         'separator' => $this->language->get('text_separator')
      );
      
      $this->document->setTitle($blogSetting['blogName']);
      $this->document->setKeywords($blogSetting['blogKeyword']);
      $this->document->setDescription($blogSetting['blogDescription']);
      
      $this->data['heading_title'] = $blogSetting['blogName'];
      $this->data['catDescription'] = null;
      $this->data['categories'] = array();
      $this->data['suffix'] = $blogSetting['blogSuffix'];
      
      $data = array(
         'article_order'         => 'dateDesc',
         'exclude_category'      => $blogSetting['blogExclude'],
         'start'                 => ($page - 1) * $limit,
         'limit'                 => $limit
      );
      
      $imageWidth = $blogSetting['articleFeatWidth'];
      $imageHeight = $blogSetting['articleFeatHeight'];
            
      //== Article
      $article_total = $this->model_blog_article->getTotalArticles($data);
      $this->data['articles'] = array();
      $results = $this->model_blog_article->getArticles($data);
      
      if ($results) {         
         foreach ($results as $result) {
            $catArticle    = array();
            $catDisabled   = array();
            $catDatas      = $this->model_blog_article->getCategoriesByArticle($result['article_id']);
            foreach ($catDatas as $catData) {
               $catArticle[]     = '<a href="' . $this->url->link('blog/category', 'category_id=' . $catData['category_id']) . '">'. $catData['name'] . '</a>';
               $catDisabled[]    = $catData['category_id'];
            }
            
            if (isset($blogSetting['artInfoName'])) {
               $art_infoName     = sprintf($this->language->get('text_art_infoName'), $result['author']);
            } else {
               $art_infoName     = '';
            }
            if (isset($blogSetting['artInfoCategory'])) {
               $art_infoCategory    = sprintf($this->language->get('text_art_infoCategory'), implode(", ", $catArticle));
            } else {
               $art_infoCategory    = '';
            }
            if (isset($blogSetting['artInfoDate'])) {
               $art_InfoDate     = sprintf($this->language->get('text_art_InfoDate'), date($this->language->get('date_format'), strtotime($result['created'])));
            } else {
               $art_InfoDate     = '';
            }
            if ($blogSetting['commentStatus']) {
               $groupDisabled    = explode(',',$blogSetting['commentDisableGroup']);
               if (array_intersect($catDisabled, $groupDisabled)) {
                  $comments      = '';
               } else {
                  $comments      = sprintf($this->language->get('text_comments'), $this->model_blog_article->getTotalCommentsByArticleId($result['article_id']));
               }
            } else { $comments   = ''; }
            
            $separator = '<!--more-->';
            $short_desc = explode($separator, html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
            if(isset($short_desc[1])) {
               $description = $short_desc[0];
            } else {
               $description = $this->truncate(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), $blogSetting['articleDesc']);
            }

            $this->data['articles'][] = array(
               'articlet_id'        => $result['article_id'],
               'title'              => $result['title'],
               'category'           => implode(", ", $catArticle),
               'modified'           => date($this->language->get('date_format'), strtotime($result['modified'])),
               'description'        => strip_tags($description,'<b><i><em><u><a><strong><p><strike><div><span><ul><ol><li><br>'),
               'image'              => $this->model_tool_image->resize($result['image'], $imageWidth, $imageHeight),
               'comments'           => $comments,
               'comments_href'      => $this->url->link('blog/article', 'article_id=' . $result['article_id']),
               'readmore'           => $this->url->link('blog/article', 'article_id=' . $result['article_id']),
               'art_infoName'       => $art_infoName,
               'art_infoCategory'   => $art_infoCategory,
               'art_infoDate'       => $art_InfoDate,
               'art_infoComment'    => isset($blogSetting['artInfoComment']) ? $blogSetting['artInfoComment'] : false
            );
         }
         
         $pagination          = new Pagination();
         $pagination->total   = $article_total;
         $pagination->page    = $page;
         $pagination->limit   = $limit;
         $pagination->text    = $this->language->get('text_pagination');
         $pagination->url     = $this->url->link('blog/category/home', 'page={page}', 'SSL');
            
         $this->data['pagination'] = $pagination->render();
         
         if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/category.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/blog/category.tpl';
         } else {
            $this->template = 'default/template/blog/category.tpl';
         }
         
         $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
         );
      
         $this->response->setOutput($this->render());
      } else {
         $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_error_art'),
            'href'      => $this->url->link('blog/category/home'),
            'separator' => $this->language->get('text_separator')
         );
         
         $this->document->setTitle($this->language->get('text_error_art'));
         $this->data['heading_title'] = $this->language->get('text_error_art');
         $this->data['text_error'] = $this->language->get('text_error_art');

         $this->data['button_continue'] = $this->language->get('button_continue');

         $this->data['continue'] = $this->url->link('common/home');

         if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
         } else {
            $this->template = 'default/template/error/not_found.tpl';
         }
         
         $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
         );
         
         $this->response->setOutput($this->render());
      }
   }

   /* auto closed tag and cut content */
   protected function truncate($text, $length = 1000, $ending = '...', $exact = false, $considerHtml = true) {
      if ($considerHtml) {
         if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
         }
         preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
         $total_length = strlen($ending);
         $open_tags = array();
         $truncate = '';
         foreach ($lines as $line_matchings) {
            if (!empty($line_matchings[1])) {
               if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
               } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                  $pos = array_search($tag_matchings[1], $open_tags);
                  if ($pos !== false) {
                  unset($open_tags[$pos]);
                  }
               } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                  array_unshift($open_tags, strtolower($tag_matchings[1]));
               }
               $truncate .= $line_matchings[1];
            }
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
               $left = $length - $total_length;
               $entities_length = 0;
               if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                  foreach ($entities[0] as $entity) {
                     if ($entity[1]+1-$entities_length <= $left) {
                        $left--;
                        $entities_length += strlen($entity[0]);
                     } else {
                        break;
                     }
                  }
               }
               $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
               break;
            } else {
               $truncate .= $line_matchings[2];
               $total_length += $content_length;
            }
            if($total_length>= $length) {
               break;
            }
         }
      } else {
         if (strlen($text) <= $length) {
            return $text;
         } else {
            $truncate = substr($text, 0, $length - strlen($ending));
         }
      }
      if (!$exact) {
         $spacepos = strrpos($truncate, ' ');
         if (isset($spacepos)) {
            $truncate = substr($truncate, 0, $spacepos);
         }
      }
      $truncate .= $ending;
      if($considerHtml) {
         foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
         }
      }
      return $truncate;
   }
}
?>