<div class="left">
  <h2><?php echo $text_your_details; ?></h2>
  <span class="required">*</span> <?php echo $entry_firstname; ?><br />
  <input type="text" name="firstname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_lastname; ?><br />
  <input type="text" name="lastname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_email; ?><br />
  <input type="text" name="email" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_telephone; ?><br />
  <input type="text" name="telephone" value="" class="large-field" id="tel"/>
  <br />
  <br />
  <?php echo $entry_fax; ?><br />
  <input type="text" name="fax" value="" class="large-field" id="cel"/>
  <br />
  <br />
  <div style="display: <?php echo (count($customer_groups) > 1 ? 'block' : 'none'); ?>;"><?php echo $entry_account; ?><br />
    <select name="customer_group_id" class="large-field">
      <?php foreach ($customer_groups as $customer_group) { ?>
      <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
      <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
      <?php } else { ?>
      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
      <?php } ?>
      <?php } ?>
    </select>
    <br />
    <br />
  </div>
  <div id="company-display"><span id="company-required" class="required">*</span> <?php echo $entry_company; ?><br />
    <input type="text" name="company" value="" class="large-field" />
    <br />
    <br />
  </div>
  <div id="company-id-display"><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?><br />
    <input type="text" name="company_id" value="" class="large-field" id="cnpj"/>
    <br />
    <br />
  </div>
  <div id="tax-id-display"><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?><br />
    <input type="text" name="tax_id" value="" class="large-field" id="cpf"/>
    <br />
    <br />
  </div>
  <div id="rg-display"><span id="rg-required" class="required">*</span> <?php echo $entry_rg; ?><br />
    <input type="text" name="rg" value="" class="large-field" />
    <br />
    <br />
  </div>
  <div id="ie-display"><span id="ie-required" class="required">*</span> <?php echo $entry_ie; ?><br />
    <input type="text" name="ie" value="" class="large-field" />
    <br />
    <br />
  </div>
  <div id="sex-display"><span id="sex-required" class="required">*</span> <?php echo $entry_sex; ?><br />
           <select name="sex">
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
    <br />
    <br />
  </div>
  <div id="birth-date-display"><span id="birth-date-required" class="required">*</span> <?php echo $entry_birth_date; ?><br />
    <input type="text" name="birth_date" value="" size="16" id="birth"/>
    <br />
    <br />
  </div>
  <h2><?php echo $text_your_password; ?></h2>
  <span class="required">*</span> <?php echo $entry_password; ?><br />
  <input type="password" name="password" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_confirm; ?> <br />
  <input type="password" name="confirm" value="" class="large-field" />
  <br />
  <br />
  <br />
</div>
<div class="right">
  <h2><?php echo $text_your_address; ?></h2>
  <span id="payment-postcode-required" class="required">*</span> <?php echo $entry_postcode; ?><br />
  <input type="text" name="postcode" value="<?php echo $postcode; ?>" class="large-field" id="postcode"/>
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_address_1; ?><br />
  <input type="text" name="address_1" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_number; ?><br />
  <input type="text" name="number" value="" class="large-field" />
  <br />
  <br />
  <?php echo $entry_complement; ?><br />
  <input type="text" name="complement" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_address_2; ?><br />
  <input type="text" name="address_2" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_city; ?><br />
  <input type="text" name="city" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_country; ?><br />
  <select name="country_id" class="large-field">
    <option value=""><?php echo $text_select; ?></option>
    <?php foreach ($countries as $country) { ?>
    <?php if ($country['country_id'] == $country_id) { ?>
    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_zone; ?><br />
  <select name="zone_id" class="large-field">
  </select>
  <br />
  <br />
  <br />
</div>
<div style="clear: both; padding-top: 15px; border-top: 1px solid #EEEEEE;">
  <input type="checkbox" name="newsletter" value="1" id="newsletter" />
  <label for="newsletter"><?php echo $entry_newsletter; ?></label>
  <br />
  <?php if ($shipping_required) { ?>
  <input type="checkbox" name="shipping_address" value="1" id="shipping" checked="checked" />
  <label for="shipping"><?php echo $entry_shipping; ?></label>
  <br />
  <?php } ?>
  <br />
  <br />
</div>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="right"><?php echo $text_agree; ?>
    <input type="checkbox" name="agree" value="1" />
    <input type="button" value="<?php echo $button_continue; ?>" id="button-register" class="button" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-register" class="button" />
  </div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$('#payment-address select[name=\'customer_group_id\']').live('change', function() {
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

$('#payment-address select[name=\'customer_group_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#payment-address select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#payment-address select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#payment-postcode-required').show();
			} else {
				$('#payment-postcode-required').hide();
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
			
			$('#payment-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#payment-address select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
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