<style>
fieldset{border:1px solid #858585;border-radius:4px}	
legend{font-weight:bold}
label{font-weight:normal}

.bootstrap-select .btn{padding:0;border:none}

.bootstrap-select .btn-group.open .dropdown-toggle{webkit-box-shadow:none;box-shadow:none}
.bootstrap-select .btn-default:active, .bootstrap-select .btn-default:focus, .bootstrap-select .btn-default:hover, .bootstrap-select .open>.dropdown-toggle.btn-default {background-color:#fff !important;border-color:#fff !important}
</style>
<div style="margin:40px"> 
	<h4>Import New Case(s)</h4>
	<form method="post"  action="<?php echo base_url();?>smd/sales/import_sales">
		<div class="row">
			<div class="col-sm-12 control-group">
				<label>Provider</label>
				<select class="form-control form-control-sm" name="provider" id="provider">
					<option>Transamerica</option>
					<option>Nationwide</option>
					<option>Pacific Life</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 control-group">
				<label>Input data</label>
				<textarea class="form-control form-control-sm" style="height:500px" name="text-input-1" id="text-input-1"></textarea>
			</div>
			<div class="col-sm-8 control-group">
				<label>Input data</label>
				<textarea class="form-control form-control-sm" style="height:500px" name="text-input" id="text-input"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 control-group">
			<input type="submit" class="btn btn-sm btn-primary" id="button-validate" value="Import">
			</div>
		</div>
	</form>
</div>