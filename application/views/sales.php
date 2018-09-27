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
.simple-list .simple-list-row>div:nth-child(3){width:120px;}
.simple-list .simple-list-row>div:nth-child(4){width:150px;}
.simple-list .simple-list-row>div:nth-child(5){width:80px;text-align:center}
</style>
<div class="main-content-wrapper">
	<h2 class="text-center">My Sales</h2>
	<div class="text-right" style="margin-bottom:10px"><a title="New case" href="<?php echo base_url();?>account/sales/sales_case"><span class="glyphicon glyphicon-plus"></span></a></div>
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
			'I' => 'Inforced',
			'P' => 'Pending',
			'C' => 'Closed',
			'CA' => 'Canceled'
		);
		if(count($sales) > 0){
			foreach($sales as $i => $row){
			?>
				<a href="<?php echo base_url();?>account/sales/sales_case/<?php echo $row['sales_id']; ?>">
				<div class="simple-list-row clearfix">
					<div class="simple-list-seq"><?php echo $i + 1;?></div>
					<div><?php echo $row['sales_provider'].' / '.$types[$row['sales_policy_type']];?></div>
					<div class="<?php echo empty($row['sales_policy_no']) ? 'simple-list-cell-grey' : '';?>"><?php echo empty($row['sales_policy_no']) ? 'No Policy #' : $row['sales_policy_no'];?></div>
					<div>
						<?php echo ($row['sales_priority'] > 0 ? '<span class="label label-danger">High</span>' : ($row['sales_priority'] == 0 ? '<span class="label label-warning">Medium</span>' : '<span class="label label-success">Low</span>'))
							.' - '.$status[$row['sales_status']];?>
					</div>
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
