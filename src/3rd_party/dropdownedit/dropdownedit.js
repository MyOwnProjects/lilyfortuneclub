(function($){
	$.fn.dropdownedit = function(prop){
		var _this = this;
		var $_this = $(this);
		
		var $_doprdown_menu = $_this.find('.dropdown-menu');
		var $_div_show = $_this.find('.dropdown-toggle');
		var $_div_hidden = $('<input>').attr('type', 'hidden').attr('name', $_div_show.attr('name'))
			.attr('id', $_div_show.attr('id')).val($_div_show.val());
		$_div_show.removeAttr('name').removeAttr('id');
		$_this.prepend($_div_hidden);
		/*<div class="dropdown">
								<input type="text" class="dropdown-toggle form-control form-control-sm" data-toggle="dropdown" value="<?php echo $display_value;?>" <?php echo array_key_exists('readonly', $prop) ? 'readonly' : ''; ?> style="background:#fff">
								<div class="dropdown-menu" style="max-height:200px;overflow-y:auto;right:0px !important;padding:0 !important">
									<?php
									foreach($prop['options'] as $o){
									?>
									<a class="dropdown-item" value="<?php echo $o['value'];?>"><?php echo $o['text'];?></a>
									<?php
									}
									?>
								</div>
							  </div>*/
		
		$_div_show.keyup(function(e){
			if($(this).prop('readonly')){
				return;
			}
			var value = $(this).val().trim();
			$(this).next().children().each(function(index, obj){
				if($(obj).html().toLowerCase().indexOf(value.toLowerCase()) >= 0
					
					|| $(obj).attr('value').toLowerCase().indexOf(value.toLowerCase()) >= 0){
					$(obj).show();
				}
				else{
					$(obj).hide();
				}
			});
		}).change(function(){
			$_div_hidden.val($_div_show.val());
		});
		
		$_doprdown_menu.delegate('.dropdown-item', 'click', function(){
			$_div_show.val($(this).html());
			$_div_hidden.val($(this).attr('value'));
			if(prop && prop['onchange'] && typeof prop['onchange'] === "function"){
				prop['onchange']($(this).attr('value'));
			}	
		});
		$_this.update = function(value){
			$_div_hidden.val(value);
			$_doprdown_menu.children().each(function(){
				if($(this).attr('value') == value){
					$_div_show.val($(this).html());
					return;
				}
			});
		};
		return $_this;
	};
}(jQuery));