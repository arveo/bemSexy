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
            <li><a href="<?php echo $menu_article_href; ?>"><?php echo $text_menu_article; ?></a></li>
            <li><a href="<?php echo $menu_category_href; ?>"><?php echo $text_menu_category; ?></a></li>
            <li><a href="<?php echo $menu_comment_href; ?>"><?php echo $text_menu_comment; ?></a></li>
            <?php if (isset($haspermission_addAuthor) || isset($haspermission_editAuthor) || isset($haspermission_removeAuthor) || isset($haspermission_editPermission)) { ?>
               <li><a href="<?php echo $menu_author_href; ?>"><?php echo $text_menu_author; ?></a></li>
            <?php } ?>
            <?php if (isset($haspermission_editSetting)) { ?>
               <li><a href="<?php echo $menu_setting_href; ?>" class="active"><?php echo $text_menu_setting; ?></a></li>
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
      <?php if ($success) { ?>
         <div class="success">
            <?php echo $success; ?>
            <img class="close" alt="" src="view/image/blog/close.png" />
         </div>
      <?php } ?>
      
      <div id="et-content">
         <?php if (isset($haspermission_editSetting)) { ?>
            <div class="floatRight"><a onclick="$('#blogSetting').submit();" class="button"><?php echo $button_save; ?></a> </div>
            
            <div id="tabs" class="htabs">
               <a href="#tabBlog"><?php echo $text_tab_blog; ?></a>
               <a href="#tabCategory"><?php echo $text_tab_category; ?>  <?php if(isset($error_tabCategory)) { echo $error_tabCategory; } ?></a>
               <a href="#tabArticle"><?php echo $text_tab_article; ?> <?php if(isset($error_tabArticle)) { echo $error_tabArticle; } ?></a>
               <a href="#tabComment"><?php echo $text_tab_comment; ?> <?php if(isset($error_tabComment)) { echo $error_tabComment; } ?></a>
               <a href="#tabSearch"><?php echo $text_tab_search; ?> <?php if(isset($error_tabSearch)) { echo $error_tabSearch; } ?></a>
               <a href="#tabAdmin"><?php echo $text_tab_admin; ?> <?php if(isset($error_tabAdmin)) { echo $error_tabAdmin; } ?></a>
            </div>
            
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="blogSetting">
               <div id="tabBlog">
                  <table class="form blogSetting">
                     <tr>
                        <td><?php echo $entry_blog_name; ?></td>
                        <td><input type="text" name="blogName" value="<?php echo $blogNameValue; ?>" /></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_blog_keyword; ?></td>
                        <td><textarea name="blogKeyword" cols="40" rows="5"><?php echo $blogKeywordValue; ?></textarea><?php echo $entry_blog_keyword_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_blog_description; ?></td>
                        <td><textarea name="blogDescription" cols="40" rows="5"><?php echo $blogDescriptionValue; ?></textarea><?php echo $entry_blog_description_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_blog_exclude; ?></td>
                        <td><input type="text" name="blogExclude" value="<?php echo $blogExcludeValue; ?>" /><?php echo $entry_blog_exclude_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_blog_suffix; ?></td>
                        <td><input type="text" name="blogSuffix" value="<?php echo $blogSuffixValue; ?>" /><?php echo $entry_blog_suffix_help; ?></td>
                     </tr>
                  </table>
               </div>
               
               <div id="tabCategory">
                  <table class="form blogSetting">
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_setting_show_category; ?></td>
                        <td class="input_35">
                           <input type="text" name="articleCat" value="<?php echo $articleCatValue; ?>" />
                           <?php if ($error_articleCat) { ?><span class="error"><?php echo $error_articleCat; ?></span><?php } ?>
                           <?php echo $entry_setting_show_category_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_setting_description; ?></td>
                        <td class="input_35">
                           <input type="text" name="articleDesc" value="<?php echo $articleDescValue; ?>" />
                           <?php if ($error_articleDesc) { ?><span class="error"><?php echo $error_articleDesc; ?></span><?php } ?>
                           <?php echo $entry_setting_description_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_image_featured; ?></td>
                        <td class="input_35"><input type="text" name="articleFeatWidth" value="<?php echo $articleFeatWidthValue; ?>" />
                           x
                           <input type="text" name="articleFeatHeight" value="<?php echo $articleFeatHeightValue; ?>" />
                           <?php if ($error_articleFeature) { ?><span class="error"><?php echo $error_articleFeature; ?></span><?php } ?>
                           <?php echo $entry_image_featured_help; ?>
                        </td>
                     </tr>
                     <tr><td colspan="2">&nbsp;</td></tr>
                     <tr>
                        <td><?php echo $entry_virtual_directory; ?></td>
                        <td class="select_90">
                           <select name="virDir">
                              <?php if (isset($virDirValue) && $virDirValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_virtual_directory_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_virdir_name; ?></td>
                        <td class="input_80"><input type="text" name="virDirName" value="<?php echo (isset($virDirNameValue) && $virDirNameValue) ? $virDirNameValue : 'blog'; ?>" /><?php echo $entry_virdir_name_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_virdir_exclude; ?></td>
                        <td><input type="text" name="virDirExclude" value="<?php echo (isset($virDirExcludeValue) && $virDirExcludeValue) ? $virDirExcludeValue : ''; ?>" /><?php echo $entry_virdir_exclude_help; ?></td>
                     </tr>
                  </table>
               </div>
               
               <div id="tabArticle">
                  <table class="form blogSetting">
                     <tr>
                        <td><?php echo $entry_setting_seosuffix; ?></td>
                        <td class="input_100"><input type="text" name="seoSuffix" value="<?php echo $seoSuffixValue; ?>" /><?php echo $entry_setting_seosuffix_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_setting_article_info; ?></td>
                        <td class="select_90">
                           <?php echo $entry_setting_article_info_help; ?>
                           <ul class="list-plain">
                              <li><input type="checkbox" name="artInfoName" <?php if(isset($artInfoNameValue)){ echo 'checked="checked"'; } ?>><label><?php echo $entry_setting_artinfo_author; ?><label></li>
                              <li><input type="checkbox" name="artInfoCategory" <?php if(isset($artInfoCategoryValue)){ echo 'checked="checked"'; } ?>><label><?php echo $entry_setting_artinfo_category; ?><label></li>
                              <li class="clear"><input type="checkbox" name="artInfoDate" <?php if(isset($artInfoDateValue)){ echo 'checked="checked"'; } ?>><label><?php echo $entry_setting_artinfo_date; ?><label></li>
                              <li><input type="checkbox" name="artInfoComment" <?php if(isset($artInfoCommentValue)){ echo 'checked="checked"'; } ?>><label><?php echo $entry_setting_artinfo_comment; ?><label></li>
                              <li class="clear"><input type="checkbox" name="artInfoUpdate" <?php if(isset($artInfoUpdateValue)){ echo 'checked="checked"'; } ?>><label><?php echo $entry_setting_artinfo_update; ?><label></li>
                           </ul>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_setting_product_related; ?></td>
                        <td class="input_35">
                           <input type="text" name="relProduct" value="<?php echo $relProductValue; ?>" />
                           <?php if ($error_relProduct) { ?><span class="error"><?php echo $error_relProduct; ?></span><?php } ?>
                           <?php echo $entry_setting_product_related_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_setting_product_image; ?></td>
                        <td class="input_35">
                           <input type="text" name="relProductWidth" value="<?php echo $relProductWidthValue; ?>" /> x 
                           <input type="text" name="relProductHeight" value="<?php echo $relProductHeightValue; ?>" />
                           <?php if ($error_relProductWH) { ?><span class="error"><?php echo $error_relProductWH; ?></span><?php } ?>
                           <?php echo $entry_setting_product_image_help; ?>
                        </td>
                     </tr>
                     <tr><td colspan="2">&nbsp;</td></tr>
                     <tr>
                        <td><?php echo $entry_setting_socmed; ?></td>
                        <td class="select_90">
                           <select name="socMedia">
                              <?php if ($socMediaValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_setting_socmed_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_setting_addthis; ?></td>
                        <td><input type="text" name="pubID" value="<?php echo $pubIDValue; ?>" /><?php echo $entry_setting_addthis_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_setting_socmedcode; ?></td>
                        <td>
                           <textarea name="socMedCode" cols="40" rows="10"><?php echo $socMedCodeValue; ?></textarea><?php echo $entry_setting_socmedcode_help; ?>
                        </td>
                     </tr>
                  </table>
               </div>
               
               <div id="tabComment">
                  <table class="form blogSetting">
                     <tr>
                        <td><?php echo $entry_comment_status; ?></td>
                        <td class="select_90">
                           <select name="commentStatus">
                              <?php if ($commentStatusValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_comment_status_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_comment_characters; ?></td>
                        <td class="input_35">
                           <input type="text" name="commentMin" value="<?php echo $commentMinValue; ?>" /> - 
                           <input type="text" name="commentMax" value="<?php echo $commentMaxValue; ?>" />
                           <?php if ($error_commentMinMax) { ?><span class="error"><?php echo $error_commentMinMax; ?></span><?php } ?>
                           <?php echo $entry_comment_characters_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_disabled_group; ?></td>
                        <td class="input_100"><input type="text" name="commentDisableGroup" value="<?php echo $commentDisableGroupValue; ?>" /><?php echo $entry_comment_disabled_group_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_perarticle; ?></td>
                        <td class="input_35"><input type="text" name="commentLimit" value="<?php echo $commentLimitValue; ?>" /><?php echo $entry_comment_perarticle_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_avatar; ?></td>
                        <td class="input_35"><input type="text" name="commentAvatar" value="<?php echo $commentAvatarValue; ?>" /><?php echo $entry_comment_avatar_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_auto_approve; ?></td>
                        <td class="select_90">
                           <select name="commentDefApprove">
                              <?php if ($commentDefApproveValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_comment_auto_approve_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_approve_group; ?></td>
                        <td class="input_100"><input type="text" name="commentApproveGroup" value="<?php echo $commentApproveGroupValue; ?>" /><?php echo $entry_comment_approve_group_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_badge; ?></td>
                        <td class="input_100"><input type="text" name="commentBadgeGroup" value="<?php echo $commentBadgeGroupValue; ?>" /><?php echo $entry_comment_badge_help; ?></td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_comment_captcha; ?></td>
                        <td class="select_175">
                           <select name="commentCaptha">
                              <option value="disabled" <?php if($commentCapthaValue == 'disabled'){ echo 'selected="selected"'; } ?>><?php echo $text_disabled; ?></option>
                              <option value="guest" <?php if($commentCapthaValue == 'guest'){ echo 'selected="selected"'; } ?>><?php echo $text_gueast_only; ?></option>
                              <option value="visitor" <?php if($commentCapthaValue == 'visitor'){ echo 'selected="selected"'; } ?>><?php echo $text_all_visitor; ?></option>
                              <option value="nondefault" <?php if($commentCapthaValue == 'nondefault'){ echo 'selected="selected"'; } ?>><?php echo $text_non_default; ?></option>
                           </select>
                           <?php echo $entry_comment_captcha_help; ?>
                        </td>
                     </tr>
                  </table>
               </div>
               
               <div id="tabSearch">
                  <table class="form blogSetting">
                     <tr>
                        <td><?php echo $entry_search_status; ?></td>
                        <td class="select_90">
                           <select name="searchStatus">
                              <?php if (isset($searchStatusValue) && $searchStatusValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_search_status_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_search_limit; ?></td>
                        <td class="input_35">
                           <input type="text" name="searchLimit" value="<?php echo $searchLimitValue; ?>" />
                           <?php if ($error_searchLimit) { ?><span class="error"><?php echo $error_searchLimit; ?></span><?php } ?>
                           <?php echo $entry_search_limit_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><?php echo $entry_search_display; ?></td>
                        <td class="select_125">
                           <select name="searchDisplay">
                              <option value="plain" <?php if($searchDisplayValue == 'plain'){ echo 'selected="selected"'; } ?>><?php echo $text_plain_list; ?></option>
                              <option value="compact" <?php if($searchDisplayValue == 'compact'){ echo 'selected="selected"'; } ?>><?php echo $text_compact_list; ?></option>
                              <option value="grid" <?php if($searchDisplayValue == 'grid'){ echo 'selected="selected"'; } ?>><?php echo $text_grid; ?></option>
                           </select>
                           <?php echo $entry_search_display_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_search_gridrow; ?></td>
                        <td class="input_35">
                           <input type="text" name="searchGrid" value="<?php echo $searchGridValue; ?>" />
                           <?php if ($error_searchGrid) { ?><span class="error"><?php echo $error_searchGrid; ?></span><?php } ?>
                           <?php echo $entry_search_gridrow_help; ?>
                        </td>
                     </tr>
                     <tr><td colspan="2">&nbsp;</td></tr>
                     <tr>
                        <td><?php echo $entry_blog_feed; ?></td>
                        <td class="select_90">
                           <select name="blogFeed">
                              <?php if ($blogFeedValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_blog_feed_help; ?>
                        </td>
                     </tr>
                     <tr>
                        <td style="vertical-align:top"><?php echo $entry_blog_sitemap; ?></td>
                        <td class="select_90">
                           <select name="blogSitemap">
                              <?php if ($blogSitemapValue) { ?>
                                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                 <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                                 <option value="1"><?php echo $text_enabled; ?></option>
                                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                           </select>
                           <?php echo $entry_blog_sitemap_help; ?>
                           <?php echo $entry_blog_htaccess_help; ?>
                        </td>
                     </tr>
                  </table>
               </div>
               
               <div id="tabAdmin">
                  <table class="form blogSetting">
                     <tr>
                        <td><span class="required">*</span> <?php echo $entry_setting_show_admin; ?></td>
                        <td class="input_35">
                           <input type="text" name="articleAdmin" value="<?php echo $articleAdminValue; ?>" />
                           <?php if ($error_articleAdmin) { ?><span class="error"><?php echo $error_articleAdmin; ?></span><?php } ?>
                           <?php echo $entry_setting_show_admin_help; ?>
                        </td>
                     </tr>
                  </table>
               </div>
               
            </form>
         <?php } else { ?>
            <div class="attention">
               <?php echo $error_nopermission; ?>
            </div>
         <?php } ?>
      </div>
      
      <div id="et-footer">
         Blog Manager &copy; <?php if ((date('Y')) == '2011') { echo date('Y'); } else { echo '2011 - '.date('Y');};?> <a href="http://www.echothemes.com" target="_blank">EchoThemes</a>. All right reserved. <br />
         <a href="http://www.opencart.com" target="_blank">OpenCart</a> &copy; 2009-<?php echo date('Y');?> All Rights Reserved. <br /> Version <?php echo sprintf(VERSION); ?>
      </div>
   </div>
</div>

<script type="text/javascript" src="view/javascript/blog/blog.js"></script>
<?php echo $footer; ?>