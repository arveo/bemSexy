<?php 
class ControllerCheckoutGuest extends Controller {
  	public function index() {
    	$this->language->load('checkout/checkout');
		
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_your_details'] = $this->language->get('text_your_details');
		$this->data['text_your_account'] = $this->language->get('text_your_account');
		$this->data['text_your_address'] = $this->language->get('text_your_address');
		
		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');	
        $this->data['entry_ie'] = $this->language->get('entry_ie');
		$this->data['entry_rg'] = $this->language->get('entry_rg');
        $this->data['entry_birth_date'] = $this->language->get('entry_birth_date');
		$this->data['entry_sex'] = $this->language->get('entry_sex');		
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
        $this->data['entry_number'] = $this->language->get('entry_number');
        $this->data['entry_complement'] = $this->language->get('entry_complement');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		
		if (isset($this->session->data['guest']['firstname'])) {
			$this->data['firstname'] = $this->session->data['guest']['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->session->data['guest']['lastname'])) {
			$this->data['lastname'] = $this->session->data['guest']['lastname'];
		} else {
			$this->data['lastname'] = '';
		}
		
		if (isset($this->session->data['guest']['email'])) {
			$this->data['email'] = $this->session->data['guest']['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->session->data['guest']['telephone'])) {
			$this->data['telephone'] = $this->session->data['guest']['telephone'];		
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->session->data['guest']['fax'])) {
			$this->data['fax'] = $this->session->data['guest']['fax'];				
		} else {
			$this->data['fax'] = '';
		}

		$this->load->model('account/customer_group');

		$this->data['customer_groups'] = array();
		
		if (is_array($this->config->get('config_customer_group_display'))) {
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();
			
			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}
		
		if (isset($this->session->data['guest']['customer_group_id'])) {
    		$this->data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		// Company
		if (isset($this->session->data['guest']['company'])) {
			$this->data['company'] = $this->session->data['guest']['company'];			
		} else {
			$this->data['company'] = '';
		}
		
		// Company ID
		if (isset($this->session->data['guest']['company_id'])) {
			$this->data['company_id'] = $this->session->data['guest']['company_id'];			
		} else {
			$this->data['company_id'] = '';
		}
		
		// Tax ID
		if (isset($this->session->data['guest']['tax_id'])) {
			$this->data['tax_id'] = $this->session->data['guest']['tax_id'];			
		} else {
			$this->data['tax_id'] = '';
		}
		
		// IE
		if (isset($this->session->data['guest']['ie'])) {
			$this->data['ie'] = $this->session->data['guest']['ie'];			
		} else {
			$this->data['ie'] = '';
		}
		
		// RG
		if (isset($this->session->data['guest']['rg'])) {
			$this->data['rg'] = $this->session->data['guest']['rg'];			
		} else {
			$this->data['rg'] = '';
		}
		
		// BirthDtate
		if (isset($this->session->data['guest']['birth_date'])) {
			$this->data['birth_date'] = $this->session->data['guest']['birth_date'];			
		} else {
			$this->data['birth_date'] = '';
		}
		
		// Sex
		if (isset($this->session->data['guest']['sex'])) {
			$this->data['sex'] = $this->session->data['guest']['sex'];			
		} else {
			$this->data['sex'] = '';
		}
								
		if (isset($this->session->data['guest']['payment']['address_1'])) {
			$this->data['address_1'] = $this->session->data['guest']['payment']['address_1'];			
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->session->data['guest']['payment']['address_2'])) {
			$this->data['address_2'] = $this->session->data['guest']['payment']['address_2'];			
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->session->data['guest']['payment']['postcode'])) {
			$this->data['postcode'] = $this->session->data['guest']['payment']['postcode'];							
		} elseif (isset($this->session->data['shipping_postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_postcode'];			
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->session->data['guest']['payment']['city'])) {
			$this->data['city'] = $this->session->data['guest']['payment']['city'];			
		} else {
			$this->data['city'] = '';
		}

		if (isset($this->session->data['guest']['payment']['country_id'])) {
			$this->data['country_id'] = $this->session->data['guest']['payment']['country_id'];			  	
		} elseif (isset($this->session->data['shipping_country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_country_id'];		
		} else {
			$this->data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->session->data['guest']['payment']['zone_id'])) {
			$this->data['zone_id'] = $this->session->data['guest']['payment']['zone_id'];	
		} elseif (isset($this->session->data['shipping_zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_zone_id'];						
		} else {
			$this->data['zone_id'] = '';
		}
					
		$this->load->model('localisation/country');
		
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		
		$this->data['shipping_required'] = $this->cart->hasShipping();
		
		if (isset($this->session->data['guest']['shipping_address'])) {
			$this->data['shipping_address'] = $this->session->data['guest']['shipping_address'];			
		} else {
			$this->data['shipping_address'] = true;
		}			
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/guest.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/guest.tpl';
		} else {
			$this->template = 'default/template/checkout/guest.tpl';
		}
		
		$this->response->setOutput($this->render());		
  	}
	
