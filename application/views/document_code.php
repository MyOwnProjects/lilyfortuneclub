<form method="post" style="margin:100px auto 200px auto;max-width:500px">
	<div class="form-group">
		<h3>Please enter the access code.</h3>
		<div style="font-weight:normal;color:#b5b5b5">If you don't have the access code, contact <a href="<?php echo base_url();?>contact" target="_blank">Lily Fortune Club</a>.</div>
		<br/>
		<input type="text" class="form-control input-lg" required name="guest_code">
		<br/>
		<div class="checkbox">
			<label><input type="checkbox" value="" required>Check here to indicate that you have read and agree to the terms of <a href="javascript:void(0)" onclick="show_terms_agreement()">agreement</a></label>
		</div>
		<input type="submit" class="btn btn-primary pull-right" value="Submit">
	</div>
</form>
<div id="terms-of-agreement" style="display:none">
			<p>Lilyfortuneclub hereby grants you permission to access and use the Service as set forth in these Terms of Service, provided that:</p>
			<p>You agree not to distribute in any medium any part of the Service or the Content without Lilyfortuneclub's prior written authorization, unless Lilyfortuneclub makes available the means for such distribution through functionality offered by the Service (such as the Embeddable Player).</p>
			<p>You agree not to alter or modify any part of the Service.</p>
			<p>You agree not to access Content through any technology or means other than the video playback pages of the Service itself, the Embeddable Player, or other explicitly authorized means Lilyfortuneclub may designate.</p>
			<p>You agree not to use the Service for any of the following commercial uses unless you obtain Lilyfortuneclub's prior written approval.</p>
			<p>If you use the Embeddable Player on your website, you may not modify, build upon, or block any portion or functionality of the Embeddable Player, including but not limited to links back to the Lilyfortuneclub website.</p>
			<p>You agree not to use or launch any automated system, including without limitation, "robots," "spiders," or "offline readers," that accesses the Service in a manner that sends more request messages to the Lilyfortuneclub servers in a given period of time than a human can reasonably produce in the same period by using a conventional on-line web browser. Notwithstanding the foregoing, Lilyfortuneclub grants the operators of public search engines permission to use spiders to copy materials from the site for the sole purpose of and solely to the extent necessary for creating publicly available searchable indices of the materials, but not caches or archives of such materials. Lilyfortuneclub reserves the right to revoke these exceptions either generally or in specific cases. You agree not to collect or harvest any personally identifiable information, including account names, from the Service, nor to use the communication systems provided by the Service (e.g., comments, email) for any commercial solicitation purposes. You agree not to solicit, for commercial purposes, any users of the Service with respect to their Content.</p>
			<p>In your use of the Service, you will comply with all applicable laws.</p>
			<p>Lilyfortuneclub reserves the right to discontinue any aspect of the Service at any time.</p>
</div>

<script>
function show_terms_agreement(){
	bootbox.alert({
		title: 'Agreement',
		message: $('#terms-of-agreement').html(),
		backdrop: true
	});
}
</script>