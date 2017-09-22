<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>
<title> ODDS CONNECT - DataMining </title>
<link href="/public/lib/base.css" rel="stylesheet" type="text/css">
<style>
    .wrap-loading div{
        position: fixed;
        top:25%;
        left:50%;
    }
    .display-none{
        display:none;
    }
</style>
</head>

<body>
<!-- 로딩이미지 -->
<div class="wrap-loading display-none">
    <div><img src="/public/lib/image/indicator.gif" width="120px"/></div>
</div>
<!-- 스케쥴 -->
<div style="margin-left: 27%;">
	<ul class="VS">
		<?php foreach($schedule as $entry){ ?>
			<li onclick="get_current_inning(<?=$entry->no;?>)"><a href="javascript:void(0)"><?=$entry->away_name;?> vs <?=$entry->home_name;?></a></li>
		<?php } ?>
	</ul>
</div>

<script src="/public/lib/js/jquery-1.12.4.js"></script>
<script src="/public/lib/js/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var playingInning = '';
function get_current_inning(schedule_no){
	$.ajax({
		type: "POST",
		url: "/message_/get_current_inning_ajax/"+schedule_no,
		success: function(data){
			playingInning = data;
		},
		beforeSend: function(){
	        $('.wrap-loading').removeClass('display-none');
	    },
		complete: function(){
			$('.wrap-loading').addClass('display-none');
			(playingInning == '0') ? alert('경기 시간이 아닙니다.') : location.href="/message_/playball/"+schedule_no+"/0";
		}
	});
}
</script>
</body>
</html>