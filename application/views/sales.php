<style>
.main-content-wrapper{max-width:1000px !important}	
.nav-tabs>li{width:25%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content-page p{margin-bottom:20px}	

#page-summary .row>div>div:first-child{float:left;font-weight:bold;width:100px;margin-right:20px;line-height:30px}
#page-summary .row>div>div:nth-child(2){overflow:hidden;line-height:30px}

.simple-list{border-bottom:1px solid #d5d5d5}
.simple-list .simple-list-row{border-top:1px solid #d5d5d5}
.simple-list .simple-list-row>div{padding:10px}
.simple-list .simple-list-cell-grey{color:#d5d5d5}
.simple-list a{text-decoration:none;color:#000}
.simple-list .simple-list-row:hover{background:#f8f8f8}
.simple-list .simple-list-row>div:first-child{float:left;width:50px;text-align:center}
.simple-list .simple-list-row>div:not(:nth-child(1)):not(:last-child){float:right}
.simple-list .simple-list-row>div:last-child{overflow:hidden}
.simple-list .simple-list-row>div:nth-child(2){width:180px}
.simple-list .simple-list-row>div:nth-child(4){width:120px;}
.simple-list .simple-list-row>div:nth-child(5){width:80px;text-align:center}
</style>
<div class="main-content-wrapper">
	<h2 class="text-center">My Sales</h2>
	<div>
		<div class="simple-list">
		<?php
		$types = array(
			'IL' => 'IUL + LTC',
			'I' => 'IUL',
			'A' => 'Annuity',
			'T' => 'Term',
		);
		$status = array(
			'I' => array('Inforced', 'success'),
			'P' => array('Pending', 'danger'),
			'C' => array('Closed', 'default'),
			'CA' => array('Canceled', 'default')
		);
		if(false){//count($sales) > 0){
			foreach($sales as $i => $row){
			?>
				<a href="#">
				<div class="simple-list-row clearfix">
					<div class="simple-list-seq"><?php echo $i + 1;?></div>
					<div><?php echo $row['sales_provider'].' / '.$types[$row['sales_policy_type']];?></div>
					<div><?php echo $row['sales_date_submission'];?></div>
					<div class="<?php echo empty($row['sales_policy_no']) ? 'simple-list-cell-grey' : '';?>"><?php echo empty($row['sales_policy_no']) ? 'No Policy #' : $row['sales_policy_no'];?></div>
					<div><span class="label label-<?php echo $status[$row['sales_status']][1];?>"><?php echo $status[$row['sales_status']][0];?></span></div>
					<div>
						<?php echo $row['sales_insured'].(empty($row['sales_owner']) ? '' : ' / '.$row['sales_owner']);?>
					</div>
				</div>
				</a>
			<?php
			}
		}
		else{
		?>
			<div class="simple-list-row clearfix">
				<div style="text-align:center;line-height:60px;float:none;width:100%">No sales found.</div>
			</div>
		<?php
		}
		?>
		</div>
	</div>
</div>
