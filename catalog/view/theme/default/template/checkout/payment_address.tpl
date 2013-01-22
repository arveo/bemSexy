<?php if ($addresses) { ?>
<div id="payment-existing" style="width: 48%; float: left;">
<p>
<input type="radio" name="payment_address" value="existing" id="payment-address-existing" checked="checked"/>
<label for="payment-address-existing"><?php echo $text_address_existing; ?></label>
</p>
  <select name="address_id" style="width: 100%; margin-right: 15px;" size="5">
    <?php foreach ($addresses as $address) { ?>
    <?php if ($address['address_id'] == $address_id) { ?>
    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['address_1']; ?>, <?php echo $address['number']; ?> - <?php echo $address['complement']; ?>. <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?>, <?php echo $address['postcode']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['address_1']; ?>, <?php echo $address['number']; ?> - <?php echo $address['complement']; ?>. <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?>, <?php echo $address['postcode']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
</div>
<div id="payment-new" style="width: 50%; float: right;">
<p>
  <input type="radio" name="payment_address" value="new" id="payment-address-new" />
  <label for="payment-address-new"><?php echo $text_address_new; ?></label>
</p>
  <table class="form">
    <tr hidden="hidden">
      <td><?php echo $entry_company; ?></td>
      <td><input type="text" name="company" disabled="disabled" value="<?php echo $this->customer->getCompany() ?>" class="large-field" /></td>
    </tr>
    <tr hidden="hidden">
      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
      <td><input type="text" name="firstname" disabled="disabled" readonly="readonly" value="<?php echo $this->customer->getFirstName() ?>" class="large-field" /></td>
    </tr>
    <tr hidden="hidden">
      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
      <td><input type="text" name="lastname" disabled="disabled" value="<?php echo $this->customer->getLastName() ?>" class="large-field" /></td>
    </tr>
    <tr>
      <td><span id="payment-postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
      <td><input type="text" name="postcode" disabled="disabled" value="" class="large-field"  id="postcode"/></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
      <td><input type="text" name="address_1" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_number; ?></td>
      <td><input type="text" name="number" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_complement; ?></td>
      <td><input type="text" name="complement" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_address_2; ?></td>
      <td><input type="text" name="address_2" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_city; ?></td>
      <td><input type="text" name="city" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_country; ?></td>
      <td><select name="country_id" disabled="disabled" class="large-field">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($countries as $country) { ?>
          <?php if ($country['country_id'] == $country_id) { ?>
          <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
      <td><select name="zone_id" disabled="disabled" class="large-field">
        </select></td>
    </tr>
  </table>
</div>
<br />
<?php } ?>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-address" class="button" />
  </div>
</div>
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item['category'] != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item['category'] + '</li>');
				
				currentCategory = item['category'];
			}
			
			self._renderItem(ul, item);
		});
	}
});

var zone_id = '<?php echo $zone_id; ?>';

$('#payment-new select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#payment-new select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
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
	    			
					if (json['zone'][i]['zone_id'] == zone_id) {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('#payment-new select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#payment-new select[name=\'country_id\']').trigger('change');

$('#payment-existing select[name=\'address_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/address&address_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json != '') {	
				$('#payment-new input[name=\'postcode\']').attr('value', json['postcode']);
                $('#payment-new input[name=\'address_1\']').attr('value', json['address_1']);
                $('#payment-new input[name=\'number\']').attr('value', json['number']);
                $('#payment-new input[name=\'complement\']').attr('value', json['complement']);
				$('#payment-new input[name=\'address_2\']').attr('value', json['address_2']);
				$('#payment-new input[name=\'city\']').attr('value', json['city']);
				$('#payment-new select[name=\'country_id\']').attr('value', json['country_id']);
                
                zone_id = json['zone_id'];				
			
				$('#payment-new select[name=\'country_id\']').trigger('change');
                
			}
		}
	});	
});


$('#payment-existing select[name=\'address_id\']').live('change', function() {
	if (this.value == 'new') {
		$('#payment-new input[name=\'postcode\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'address_1\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'number\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'complement\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'address_2\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'city\']').attr('disabled', false).attr('value', '');
        $('#payment-new select[name=\'country_id\']').attr('disabled', false).attr('value', '');
        $('#payment-new select[name=\'zone_id\']').attr('disabled', false).attr('value', '');                                                
		} else {
		$('#payment-new input[name=\'postcode\']').attr('disabled', true);
        $('#payment-new input[name=\'address_1\']').attr('disabled', true);
        $('#payment-new input[name=\'number\']').attr('disabled', true);
        $('#payment-new input[name=\'complement\']').attr('disabled', true);
        $('#payment-new input[name=\'address_2\']').attr('disabled', true);
        $('#payment-new input[name=\'city\']').attr('disabled', true);
        $('#payment-new select[name=\'country_id\']').attr('disabled', true);
        $('#payment-new select[name=\'zone_id\']').attr('disabled', true);        
	}
});

$('input[name=\'payment_address\']').live('change', function() {
	if (this.value == 'new') {
		$('#payment-new input[name=\'company\']').attr('disabled', false).attr('readonly', true);
        $('#payment-new input[name=\'firstname\']').attr('disabled', false).attr('readonly', true);
        $('#payment-new input[name=\'lastname\']').attr('disabled', false).attr('readonly', true);
        $('#payment-new input[name=\'postcode\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'address_1\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'number\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'complement\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'address_2\']').attr('disabled', false).attr('value', '');
        $('#payment-new input[name=\'city\']').attr('disabled', false).attr('value', '');
        $('#payment-new select[name=\'country_id\']').attr('disabled', false).attr('value', '');
        $('#payment-new select[name=\'zone_id\']').attr('disabled', false).attr('value', '');
        $('#payment-existing select[name=\'address_id\']').attr('disabled', true);                                                
		} else {
		$('#payment-new input[name=\'company\']').attr('disabled', true);
        $('#payment-new input[name=\'firstname\']').attr('disabled', true);
        $('#payment-new input[name=\'lastname\']').attr('disabled', true);
        $('#payment-new input[name=\'postcode\']').attr('disabled', true);
        $('#payment-new input[name=\'address_1\']').attr('disabled', true);
        $('#payment-new input[name=\'number\']').attr('disabled', true);
        $('#payment-new input[name=\'complement\']').attr('disabled', true);
        $('#payment-new input[name=\'address_2\']').attr('disabled', true);
        $('#payment-new input[name=\'city\']').attr('disabled', true);
        $('#payment-new select[name=\'country_id\']').attr('disabled', true);
        $('#payment-new select[name=\'zone_id\']').attr('disabled', true);
        $('#payment-existing select[name=\'address_id\']').attr('disabled', false);        
	}
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