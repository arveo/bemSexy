<?php echo $header; ?>
<div id="content">
   <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
         <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
   </div>

   <div class="container">
      <div id="et-header">
         <span class="em-header"><img src="view/image/blog/blog_manager.png" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></span>
         
         <ul>
            <li><a href="<?php echo $menu_home_href; ?>"><?php echo $text_menu_home; ?></a></li>
            <li><a href="<?php echo $menu_article_href; ?>" class="active"><?php echo $text_menu_article; ?></a></li>
            <li><a href="<?php echo $menu_category_href; ?>"><?php echo $text_menu_category; ?></a></li>
            <li><a href="<?php echo $menu_comment_href; ?>"><?php echo $text_menu_comment; ?></a></li>
            <?php if (isset($haspermission_addAuthor) || isset($haspermission_editAuthor) || isset($haspermission_removeAuthor) || isset($haspermission_editPermission)) { ?>
               <li><a href="<?php echo $menu_author_href; ?>"><?php echo $text_menu_author; ?></a></li>
            <?php } ?>
            <?php if (isset($haspermission_editSetting)) { ?>
               <li><a href="<?php echo $menu_setting_href; ?>"><?php echo $text_menu_setting; ?></a></li>
            <?php } ?>
            <li><a href="<?php echo $menu_about_href; ?>"><?php echo $text_menu_about; ?></a></li>
         </ul>
      </div>
      <?php if ($error_warning) { ?>
         <div class="warning">
            <?php echo $error_warning; ?>
            <img class="close" alt="" src="view/image/blog/close.png" />
         </div>
      <?php } ?>
      <?php if ($attention) { ?>
         <div class="attention">            
            <?php echo $attention; ?>
            <img class="close" alt="" src="view/image/blog/close.png" />
         </div>
      <?php } ?>
      <?php if ($success) { ?>
         <div class="success">
            <?php echo $success; ?>
            <img class="close" alt="" src="view/image/blog/close.png" />
         </div>
      <?php } ?>
      <div id="et-content">
         <div class="heading">
            <h2><?php echo $heading_list; ?></h2>
            <div class="buttons">
               <?php if (isset($haspermission_addArticle)) { ?>
                  <a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a>
               <?php } ?>
               <?php if (isset($haspermission_copyArticle)) { ?>
                  <a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><?php echo $button_copy; ?></a>
               <?php } ?>
               <?php if (isset($haspermission_removeArticle)) { ?>
                  <a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a>
               <?php } ?>
            </div>
         </div>
         
         <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="blogList">
               <thead>
                  <tr>
                     <?php if (isset($haspermission_removeArticle) || isset($haspermission_copyArticle)) { ?>
                        <td width="1" class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                     <?php } ?>
                     <?php if ($sort == 'ad.title') { ?>
                        <td class="center <?php echo strtolower($order); ?>"><a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a></td>
                     <?php } else { ?>
                        <td class="center"><a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a></td>
                     <?php } ?>
                     <td class="center"style="width:225px;"><?php echo $column_seo; ?></td>
                     <?php if ($sort == 'a.created') { ?>
                        <td class="center <?php echo strtolower($order); ?>" style="width:100px;"><a href="<?php echo $sort_created; ?>"><?php echo $column_created; ?></a></td>
                     <?php } else { ?>
                        <td class="center" style="width:100px;"><a href="<?php echo $sort_created; ?>"><?php echo $column_created; ?></a></td>
                     <?php } ?>
                     <td class="center" style="width:70px;"><?php echo $column_status; ?></td>
                     <?php if ($sort == 'a.sort_order') { ?>
                        <td class="center <?php echo strtolower($order); ?>" style="width:50px;"><a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a></td>
                     <?php } else { ?>
                        <td class="center" style="width:50px;"><a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a></td>
                     <?php } ?>
                     <?php if (isset($haspermission_editOwnArticle) || isset($haspermission_editOtherArticle)) { ?>
                        <td class="center" style="width:60px;"><?php echo $column_action; ?></td>
                     <?php } ?>
                  </tr>
               </thead>
               <tbody>
                  <?php if ($articles) { ?>
                     <?php $class = 'odd'; ?>
                     <?php foreach ($articles as $article) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <tr class="<?php echo $class; ?>">
                           <?php if (isset($haspermission_removeArticle) || isset($haspermission_copyArticle)) { ?>
                              <td class="center">
                                 <?php if ($article['selected']) { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" checked="checked" />
                                 <?php } else { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" />
                                 <?php } ?>
                              </td>
                           <?php } ?>
                           <td class="left"><?php echo $article['title']; ?></td>
                           <td class="left"><?php echo $article['keyword']; ?></td>
                           <td class="center"><?php echo $article['created']; ?></td>
                           <td class="center"><?php if ($article['status']) { echo $text_enabled; } else { echo $text_disabled; }?></td>
                           <td class="center"><?php echo $article['sort_order']; ?></td>
                           <?php if (isset($haspermission_editOwnArticle) || isset($haspermission_editOtherArticle)) { ?>
                              <td class="center">
                                 <?php if (isset($haspermission_editOwnArticle) && $article['ownArticle'] || isset($haspermission_editOtherArticle) && $article['otherArticle']) { ?>
                                    <?php foreach ($article['action'] as $action) { ?>
                                       <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                                    <?php } ?>
                                 <?php } ?>
                              </td>
                           <?php } ?>
                        </tr>
                     <?php } ?>
                  <?php } else { ?>
                     <tr>
                        <?php if (isset($haspermission_removeArticle) && (isset($haspermission_editOwnArticle) || isset($haspermission_editOtherArticle))) { ?>
                           <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
                        <?php } elseif (isset($haspermission_removeArticle) || (isset($haspermission_editOwnArticle) || isset($haspermission_editOtherArticle))) { ?>
                           <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
                        <?php } else { ?>
                           <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
                        <?php } ?>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </form>
         <div class="pagination"><?php echo $pagination; ?></div>
      </div>
      
      <div id="et-footer">
         Blog Manager &copy; <?php if ((date('Y')) == '2011') { echo date('Y'); } else { echo '2011 - '.date('Y');};?> <a href="http://www.echothemes.com" target="_blank">EchoThemes</a>. All right reserved. <br />
         <a href="http://www.opencart.com" target="_blank">OpenCart</a> &copy; 2009-<?php echo date('Y');?> All Rights Reserved. <br /> Version <?php echo sprintf(VERSION); ?>
      </div>
   </div>
</div>

<script type="text/javascript" src="view/javascript/blog/blog.js"></script>
<?php echo $footer; ?>