<?php  
class ControllerModuleBlogarchive extends Controller {
   protected function index($setting) {
      $this->load->model('blog/article');
      $this->language->load('module/blogarchive');
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog_module.css')) {
         $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog_module.css');
      } else {
         $this->document->addStyle('catalog/view/theme/default/stylesheet/blog_module.css');
      }
      
      $this->data['heading_title']  = $this->language->get('heading_title');
      $this->data['classSuffix']    = $setting['suffix'];
      
      $years = $this->model_blog_article->getArchive('year');
      
      $data = array();
      if(isset($setting['exclude']) && $setting['exclude']) { $data = array( 'exclude' => $setting['exclude']); }
      
      $this->data['archives'] = array();
      if ($years) {
         foreach ($years as $year) {
            $month_data = array();
            $months = $this->model_blog_article->getArchive($year['value']);
            
            if ($months) {
               foreach ($months as $month) {
                  //=== Articles
                  $article_data = array();
                  $articles = $this->model_blog_article->getArchiveArticle($month['value'], 0, $data);
                  
                  if ($articles) {
                     foreach ($articles as $article) {
                        $article_data[] = array(
                           'articlet_id'   => $article['article_id'],
                           'title'         => $article['title'],
                           'link'         => $this->url->link('blog/article', 'article_id=' . $article['article_id'])
                        );   
                     }
                  }
                  
                  //=== Months
                  if ($setting['count']) {
                     $article_total = '[' . count($this->model_blog_article->getArchiveArticle($month['value'], 0, $data)) . '] ';
                  } else {
                     $article_total = false;
                  }
                  
                  $month_data[] = array(
                     'value'         => $article_total . $month['value'],
                     'articles'      => $article_data
                  );               
               }
            }
            
            //=== Years
            if ($setting['count']) {
               $article_total = '[' . count($this->model_blog_article->getArchiveArticle($year['value'], 1, $data)) . '] ';
            } else {
               $article_total = false;
            }
            
            $this->data['archives'][] = array(
               'value'      => $article_total . $year['value'],
               'months'      => $month_data
            );
         }
      }
      
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogarchive.tpl')) {
         $this->template = $this->config->get('config_template') . '/template/module/blogarchive.tpl';
      } else {
         $this->template = 'default/template/module/blogarchive.tpl';
      }
      
      $this->render();
   }
}
?>