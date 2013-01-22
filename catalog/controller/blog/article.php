<?php  
class ControllerBlogArticle extends Controller {
   private $error = array(); 
   
   public function index() {
      if (isset($this->request->get['article_id'])) {
         $article_id = $this->request->get['article_id'];
      } else {
         $this->redirect($this->url->link('blog/category/home'));
      }
      
      $this->load->model('blog/setting');
      $this->load->model('blog/article');
      $this->load->model('blog/category');
      $this->data = $this->language->load('blog/blog');
      
      $this->document->addLink($this->url->link('blog/article', 'article_id=' . $this->request->get['article_id']), 'canonical');
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog.css')) {
         $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
      } else {
         $this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
      }
      
      $blogSetting = $this->model_blog_setting->getSettings();
      
      // Redirect page if Blog Manager is not installed
      if (!isset($blogSetting['blogName'])) { $this->redirect($this->url->link('common/home')); }
      
      $this->data['breadcrumbs'] = array();
         $this->data['breadcrumbs'][] = array(
           'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home'),
           'separator' => false
         );
      
      if (isset($this->request->get['category_id'])) {
         $path = '';
            
         $this->data['breadcrumbs'][] = array(
           'text'      => $this->language->get('text_blog'),
         'href'      => $this->url->link('blog/category/home'),
           'separator' => $this->language->get('text_separator')
         );
         foreach (explode('_', $this->request->get['category_id']) as $path_id) {
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
      } else {
         $this->data['breadcrumbs'][] = array(
           'text'      => $this->language->get('text_blog'),
         'href'      => $this->url->link('blog/category/home'),
           'separator' => $this->language->get('text_separator')
         );
      }

      $articleData = $this->model_blog_article->getArticle($article_id);
      
      if ($articleData) {
         $url = '';
         if (isset($this->request->get['category_id'])) {
            $url .= '&category_id=' . $this->request->get['category_id'];
         }
         
         $this->data['breadcrumbs'][] = array(
            'text'      => $articleData['title'],
            'href'      => $this->url->link('blog/article', $url . '&article_id=' . $article_id),
            'separator' => $this->language->get('text_separator')
         );
         
         $this->document->setTitle($articleData['title']);
         $this->document->setKeywords($articleData['meta_keyword']);
         $this->document->setDescription($articleData['meta_description']);
         
         $this->data['heading_title'] = $articleData['title'];
         
         $catArticle = array();
         $catDisabled = array();
         $catDatas = $this->model_blog_article->getCategoriesByArticle($articleData['article_id']);
         foreach ($catDatas as $catData) {
            $catArticle[] = '<a href="' . $this->url->link('blog/category', 'category_id=' . $catData['category_id']) . '">'. $catData['name'] . '</a>';
            $catDisabled[]   = $catData['category_id'];
         }
         
         if (isset($blogSetting['artInfoName'])) {
            $art_infoName = sprintf($this->language->get('text_art_infoName'), $articleData['author']);
         } else {
            $art_infoName = '';
         }
         if (isset($blogSetting['artInfoCategory'])) {
            $art_infoCategory = sprintf($this->language->get('text_art_infoCategory'), implode(", ", $catArticle));
         } else {
            $art_infoCategory = '';
         }
         if (isset($blogSetting['artInfoDate'])) {
            $art_InfoDate = sprintf($this->language->get('text_art_InfoDate'), date($this->language->get('date_format'), strtotime($articleData['created'])));
         } else {
            $art_InfoDate = '';
         }
         
         if ($blogSetting['commentStatus']) {
            $groupDisabled = explode(',',$blogSetting['commentDisableGroup']);
            if (array_intersect($catDisabled, $groupDisabled)) {
               $commentStatus = 0;
               $heading_comment = '';
               $comments = '';
            } else {
               $commentStatus = $blogSetting['commentStatus'];
               $totalComments = $this->model_blog_article->getTotalCommentsByArticleId($this->request->get['article_id']);
               if ($totalComments) {
                  $heading_comment = sprintf($this->language->get('text_comments'), $totalComments);
                  $comments = sprintf($this->language->get('text_comments'), $totalComments);
               } else {
                  $heading_comment = $this->language->get('text_comment');
                  $comments = sprintf($this->language->get('text_comments'), $totalComments);
               }
            }
            
         } else { 
            $commentStatus = 0;
            $heading_comment = '';
            $comments = '';  
         }
         
         $totalReplies = $this->model_blog_article->getTotalRepliesByArticleId($this->request->get['article_id']);
         if ($totalReplies) {
            $replies = sprintf($this->language->get('text_replies'), $totalReplies);
         } else {
            $replies = '';
         }
         
         $this->data['title']            = $articleData['title'];
         $this->data['link']            = $this->url->link('blog/article', $url . '&article_id=' . $article_id);
         $this->data['art_infoName']   = $art_infoName;
         $this->data['art_infoCategory']   = $art_infoCategory;
         $this->data['art_infoDate']   = $art_InfoDate;
         $this->data['art_infoComment']= isset($blogSetting['artInfoComment']) ? $blogSetting['artInfoComment'] : false;
         $this->data['art_infoUpdate']   = isset($blogSetting['artInfoUpdate']) ? $blogSetting['artInfoUpdate'] : false;
         $this->data['modified']         = date($this->language->get('date_format'), strtotime($articleData['modified']));
         
         $this->data['heading_comment']= $heading_comment;
         $this->data['comments']         = $comments;
         $this->data['replies']         = $replies;
         $this->data['description']      = str_replace('<!--more-->','',html_entity_decode($articleData['description'], ENT_QUOTES, 'UTF-8'));
         $this->data['artRelateds']      = $this->model_blog_article->getRelatedArticle($articleData['article_id']);
         
         $this->load->model('tool/image');
         $this->data['prodRelateds']   = array();
         $prodRelateds                  = $this->model_blog_article->getRelatedProduct($articleData['article_id']);
         $this->data['prodPerRow']      = $blogSetting['relProduct'];
         
         foreach ($prodRelateds as $result) {
            if ($result['image']) {
               $image = $this->model_tool_image->resize($result['image'], $blogSetting['relProductWidth'], $blogSetting['relProductHeight']);
            } else {
               $image = $this->model_tool_image->resize('no_image.jpg', $blogSetting['relProductWidth'], $blogSetting['relProductHeight']);
            }
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
               $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
               $price = false;
            }
            if ((float)$result['special']) {
               $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
               $special = false;
            }
            if ($this->config->get('config_review_status')) {
               $rating = $result['rating'];
            } else {
               $rating = false;
            }
            $this->data['prodRelateds'][] = array(
               'product_id' => $result['product_id'],
               'thumb'       => $image,
               'name'        => $result['name'],
               'price'       => $price,
               'special'     => $special,
               'rating'     => $rating,
               'reviews'    => sprintf($this->language->get('text_reviews'), $result['reviews']),
               'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
            );
         }
         
         $tagsList = array();
         $results = $this->model_blog_article->getArticleTags($articleData['article_id']);
         foreach ($results as $result) {
            $tagsList[] = '<a href="' . $this->url->link('product/search', 'filter_tag=' . $result['tag']) . '" title="'.$result['tag'].'">'. $result['tag'] . '</a>';
         }
         $this->data['tags'] = implode(", ", $tagsList);
         
         $this->data['socMedia']         = $blogSetting['socMedia'];
         $this->data['pubID']            = $blogSetting['pubID'];
         $this->data['socMedCode']      = html_entity_decode($blogSetting['socMedCode'], ENT_QUOTES, 'UTF-8');
         
         $this->data['article_id']      = $article_id;
         $this->data['customerID']      = $this->customer->getId();
         $this->data['customerName']   = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
         $this->data['customerMail']   = $this->customer->getEmail();
         $this->data['commentStatus']   = $commentStatus;
         
         if ( (!$blogSetting['commentCaptha'] == 'disabled') || ($blogSetting['commentCaptha'] == 'guest' && $this->customer->getId() == 0) || ($blogSetting['commentCaptha'] == 'visitor') || ($blogSetting['commentCaptha'] == 'nondefault' && ($this->customer->getId() == 0 || $this->customer->getCustomerGroupId() == $this->config->get('config_customer_group_id')) ) ) {
            $this->data['commentCaptha']   = 1;
         } else {
            $this->data['commentCaptha']   = 0;
         }
         
         if ($blogSetting['commentDefApprove']) {
            $autoApprove = 1;
         } else {
            $autoApproves = explode(',',$blogSetting['commentApproveGroup']);
            if (in_array($this->customer->getCustomerGroupId(), $autoApproves)) {
               $autoApprove = 1;
            } else {
               $autoApprove = 0;
            }
         }
         $this->data['autoApprove']   = $autoApprove;
         
         if(!isset($this->session->data['BlogArticle' . $article_id])) {
            $this->model_blog_article->updateViewed($article_id);
            $this->session->data['BlogArticle' . $article_id] = 1;
         }
         
         if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/article.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/blog/article.tpl';
         } else {
            $this->template = 'default/template/blog/article.tpl';
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
              'text'      => $this->language->get('text_error'),
            'href'      => $this->url->link('blog/article', 'article_id=' . $article_id),
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
   
   public function comment() {
       $this->load->model('blog/setting');
      $this->load->model('blog/article');
      $this->data = $this->language->load('blog/blog');
      
      $blogSetting = $this->model_blog_setting->getSettings();

      if (isset($this->request->get['page'])) { $page = $this->request->get['page']; } else { $page = 1; }
      $limit = $blogSetting['commentLimit'];
      
      $this->data['comments'] = array();
      
      $results = $this->model_blog_article->getCommentsByArticleId($this->request->get['article_id'], ($page - 1) * $limit, $limit, 'DESC');
      
      foreach ($results as $result) {
            $replyComments = array();
            $replyDatas = $this->model_blog_article->getReplyComments($result['comment_id']);
            
            foreach ($replyDatas as $replyData) {
               if ($replyData['staff_id']) {
                  $badgeReply = $this->model_blog_article->getStaffGroup($replyData['staff_id']);
               } else {
                  $custGroupReply = $this->model_blog_article->getCustomerGroup($replyData['customer_id']);
                  $groupBadgeReply = explode(',',$blogSetting['commentBadgeGroup']);
                  if ($custGroupReply && in_array($custGroupReply['groupId'], $groupBadgeReply)) {
                     $badgeReply = $custGroupReply['groupName']; 
                  } else { 
                     $badgeReply = 0; 
                  }
               }
               
               $replyComments[] = array(
                  'comment_id'   => $replyData['comment_id'],
                  'badge'         => $badgeReply,
                  'name'         => $replyData['name'],
                  'avatar'         => $this->getGravatar($replyData['email']),
                  'website'      => $replyData['website'],
                  'content'      => nl2br($replyData['content']),
                  //'content'      => nl2br(strip_tags(html_entity_decode($replyData['content'], ENT_QUOTES, 'UTF-8'),'<b><i><u><a>')),
                  'created'      => date($this->language->get('date_time_format'), strtotime($replyData['created']))
               );
            }

         $custGroup = $this->model_blog_article->getCustomerGroup($result['customer_id']);
         $groupBadge = explode(',',$blogSetting['commentBadgeGroup']);
         if ($custGroup && in_array($custGroup['groupId'], $groupBadge)) { $badge = $custGroup['groupName']; } else { $badge = 0; }
         
           $this->data['comments'][] = array(
            'comment_id'   => $result['comment_id'],
            'badge'         => $badge,
            'replyComments'   => $replyComments,
            'name'         => $result['name'],
              'avatar'         => $this->getGravatar($result['email']),
            'website'      => $result['website'],
            'content'      => nl2br($result['content']),
            //'content'      => nl2br(strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8'),'<b><i><u><a>')),
              'created'      => date($this->language->get('date_time_format'), strtotime($result['created']))
           );
         }
      
      $commentsTotal = $this->model_blog_article->getTotalCommentsByArticleId($this->request->get['article_id']);
         
      $pagination = new Pagination();
      $pagination->total = $commentsTotal;
      $pagination->page = $page;
      $pagination->limit = $limit; 
      $pagination->text = $this->language->get('text_pagination');
      $pagination->url = $this->url->link('blog/article/comment', 'article_id=' . $this->request->get['article_id'] . '&page={page}');
         
      $this->data['pagination'] = $pagination->render();
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/comment.tpl')) {
         $this->template = $this->config->get('config_template') . '/template/blog/comment.tpl';
      } else {
         $this->template = 'default/template/blog/comment.tpl';
      }
      
      $this->response->setOutput($this->render());
   }
   
   public function write() {
      $this->load->model('blog/setting');
      $this->load->model('blog/article');
      $this->data = $this->language->load('blog/blog');
      
      $blogSetting = $this->model_blog_setting->getSettings();
      
      $json = array();
      
      if ((strlen(utf8_decode($this->request->post['name'])) < 2) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
         $json['error']['name'] = $this->language->get('error_name');
      }
      if ((strlen(utf8_decode($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
         $json['error']['email'] = $this->language->get('error_email');
       }
      if ((strlen(utf8_decode($this->request->post['content'])) < $blogSetting['commentMin']) || (strlen(utf8_decode($this->request->post['content'])) > $blogSetting['commentMax'])) {
         $json['error']['content'] = sprintf($this->language->get('error_content'), $blogSetting['commentMin'], $blogSetting['commentMax']);
      }
      if ( (!$blogSetting['commentCaptha'] == 'disabled') || ($blogSetting['commentCaptha'] == 'guest' && $this->customer->getId() == 0) || ($blogSetting['commentCaptha'] == 'visitor') || ($blogSetting['commentCaptha'] == 'nondefault' && ($this->customer->getId() == 0 || $this->customer->getCustomerGroupId() == $this->config->get('config_customer_group_id')) ) ) {
         if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
            $json['error']['captcha'] = $this->language->get('error_captcha');
         }
      }
      if (isset($json['error'])) {
         $json['error']['common'] = $this->language->get('error_common');
      }
      
      if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
         $data = array();
         
         if ($blogSetting['commentDefApprove']) {
            $status = 1;
         } else {
            if ($blogSetting['commentApproveGroup']) {
               $groupApprove = explode(',',$blogSetting['commentApproveGroup']);
               if (in_array($this->customer->getCustomerGroupId(), $groupApprove)) {
                  $status = 1;
               } else {
                  $status = 0;
               }
            } else {
               $status = 0;
            }
         }
         
         $data['customer_id']    = $this->customer->getId();
         $data['status']       = $status;
         
         $this->model_blog_article->addComment($this->request->get['article_id'], array_merge($this->request->post, $data));
         
         if($status == 1) {
            $json['success'] = $this->language->get('text_success');
         } else {
            $json['success'] = $this->language->get('text_approval');
         }
      }
      
      if (file_exists(DIR_SYSTEM.'library/json.php')) {
         $this->load->library('json');
         $this->response->setOutput(Json::encode($json));
      } else {
         $this->response->setOutput(json_encode($json));
      }
   }
   
   public function captcha() {
      $this->load->library('captcha');
      
      $captcha = new Captcha();
      $this->session->data['captcha'] = $captcha->getCode();
      
      $captcha->showImage();
   }

   private function getGravatar($email) {
      $this->load->model('blog/setting');
      $blogSetting = $this->model_blog_setting->getSettings();
      if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) { $http = 'https://secure.'; } else { $http = 'http://www.'; }
      
      $size       = $blogSetting['commentAvatar'];
      $default    = HTTP_IMAGE . 'data/avatar.jpg';
      $url          = $http . 'gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?d=' . urlencode($default);
      
      $gravatar   = '<img src="'.$url.'" alt="Avatar" width="'.$size.'px" height="'.$size.'px" class="avatar" />';
      
      return $gravatar;
   }
}
?>