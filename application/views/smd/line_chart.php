<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/datepicker/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/clockpicker/bootstrap-clockpicker.min.css">
<style>
.line-chart{font-size:12px}
.line-chart .dp input[type=text]{width:100px}
.line-chart .clockpicker input[type=text]{width:65px}
</style>
<?php
$now = date_create();
$to = clone $now;
$from = date_sub($now,date_interval_create_from_date_string("1 day"));
?>

<script src="<?php echo base_url();?>src/3rd_party/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>src/3rd_party/clockpicker/bootstrap-clockpicker.min.js"></script>
<ul class="list-group line-chart">
		<li class="list-group-item clearfix">
			<form class="form-inline">
			<div class="pull-left">
				<label>From</label>&nbsp;
				<div class="input-group date input-group-sm dp" id="dp_from" data-date="<?php echo date_format($from, 'Y-m-d');?>" data-date-format="yyyy-mm-dd">
					<input type="text" class="form-control" value="<?php echo date_format($from, 'Y-m-d');?>">
					<div class="input-group-addon">
						<span class="glyphicon"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
				</div>
				<div class="input-group  input-group-sm clockpicker" id="cp_from">
					<input type="text" class="form-control" value="<?php echo date_format($from, 'H:i'); ?>" data-default="<?php echo date_format($from, 'H:i'); ?>">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-time"></span>
					</span>
				</div>&nbsp;&nbsp;
				<label>To</label>&nbsp;
				<div class="input-group date input-group-sm dp" id="dp_to" data-date="<?php echo date_format($to, 'Y-m-d');?>" data-date-format="yyyy-mm-dd">
					<input type="text" class="form-control" value="<?php echo date_format($to, 'Y-m-d');?>">
					<div class="input-group-addon">
						<span class="glyphicon"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
				</div>
				<div class="input-group  input-group-sm clockpicker" id="cp_to">
					<input type="text" class="form-control" value="<?php echo date_format($to, 'H:i'); ?>" data-default="<?php echo date_format($to, 'H:i'); ?>">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-time"></span>
					</span> 
				</div>&nbsp;&nbsp;
				
				<div class="btn btn-sm btn-primary" id="btn-go">Go</div>
				<div class="btn btn-sm btn-success" id="btn-export">Export</div>
			</div>
			<div class="pull-right">
				<select class="form-control input-sm" id="line-chart-show" style="text-transform:capitalize">
					<option value="all">All</option>
					<?php
					foreach($fields as $f){
						echo '<option value="'.$f.'">'.$f.'</option>';
					}
					?>
				</select>
			</div>
			</form>
		</li>
		<li class="list-group-item" style="position:relative">
			<div style="margin:40px">
				<canvas width="300px"></canvas>
			</div>
			<div id="chart-data-loading" style="padding:10px 0;margin:0 auto;position:absolute;left:0;right:0;width:150px;display:none1;top:200px;display:none;border:1px solid #d5d5d5;text-align:center;background:rgba(255,255,255,1)">
				<img style="height:20px" src="<?php echo base_url();?>src/img/spinning.gif">
			</div>
		</li>
		</ul>
