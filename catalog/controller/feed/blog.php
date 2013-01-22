<?php 
class ControllerFeedBlog extends Controller {
   public function index() {
      $this->load->model('blog/setting');
      $blogSetting = $this->model_blog_setting->getSettings();
      
      if ($blogSetting['blogFeed']) {
         $output  = '<?xml version="1.0" encoding="UTF-8" ?>';
         $output .= '<rss version="2.0">';
         $output .= '<channel>';
         $output .= '<title>' . $blogSetting['blogName'] . '</title>'; 
         $output .= '<link>' . HTTP_SERVER . '</link>';
         $output .= '<description>' . $blogSetting['blogDescription'] . '</description>';
         $output .= '<image>';
         $output .= '<title>' . $blogSetting['blogName'] . '</title>'; 
         $output .= '<url>' . HTTP_IMAGE  . $this->config->get('config_logo') . '</url>';
         $output .= '<link>' . HTTP_SERVER . '</link>';
         $output .= '</image>'; 
      
         $this->load->model('tool/image');
         $this->load->model('blog/article');
         
         $data = array(
            'article_order'   => 'dateDesc'
         );
      
         $results = $this->model_blog_article->getArticles($data);
         
         foreach ($results as $result) {
            $catArticle = array();
            $catDatas = $this->model_blog_article->getCategoriesByArticle($result['article_id']);
            
            if ($result['description']) {
               $separator = '&lt;!--more--&gt;';
               $short_desc = explode($separator, $result['description']);
               if(isset($short_desc[1])) {
                  $description = $short_desc[0];
               } else {
                  $description = $this->truncate($result['description'], $blogSetting['articleDesc']);
               }
               
               $output .= '<item>';
               $output .= '<title>' . $result['title'] . '</title>';
               //$output .= '<author>' . $result['author'] . '</author>';
               foreach ($catDatas as $catData) {
                  $output .= '<category domain="' . str_replace('&', '&amp;', $this->url->link('blog/category', 'category_id=' . $catData['category_id'])) . '">' . $catData['name'] . '</category>';
               }
               //$output .= '<pubDate>' . date('l, M d, Y', strtotime($result['created'])) . '</pubDate>';
               $output .= '<pubDate>' . date(DATE_RFC822, strtotime($result['created'])) . '</pubDate>';
               $output .= '<link>' . $this->url->link('blog/article', 'article_id=' . $result['article_id']) . '</link>';
               $output .= '<description>';
               if ($result['image']) { $output .= '&lt;img src="'.$this->model_tool_image->resize($result['image'], 120, 120).'" alt="" align="left" /&gt;'; }
               //$output .= $this->truncate($result['description'], $blogSetting['articleDesc']) . ' ' . '&lt;a href="' . str_replace('&', '&amp;', $this->url->link('blog/article', 'article_id=' . $result['article_id'])) . '"&gt;readmore&lt;/a&gt; ' . '</description>';
               $output .= $description . ' ' . '&lt;a href="' . str_replace('&', '&amp;', $this->url->link('blog/article', 'article_id=' . $result['article_id'])) . '"&gt;readmore&lt;/a&gt; ' . '</description>';
               $output .= '</item>';
            }
         }
         
         $output .= '</channel>'; 
         $output .= '</rss>';   
         
         $this->response->addHeader('Content-Type: application/rss+xml');
         $this->response->setOutput($output);
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
}?>