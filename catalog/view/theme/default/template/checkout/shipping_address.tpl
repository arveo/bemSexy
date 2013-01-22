<?php if ($addresses) { ?>
<div id="shipping-existing" style="width: 48%; float: left;">
<p>
<input type="radio" name="shipping_address" value="existing" id="shipping-address-existing" checked="checked"/>
<label for="shipping-address-existing"><?php echo $text_address_existing; ?></label>
</p>
  <select name="address_id" style="width: 100%; margin-right: 15px;" size="5">
    <?php foreach ($addresses as $address) { ?>
    <?php if ($address['address_id'] == $address_id) { ?>
    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
</div>
<?php } ?>
<div id="shipping-new" style="width: 50%; float: right;">
<p>
  <input type="radio" name="shipping_address" value="new" id="shipping-address-new" />
  <label for="shipping-address-new"><?php echo $text_address_new; ?></label>
</p>
  <table class="form">
    <tr>
      <td><?php echo $entry_company; ?></td>
      <td><input type="text" name="company" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
      <td><input type="text" name="firstname" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
      <td><input type="text" name="lastname" disabled="disabled" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span id="shipping-postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
      <td><input type="text" name="postcode" disabled="disabled" value="<?php echo $postcode; ?>" class="large-field" id="postcode"/></td>
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
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-shipping-address" class="button" />
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

$('#shipping-new select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#shipping-new select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#shipping-postcode-required').show();
			} else {
				$('#shipping-postcode-required').hide();
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
			
			$('#shipping-new select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#shipping-new select[name=\'country_id\']').trigger('change');

$('#shipping-existing select[name=\'address_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/address&address_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json != '') {	
				$('#shipping-new input[name=\'company\']').attr('value', json['company']);
                $('#shipping-new input[name=\'firstname\']').attr('value', json['firstname']);
                $('#shipping-new input[name=\'lastname\']').attr('value', json['lastname']);
                $('#shipping-new input[name=\'postcode\']').attr('value', json['postcode']);
                $('#shipping-new input[name=\'address_1\']').attr('value', json['address_1']);
                $('#shipping-new input[name=\'number\']').attr('value', json['number']);
                $('#shipping-new input[name=\'complement\']').attr('value', json['complement']);
				$('#shipping-new input[name=\'address_2\']').attr('value', json['address_2']);
				$('#shipping-new input[name=\'city\']').attr('value', json['city']);
				$('#shipping-new select[name=\'country_id\']').attr('value', json['country_id']);
                
                zone_id = json['zone_id'];				
			
				$('#shipping-new select[name=\'country_id\']').trigger('change');
                
			}
		}
	});	
});


$('#shipping-existing select[name=\'address_id\']').live('click', function() {
	if (this.value == 'new') {
		$('#shipping-new input[name=\'company\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'firstname\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'lastname\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'postcode\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'address_1\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'number\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'complement\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'address_2\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'city\']').attr('disabled', false).attr('value', '');
        $('#shipping-new select[name=\'country_id\']').attr('disabled', false).attr('value', '');
        $('#shipping-new select[name=\'zone_id\']').attr('disabled', false).attr('value', '');
        $('#shipping-existing select[name=\'address_id\']').attr('disabled', true);                                                
		} else {
		$('#shipping-new input[name=\'company\']').attr('disabled', true);
        $('#shipping-new input[name=\'firstname\']').attr('disabled', true);
        $('#shipping-new input[name=\'lastname\']').attr('disabled', true);
        $('#shipping-new input[name=\'postcode\']').attr('disabled', true);
        $('#shipping-new input[name=\'address_1\']').attr('disabled', true);
        $('#shipping-new input[name=\'number\']').attr('disabled', true);
        $('#shipping-new input[name=\'complement\']').attr('disabled', true);
        $('#shipping-new input[name=\'address_2\']').attr('disabled', true);
        $('#shipping-new input[name=\'city\']').attr('disabled', true);
        $('#shipping-new select[name=\'country_id\']').attr('disabled', true);
        $('#shipping-new select[name=\'zone_id\']').attr('disabled', true); 
        $('#shipping-existing select[name=\'address_id\']').attr('disabled', false);        
	}
});

$('input[name=\'shipping_address\']').live('click', function() {
	if (this.value == 'new') {
		$('#shipping-new input[name=\'company\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'firstname\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'lastname\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'postcode\']').attr('disabled', false).attr('value', '').mask("99999-999");
        $('#shipping-new input[name=\'address_1\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'number\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'complement\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'address_2\']').attr('disabled', false).attr('value', '');
        $('#shipping-new input[name=\'city\']').attr('disabled', false).attr('value', '');
        $('#shipping-new select[name=\'country_id\']').attr('disabled', false).attr('value', '');
        $('#shipping-new select[name=\'zone_id\']').attr('disabled', false).attr('value', '');
        $('#shipping-existing select[name=\'address_id\']').attr('disabled', true);                                                
		} else {
		$('#shipping-new input[name=\'company\']').attr('disabled', true);
        $('#shipping-new input[name=\'firstname\']').attr('disabled', true);
        $('#shipping-new input[name=\'lastname\']').attr('disabled', true);
        $('#shipping-new input[name=\'postcode\']').attr('disabled', true);
        $('#shipping-new input[name=\'address_1\']').attr('disabled', true);
        $('#shipping-new input[name=\'number\']').attr('disabled', true);
        $('#shipping-new input[name=\'complement\']').attr('disabled', true);
        $('#shipping-new input[name=\'address_2\']').attr('disabled', true);
        $('#shipping-new input[name=\'city\']').attr('disabled', true);
        $('#shipping-new select[name=\'country_id\']').attr('disabled', true);
        $('#shipping-new select[name=\'zone_id\']').attr('disabled', true); 
        $('#shipping-existing select[name=\'address_id\']').attr('disabled', false);        
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