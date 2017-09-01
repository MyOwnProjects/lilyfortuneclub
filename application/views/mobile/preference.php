<div data-role="page" id="preference" data-theme="d">
	<div data-role="main" class="ui-content">
		<p>Welcome to WFG, Lily's finance club. Before startup, please let us know about your preference.</p>
		<form method="POST" data-ajax="false" action="<?php echo base_url();?>account/preference">
			<fieldset data-role="controlgroup">
				<legend>You are interested in:</legend>
				<label for="preference-e">Learning More Financial Solution for My Family</label>
				<input type="radio" name="preference" id="preference-e" value="E" required>
				<label for="preference-b">Starting a business/Career</label>
				<input type="radio" name="preference" id="preference-b" value="B" required>
				<label for="preference-be">Both of the Above</label>
				<input type="radio" name="preference" id="preference-be" value="BE" required>
			</fieldset>
			<input type="submit" data-inline="true" value="Submit">
		</form>
	</div>
</div>