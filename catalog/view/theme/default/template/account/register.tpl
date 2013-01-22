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
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form">      
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
          <td><input type="text" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
          <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" id="tel"/></td>
            <?php if ($error_telephone) { ?>
            <span class="error"><?php echo $error_telephone; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fax; ?></td>
          <td><input type="text" name="fax" value="<?php echo $fax; ?>" id="cel"/></td>
        </tr>
        <tr style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;">
          <td><?php echo $entry_account; ?></td>
          <td><select name="customer_group_id">
              <?php foreach ($customer_groups as $customer_group) { ?>
              <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
              <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        <tr id="company-display">
          <td><span id="company-required" class="required">*</span> <?php echo $entry_company; ?></td>
          <td><input type="text" name="company" value="<?php echo $company; ?>" />
            <?php if ($error_company) { ?>
            <span class="error"><?php echo $error_company; ?></span>
            <?php } ?></td>
        </tr>    
        <tr id="company-id-display">
          <td><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?></td>
          <td><input type="text" name="company_id" value="<?php echo $company_id; ?>" id="cnpj"/>
            <?php if ($error_company_id) { ?>
            <span class="error"><?php echo $error_company_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr id="tax-id-display">
          <td><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?></td>
          <td><input type="text" name="tax_id" value="<?php echo $tax_id; ?>" id="cpf"/>
            <?php if ($error_tax_id) { ?>
            <span class="error"><?php echo $error_tax_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr id="ie-display">
          <td><span id="ie-required" class="required">*</span> <?php echo $entry_ie; ?></td>
          <td><input type="text" name="ie" value="<?php echo $ie; ?>" />
            <?php if ($error_ie) { ?>
            <span class="error"><?php echo $error_ie; ?></span>
            <?php } ?></td>
        </tr>
        <tr id="rg-display">
          <td><span id="rg-required" class="required">*</span> <?php echo $entry_rg; ?></td>
          <td><input type="text" name="rg" value="<?php echo $rg; ?>" />
            <?php if ($error_rg) { ?>
            <span class="error"><?php echo $error_rg; ?></span>
            <?php } ?></td>
        </tr>
                   <tr id="sex-display"><?php echo $sex; ?>
           <td><span id="sex-required" class="required">*</span> <?php echo $entry_sex; ?></td>
           <td><select name="sex">
           <?php if ($sex == '') { ?>
                    <option value="" selected="selected"><?php echo $text_select; ?></option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <?php } ?>
           <?php if ($sex == 'Masculino') { ?>
                    <option value=""><?php echo $text_select; ?></option>
                    <option value="Masculino" selected="selected">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <?php } ?>
           <?php if ($sex == 'Feminino') { ?>
                    <option value=""><?php echo $text_select; ?></option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino" selected="selected">Feminino</option>
                    <?php } ?>
                  </select>
            <?php if ($error_sex) { ?>
            <span class="error"><?php echo $error_sex; ?></span>
            <?php } ?></td>
        </tr> 
        <tr id="birth-date-display">
          <td><span id="birth-date-required" class="required">*</span> <?php echo $entry_birth_date; ?></td>
          <td><input type="text" name="birth_date" value="<?php echo $birth_date; ?>" size="16" id="birth" />
            <?php if ($error_birth_date) { ?>
            <span class="error"><?php echo $error_birth_date; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_your_address; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
          <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" id="postcode"/>
            <?php if ($error_postcode) { ?>
            <span class="error"><?php echo $error_postcode; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
          <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" />
            <?php if ($error_address_1) { ?>
            <span class="error"><?php echo $error_address_1; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_number; ?></td>
          <td><input type="text" name="number" value="<?php echo $number; ?>" />
            <?php if ($error_number) { ?>
            <span class="error"><?php echo $error_number; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_complement; ?></td>
          <td><input type="text" name="complement" value="<?php echo $complement; ?>" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_address_2; ?></td>
          <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" />
            <?php if ($error_address_2) { ?>
            <span class="error"><?php echo $error_address_2; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_city; ?></td>
          <td><input type="text" name="city" value="<?php echo $city; ?>" />
            <?php if ($error_city) { ?>
            <span class="error"><?php echo $error_city; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_country; ?></td>
          <td><select name="country_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_country) { ?>
            <span class="error"><?php echo $error_country; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
          <td><select name="zone_id">
            </select>
            <?php if ($error_zone) { ?>
            <span class="error"><?php echo $error_zone; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_your_password; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />  <?php echo utf8_encode('<i>(Entre 4 a 20 caracteres)</i>'); ?>
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_newsletter; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td><?php if ($newsletter) { ?>
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="newsletter" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="right"><?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } ?>
  </form>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('select[name=\'customer_group_id\']').live('change', function() {
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['birth_date_display'] = '<?php echo $customer_group['birth_date_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['birth_date_required'] = '<?php echo $customer_group['birth_date_required']; ?>';
    customer_group[<?php echo $customer_group['customer_group_id']; ?>]['sex_display'] = '<?php echo $customer_group['sex_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['sex_required'] = '<?php echo $customer_group['sex_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_display'] = '<?php echo $customer_group['company_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_required'] = '<?php echo $customer_group['company_required']; ?>';
    customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['ie_display'] = '<?php echo $customer_group['ie_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['ie_required'] = '<?php echo $customer_group['ie_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['rg_display'] = '<?php echo $customer_group['rg_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['rg_required'] = '<?php echo $customer_group['rg_required']; ?>';
<?php } ?>	

	if (customer_group[this.value]) {
		if (customer_group[this.value]['birth_date_display'] == '1') {
			$('#birth-date-display').show();
		} else {
			$('#birth-date-display').hide();
		}
		
		if (customer_group[this.value]['birth_date_required'] == '1') {
			$('#birth-date-required').show();
		} else {
			$('#birth-date-required').hide();
		}
        
		if (customer_group[this.value]['sex_display'] == '1') {
			$('#sex-display').show();
		} else {
			$('#sex-display').hide();
		}
		
		if (customer_group[this.value]['sex_required'] == '1') {
			$('#sex-required').show();
		} else {
			$('#sex-required').hide();
		}
		
        if (customer_group[this.value]['company_display'] == '1') {
			$('#company-display').show();
		} else {
			$('#company-display').hide();
		}
		
		if (customer_group[this.value]['company_required'] == '1') {
			$('#company-required').show();
		} else {
			$('#company-required').hide();
		}
		
        if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}
		
		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}
		
		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}
		
		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}
        if (customer_group[this.value]['ie_display'] == '1') {
			$('#ie-display').show();
		} else {
			$('#ie-display').hide();
		}
		
		if (customer_group[this.value]['ie_required'] == '1') {
			$('#ie-required').show();
		} else {
			$('#ie-required').hide();
		}
		
		if (customer_group[this.value]['rg_display'] == '1') {
			$('#rg-display').show();
		} else {
			$('#rg-display').hide();
		}
		
		if (customer_group[this.value]['rg_required'] == '1') {
			$('#rg-required').show();
		} else {
			$('#rg-required').hide();
		}	
	}
});

$('select[name=\'customer_group_id\']').trigger('change');
//--></script>   
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('#dob').datepicker({changeMonth: true, changeYear: true, yearRange: '-80:-18', dateFormat: 'dd/mm/yy'});
});
//--></script>
<script type="text/javascript">
      jQuery(function($) {
      $("#postcode").mask("99999-999");
      $("#birth").mask("99/99/9999");
      $("#cpf").mask("999.999.999-99");
      $("#cnpj").mask("99.999.999/9999-99");
      $("#tel").mask("(99)9999-9999");
      $("#cel").mask("(99)9999-9999?9");
   });
</script>
<?php echo $footer; ?>