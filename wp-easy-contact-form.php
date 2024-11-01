<?php
/*
Plugin Name: Wp Easy Contact Form
Plugin URI: https://wordpress.org/support/profile/amybeagh
Description: Contact Form Widget - Easy to use and small contact form and also available shortcode.
Version: 1.0
Author :Amy Beagh
Author URI: https://wordpress.org/support/profile/amybeagh
*/

class wecf_contact_mail_message{
	
	public $options;
	public function __construct() {

        $this->options = get_option('wecf_contact_mail_message_options');
		$this->wecf_contact_mail_register_fields();
	
    }
	
	public static function add_wecf_contact_setting_menu_options_page(){

        add_options_page('Wp Easy Contact Form', 'Wp Easy Contact Form', 'administrator', __FILE__, array('wecf_contact_mail_message','wecf_contact_mail_tools_options'));

    }
	
	public static function wecf_contact_mail_tools_options(){?>
    
    	<div class="artboard">
			<h2 class="top-style">Contact Form  Setting</h2>
  			<h4 class="wecf_shotcode">Use Shortcode "[wecf_contact_form_shortcode]" For Custom Show Page Or Post.</h4>
			<form method="post" action="options.php" enctype="multipart/form-data" >
				<?php settings_fields('wecf_contact_mail_message_options'); ?>
			 		<div id="general_outer">
                		<?php do_settings_sections(__FILE__);?>
            		</div>
  			<p class="submit">
         		<input name="submit" type="submit" class="button-default" value="Save Changes"/>
        	</p>
			</form>
		</div>

	<script>
    jQuery(document).ready(function() {
        jQuery( function() {
        jQuery( "#sortable" ).sortable({
            update: function(event, ui) { 
                console.log('update: '+ui.item.index())
                },
            start: function(event, ui) { 
                console.log('start: ' + ui.item.index())
            }
        });
    
      } );
    
    jQuery(document).on('change','.edit_label',function(){
        
            var thinkness_select =jQuery(this).val();
            
            var idval= jQuery('.edit_label').attr('id');
            
            jQuery(this).attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_label]['+idval+']');
            
            jQuery(this).parent().parent().find('.show_in_label').val(thinkness_select);
            
            jQuery(this).parent().parent().find('.show_in_placeholder').val(thinkness_select);
            
            jQuery(this).parent().parent().find('.show_in_required').val('required');
            
                    
    });		
    
    
    jQuery(document).on('change','.show_in_label',function(){	
    
            var thinkness_select =jQuery(this).parent().parent().find('.edit_label').val();
            
            jQuery(this).val(thinkness_select);
                
    });
    
    jQuery(document).on('change','.show_in_placeholder',function(){	
    
            var thinkness_select =jQuery(this).parent().parent().find('.edit_label').val();
            
            jQuery(this).val(thinkness_select);
        
    });		
    jQuery(document).on('change','.show_in_required',function(){	
    
            jQuery(this).val('required');
                
    });		
            
            
    
    jQuery(document).on('change','.edit_type',function(){
            
            var thinkness_select =jQuery(this).val();
    
            var idval= jQuery(this).attr('id');
             
            jQuery(this).attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_type]['+idval+']');
            
            jQuery(this).parent().parent().find('.show_in_label').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_full]['+idval+']['+thinkness_select+'][label]');
            
            jQuery(this).parent().parent().find('.show_in_placeholder').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_full]['+idval+']['+thinkness_select+'][placeholder]');
            
            jQuery(this).parent().parent().find('.show_in_required').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_full]['+idval+']['+thinkness_select+'][required]');
            
            
        });		
    });
    
    
    jQuery('#add_more').click(function(e) {
        
        
            var num = jQuery('.fieldset_outer').length; 
        
            var newElem = jQuery('#field-03.custom_outer').clone();
            
            var numadd=num++;
            
            newElem.attr("class", "fieldset_outer");
            
            var tt=newElem.attr("id", "field-"+numadd);
        
            newElem.find('.edit_label').attr("id", numadd);
           
            newElem.find('.edit_label').val('');
          
            newElem.find('.edit_label').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_label]['+numadd+']');
           
            newElem.find('.edit_type').attr("id", numadd);
           
            var field_type=  newElem.find('.edit_type').val();
          
            newElem.find('.show_in_label').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_full]['+numadd+']['+field_type+']');
           
           newElem.find('.show_in_placeholder').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_full]['+numadd+']['+field_type+']');
            
           newElem.find('.show_in_required').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_full]['+numadd+']['+field_type+']');
          
           
           newElem.find('.edit_type').attr("name", 'wecf_contact_mail_message_options[wecf_edit_field_type]['+numadd+']');
           
           jQuery('#sortable').append(newElem);
        
        });
        
           jQuery(document).on('click','.think_remove_add_more',function() {
    
            jQuery(this).parent().remove();
    
        });
        
    
    </script>
