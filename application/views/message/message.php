<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
<?php date_default_timezone_set('Asia/Seoul');?>
<title> ODDS CONNECT - DataMining </title>
<link href="/public/lib/base.css" rel="stylesheet" type="text/css">
<style>
    .wrap-loading div{
        position: fixed;
        top:60%;
        left:50%;
        margin-left: -10px;
    }
    .display-none{
        display:none;
    }
</style>
</head>

<body>

<?php
	$aa=$game_data->pitch;
	$pitch=explode(";", $aa);
	$aa=$game_data->inning;
	$inning=explode(";", $aa);
	$aa=$game_data->so;
	$so=explode(";",$aa);
	$aa=$game_data->rheb;
	$rheb=explode(";",$aa);
	$aa=$game_data->ball;
	$ball=explode(";",$aa);
	$aa=$game_data->runner;
	$runner=explode(";",$aa);
	$aa=$game_score->score;
	$score=explode(";",$aa);
	$now_score=0;
	for($i=0;$i<count($score);$i++){
		if($i==23 || $score[$i+1]==""){
			$now_score=(int)$score[$i];
			$i=24;
		}
	}
	$aa=$game_data->taja;
	$taja=explode(";",$aa);
?>

<!-- 로딩이미지 -->
<div class="wrap-loading display-none">
    <div><img src="/public/lib/image/indicator.gif" width="60px"/></div>
</div>
<!-- 스케쥴 -->
<div style="margin-left: 27%;">
	<ul class="VS">
		<?php foreach($schedule as $entry){ ?>
			<li <?php if($entry->no == $game_no) echo 'class="on"' ?>>
				<a href="/message_/playball/<?=$date?>/<?=$entry->no;?>/0"><?=$entry->away_name;?> vs <?=$entry->home_name;?></a>
			</li>
		<?php } ?>
	</ul>
