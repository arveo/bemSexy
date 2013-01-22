<?php
class ControllerModuleBlogarticle extends Controller {
   protected function index($setting) {
      $this->load->model('tool/image');
      $this->load->model('blog/article');
      $this->language->load('module/blogarticle');
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog_module.css')) {
         $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog_module.css');
      } else {
         $this->document->addStyle('catalog/view/theme/default/stylesheet/blog_module.css');
      }
      
         $this->data['heading_title']   = $this->language->get('heading_title');
         $this->data['classSuffix']      = $setting['suffix'];

      if ($setting['spesific']) {
         if ($setting['spesific'] < 0 || $setting['spesific'] == '-') {
            $title_position = 'top';
         } else {
            $title_position = false;
         }
         $spesific = abs($setting['spesific']);
      } else {
         $spesific = false;
         $title_position = false;
      }
      
      if ($setting['exclude'] && !$setting['spesific']) {
         $exclude = $setting['exclude'];
      } else {
         $exclude = false;
      }
      
      $data = array(
         'article_order'         => 'dateDesc',
         'filter_category_id'    => $spesific,
         'exclude_category'      => $exclude,
         'start'                 => 0,
         'limit'                 => $setting['limit']
      );

      $this->load->model('blog/category');
      $categoryData = $this->model_blog_category->getCategory($spesific);
      if ($categoryData) {
         $this->data['catTitle'] = $categoryData['name'];
      } else {
         $this->data['catTitle'] = '';
      }
      
      $this->data['articles'] = array();
      $results = $this->model_blog_article->getArticles($data);

      foreach ($results as $result) {
         if ($result['image']) {
            $image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
         } else {
            $image = false;
         }
         
         if ($setting['description']) {
            $description = strip_tags($this->truncate(html_entity_decode($result['description']), $setting['description']));
         } else {
            $description = false;
         }
         
         $this->data['articles'][] = array(
            'articlet_id'   => $result['article_id'],
            'image'         => $image,
            'title'         => $result['title'],
            'titlePos'      => $title_position,
            'author'        => $result['author'],
            'created'       => date($this->language->get('date_format'), strtotime($result['created'])),
            'description'   => $description,
            'link'          => $this->url->link('blog/article', 'article_id=' . $result['article_id'])
         );
      }

      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogarticle.tpl')) {
         $this->template = $this->config->get('config_template') . '/template/module/blogarticle.tpl';
      } else {
         $this->template = 'default/template/module/blogarticle.tpl';
      }

      $this->render();
   }
   
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