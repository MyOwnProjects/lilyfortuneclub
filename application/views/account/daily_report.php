<div class="main-content-wrapper" style="max-width:none !important;margin:0;padding:0;">
	<div style="margin-left:40px">
	<h2>Daily Report</h2>
	<div>
		<?php
			$days = array('', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
			$timeZone = 'America/Los_Angeles';
			date_default_timezone_set($timeZone);			
			$today = date_create();
			date_sub($today, date_interval_create_from_date_string("1 days"));
			echo $days[date_format($today, "N")].', '.date_format($today, "M d, Y");
		?>
		&nbsp;&nbsp;
		<button class="btn btn-sm btn-primary" onclick="reload();">Reload</button>
	</div>
	</div>
	<br/>
	<div style="">
	<table style="table-layout:fixed">
		<tr>
			<td style="vertical-align:top">
			<div id="daily-report-grid"></div>
			</td>
			<td style="width:40px">&nbsp;</td>
			<td style="vertical-align:top">
			<div id="daily-report-rank-grid"></div>
			</td>
		</tr>
	</table>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.css?<?php echo time();?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/smart-table/smart_table.css?t=<?php echo time();?>">
<script src="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.js?<?php echo time();?>"></script>
<script src="<?php echo base_url();?>src/3rd_party/smart-table/smart_table.js?<?php echo time();?>"></script>

<script>
	function reload(){
		grid1.load();
		//grid2.load();
	}
	var background1 = 'RGB(255, 255, 190)';
	var background2 = 'RGB(239, 253, 255)';
	var grid1 = $('#daily-report-grid').smart_table({
		url: {
			get: '<?php echo base_url();?>daily_report/get',
			update: '<?php echo base_url();?>daily_report/update',
			delete: '<?php echo base_url();?>daily_report/delete',
		},
		headers:[
			[
				{
					header: 'Daily Report',
					col_span: '7'
				},				
				{
					header: 'Ranking - Daily',
					col_span: '7',
					css: {background:background1}
				},
				{
					header: 'Ranking - Month to Date',
					col_span: '7',
					css: {background:background2}
				}
			],
			[
				{
					header: 'Name',
					data_type: 'text',
					editable: false,
					width: 150,
				}, 
				{
					header: '#<br/>APP',
					data_type: 'text', 
					width: 60,
					css: {'text-align':'center'},
					editable: true,
					id: 'daily_report_appointment',
					summary: true
				}, 
				{
					header: 'PER<br/>REC', 
					data_type: 'text',
					width: 60,
					css: {'text-align':'center'},
					id: 'daily_report_personal_recruits',
					editable: true,
					summary: true
				}, 
				{
					header: 'PER<br/>PROD',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center'},
					editable: true,
					id: 'daily_report_personal_products',
					summary: true
				},
				{
					header: 'BASE<br/>REC',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center'},
					editable: true,
					id: 'daily_report_baseshop_recruits',
					summary: true
				},
				{
					header: 'BASE<br/>PROD',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center'},
					editable: true,
					id: 'daily_report_baseshop_products',
					summary: true
				},
				{
					header: 'ELITE<br/>REG',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center'},
					editable: true,
					id: 'daily_report_base_elite',
					summary: true
				},
				{
					header: 'Rank',
					data_type: 'text',
					css: {'text-align':'center', background: background1, 'font-weight':'bold'},
					editable: false,
					width: 60,
				}, 
				{
					header: 'Name',
					data_type: 'text',
					css: {background: background1},
					editable: false,
					width: 150,
					auto_refresh: true
				}, 
				{
					header: 'PER<br/>REC', 
					data_type: 'text',
					width: 60,
					css: {'text-align':'center', background: background1},
					summary: true,
					auto_refresh: true
				}, 
				{
					header: 'PER<br/>PROD',
					data_type: 'text',
					css: {'text-align':'center', background: background1},
					width: 80,
					summary: true,
					auto_refresh: true
				},
				{
					header: 'BASE<br/>REC',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center', background: background1},
					summary: true,
					auto_refresh: true
				},
				{
					header: 'BASE<br/>PROD',
					data_type: 'text',
					width: 80,
					css: {'text-align':'center', background: background1},
					summary: true,
					auto_refresh: true
				},
				{
					header: 'Total<br/>GS',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center', background: background1},
					auto_refresh: true				
				},
				{
					header: 'Rank',
					data_type: 'text',
					css: {'text-align':'center', background: background2, 'font-weight':'bold'},
					editable: false,
					width: 60,
				}, 
				{
					header: 'Name',
					data_type: 'text',
					css: {background: background2},
					editable: false,
					width: 150,
					auto_refresh: true				
				}, 
				{
					header: 'PER<br/>REC', 
					data_type: 'text',
					width: 60,
					css: {'text-align':'center', background: background2},
					summary: true,
					auto_refresh: true				
				}, 
				{
					header: 'PER<br/>PROD',
					data_type: 'text',
					css: {'text-align':'center', background: background2},
					width: 80,
					summary: true,
					auto_refresh: true				
				},
				{
					header: 'BASE<br/>REC',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center', background: background2},
					summary: true,
					auto_refresh: true				
				},
				{
					header: 'BASE<br/>PROD',
					data_type: 'text',
					width: 80,
					css: {'text-align':'center', background: background2},
					summary: true,
					auto_refresh: true				
				},
				{
					header: 'Total<br/>GS',
					data_type: 'text',
					width: 60,
					css: {'text-align':'center', background: background2},
					auto_refresh: true				
				},
			]
		],
	});
	
</script>
