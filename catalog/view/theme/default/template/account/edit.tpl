<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form">
        <?php if ($company) { ?>
          <tr>
            <td><?php echo $entry_company; ?></td>
            <td><?php echo $company; ?></td>
          </tr>
          <?php } ?>
          <?php if ($tax_id) { ?>
          <tr>
            <td><?php echo $entry_tax_id; ?></td>
            <td><?php echo $tax_id; ?></td>
          </tr>
          <?php } ?>
          <?php if ($company_id) { ?>
          <tr>
            <td><?php echo $entry_company_id; ?></td>
            <td><?php echo $company_id; ?></td>
          </tr>
          <?php } ?>
          <?php if ($ie) { ?>
          <tr>
            <td><?php echo $entry_ie; ?></td>
            <td><?php echo $ie; ?></td>
          </tr>
          <?php } ?>
          <?php if ($rg) { ?>
          <tr>
            <td><?php echo $entry_rg; ?></td>
            <td><?php echo $rg; ?></td>
          </tr>
          <?php } ?>
          <?php if ($sex) { ?>
          <tr>
            <td><?php echo $entry_sex; ?></td>
            <td><?php echo $sex; ?></td>
          </tr>
          <?php } ?>
          <?php if ($birth_date) { ?>
          <tr>
            <td><?php echo $entry_birth_date; ?></td>
            <td><?php echo $birth_date; ?></td>
          </tr>
          <?php } ?>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
          <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
            <?php if ($error_firstname) { ?>
            <span class="error"><?php echo $error_firstname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
          <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
            <?php if ($error_lastname) { ?>
            <span class="error"><?php echo $error_lastname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />  <?php echo utf8_encode('<i>(eu@exemplo.com)</i>'); ?>
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
          <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />  <?php echo utf8_encode('<i>(DDD sem 0 e apenas números: "7199999999")</i>'); ?>
            <?php if ($error_telephone) { ?>
            <span class="error"><?php echo $error_telephone; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fax; ?></td>
          <td><input type="text" name="fax" value="<?php echo $fax; ?>" />  <?php echo utf8_encode('<i>(DDD sem 0 e apenas números: "7199999999")</i>'); ?></td>
        </tr>
      </table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>