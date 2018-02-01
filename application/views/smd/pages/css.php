<style>
.clearfix:after{content:"";display:table;clear:both}
body{margin:0;padding:0;background:url(<?php echo base_url();?>src/img/Checkered.png);font-family:Arial}
.a4{width:210mm;height:297.0mm;margin:0;background:url(<?php echo base_url();?>src/img/watermark.png) #fff no-repeat;opacity:1;position:relative}
.a4 .header{position:absolute;top:0;left:30px;right:30px;height:19px;padding-top:9px;border-bottom:1px solid #e5e5e5;font-size:13px;color:#858585;text-align:right;}
.a4 .header>div{line-height:20px;}
.a4 .footer{position:absolute;bottom:0;left:30px;right:30px;height:29px;border-top:1px solid #e5e5e5;font-size:13px;color:#858585;}
.a4 .footer div{line-height:20px}
.a4 .footer>div:first-child{float:left}
.a4 .footer>div:last-child{float:right}
/*.a4 .main{height:276.5mm;width:200mm;overflow:auto;margin:0 auto;background:transparent}*/
.a4 .main{position:absolute;top:30px;bottom:30px;left:30px;right:30px;z-index:100;background:transparent;}

.a41:nth-child(even){background:red}.a42:nth-child(odd){background:blue}
.a4 .title{font-size:8mm;font-weight:bold;text-align:center;color:#7D0B0F;margin-bottom:10mm}
ul,ul li{padding:0;margin:0;list-style:none}
.block .head1{color:#8B0000;font-weight:bold;font-size:5mm;line-height:10mm}
.block:not(:first-child) .head1{margin-top:5mm}
.block .text{font-size:3.5mm;line-height:5mm}
.p{line-height:26px;font-size:14px;margin:10px 0;text-indent:28px;}
		table{table-layout:fixed;border-collapse:collapse;margin:0 auto}
		table.t1{width:100%}
		table.t1 td.h.h1.h2{font-size:3.5mm}
		table.t1 td:not(.h):not(.h1):not(.h2){font-size:3.5mm}
		table.t1 tr td.h{padding:0.5mm 0;text-align:center;vertical-align:middle;color:#fff;background:#8B0000/*#d9534f*/;font-weight:bold}
		table.t1 tr td.h1{border-right:1px solid #fff;}
		table.t1 tr td.h:first-child{border-left:1px solid #8B0000;}
		table.t1 td.h:not(.b){border-bottom:1px solid #fff}
		table.t1 td:not(.h):not(.f){padding:5px 5px;vertical-align:top;text-align:left}
		table.t1 td.h2{color:#000;font-weight:bold;border-bottom:1px solid #8B0000}
		table.t1 td:not(.h):not(.h1):not(.h2):not(.b):not(.f):not(.g){border-bottom:1px solid #858585}
		table.t1 td.g{border-bottom:1px solid #e5e5e5}
		table.t1 td.h2.t{text-align:center}
		table.t1 tr td:last-child{border-right:1px solid #8B0000}
		table.t1 td.t{border-top:1px solid #8B0000}
		table.t1 td.b{border-bottom:1px solid #8B0000}
		table.t1 tr td:not(:last-child):not(.h):not(.h1):not(.h2){border-right:1px solid #858585}
		table.t1 tr td.h2:not(:last-child){border-right:1px solid #8B0000 !important}
		
		table.t2{text-align:center;table-layout:fixed;border-collapse:collapse;font-size:3.5mm}
		table.t2.th{width:95mm}
		table.t2.tf{width:200mm}
		table.t2:first-child{float:left}
		table.t2:nth-child(2){float:right}
		table.t2 tr td{border-top:1px solid #e5e5e5;white-space:nowrap;}
		
		table.t3{width:100%}
		table.t3 td{font-size:3.5mm}
		table.t3 td.c{text-align:center}
		table.t3 td.h{border-top:1px solid #8B0000;background:#8B0000;color:#fff;font-weight:bold;padding:2mm 1.5mm}
		table.t3 td:not(.h){padding:1.5mm}
		table.t3 td.gl{border-left:1px solid #8B0000;}
		table.t3 td:last-child{border-right:1px solid #8B0000;}
		table.t3 tr td.h:not(:first-child){border-left:1px solid #FFF;}
		table.t3 td{padding-left:1mm;padding-right:1mm}
		table.t3 tr td:not(.h):not(.b):not(.s){border-bottom:1px solid #858585}
		table.t3 tr td.s{border-bottom:1px solid #e5e5e5}
		table.t3 tr td:not(.h):not(.gl){border-left:1px solid #858585}
		table.t3 tr td.b, table.t3 tr:last-child td{border-bottom:1px solid #8B0000 !important;}
		

</style>