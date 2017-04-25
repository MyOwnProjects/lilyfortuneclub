<div class="pie-chart">
	<canvas id="<?php echo $element;?>" width="<?php echo $width; ?>"></canvas>
</div>
<script>
(function(id, data){
	var labels = [];
	var values = [];
	var colors = ['red', 'blue', 'yellow', 'green',"#FF6384","#36A2EB","#FFCE56"];
	var fill_colors = ['#fff', '#fff', '000', '#fff',"#000","#000","#000"];
	for(var i  = 0; i < data.length; ++i){
		labels.push(data[i]['label']);
		values.push(data[i]['value']);
	}
	var show_data = {
		labels: labels,
		datasets: [{
			data: values,
			backgroundColor: colors,
			hoverBackgroundColor: colors,
			fillColor: fill_colors
		}]
	};

	var chart = new Chart(document.getElementById(id).getContext("2d"),{
		type: 'pie',
		data: show_data,
		options: {cutoutPercentage: 0,
			events: false,
			animation: {
				duration: 500,
				easing: "easeOutQuart",
				onComplete: function () {
					var ctx = this.chart.ctx;
					ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
					ctx.textAlign = 'center';
					ctx.textBaseline = 'bottom';

					this.data.datasets.forEach(function (dataset) {
						for (var i = 0; i < dataset.data.length; i++) {
							var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
							total = dataset._meta[Object.keys(dataset._meta)[0]].total,
							mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) * 0.618,
							start_angle = model.startAngle,
							end_angle = model.endAngle,
							mid_angle = start_angle + (end_angle - start_angle)/2;
							var percentage= dataset.data[i] / total;
							var dia = percentage < 0.083 ? model.outerRadius + 20 : mid_radius;
							var x = dia * Math.cos(mid_angle);
							var y = dia * Math.sin(mid_angle);
							ctx.fillStyle = percentage < 0.083 ? "#000" : dataset['fillColor'][i];
							//var percent = String(Math.round(dataset.data[i]/total*100)) + "%";
							//ctx.fillText(dataset.data[i], model.x + x, model.y + y);
							// Display percent in another line, line break doesn't work for fillText
							ctx.font='italic 20px calibri';
							ctx.fillText(dataset.data[i], model.x + x, model.y + y + 15);
						}
					});               
				}
			}
		}
	});
}('<?php echo $element;?>', JSON.parse('<?php echo json_encode($data);?>')));
</script>
