<div class="main-body-wrapper">
<?php 
if(!$document){
?>
<div class="alert alert-danger">The document does not exists.</div>
<?php
	exit;
}
?>
<div class="row">
	<div class="col-lg-6">
		<ul class="list-group">
			<li class="list-group-item list-group-item-primary cearfix">
				<b>Document Information</b>
			</li>
			<?php 
			foreach($document as $name => $value){
				if(in_array($name, array('documents_id', 'pub_code'))) continue;
			?>
			<li class="list-group-item clearfix">
				<div class="pull-left" style="font-weight:bold;text-transform:capitalize;width:130px;margin-right:5px;text-align:right">
					<?php
					if($name == 'mime_content_type'){
						echo 'Mime Type';
					}
					else if($name == 'original_start_date'){
						echo 'Initial Start';
					}
					else{
						echo str_replace('_', ' ', $name);
					}
					?>:
				</div>
				<?php
				if(!in_array($name, array('uniqid', 'file_name', 'mime_content_type', 'create_date'))){
				?>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $document['uniqid'];?>" dialog-header="Update Document Information" dialog-url="<?php echo base_url();?>smd/documents/update/<?php echo $name?>"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
				<?php
				}
				?>
				<div class="value" style="overflow:hidden">
					<?php 
					switch($name){
						case 'abstract':
							echo str_replace("\n", '<br/>', $value);
							break;
						default:
							echo $value;
							
					}
					?>
				</div>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
	<div class="col-lg-6">
		<ul class="list-group">
			<li class="list-group-item list-group-item-primary">
				<b>Pub Codes</b>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $document['uniqid'];?>" dialog-header="Generate New Code" dialog-url="<?php echo base_url();?>smd/documents/generate_pub_code">
					<i class="fa fa-plus" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generate new code"></i>
				</a>
			</li>
			<?php 
			$pub_code = $document['pub_code'];
			foreach($pub_code as $name => $value){
			?>
			<li class="list-group-item clearfix">
				<div class="value pull-left">
					<?php 
					$expired = strtotime('now') > strtotime($value['expire']);
					echo '<span class="'.($expired ? 'text-danger' : 'text-success').'">'.$value['code'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-secondary">['.date_format(date_create($value['expire']), 'm/d/Y H:i').']</span>';
					?>
				</div>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $value['code'];?>" dialog-header="Delete Pub Code" dialog-url="<?php echo base_url();?>smd/documents/delete_pub_code"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
				<a href="javascript:void(0)" style="margin-right:10px" class="pull-right dialog-toggle" data-id="<?php echo $value['code'];?>" dialog-header="Change Pub Code Time" dialog-url="<?php echo base_url();?>smd/documents/change_pub_code_time"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
			</li>
			<?php 
			}
			?>
		</ul>
	</div>
</div>
</div>
<script>
$(document).ready(function(){
});
</script>