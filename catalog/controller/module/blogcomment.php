<?php
class ControllerModuleBlogcomment extends Controller {
   protected function index($setting) {
      $this->load->model('tool/image');
      $this->load->model('blog/article');
      $this->language->load('module/blogcomment');
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog_module.css')) {
         $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog_module.css');
      } else {
         $this->document->addStyle('catalog/view/theme/default/stylesheet/blog_module.css');
      }
      
         $this->data['heading_title']   = $this->language->get('heading_title');
         $this->data['classSuffix']      = $setting['suffix'];

      $data = array(
         'exclude_category'      => $setting['exclude'],
         'limit'               => $setting['limit']
      );

      $this->data['comments'] = array();
      $results = $this->model_blog_article->getComments($data);

      foreach ($results as $result) {
         if ($result['website']) {
            $author = '<a href="'.$result['website'].'" title="'.$result['website'].'" target="_blank" rel="nofollow">'.$result['name'].'</a>';
         } else {
            $author = $result['name'];
         }
         
         $this->data['comments'][] = array(
            'comment_id'   => $result['comment_id'],
            'avatar'         => $this->getGravatar($result['email'],$setting),
            'author'         => $author,
            'name'         => $result['name'],
            'article'      => $result['title'],
            'created'      => date($this->language->get('date_format'), strtotime($result['created'])),
            'link'         => $this->url->link('blog/article', 'article_id=' . $result['article_id'])
         );
      }

      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogcomment.tpl')) {
         $this->template = $this->config->get('config_template') . '/template/module/blogcomment.tpl';
      } else {
         $this->template = 'default/template/module/blogcomment.tpl';
      }

      $this->render();
   }
   
   private function getGravatar($email, $setting) {
      if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) { $http = 'https://secure.'; } else { $http = 'http://www.'; }
      
      $default    = HTTP_IMAGE . 'data/avatar.jpg';
      $url          = $http . 'gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?d=' . urlencode($default);
      
      $gravatar   = '<img class="image" src="'.$url.'" alt="Avatar" width="'.$setting['image_width'].'px" height="'.$setting['image_height'].'px" />';
      
      return $gravatar;
   }
}
?>