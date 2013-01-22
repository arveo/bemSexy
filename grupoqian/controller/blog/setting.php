<?php
class ControllerBlogSetting extends Controller {
   private $error = array();
 
   public function index() {
      $this->load->model('blog/setting');
      $this->load->model('setting/setting');
      $this->data = $this->load->language('blog/blog');
      $this->data = $this->load->language('blog/setting');

      $this->document->setTitle($this->language->get('heading_title'));
      $this->document->addStyle('view/stylesheet/blog.css');
      
      $this->load->model('blog/article');
      $isAuthor = $this->model_blog_article->getAuthorByUser($this->user->getId());
      if (!$isAuthor) {
         $this->session->data['warning'] = $this->language->get('error_notauthor');
         $this->redirect($this->url->link('blog/blog', 'token=' . $this->session->data['token'], 'SSL'));
      }
      
      $this->load->model('blog/author');
      $blogPermission = $this->model_blog_author->getPermissionByUser($this->user->getId());
      if (is_array(unserialize($blogPermission))) { foreach (unserialize($blogPermission) as $permission) { $this->data['haspermission_'. $permission] = 1; }; }
      
      $this->data['breadcrumbs'] = array();
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
         'separator' => false
      );
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('heading_title'),
         'href'      => $this->url->link('blog/blog', 'token=' . $this->session->data['token'], 'SSL'),
         'separator' => ' <span class="separator">&#187;</span> '
      );
      $this->data['breadcrumbs'][] = array(
         'text'      => $this->language->get('head_setting'),
         'href'      => $this->url->link('blog/setting', 'token=' . $this->session->data['token'], 'SSL'),
         'separator' => ' <span class="separator">&#187;</span> '
      );

      if (isset($this->session->data['success'])) {
         $this->data['success'] = $this->session->data['success'];
         unset($this->session->data['success']);
      } else {
         $this->data['success'] = '';
      }
      
      if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSetting()) {
         if (isset($this->request->post['articleAdmin'])) {
            $this->model_blog_setting->updateSetting($this->request->post);
            
            $blogSettingConfig = array(
               'blogSetting_virDir'          => $this->request->post['virDir'],
               'blogSetting_virDirName'      => $this->request->post['virDirName'],
               'blogSetting_virDirExclude'   => $this->request->post['virDirExclude']
            );
            
            $this->model_setting_setting->editSetting('blogSetting', $blogSettingConfig);

            $this->session->data['success'] = $this->language->get('text_success_setting');
            $this->redirect($this->url->link('blog/setting', 'token=' . $this->session->data['token'], 'SSL')); 
         }
      }
      
      //== Menu
      $this->data['menu_home_href']       = $this->url->link('blog/blog', 'token=' . $this->session->data['token'], 'SSL');
      $this->data['menu_article_href']    = $this->url->link('blog/article', 'token=' . $this->session->data['token'], 'SSL');
      $this->data['menu_category_href']    = $this->url->link('blog/category', 'token=' . $this->session->data['token'], 'SSL');
      $this->data['menu_comment_href']    = $this->url->link('blog/comment', 'token=' . $this->session->data['token'], 'SSL');
      $this->data['menu_author_href']    = $this->url->link('blog/author', 'token=' . $this->session->data['token'], 'SSL');
      $this->data['menu_setting_href']    = $this->url->link('blog/setting', 'token=' . $this->session->data['token'], 'SSL');
      $this->data['menu_about_href']       = $this->url->link('blog/about', 'token=' . $this->session->data['token'], 'SSL');
      
      $this->data['action'] = $this->url->link('blog/setting', 'token=' . $this->session->data['token'], 'SSL');
      
      //== Tab Setting
      $blogSettings = $this->model_blog_setting->getSettings();
      foreach ($blogSettings as $key => $value) { $this->data[$key . 'Value'] = $value; };
      
      //== Error Handle
      $errorSettings = array('warning', 'tabAdmin', 'articleAdmin', 'tabCategory', 'articleCat', 'articleDesc', 'articleFeature', 'tabArticle', 'relProduct', 'relProductWH', 'tabComment', 'commentMinMax', 'tabSearch', 'searchLimit', 'searchGrid');
      foreach ($errorSettings as $errorSetting) {
         if (isset($this->error[$errorSetting])) {
            $this->data['error_'.$errorSetting] = $this->error[$errorSetting];
         } else {
            $this->data['error_'.$errorSetting] = '';
         }
      }
      if (isset($this->error['warning'])) {
         $this->data['warning'] = $this->error['warning'];
      } else {
         $this->data['warning'] = '';
      }
      
      $this->template = 'blog/setting.tpl';
      $this->children = array(
         'common/header',
         'common/footer',
      );
      
      $this->response->setOutput($this->render());
   }
   
   private function validateSetting() {
      if (!$this->user->hasPermission('modify', 'blog/setting')) {
         $this->error['warning'] = $this->language->get('error_permission');
      }
      
      if (isset($this->request->post['articleCat'])) {
         if (!$this->request->post['articleCat'] || $this->request->post['articleCat'] <= 0) {
            $this->error['articleCat'] = $this->language->get('error_limit');
         }
         if (!$this->request->post['articleDesc'] || $this->request->post['articleDesc'] <= 0) {
            $this->error['articleDesc'] = $this->language->get('error_limit');
         }
         if (!$this->request->post['articleFeatWidth'] || $this->request->post['articleFeatWidth'] <= 0 || !$this->request->post['articleFeatHeight'] || $this->request->post['articleFeatHeight'] <= 0) {
            $this->error['articleFeature'] = $this->language->get('error_size');
         }
         if ((isset($this->error['articleCat']) || isset($this->error['articleDesc']) || isset($this->error['articleFeatWidth'])) && !isset($this->error['warning'])) {
            $this->error['tabCategory'] = $this->language->get('error_tab');
         }
      }
      
      if (isset($this->request->post['relProduct'])) {
         if (!$this->request->post['relProduct'] || $this->request->post['relProduct'] <= 0) {
            $this->error['relProduct'] = $this->language->get('error_limit');
         }
         if (!$this->request->post['relProductWidth'] || $this->request->post['relProductWidth'] <= 0 || !$this->request->post['relProductHeight'] || $this->request->post['relProductHeight'] <= 0) {
            $this->error['relProductWH'] = $this->language->get('error_size');
         }
         if ((isset($this->error['relProduct']) || isset($this->error['relProductWH']) || isset($this->error['commentMinMax'])) && !isset($this->error['warning'])) {
            $this->error['tabArticle'] = $this->language->get('error_tab');
         }
      }
      
      if (isset($this->request->post['relProduct'])) {
         if (!$this->request->post['commentMin'] || $this->request->post['commentMin'] <= 0 || !$this->request->post['commentMax'] || $this->request->post['commentMax'] <= 0) {
            $this->error['commentMinMax'] = $this->language->get('error_limit');
         }
         if (isset($this->error['commentMinMax']) && !isset($this->error['warning'])) {
            $this->error['tabComment'] = $this->language->get('error_tab');
         }
      }
      
      if (isset($this->request->post['searchLimit'])) {
         if (!$this->request->post['searchLimit'] || $this->request->post['searchLimit'] <= 0) {
            $this->error['searchLimit'] = $this->language->get('error_limit');
         }
         if (!$this->request->post['searchGrid'] || $this->request->post['searchGrid'] <= 0) {
            $this->error['searchGrid'] = $this->language->get('error_limit');
         }
         if ((isset($this->error['searchLimit']) || isset($this->error['searchGrid'])) && !isset($this->error['warning'])) {
            $this->error['tabSearch'] = $this->language->get('error_tab');
         }
      }
      
      if (isset($this->request->post['articleAdmin'])) {
         if (!$this->request->post['articleAdmin'] || $this->request->post['articleAdmin'] <= 0) {
            $this->error['articleAdmin'] = $this->language->get('error_limit');
         }
         if (isset($this->error['articleAdmin']) && !isset($this->error['warning'])) {
            $this->error['tabAdmin'] = $this->language->get('error_tab');
         }
      }
 
      if (!$this->error) {
         return true; 
      } else {
         return false;
      }
   }
}
?>