<script>
(function(){
	var chart_data = [];
	var from_date = '<?php echo date_format($from, 'Y-m-d');?>';
	var from_time = '<?php echo date_format($from, 'H:i'); ?>';
	var to_date = '<?php echo date_format($to, 'Y-m-d');?>';
	var to_time = '<?php echo date_format($to, 'H:i'); ?>';

	$('.line-chart #dp_from').datepicker({autoclose: true, todayHighlight: true }).on('changeDate', function(e){
		from_date = e.date.getFullYear() + '-' + (e.date.getMonth() + 1) + '-' + e.date.getDate();
		$(this).datepicker('hide');
	});
	$('.line-chart #dp_to').datepicker({autoclose: true, todayHighlight: true }).on('changeDate', function(e){
		to_date = e.date.getFullYear() + '-' + (e.date.getMonth() + 1) + '-' + e.date.getDate();
		$(this).datepicker('hide');
	});
	$('.line-chart .clockpicker').clockpicker({
		donetext: 'Done'
	});
	var color_list = ['red', 'blue', 'yellow', 'green'];
	var fields = JSON.parse('<?php echo json_encode($fields);?>');
	var datasets = [];
	for(var  i= 0; i < fields.length; ++i){
		datasets.push({
			label: fields[i],
			fill: false,
			pointRadius: 0,
			showLine: false,
			borderColor: color_list[i],
			backgroundColor: color_list[i],
			data: [0, 100]
		});
	}
		var data = {labels: [0, 100], datasets: datasets};

	var line_chart = new Chart($('.line-chart canvas'), {
		scaleOverride : true,
		//scaleSteps : 10,
		//scaleStepWidth : 50,
		scaleStartValue : 0,
		type: 'line',
		data: data,
		options:{ 
			scales : {
				xAxes : [ {
					gridLines: {display : false}
				}],
				yAxes: [{
					display: true,
					ticks: {
						beginAtZero: true   // minimum value will be 0.
					}
				}]
			}
		}
	});

	function update_chart(){
		var show = $('#line-chart-show').val();
		var show_fields = show == 'all' ? fields : [show];

		line_chart.data.labels = [];
		line_chart.data.datasets = [];
		for(var i = 0; i < show_fields.length; ++i){
			line_chart.data.datasets.push({
				label: show_fields[i],
				fill: false,
				pointRadius: 0,
				showLine: true,
				borderColor: color_list[i],
				backgroundColor: color_list[i],
				data: []
			});
		}
		line_chart.update();
			
		if(chart_data.length > 0){
			for(var i = 0; i < chart_data.length; ++i){
				if(i == 0 || i == chart_data.length - 1){
					line_chart.data.labels.push(new Date(chart_data[i]['time']).format('abbr'));
				}
				else{
					line_chart.data.labels.push('');
				}
				for(var j = 0; j < show_fields.length; ++j){
					line_chart.data.datasets[j].data.push(
						chart_data[i][show_fields[j]]
					);
				}
			}
			line_chart.update();
		}
		else{
			line_chart.data.labels = [''];
			for(var i = 0; i < show_fields.length; ++i){
				line_chart.data.datasets[i].data = [0, 100];
				line_chart.data.datasets[i].showLine = false;
			}
			line_chart.update();
		}
	}

	$('.line-chart #btn-export').click(function(){
		//alert('<?php echo base_url().'myaccount/devices/'.$url;?>?id=' + '<?php echo $id;?>' + '&from=' + from_date + ' ' + from_time + '&to=' + to_date + ' ' + to_time);
		window.location.href = '<?php echo base_url().'myaccount/devices/'.$url;?>?id=<?php echo $id;?>&from=' + from_date + ' ' + from_time + '&to=' + to_date + ' ' + to_time;
	});

	$('.line-chart #btn-go').click(function(){
		$('#btn-go').addClass('disabled');
		$('#chart-data-loading').show();
		$.ajax({
			url: '<?php echo base_url().'myaccount/ajax/'.$url;?>',
			method: 'post',
			data:{id: '<?php echo $id;?>', from: from_date + ' ' + from_time, to: to_date + ' ' + to_time, fields: fields},
			dataType: 'json',
			success: function(data){
				if(data['success']){
					chart_data = data['data'];
					update_chart();//line_chart, data['data'], fields);
				}
				else{
				}
			},
			error: function(a, b, c){
			},
			complete: function(){
				$('#chart-data-loading').hide();
				$('#btn-go').removeClass('disabled');
			}
		});
	});

	$(".line-chart #cp_from").change(function(){
		from_time = $(this).children('input').val();
	});

	$(".line-chart #cp_to").change(function(){
		to_time = $(this).children('input').val();
	});

	$('.line-chart #line-chart-show').change(function(){
		update_chart();
	});
}());
</script>