<?php
class ControllerFeedBlogSitemap extends Controller {
   public function index() {
      $this->load->model('blog/setting');
      $blogSetting = $this->model_blog_setting->getSettings();
      
      if ($blogSetting['blogSitemap']) {
         $output  = '<?xml version="1.0" encoding="UTF-8"?>';
         $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

         $this->load->model('blog/article');
         $this->load->model('blog/category');

         $results = $this->model_blog_article->getArticles();

         foreach ($results as $result) {
            $output .= '<url>';
            $output .= '<loc>' . str_replace('&', '&amp;', $this->url->link('blog/article', 'article_id=' . $result['article_id'])) . '</loc>';
            $output .= '<changefreq>weekly</changefreq>';
            $output .= '<priority>1.0</priority>';
            $output .= '</url>';   
         }
         
         $output .= $this->getCategories(0);

         $output .= '</urlset>';

         $this->response->addHeader('Content-Type: application/xml');
         $this->response->setOutput($output);
      }
   }

   protected function getCategories($parent_id, $current_path = '') {
      $output = '';

      $results = $this->model_blog_category->getCategories($parent_id);

      foreach ($results as $result) {
         if (!$current_path) {
            $new_path = $result['category_id'];
         } else {
            $new_path = $current_path . '_' . $result['category_id'];
         }

         $output .= '<url>';
         $output .= '<loc>' . str_replace('&', '&amp;', $this->url->link('blog/category', 'category_id=' . $new_path)) . '</loc>';
         $output .= '<changefreq>weekly</changefreq>';
         $output .= '<priority>0.7</priority>';
         $output .= '</url>';         

         $articles = $this->model_blog_article->getArticles(array('filter_category_id' => $result['category_id']));

         foreach ($articles as $article) {
            $output .= '<url>';
            $output .= '<loc>' . str_replace('&', '&amp;', $this->url->link('blog/article', 'category_id=' . $new_path . '&article_id=' . $article['article_id'])) . '</loc>';
            $output .= '<changefreq>weekly</changefreq>';
            $output .= '<priority>1.0</priority>';
            $output .= '</url>';   
         }   

         $output .= $this->getCategories($result['category_id'], $new_path);
      }

      return $output;
   }      
}
?>