</div><br>
<div class="input" style="margin-left: 25%; width: 935px; height: 815px; display: inline-block;">
	<div class="date">
		<!-- 경기 상세 정보 -->
		<p>
			<span><?=$detail->game_time1;?></span>
			<span><?=$detail->game_time2;?></span>
			<span><?=$detail->stadinum;?></span>
			<span class="time"></span>
		</p>
		<!-- 서버 실시간 -->
		<span id="server_time" style="float: right;"><?php echo date("H:i:s", time()); ?></span>
	</div>

	<!-- 전광판 -->
	<table>
		<caption></caption>
		<colgroup>
			<col width="100px"/>
			<col width="75px"/>
			<col width="77px"/>
			<col width="67px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
			<col width="40px"/>
		</colgroup>
		<tr>
			<th>&nbsp;</th>
			<th colspan="3">투수</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
			<th class="gray">10</th>
			<th class="gray">11</th>
			<th class="gray">12</th>
			<th>R</th>
			<th>H</th>
			<th>E</th>
			<th>B</th>
		</tr>
		<tr>
			<td><?=$detail->away_name;?></td>
			<td><?=$away_line_major[9]->name ?></td>
			<td><span id="away_pitch">투구수 : <?=$pitch[0];?></span></td>
			<td><span id="away_so">삼진 : <?=$so[0];?></span></td>
			<?php
				for($i=0;$i<count($score);$i=$i+2){
					if($score[$i+1]==""){
						echo "<td><span class='red' id='$i'>".$score[$i]."</span></td>";
					}else if($score[$i]==""){
						echo "<td id='$i'>&nbsp;</td>";
					}else{
						echo "<td id='$i'>".$score[$i]."</td>";
					}
				}
			?>
			<td id='away_rheb_r'><?=$rheb[0];?></td>
			<td id='away_rheb_h'><?=$rheb[1];?></td>
			<td id='away_rheb_e'><?=$rheb[2];?></td>
			<td id='away_rheb_b'><?=$rheb[3];?></td>
		</tr>
		<tr>
			<td><?=$detail->home_name;?></td>
			<td><?=$home_line_major[9]->name ?></td>
			<td><span id="home_pitch">투구수 : <?=$pitch[1];?></span></td>
			<td><span id="home_so">삼진 : <?=$so[1];?></span></td>
			<?php
				for($i=1;$i<count($score);$i=$i+2){
					if($i==23 || $score[$i+1]==""){
						echo "<td><span class='red' id='$i'>".$score[$i]."</span></td>";
					}else if($score[$i]==""){
						echo "<td id='$i'>&nbsp;</td>";
					}else{
						echo "<td id='$i'>".$score[$i]."</td>";
					}
				}
			?>
			<td id='home_rheb_r'><?=$rheb[4];?></td>
			<td id='home_rheb_r'><?=$rheb[5];?></td>
			<td id='home_rheb_r'><?=$rheb[6];?></td>
			<td id='home_rheb_r'><?=$rheb[7];?></td>
		</tr>
	</table>

	<!-- away_side -->
	<div class="game">
		<div class="view" style="width: 100px; float: left;">
			<div style="width: 298px; height:158px; text-align: center; border: 1px solid #BDBDBD; margin-bottom: 10px; padding-top: 10px;">
				<h1><?=$detail->away_name?></h1>
			</div>
			<table style="width: 300px;">
				<thead>
					<tr>
						<th>타순</th>
						<th>선수이름</th>
						<th>포지션</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($away_line_major as $key=>$entry){
						if ($entry->subi != ''){
					?>
						<tr>
							<td width="30"><?=$key+1 ?></td>
							<td width="80"><?=$entry->name ?></td>
							<td width="80"><?=$entry->subi ?></td>
						</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- 문자중계 -->
	<div class="game" style="margin-left: 313px;">
		<div class="view" style="width: 336px; float: left;">
			<ul class="st">
				<?php
					for ($i=1; $i<=12; $i++){
				?>
						<li id="inning_<?=$i;?>"><a href="/message_/playball/<?=$date?>/<?=$game_no;?>/<?=$i;?>"><?=$i;?>회</a></li>
				<?php
					}
				?>
			</ul>
			<div class="window" id="chating">
			</div>
			<ul class="BSO">
				<li style="width: 110px;">
					<b>B</b><span class="B_<?=$ball[0] ?>" id="b"></span>
				</li>
				<li style="width: 110px;">
					<b>S</b><span class="S_<?=$ball[1] ?>" id=s></span>
				</li>
				<li style="width: 110px;">
					<b>O</b><span class="O_<?=$ball[2] ?>" id="o"></span>
				</li>
			</ul>
			<span class="clear"></span>
		</div>
	</div>

	<!-- home_side -->
	<div class="game" style="margin-left: 11px; float: left;">
		<div class="view" style="width: 100px;">
			<div style="width: 298px; height:158px; text-align: center; border: 1px solid #BDBDBD; margin-bottom: 10px; padding-top: 10px;">
				<h1><?=$detail->home_name?></h1>
			</div>
			<table style="width: 300px;">
				<thead>
					<tr>
						<th>타순</th>
						<th>선수이름</th>
						<th>포지션</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($home_line_major as $key=>$entry){
						if ($entry->subi != ''){
					?>
						<tr>
							<td width="30"><?=$key+1 ?></td>
							<td width="80"><?=$entry->name ?></td>
							<td width="80"><?=$entry->subi ?></td>
						</tr>
					<?php }} ?>
				</tbody>
			</table>
			<input type="hidden" name="home_line_major" />
		</div>
	</div>
	<div style="float: right; margin-top: 10px;">Copyright ⓒ ODDS CONNECT Corp. All Rights Reserved.</div>
</div>

<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
	var schedule_no = <?=$game_no;?>;
	var selectedInning = 1;
	var playingInning = '';
	var interval_;
	var interval_string = '';
	$(document).ready(function(){
	 	for (var i=<?=$playingInning;?>+1; i<=12; i++) {
			$('#inning_'+i).css('background-color', '#BDBDBD');
			$('#inning_'+i+' a').replaceWith('<span style="color:#747474;">'+i+'회</span>');
		}

	 	if (<?=$selectedInning;?> == 0 || <?=$playingInning;?> == <?=$selectedInning;?>){
	 		selectedInning = <?=$playingInning;?>;
	 		interval_string = 'start';
		}else{
			selectedInning = <?=$selectedInning;?>;
			interval_string = 'stop';
		}
		get_message(selectedInning);
		intervalToggle(interval_string);
	});

	function intervalToggle(toggle){
		if(toggle == 'start') interval_ = setInterval(function(){get_message(selectedInning)}, 15000);
		else clearInterval(interval_);
	}
	function get_message(inning){
		$.ajax({
			type: "POST",
			url: "/message_/get_messsage_ajax/"+schedule_no+"/"+inning,
			success: function(data){
				var strArr = data.split('::');

				/* 전광판_투구수 */
				var pitchArr = strArr[0].split(';');
				$('#away_pitch').text('투구수 : '+pitchArr[0]);
				$('#home_pitch').text('투구수 : '+pitchArr[1]);
				/* 전광판_삼진 */
				var soArr = strArr[1].split(';');
				$('#away_so').text('삼진 : '+soArr[0]);
				$('#home_so').text('삼진 : '+soArr[1]);
				/* 전광판_점수 */
				var rhebArr = strArr[4].split(';');
				rhebArr.forEach(function(v, i) {$('#'+i).text(v);});
				/* 전광판_RHEB */
				var rhebArr = strArr[3].split(';');
				$('#away_rheb_r').text(rhebArr[0]);
				$('#away_rheb_h').text(rhebArr[1]);
				$('#away_rheb_e').text(rhebArr[2]);
				$('#away_rheb_b').text(rhebArr[3]);
				$('#home_rheb_r').text(rhebArr[4]);
				$('#home_rheb_h').text(rhebArr[5]);
				$('#home_rheb_e').text(rhebArr[6]);
				$('#home_rheb_b').text(rhebArr[7]);
				/* 볼카운트 */
				var bsoArr = strArr[2].split(';');
				$('#b').attr('class','B_'+bsoArr[0]);
				$('#s').attr('class','S_'+bsoArr[1]);
				$('#o').attr('class','O_'+bsoArr[2]);

				$('.st li').removeClass('on');
				$("#inning_"+inning).addClass('on');

				/* 메세지 */
				$("#chating").html(strArr[5]);
			},
			beforeSend: function(){
		        $('.wrap-loading').removeClass('display-none');
		        chk_playing_inning();
		    },
		    complete: function(){
		        $('.wrap-loading').addClass('display-none');
		    }
		});
	}

	/* 시청 중 다음 이닝 체크 및 페이지 이동 */
	function chk_playing_inning(){
        if(interval_string == 'start'){
            get_playing_inning();
        	if(playingInning > selectedInning) location.href="/message_/playball/<?=$date?>/"+schedule_no+"/"+playingInning;
		}
	}

	function get_playing_inning(){
		$.ajax({
			type: "POST",
			url: "/message_/get_playing_inning_ajax/"+schedule_no,
			success: function(data){
				playingInning = data;
			},
			beforeSend: function(){
		        $('.wrap-loading').removeClass('display-none');
		    },
			complete: function(){
				$('.wrap-loading').addClass('display-none');
			}
		});
	}

	/* 서버 실시간 */
	var srv_time = "<?php print date("F d, Y H:i:s", time()); ?>";
	var now = new Date(srv_time);
	setInterval("server_time()", 1000);
	function server_time(){
	    now.setSeconds(now.getSeconds()+1);
	    var hours = now.getHours();
	    var minutes = now.getMinutes();
	    var seconds = now.getSeconds();
	    if(hours < 10) hours = "0" + hours;
	    if(minutes < 10) minutes = "0" + minutes;
	    if(seconds < 10) seconds = "0" + seconds;
	    document.getElementById("server_time").innerHTML = hours+":"+minutes+":"+seconds;
	}
</script>
</body>
</html>