<?php }
	
	 public function wecf_contact_mail_register_fields(){

		register_setting('wecf_contact_mail_message_options', 'wecf_contact_mail_message_options',array($this,'wecf_contact_mail_validate_settings'));

        add_settings_section('wecf_contact_mail_main_section', 'Settings', array($this,'wecf_contact_mail_main_section_cb'), __FILE__);

   		add_settings_field('wecf_edit_field_label', 'Contact Form Field', array($this,'wecf_contact_edit_field_label'), __FILE__,'wecf_contact_mail_main_section');
		
         //wecf_name

        add_settings_field('wecf_name_field', 'Contact Form Title', array($this,'wecf_name_field_settings'), __FILE__,'wecf_contact_mail_main_section');

        //wecf_email

        add_settings_field('wecf_email_field', 'Recipient Email', array($this,'wecf_email_field_settings'), __FILE__,'wecf_contact_mail_main_section');

       //wecf_alignment option

         add_settings_field('wecf_alignment_field', 'Form Alignment', array($this,'wecf_position_field_settings'),__FILE__,'wecf_contact_mail_main_section');
 		
		//wecf_marginTop

        add_settings_field('wecf_marginTop_field', 'Margin Top', array($this,'wecf_marginTop_field_settings'), __FILE__,'wecf_contact_mail_main_section');


       add_settings_field('wecf_success_message_field', 'Success Message', array($this,'wecf_success_message_field_settings'), __FILE__,'wecf_contact_mail_main_section');

        ///cfw_error_message

        add_settings_field('wecf_error_message_field', 'Error Message', array($this,'wecf_error_message_field_settings'), __FILE__,'wecf_contact_mail_main_section');
		
	  }
	
	  public function wecf_contact_mail_validate_settings($plugin_options){

        return($plugin_options);
 	  }
	
	public function wecf_contact_mail_main_section_cb(){
		//optional
    }
	
	public function wecf_contact_mail_edit_field_section_fn(){
   		//optional

    }
	public function wecf_contact_edit_field_label() { ?>
      
	  <div id="sortable">
	  <?php
	  
	    if(!empty($this->options['wecf_edit_field_full'])){
		
		if(!empty($this->options['wecf_edit_field_label'])&&($fulledit_type = $this->options['wecf_edit_field_type'])){
			 $fulledit_field = $this->options['wecf_edit_field_label'];
		     $fulledit_type = $this->options['wecf_edit_field_type'];
		}
		
		foreach($this->options['wecf_edit_field_full'] as $key_no => $full_label){
			
		$key= stripslashes($key_no);
			foreach($full_label as $input_type_name => $label_in_array){
				
				$input_type= stripslashes($input_type_name);
			
			if(isset( $label_in_array['label']) &&  ($label_in_array['label']!='')){
			$label_name  = stripslashes($label_in_array['label']);
			}
			else{
		
				$label_name ='';
			}
			if(isset( $label_in_array['placeholder']) &&  ($label_in_array['placeholder']!='')){
			$label_placeholder  = stripslashes($label_in_array['placeholder']);
			}
			else{
		
				$label_placeholder ='';
			}
			if(isset( $label_in_array['required']) &&  ($label_in_array['required']!='')){
			$label_required  = stripslashes($label_in_array['required']);
			}
			else{
		
				$label_required ='';
			}
			?>	
			
			<fieldset class="fieldset_outer inarray" id="field-<?php echo $key;?> " >
	
				<div class="wecf_field_label_left_outer">
                    
                    <div class="wecf_field_label_left">
                    <legend><b>New Field:</b> </legend>
        
                    <input name="wecf_contact_mail_message_options[wecf_edit_field_label][<?php echo $key;?>]" value="<?php if($label_name!=''){echo $label_name;}else{echo $label_placeholder;}?>" size="70" type="text" id="<?php echo $key;?>" class="edit_label" >
                    </div>
                    
                    <div class="wecf_field_label_mid">
                        <label>Show In Label:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][<?php echo $key;?>][<?php echo $input_type;?>][label]" value="<?php echo $label_name;?>" id="<?php echo $key;?>" class="show_in_label" <?php if($label_name!=''){ echo "checked='checked'";}?>/>
                        
                        <label>Show In Placeholder:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][<?php echo $key;?>][<?php echo $input_type;?>][placeholder]" value="<?php echo $label_placeholder;?>" id="<?php echo $key;?>" class="show_in_placeholder" <?php if($label_placeholder!=''){ echo "checked='checked'";}?>/>
                        
                        <label>Required:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][<?php echo $key;?>][<?php echo $input_type;?>][required]" value="<?php echo $label_required;?>" id="<?php echo $key;?>" class="show_in_required" <?php if($label_required!=''){ echo "checked='checked'";}?>>
                        </div>
				
				</div>
			  <div class="wecf_field_label_right">
				<label>Field type:</label>
				<select id="<?php echo $key;?>" name="wecf_contact_mail_message_options[wecf_edit_field_type][<?php echo $key;?>]" class="edit_type">
							 
				<?php $option= array( 0=>'select',1=>'text',2=>'textarea', 3=>'email',4=>'tel', 5=>'hidden',6=>'password');
							 
				foreach($option as $op_value){?>
							 
				<option value="<?php echo stripslashes($op_value);?>" <?php if($op_value==$input_type){ echo "selected='selected'";}?> ><?php echo stripslashes($op_value);?></option>
				<?php }?>
							
				</select>
		   </div>   
				<p class="form-field custom_field_type think_remove_add_more"><a href="javascript:void(0);" id="remove_add_more"><img class="outer" src=" <?php echo plugins_url( 'assets/minus_sign.png', __FILE__ );?>" alt=""></a></p>	
			
				</fieldset>	
				
			 <?php } 
		    }
		
		}else{?>
			<fieldset class="fieldset_outer" id="field-0">


            <div class="wecf_field_label_left_outer">
                
                <div class="wecf_field_label_left">
                <legend><b>New Field:</b> </legend>
                <input name="wecf_contact_mail_message_options[wecf_edit_field_label][0]" value="Email" size="70" type="text" id="0" class="edit_label"  >
    </div>
               
                <div class="wecf_field_label_mid">
                <label>Show In Label:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][0][email][label]" value="" id="0" class="show_in_label"/>
                
                <label>Show In Placeholder:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][0][email][placeholder]" value="" id="0" class="show_in_placeholder" checked="checked"/>
                <label>Required:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][0][email][required]" value="" id="0" class="show_in_required" checked="checked">
                </div>
            
            </div>
          <div class="wecf_field_label_right">
		  	<label>Field type:</label>
            <select id="0" name="wecf_contact_mail_message_options[wecf_edit_field_type][0]" class="edit_type">
                <option >select</option>
                <option value="text">text</option>
                <option value="textarea">textarea</option>
                <option value="email" selected="selected">email</option>
                <option value="tel">tel</option>
                <option value="hidden">hidden</option>
                <option value="password">password</option>
            </select>
		  </div>	
			<p class="form-field custom_field_type think_remove_add_more"><a href="javascript:void(0);" id="remove_add_more"><img class="outer" src=" <?php echo plugins_url( 'assets/minus_sign.png', __FILE__ );?>" alt=""></a></p>	
			</fieldset>
            
    	  <fieldset class="fieldset_outer" id="field-1">

            <div class="wecf_field_label_left_outer">
                
                <div class="wecf_field_label_left">
                <legend><b>New Field:</b> </legend>
    
                <input name="wecf_contact_mail_message_options[wecf_edit_field_label][1]" value="Subject" size="70" type="text" id="1" class="edit_label" >
    </div>
               
                <div class="wecf_field_label_mid">
                <label>Show In Label:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][1][text][label]" value="" id="1" class="show_in_label"/>
                
                <label>Show In Placeholder:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][1][text][placeholder]" value="" id="1" class="show_in_placeholder" checked="checked"/>
                <label>Required:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][1][text][required]" value="" id="1" class="show_in_required">
                </div>
            
            </div>
          <div class="wecf_field_label_right">

		  	<label>Field type:</label>
            <select id="1" name="wecf_contact_mail_message_options[wecf_edit_field_type][1]" class="edit_type">
                <option >select</option>
                <option value="text" selected="selected">text</option>
                <option value="textarea">textarea</option>
                <option value="email">email</option>
                <option value="tel">tel</option>
                <option value="hidden">hidden</option>
                <option value="password">password</option>
            </select>
            
		  </div>		
			<p class="form-field custom_field_type think_remove_add_more"><a href="javascript:void(0);" id="remove_add_more"><img class="outer" src=" <?php echo plugins_url( 'assets/minus_sign.png', __FILE__ );?>" alt=""></a></p>	
			
		 </fieldset>
            
        <fieldset class="fieldset_outer" id="field-2">

			<div class="wecf_field_label_left_outer">
                <div class="wecf_field_label_left">
                <legend><b>New Field:</b> </legend>
    
                <input name="wecf_contact_mail_message_options[wecf_edit_field_label][2]" value="Message" size="70" type="text" id="2" class="edit_label" >
    </div>
          		
                <div class="wecf_field_label_mid">
            <label>Show In Label:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][2][textarea][label]" value="" id="2" class="show_in_label"/>
            
            <label>Show In Placeholder:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][2][textarea][placeholder]" value="" id="2" class="show_in_placeholder" checked="checked"/>
            <label>Required:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][2][textarea][required]" value="" id="2" class="show_in_required">
            </div>
            
            </div>
            
          <div class="wecf_field_label_right">

			<label>Field type:</label>
            <select id="2" name="wecf_contact_mail_message_options[wecf_edit_field_type][2]" class="edit_type">
                <option >select</option>
                <option value="text">text</option>
                <option value="textarea" selected="selected">textarea</option>
                <option value="email">email</option>
                <option value="tel">tel</option>
                <option value="hidden">hidden</option>
                <option value="password">password</option>
                
			</select>
         </div>
		<p class="form-field custom_field_type think_remove_add_more"><a href="javascript:void(0);" id="remove_add_more"><img class="outer" src=" <?php echo plugins_url( 'assets/minus_sign.png', __FILE__ );?>" alt=""></a></p>	
		
       </fieldset>
    
	<?php } ?>
       
        <fieldset class="fieldset_outer custom_outer" id="field-03">
           <div class="wecf_field_label_left_outer">
             
               <div class="wecf_field_label_left">
                <legend><b>New Field:</b> </legend>
                <input name="wecf_contact_mail_message_options[wecf_edit_field_label][]" value="" size="70" type="text" id="" class="edit_label" placeholder="New Field" >
                
                <input type="hidden" name="edit_field" value="wecf_edit_field_hidden"/>
                </div>
             
               <div class="wecf_field_label_mid">
                    <label>Show In Label:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][03][email][label]" value="" id="03" class="show_in_label"/>
                    
                    <label>Show In Placeholder:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][03][email][placeholder]" value="" id="03" class="show_in_placeholder"/>
                    <label>Required:</label><input type="checkbox" name="wecf_contact_mail_message_options[wecf_edit_field_full][03][email][required]" value="" id="03" class="show_in_required">
                    </div>
            
           </div>
          
              <div class="wecf_field_label_right">
    
                <label>Field type:</label>
                <select id="" name="wecf_contact_mail_message_options[wecf_edit_field_type][]" class="edit_type">
                    <option >select</option>
                    <option value="text">text</option>
                    <option value="textarea" >textarea</option>
                    <option value="email">email</option>
                    <option value="tel">tel</option>
                    <option value="hidden">hidden</option>
                    <option value="password">password</option>
                    </select>
                </div>
			
              <p class="form-field custom_field_type think_remove_add_more"><a href="javascript:void(0);" id="remove_add_more"><img class="outer" src=" <?php echo plugins_url( 'assets/minus_sign.png', __FILE__ );?>" alt=""></a></p>	
		
        </fieldset>
            
         </div>  
         <p class="form-field custom_field_type shape"><a href="javascript:void(0);" id="add_more">Add More</a></p>
      
   <?php }
	
	
	//wecf_name_settings

    public function wecf_name_field_settings() { 

        if(empty($this->options['wecf_name_field']))$this->options['wecf_name_field'] = "Contact Form"; 

        echo '<input name="wecf_contact_mail_message_options[wecf_name_field]" type="text" value="'.$this->options['wecf_name_field'].'" />';
		
	    }

      //wecf_email_settings

    public function wecf_email_field_settings() {

        if(empty($this->options['wecf_email_field'])) $this->options['wecf_email_field'] = "user@example.com";

        echo '<input name="wecf_contact_mail_message_options[wecf_email_field]" type="text" value="'.$this->options['wecf_email_field'].'" />';
		
	 }

    //wecf_marginTop_settings

    public function wecf_marginTop_field_settings() {

        if(empty($this->options['wecf_marginTop_field'])) $this->options['wecf_marginTop_field'] = "100";

        echo '<input name="wecf_contact_mail_message_options[wecf_marginTop_field]" type="text" value="'.$this->options['wecf_marginTop_field'].'" />';

    }

    //wecf_alignment_settings

    public function wecf_position_field_settings(){

        if(empty($this->options['wecf_alignment_field'])) $this->options['wecf_alignment_field'] = "left";

        $items = array('left','right');

        echo '<select name="wecf_contact_mail_message_options[wecf_alignment_field]">';

        foreach($items as $item){

            $selected = ($this->options['wecf_alignment_field'] === $item) ? 'selected = "selected"' : '';

            echo '<option value="'.$item.'" '. $selected.'>'.$item.'</option>';

        }

        echo '</select>';

    }

 
	//cfw_success_message_settings

    public function wecf_success_message_field_settings() {

        if(empty($this->options['wecf_success_message_field'])) $this->options['wecf_success_message_field'] = "Thank you for your message. It has been sent.";

        echo '<textarea name="wecf_contact_mail_message_options[wecf_success_message_field]" style="resize: none;">'.$this->options['wecf_success_message_field'].'</textarea>';

    }

    //cfw_error_message_settings

    public function wecf_error_message_field_settings() {

        if(empty($this->options['wecf_error_message_field'])) $this->options['wecf_error_message_field'] = "Mail was not sent. Please try again later.";

        echo '<textarea name="wecf_contact_mail_message_options[wecf_error_message_field]" style="resize: none;">'.$this->options['wecf_error_message_field'].'</textarea>';

    }

	

}

	add_action('admin_menu', 'wecf_contact_mail_add_in_menu_function');
	
		function wecf_contact_mail_add_in_menu_function(){
		
			wecf_contact_mail_message::add_wecf_contact_setting_menu_options_page();
		
		}
	
	add_action('admin_init','wecf_contact_mail_create_object');

		function wecf_contact_mail_create_object(){
	
		new wecf_contact_mail_message();

		}


	add_action('wp_footer','wecf_contact_mail_forented_show_in_footer');

	function wecf_contact_mail_forented_show_in_footer(){

		$values = get_option('wecf_contact_mail_message_options');
	
		extract($values);

		if($wecf_alignment_field=='left'){?>
            
            <div id="form_contact_outer" class="left_section">
                <div id="form_contact_inner">
                    
                    <a class="open" id="wecf" href="javascript:;"><img class="outer" src=" <?php echo plugins_url( 'assets/contact-icon-outer.png', __FILE__ );?>" alt=""></a>
                    <div id="form_contact_detail"> <?php  $values = get_option('wecf_contact_mail_message_options');
                
                    extract($values);?>
                
                    <div class="wecf-sec"><h2><?php echo stripslashes($wecf_name_field);?></h2>
                
                         <form action="" id="wecf_main_form_outer" method="post">
                    
                         <input type="hidden" name="action" value="wecf_wp_contact_adminajax"/>
                    
                         <input type="hidden" name="_ajax_nonce" value="<?php echo wp_create_nonce( "wecf_wp_contact_adminajax_ajax_nonce" );?>"/>
                    
                    
                         <?php foreach($values['wecf_edit_field_full'] as $key_no => $full_label){
                                
                                $key=stripslashes($key_no);
                        
								foreach($full_label as $input_type_name => $label_in_array){
									
								$input_type=stripslashes($input_type_name);
								
									if(isset( $label_in_array['label']) &&  ($label_in_array['label']!='')){
									$label_name  = stripslashes($label_in_array['label']);
									}
									else{
								
										$label_name ='';
									}
									if(isset( $label_in_array['placeholder']) &&  ($label_in_array['placeholder']!='')){
									$label_placeholder  = stripslashes($label_in_array['placeholder']);
									}
									else{
								
										$label_placeholder ='';
									}
									if(isset( $label_in_array['required']) &&  ($label_in_array['required']!='')){
									$label_required  = stripslashes($label_in_array['required']);
									}
									else{
								
										$label_required ='';
									}
									if($label_name==''){
										
										$label_name_required=stripslashes($label_name);
									
									}else{
										$label_name_required = stripslashes($label_placeholder);
											
									}
							  
									if($input_type=='textarea'){ 
							
										if($label_name!=''){?>
							
											<label><?php echo stripslashes($label_name);?></label>
							
										<?php }?>
											<textarea name="wecf_<?php if($label_name!=''){echo stripslashes(str_replace(' ','_',$label_name));}else{echo stripslashes(str_replace(' ','_',$label_placeholder));}?>" <?php if($label_placeholder!=''){?> placeholder="<?php echo stripslashes($label_placeholder);}?>" <?php if($label_required!=''){?>required="required" <?php } ?> ></textarea>
									<?php }else {
								
								if($label_name!='' && $input_type!='hidden'){?>
							
								<label><?php echo stripslashes($label_name);?></label>
							
								<?php }	?>
							   <input name="wecf_<?php if($label_name!=''){echo stripslashes(str_replace(' ','_',$label_name));}else{echo stripslashes(str_replace(' ','_',$label_placeholder));}?>" type="<?php echo stripslashes($input_type);?>"  value="" <?php if($label_placeholder!=''){?> placeholder="<?php echo stripslashes($label_placeholder);}?>"  <?php if($label_required!=''){?>required="required" <?php } ?> />
						<?php }
						 }
					}?>
                    
                    <div class="wecf-submit"><input type="submit" value="SUBMIT" />
                           
                        <div class="wecf_loadinfo" style="display:none;"><img src="<?php echo plugins_url( 'assets/ajax-loader.gif', __FILE__ );?>" alt="loading..." /></div></div>
                    
                        <div class="wecf_succees"></div>
                    </form>
                
               </div>
           
             </div>
         
          </div>
       
       </div>
			
			<style type="text/css">
                    
                    div#form_contact_inner{        
                        left: -360px;         
                        top: <?php echo stripslashes($wecf_marginTop_field);?>px;         
                        z-index: 10000;
                        }
                    
                    div#form_contact_inner.showdiv {
                        left: -5px;
                    }	
                    
                    div#form_contact_detail{        
                        text-align: left;        
                        width:350px; 
                        border-top: none;       
                            
                        }
                      div#form_contact_inner .outer{
                          top: 0px;
                          right:-25px; 
                      }
                      
                    </style>
		
		<?php } else { ?>
       
                <div id="form_contact_outer" class="right_section">
                    <div id="form_contact_inner">
                        <a class="open" id="wecf" href="javascript:;"><img class="outer"  src="<?php echo plugins_url( 'assets/contact-icon-outer.png', __FILE__ );?>" alt=""></a>
                        <div id="form_contact_detail"> <?php 
                        
                        $values = get_option('wecf_contact_mail_message_options');
                    
                        extract($values);?>
                    
                        <div class="wecf-sec"><h2><?php echo stripslashes($wecf_name_field);?></h2>
                    
                         <form action="" id="wecf_main_form_outer" method="post">
                    
                         <input type="hidden" name="action" value="wecf_wp_contact_adminajax"/>
                    
                         <input type="hidden" name="_ajax_nonce" value="<?php echo wp_create_nonce( "wecf_wp_contact_adminajax_ajax_nonce" );?>"/>
                    
                    
                    <?php 
                    foreach($values['wecf_edit_field_full'] as $key_no => $full_label){
                                
                                $key=stripslashes($key_no);
                        
                            foreach($full_label as $input_type_name => $label_in_array){
                                
								$input_type=stripslashes($input_type_name);
								
								if(isset( $label_in_array['label']) &&  ($label_in_array['label']!='')){
								$label_name  = stripslashes($label_in_array['label']);
								}
								else{
							
									$label_name ='';
								}
								if(isset( $label_in_array['placeholder']) &&  ($label_in_array['placeholder']!='')){
								$label_placeholder  = stripslashes($label_in_array['placeholder']);
								}
								else{
							
									$label_placeholder ='';
								}
								if(isset( $label_in_array['required']) &&  ($label_in_array['required']!='')){
								$label_required  = stripslashes($label_in_array['required']);
								}
								else{
							
									$label_required ='';
								}
								if($label_name==''){
									
									$label_name_required=stripslashes($label_name);
								
								}else{
									$label_name_required = stripslashes($label_placeholder);
										
								}
						  
                            
                    
								if($input_type=='textarea'){ 
								
								if($label_name!=''){?>
								
								<label><?php echo stripslashes($label_name);?></label>
								
								<?php }?>
									<textarea name="wecf_<?php if($label_name!=''){echo stripslashes(str_replace(' ','_',$label_name));}else{echo stripslashes(str_replace(' ','_',$label_placeholder));}?>" <?php if($label_placeholder!=''){?> placeholder="<?php echo stripslashes($label_placeholder);}?>" <?php if($label_required!=''){?>required="required" <?php } ?> ></textarea>               
								<?php }else {
                            
                               if($label_name!='' && $input_type!='hidden'){?>
                        
                              <label><?php echo stripslashes($label_name);?></label>
                        
                              <?php }	?>
                             <input name="wecf_<?php if($label_name!=''){echo stripslashes(str_replace(' ','_',$label_name));}else{echo stripslashes(str_replace(' ','_',$label_placeholder));}?>" type="<?php echo stripslashes($input_type);?>"  value="" <?php if($label_placeholder!=''){?> placeholder="<?php echo stripslashes($label_placeholder);}?>"  <?php if($label_required!=''){?>required="required" <?php } ?> />
                        
                         <?php }
						 }
					}?>
                    
                     	<div class="wecf-submit"><input type="submit" value="SUBMIT" />
                           
                           <div class="wecf_loadinfo" style="display:none;"><img src="<?php echo plugins_url( 'assets/ajax-loader.gif', __FILE__ );?>" alt="loading..." /></div></div>
                    		
                            <div class="wecf_succees"></div>
                      </form>
                    
                        </div>
                        
                     </div>
                   
                   </div>
                
                </div>
		
		<style type="text/css">
                
                div#form_contact_inner{ 
                     right: -360px;
                     top: <?php echo $wecf_marginTop_field;?>px;
                    }
                
               div#form_contact_inner.showdiv{   right:0; }	
                
               div#form_contact_detail{
                     text-align: left; 
                     }
                
               div#form_contact_inner .outer{
                      top: 0px;
                      left:-25px; 
               }
        </style>
	
	<?php } ?>

		<script type="text/javascript">
        
        jQuery(document).ready(function() {
        
        /** Toggle form **/	
        
        jQuery('#wecf').click(function(){
        
            jQuery(this).parent().toggleClass('showdiv');
        
        });
        
            
        
        /** mail send jquery **/
        
        jQuery('#wecf_main_form_outer').submit(wecf_mailsend_ajax);
        
        
        
        function wecf_mailsend_ajax(){
        
        jQuery('.wecf_loadinfo').show();
        
        var cf_send_data_via_mail = jQuery(this).serialize();
        
        
        jQuery.ajax({
        
        type:"POST",
        
        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
        
        data: cf_send_data_via_mail,
        
        success:function(data){
        
        //alert(data);
        
        jQuery('.wecf_loadinfo').hide();	
        
        jQuery('.wecf_succees').html(data);
        
        wecf_reset_form_val();
        
        }
        
        });
        
        
        
        return false;
        
        }
        
        /***  reset form data **/
        
        function wecf_reset_form_val(){
        
             jQuery('#wecf_main_form_outer').find('input:text, textarea').val('');
        
             setTimeout(function(){jQuery('.wecf_succees').html(''); }, 3000);
        
            }
        
         /**  shortcode mail send jquery **/
        jQuery('#wecf_main_form_outer_short').submit(wecf_mailsend_ajax_short);
        
        function wecf_mailsend_ajax_short(){
        
        jQuery('.wecf_loadinfo_short').show();
        
        var cf_send_data_via_mail = jQuery(this).serialize();
        
        jQuery.ajax({
        
        type:"POST",
        
        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
        
        data: cf_send_data_via_mail,
        
        success:function(data){
        
        //alert(data);
        
        jQuery('.wecf_loadinfo_short').hide();	
        
        jQuery('.wecf_succees_short').html(data);
        
        wecf_reset_form_val_short();
        
        }
        
        });
        
        
        
        return false;
        
        }
        
        function wecf_reset_form_val_short(){
        
         jQuery('#wecf_main_form_outer_short').find('input:text, textarea').val('');
        
             setTimeout(function(){jQuery('.wecf_succees_short').html(''); }, 3000);
        
            }
        
        
        });
        
        </script>
	<?php }



	add_action( 'wp_enqueue_scripts', 'register_wecf_contact_mail_styles' );

	add_action( 'admin_enqueue_scripts', 'register_wecf_contact_mail_styles' );

	function register_wecf_contact_mail_styles() {

		wp_register_style( 'register_wecf_contact_mail_styles', plugins_url( 'assets/contact-mail.css' , __FILE__ ) );
		
		wp_enqueue_style( 'register_wecf_contact_mail_styles' );
			
		wp_register_script( 'wecf_jquery_ui', plugins_url( '/assets/jquery-ui.js', __FILE__ ) );
	   
		wp_enqueue_script( 'wecf_jquery_ui' );
	
	}



		$wecf_contact_mail_default_values = array(
		
		'wecf_edit_field_full'=> array(
									array('email'=> array('label'=>'','placeholder'=>'Email','required'=>'reqired')),
									array('text'=> array('label'=>'','placeholder'=>'Subject','required'=>'')),
									array('textarea'=> array('label'=>'','placeholder'=>'Message','required'=>''))
								  ),
		'wecf_edit_field_label' => array(0 => 'Email', '1' => 'Subject','2' => 'Message'),
		
		'wecf_edit_field_type' => array(0 => 'email', '1' => 'text','2' => 'textarea'),
		
		'wecf_name_field' => 'Let\'s Get Started',
		
		'wecf_email_field' => 'user@example.com',
		
		'wecf_marginTop_field' => '100',
		
		'wecf_alignment_field' => 'left',
		
		'wecf_success_message_field' => 'Thank you for your message. It has been sent.',
		
		'wecf_error_message_field'=>'Mail was not sent. Please try again later.'
		
		);


	add_option('wecf_contact_mail_message_options', $wecf_contact_mail_default_values);
	
	add_action('wp_ajax_wecf_wp_contact_adminajax', 'wecf_wp_contact_adminajax');
	
	add_action('wp_ajax_nopriv_wecf_wp_contact_adminajax', 'wecf_wp_contact_adminajax');

	function wecf_wp_contact_adminajax(){
	
	check_ajax_referer('wecf_wp_contact_adminajax_ajax_nonce');
	
		if (isset($_POST['action']) && $_POST['action'] =="wecf_wp_contact_adminajax"){
		
		
		$values = get_option('wecf_contact_mail_message_options');
		
		extract($values);
		
		/*contact form code start*/
		
		$myError = '';
		
		$RIGHT_EMAIL = '';
		
		$RIGHT_SUBJECT = ''; 
		
		$RIGHT_MESSAGE = '';
		
	
		foreach($values['wecf_edit_field_full'] as $key_no => $full_label){
			
			$key=stripslashes($key_no);
		
		foreach($full_label as $input_type_name => $label_in_array){
			
			$input_type=stripslashes($input_type_name);
		
			if(isset( $label_in_array['label']) &&  ($label_in_array['label']!='')){
				
			$label_name  = stripslashes($label_in_array['label']);
			
			}
			else{
			
				$label_name ='';
			}
			if(isset( $label_in_array['placeholder']) &&  ($label_in_array['placeholder']!='')){
			$label_placeholder  = stripslashes($label_in_array['placeholder']);
			}
			else{
			
				$label_placeholder ='';
			}
			if(isset( $label_in_array['required']) &&  ($label_in_array['required']!='')){
				
			$label_required  = stripslashes($label_in_array['required']);
			}
			else{
			
				$label_required ='';
			}
		
			if($label_name!=''){$label_name_req= stripslashes($label_name); }else{ $label_name_req=stripslashes($label_placeholder); }
		
		$label_name_reqired= 'wecf_'.stripslashes(str_replace(' ','_',$label_name_req));
		
		// check email
		if($input_type=='email'){
		
			if ($_POST[$label_name_reqired] === "") {
			
			 $myError = '<small style="color:#f00;">No Email</small>';
			
			}
			
			elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", strtolower(sanitize_email($_POST[$label_name_reqired])))) {
			
			  $myError = '<small style="color:#f00;">Invalid Email</small>';
			
			}
		
			else {
		
			$RIGHT_EMAIL = htmlentities(sanitize_email($_POST[$label_name_reqired]), ENT_COMPAT, "UTF-8");
		
			}  
		}
		elseif($label_name_req=='subject'||$label_name_req=='Subject'||$label_name_req=='SUBJECT'){
		
			$RIGHT_SUBJECT = htmlentities(sanitize_text_field($_POST[$label_name_reqired]), ENT_COMPAT, "UTF-8");
		}
		
		else{
			$message_body[] = htmlentities(sanitize_text_field($_POST[$label_name_reqired]), ENT_COMPAT, "UTF-8");
		}
		
		}
	}
		
		if ($myError == '') {
		
			//print_r($message_body);   
			
			$email = sanitize_email($wecf_email_field);	   
			
			$mySubject = $RIGHT_SUBJECT;
			
			$content = implode("\n", $message_body);
			
			$myMessage = 'You received a message from '. $RIGHT_EMAIL ."\n\n". $content;
			
			$mailSender = wp_mail( $email, $mySubject, $myMessage );
			
			if ($mailSender) {
			
			echo '<small  style="color:#0f0;">'.$wecf_success_message_field.'</small>'; 
			
			}
			
			else {
			
			echo '<small style="color:#f00;">'.$wecf_error_message_field.'</small>';
			
			}
		
		} else{
		
			echo $myError;
		
		}   
		
		die();
		
		}
	
	}


	add_shortcode("wecf_contact_form_shortcode", "wecf_contact_full_edit_form");

	function wecf_contact_full_edit_form($print_contact_scode){?>
    <div id="wecf_cnt_form_plugin_outer">
        
            <div id="wecf_cnt_form_plugin_inner"> <?php 
            
            $values = get_option('wecf_contact_mail_message_options');
        
            extract($values);?>
        
            <div class="wecf-sec"><h2><?php echo stripslashes($wecf_name_field);?></h2>
        
             <form action="" id="wecf_main_form_outer_short" method="post">
        
             <input type="hidden" name="action" value="wecf_wp_contact_adminajax"/>
        
             <input type="hidden" name="_ajax_nonce" value="<?php echo wp_create_nonce( "wecf_wp_contact_adminajax_ajax_nonce" );?>"/>
        
        
        <?php 
        foreach($values['wecf_edit_field_full'] as $key_no => $full_label){
                    
                $key=stripslashes($key_no);
            
                foreach($full_label as $input_type_name => $label_in_array){
                    
                $input_type=stripslashes($input_type_name);
                
					if(isset( $label_in_array['label']) &&  ($label_in_array['label']!='')){
					$label_name  = stripslashes($label_in_array['label']);
					}
					else{
				
						$label_name ='';
					}
					if(isset( $label_in_array['placeholder']) &&  ($label_in_array['placeholder']!='')){
					$label_placeholder  = stripslashes($label_in_array['placeholder']);
					}
					else{
				
						$label_placeholder ='';
					}
					if(isset( $label_in_array['required']) &&  ($label_in_array['required']!='')){
					$label_required  = stripslashes($label_in_array['required']);
					}
					else{
				
						$label_required ='';
					}
					if($label_name==''){
						
						$label_name_required=stripslashes($label_name);
					
					}else{
						$label_name_required = stripslashes($label_placeholder);
							
					}
			  
                
        
            		if($input_type=='textarea'){ 
            
            			if($label_name!=''){?>
            
           				 <label><?php echo stripslashes($label_name);?></label>
            
            			<?php }?>
                		<textarea name="wecf_<?php if($label_name!=''){echo stripslashes(str_replace(' ','_',$label_name));}else{echo stripslashes(str_replace(' ','_',$label_placeholder));}?>" <?php if($label_placeholder!=''){?> placeholder="<?php echo stripslashes($label_placeholder);}?>" <?php if($label_required!=''){?>required="required" <?php } ?> ></textarea>
           
            <?php }else {
                
                	if($label_name!='' && $input_type!='hidden'){?>
            
            			<label><?php echo stripslashes($label_name);?></label>
                    
                    <?php }	?>
                        <input name="wecf_<?php if($label_name!=''){echo stripslashes(str_replace(' ','_',$label_name));}else{echo stripslashes(str_replace(' ','_',$label_placeholder));}?>" type="<?php echo stripslashes($input_type);?>"  value="" <?php if($label_placeholder!=''){?> placeholder="<?php echo stripslashes($label_placeholder);}?>"  <?php if($label_required!=''){?>required="required" <?php } ?> />
            <?php }?>
        
         <?php }
		  }?>
        
        
         <div class="wecf-submit"><input type="submit" value="SUBMIT" />
               
               <div class="wecf_loadinfo_short" style="display:none;"><img src="<?php echo plugins_url( 'assets/ajax-loader.gif', __FILE__ );?>" alt="loading..." /></div></div>
              <div class="wecf_succees_short"></div>
              </form>
         </div>
            
      </div>
       
   </div>

	<?php }?>