	public function validate() {
    	$this->language->load('checkout/checkout');

		$json = array();
		
		// Validate if customer is logged in.
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		} 			
		
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');		
		}
		
		// Check if guest checkout is avaliable.			
		if (!$this->config->get('config_guest_checkout') || $this->config->get('config_customer_price') || $this->cart->hasDownload()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		} 
					
		if (!$json) {
			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}
	
			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				$json['error']['lastname'] = $this->language->get('error_lastname');
			}
	
			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$json['error']['email'] = $this->language->get('error_email');
			}
			
			if ((utf8_strlen($this->request->post['telephone']) < 13) || (utf8_strlen($this->request->post['telephone']) > 13)) {
				$json['error']['telephone'] = $this->language->get('error_telephone');
			}

			// Customer Group
			$this->load->model('account/customer_group');
			
			if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
				$customer_group_id = $this->request->post['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}
			
			$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
				
			if ($customer_group) {	
				// Company
				if ($customer_group['company_display'] && $customer_group['company_required'] && !$this->request->post['company']) {
					$json['error']['company'] = $this->language->get('error_company_r');
				}
				
				// Tax ID
				if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && !$this->request->post['tax_id']) {
					$json['error']['tax_id'] = $this->language->get('error_tax_id');
				}
                
                // Company ID
				if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && !$this->request->post['company_id']) {
					$json['error']['company_id'] = $this->language->get('error_company_id');
				}
				
				// IE
				if ($customer_group['ie_display'] && $customer_group['ie_required'] && !$this->request->post['ie']) {
					$json['error']['ie'] = $this->language->get('error_ie');
				}
                
                // RG
				if ($customer_group['rg_display'] && $customer_group['rg_required'] && !$this->request->post['rg']) {
					$json['error']['rg'] = $this->language->get('error_rg');
				}
				
				// SEX
				if ($customer_group['sex_display'] && $customer_group['sex_required'] && !$this->request->post['sex']) {
					$json['error']['sex'] = $this->language->get('error_sex');
				}
                
                // BIRTH DATE
				if ($customer_group['birth_date_display'] && $customer_group['birth_date_required'] && !$this->request->post['birth_date']) {
					$json['error']['birth_date'] = $this->language->get('error_birth_date');
				}
            
            						
			}
						
			if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
				$json['error']['address_1'] = $this->language->get('error_address_1');
			}
				
			if ((utf8_strlen($this->request->post['number']) < 2) || (utf8_strlen($this->request->post['number']) > 128)) {
				$json['error']['number'] = $this->language->get('error_number');
			}
				
			if ((utf8_strlen($this->request->post['address_2']) < 3) || (utf8_strlen($this->request->post['address_2']) > 128)) {
				$json['error']['address_2'] = $this->language->get('error_address_2');
			}
	
			if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
				$json['error']['city'] = $this->language->get('error_city');
			}
			
			$this->load->model('localisation/country');
			
			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
			
			if ($country_info) {
				if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 9) || (utf8_strlen($this->request->post['postcode']) > 9)) {
					$json['error']['postcode'] = $this->language->get('error_postcode');
				}
				
			// VAT Validation
				$this->load->helper('vat');
				
				if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($this->request->post['tax_id']) != 'true')) {
					$json['error']['tax_id'] = $this->language->get('error_vat');
				}

			// Company Validation
			$this->load->helper('company');

			if ($this->config->get('config_company') && $this->request->post['company_id'] && (company_validation($this->request->post['company_id']) != 'true')) {
				$json['error']['company_id'] = $this->language->get('error_company');
			}
            					
			}
	
			if ($this->request->post['country_id'] == '') {
				$json['error']['country'] = $this->language->get('error_country');
			}
			
			if ($this->request->post['zone_id'] == '') {
				$json['error']['zone'] = $this->language->get('error_zone');
			}	
		}
			
		if (!$json) {
			$this->session->data['guest']['customer_group_id'] = $customer_group_id;
			$this->session->data['guest']['firstname'] = $this->request->post['firstname'];
			$this->session->data['guest']['lastname'] = $this->request->post['lastname'];
			$this->session->data['guest']['email'] = $this->request->post['email'];
			$this->session->data['guest']['telephone'] = $this->request->post['telephone'];
			$this->session->data['guest']['birth_date'] = $this->request->post['birth_date'];
            $this->session->data['guest']['sex'] = $this->request->post['sex'];
            $this->session->data['guest']['fax'] = $this->request->post['fax'];            
            $this->session->data['guest']['company'] = $this->request->post['company'];
			$this->session->data['guest']['company_id'] = $this->request->post['company_id'];
			$this->session->data['guest']['tax_id'] = $this->request->post['tax_id'];
            $this->session->data['guest']['ie'] = $this->request->post['ie'];
            $this->session->data['guest']['rg'] = $this->request->post['rg'];  
            			
			$this->session->data['guest']['payment']['firstname'] = $this->request->post['firstname'];
			$this->session->data['guest']['payment']['lastname'] = $this->request->post['lastname'];				
			$this->session->data['guest']['payment']['address_1'] = $this->request->post['address_1'];
            $this->session->data['guest']['payment']['number'] = $this->request->post['number'];
            $this->session->data['guest']['payment']['complement'] = $this->request->post['complement'];
			$this->session->data['guest']['payment']['address_2'] = $this->request->post['address_2'];
			$this->session->data['guest']['payment']['postcode'] = $this->request->post['postcode'];
			$this->session->data['guest']['payment']['city'] = $this->request->post['city'];
			$this->session->data['guest']['payment']['country_id'] = $this->request->post['country_id'];
			$this->session->data['guest']['payment']['zone_id'] = $this->request->post['zone_id'];
							
			$this->load->model('localisation/country');
			
			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
			
			if ($country_info) {
				$this->session->data['guest']['payment']['country'] = $country_info['name'];	
				$this->session->data['guest']['payment']['iso_code_2'] = $country_info['iso_code_2'];
				$this->session->data['guest']['payment']['iso_code_3'] = $country_info['iso_code_3'];
				$this->session->data['guest']['payment']['address_format'] = $country_info['address_format'];
			} else {
				$this->session->data['guest']['payment']['country'] = '';	
				$this->session->data['guest']['payment']['iso_code_2'] = '';
				$this->session->data['guest']['payment']['iso_code_3'] = '';
				$this->session->data['guest']['payment']['address_format'] = '';
			}
						
			$this->load->model('localisation/zone');

			$zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);
			
			if ($zone_info) {
				$this->session->data['guest']['payment']['zone'] = $zone_info['name'];
				$this->session->data['guest']['payment']['zone_code'] = $zone_info['code'];
			} else {
				$this->session->data['guest']['payment']['zone'] = '';
				$this->session->data['guest']['payment']['zone_code'] = '';
			}
			
			if (!empty($this->request->post['shipping_address'])) {
				$this->session->data['guest']['shipping_address'] = true;
			} else {
				$this->session->data['guest']['shipping_address'] = false;
			}
			
			// Default Payment Address
			$this->session->data['payment_country_id'] = $this->request->post['country_id'];
			$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
			
			if ($this->session->data['guest']['shipping_address']) {
				$this->session->data['guest']['shipping']['firstname'] = $this->request->post['firstname'];
				$this->session->data['guest']['shipping']['lastname'] = $this->request->post['lastname'];
				$this->session->data['guest']['shipping']['company'] = $this->request->post['company'];
				$this->session->data['guest']['shipping']['address_1'] = $this->request->post['address_1'];
                $this->session->data['guest']['shipping']['number'] = $this->request->post['number'];
                $this->session->data['guest']['shipping']['complement'] = $this->request->post['complement'];
				$this->session->data['guest']['shipping']['address_2'] = $this->request->post['address_2'];
				$this->session->data['guest']['shipping']['postcode'] = $this->request->post['postcode'];
				$this->session->data['guest']['shipping']['city'] = $this->request->post['city'];
				$this->session->data['guest']['shipping']['country_id'] = $this->request->post['country_id'];
				$this->session->data['guest']['shipping']['zone_id'] = $this->request->post['zone_id'];
				
				if ($country_info) {
					$this->session->data['guest']['shipping']['country'] = $country_info['name'];	
					$this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
					$this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
					$this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
				} else {
					$this->session->data['guest']['shipping']['country'] = '';	
					$this->session->data['guest']['shipping']['iso_code_2'] = '';
					$this->session->data['guest']['shipping']['iso_code_3'] = '';
					$this->session->data['guest']['shipping']['address_format'] = '';
				}
	
				if ($zone_info) {
					$this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
					$this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
				} else {
					$this->session->data['guest']['shipping']['zone'] = '';
					$this->session->data['guest']['shipping']['zone_code'] = '';
				}
				
				// Default Shipping Address
				$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
				$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
				$this->session->data['shipping_postcode'] = $this->request->post['postcode'];
			}
			
			$this->session->data['account'] = 'guest';
			
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
		}
					
		$this->response->setOutput(json_encode($json));	
	}
	
  	public function zone() {
		$output = '<option value="">' . $this->language->get('text_select') . '</option>';
		
		$this->load->model('localisation/zone');

    	$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
        
      	foreach ($results as $result) {
        	$output .= '<option value="' . $result['zone_id'] . '"';
	
	    	if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['name'] . '</option>';
    	} 
		
		if (!$results) {
		  	$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
		}
	
		$this->response->setOutput($output);
  	}
}
?>