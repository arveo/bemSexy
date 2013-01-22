<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/feed.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="storeya_status">
                <?php if ($storeya_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td>Max amount of products</td>
            <td>
            <select name="tocount">
            <option value="50" <?php if($tocount==50) echo 'selected="selected"';?> >50</option>
            <option value="500" <?php if($tocount==500 || $tocount=='') echo 'selected="selected"';?>)>500</option>
            <option value="5000" <?php if($tocount==5000) echo 'selected="selected"';?>>5000</option>
            <option value="10000" <?php if($tocount==10000) echo 'selected="selected"';?>>10000</option>
            </select>
            
             <input type="hidden" name="fromcount" maxlength="5" size="5" value="0"/></td>
          </tr>
          <tr>
            <td><?php echo $entry_data_feed; ?></td>
            <td><textarea cols="40" rows="5"><?php echo $data_feed; ?></textarea></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>