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
$message="";

if($game_message!=""){
	for($i=0;$i<count($game_message);$i++){
		$message=$game_message[$i]->message.$message;
	}
}
$aa=$game_data->taja;
$taja=explode(";",$aa);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
<title> ODDS CONNECT - DataMining </title>
<link href="/public/lib/base.css" rel="stylesheet" type="text/css">
</head>

<body onkeydown='on_key_down()'>
<div style="color:white">
	<input type="hidden" id="batter101" name="batter101" value="<?=$away_line[9]->position;?>"/><input type="hidden" id="batter102" name="batter102" value="<?=$away_line[9]->name;?>"/><input type="hidden" id="batter103" name="batter103" value="<?=$away_line[9]->subi;?>"/>
	<input type="hidden" id="batter111" name="batter111" value="<?=$away_line[0]->position;?>"/><input type="hidden" id="batter112" name="batter112" value="<?=$away_line[0]->name;?>"/><input type="hidden" id="batter113" name="batter113" value="<?=$away_line[0]->subi;?>"/>
	<input type="hidden" id="batter121" name="batter121" value="<?=$away_line[1]->position;?>"/><input type="hidden" id="batter122" name="batter122" value="<?=$away_line[1]->name;?>"/><input type="hidden" id="batter123" name="batter123" value="<?=$away_line[1]->subi;?>"/>
	<input type="hidden" id="batter131" name="batter131" value="<?=$away_line[2]->position;?>"/><input type="hidden" id="batter132" name="batter132" value="<?=$away_line[2]->name;?>"/><input type="hidden" id="batter133" name="batter133" value="<?=$away_line[2]->subi;?>"/>
	<input type="hidden" id="batter141" name="batter141" value="<?=$away_line[3]->position;?>"/><input type="hidden" id="batter142" name="batter142" value="<?=$away_line[3]->name;?>"/><input type="hidden" id="batter143" name="batter143" value="<?=$away_line[3]->subi;?>"/>
	<input type="hidden" id="batter151" name="batter151" value="<?=$away_line[4]->position;?>"/><input type="hidden" id="batter152" name="batter152" value="<?=$away_line[4]->name;?>"/><input type="hidden" id="batter153" name="batter153" value="<?=$away_line[4]->subi;?>"/>
	<input type="hidden" id="batter161" name="batter161" value="<?=$away_line[5]->position;?>"/><input type="hidden" id="batter162" name="batter162" value="<?=$away_line[5]->name;?>"/><input type="hidden" id="batter163" name="batter163" value="<?=$away_line[5]->subi;?>"/>
	<input type="hidden" id="batter171" name="batter171" value="<?=$away_line[6]->position;?>"/><input type="hidden" id="batter172" name="batter172" value="<?=$away_line[6]->name;?>"/><input type="hidden" id="batter173" name="batter173" value="<?=$away_line[6]->subi;?>"/>
	<input type="hidden" id="batter181" name="batter181" value="<?=$away_line[7]->position;?>"/><input type="hidden" id="batter182" name="batter182" value="<?=$away_line[7]->name;?>"/><input type="hidden" id="batter183" name="batter183" value="<?=$away_line[7]->subi;?>"/>
	<input type="hidden" id="batter191" name="batter191" value="<?=$away_line[8]->position;?>"/><input type="hidden" id="batter192" name="batter192" value="<?=$away_line[8]->name;?>"/><input type="hidden" id="batter193" name="batter193" value="<?=$away_line[8]->subi;?>"/>
	
	<input type="hidden" id="batter201" name="batter201" value="<?=$home_line[9]->position;?>"/><input type="hidden" id="batter202" name="batter202" value="<?=$home_line[9]->name;?>"/><input type="hidden" id="batter203" name="batter203" value="<?=$home_line[9]->subi;?>"/>
	<input type="hidden" id="batter211" name="batter211" value="<?=$home_line[0]->position;?>"/><input type="hidden" id="batter212" name="batter212" value="<?=$home_line[0]->name;?>"/><input type="hidden" id="batter213" name="batter213" value="<?=$home_line[0]->subi;?>"/>
	<input type="hidden" id="batter221" name="batter221" value="<?=$home_line[1]->position;?>"/><input type="hidden" id="batter222" name="batter222" value="<?=$home_line[1]->name;?>"/><input type="hidden" id="batter223" name="batter223" value="<?=$home_line[1]->subi;?>"/>
	<input type="hidden" id="batter231" name="batter231" value="<?=$home_line[2]->position;?>"/><input type="hidden" id="batter232" name="batter232" value="<?=$home_line[2]->name;?>"/><input type="hidden" id="batter233" name="batter233" value="<?=$home_line[2]->subi;?>"/>
	<input type="hidden" id="batter241" name="batter241" value="<?=$home_line[3]->position;?>"/><input type="hidden" id="batter242" name="batter242" value="<?=$home_line[3]->name;?>"/><input type="hidden" id="batter243" name="batter243" value="<?=$home_line[3]->subi;?>"/>
	<input type="hidden" id="batter251" name="batter251" value="<?=$home_line[4]->position;?>"/><input type="hidden" id="batter252" name="batter252" value="<?=$home_line[4]->name;?>"/><input type="hidden" id="batter253" name="batter253" value="<?=$home_line[4]->subi;?>"/>
	<input type="hidden" id="batter261" name="batter261" value="<?=$home_line[5]->position;?>"/><input type="hidden" id="batter262" name="batter262" value="<?=$home_line[5]->name;?>"/><input type="hidden" id="batter263" name="batter263" value="<?=$home_line[5]->subi;?>"/>
	<input type="hidden" id="batter271" name="batter271" value="<?=$home_line[6]->position;?>"/><input type="hidden" id="batter272" name="batter272" value="<?=$home_line[6]->name;?>"/><input type="hidden" id="batter273" name="batter273" value="<?=$home_line[6]->subi;?>"/>
	<input type="hidden" id="batter281" name="batter281" value="<?=$home_line[7]->position;?>"/><input type="hidden" id="batter282" name="batter282" value="<?=$home_line[7]->name;?>"/><input type="hidden" id="batter283" name="batter283" value="<?=$home_line[7]->subi;?>"/>
	<input type="hidden" id="batter291" name="batter291" value="<?=$home_line[8]->position;?>"/><input type="hidden" id="batter292" name="batter292" value="<?=$home_line[8]->name;?>"/><input type="hidden" id="batter293" name="batter293" value="<?=$home_line[8]->subi;?>"/>
	
	<form name="stat_data" id="stat_data">
		<input type="hidden" id="home" name="home" value="<?=$game->home_no?>"/>
		<input type="hidden" id="away" name="away" value="<?=$game->away_no?>"/>
		<input type="hidden" id="game_time1" name="game_time1" value="<?=$game->game_time1?>" style="width:70px;" />
		<input type="hidden" id="game_time2" name="game_time2" value="<?=$game->game_time2?>"/>
		<input type="hidden" id="stadinum" name="stadinum" value="<?=$game->stadinum?>"/>
		<input type="hidden" id="away_name" name="away_name" value="<?=$game->away_name?>"/>
		<input type="hidden" id="home_name" name="home_name" value="<?=$game->home_name?>"/>

		<input type="hidden" id="game_no" name="game_no" value="<?=$game->no;?>" style="width:50px;"/>
		<input type="hidden" id="inning1" name="inning1" value="<?=$inning[0]?>"/>
		<input type="hidden" id="inning2" name="inning2" value="<?=$inning[1]?>"/>
		<input type="hidden" id="pitcher" name="pitcher" value="<?=$game_data->pitcher;?>"/>
		<input type="hidden" id="batter" name="batter" value="<?=$game_data->batter;?>"/>
		<input type="hidden" id="runner1" name="runner1" value="<?=$runner[0];?>"/>
		<input type="hidden" id="runner2" name="runner2" value="<?=$runner[1];?>"/>
		<input type="hidden" id="runner3" name="runner3" value="<?=$runner[2];?>"/>
		<input type="hidden" id="pitch1" name="pitch1" value="<?=$pitch[0];?>"/>
		<input type="hidden" id="pitch2" name="pitch2" value="<?=$pitch[1];?>"/>
		<input type="hidden" id="so1" name="so1" value="<?=$so[0];?>"/>
		<input type="hidden" id="so2" name="so2" value="<?=$so[1];?>"/>
		<input type="hidden" id="ball1" name="ball1" value="<?=$ball[0];?>"/>
		<input type="hidden" id="ball2" name="ball2" value="<?=$ball[1];?>"/>
		<input type="hidden" id="ball3" name="ball3" value="<?=$ball[2];?>"/>
		<input type="hidden" id="rheb1" name="rheb1" value="<?=$rheb[0];?>"/>
		<input type="hidden" id="rheb2" name="rheb2" value="<?=$rheb[1];?>"/>
		<input type="hidden" id="rheb3" name="rheb3" value="<?=$rheb[2];?>"/>
		<input type="hidden" id="rheb4" name="rheb4" value="<?=$rheb[3];?>"/>
		<input type="hidden" id="rheb5" name="rheb5" value="<?=$rheb[4];?>"/>
		<input type="hidden" id="rheb6" name="rheb6" value="<?=$rheb[5];?>"/>
		<input type="hidden" id="rheb7" name="rheb7" value="<?=$rheb[6];?>"/>
		<input type="hidden" id="rheb8" name="rheb8" value="<?=$rheb[7];?>"/>
		<input type="hidden" id="now_score" name="now_score" value="<?=$now_score;?>"/>
		<input type="hidden" id="taja1" name="taja1" value="<?=$taja[0];?>"/>
		<input type="hidden" id="taja2" name="taja2" value="<?=$taja[1];?>"/>
		 
		<input type="hidden" id="start_" name="start_" value="<?=$rows_?>"/>
		<input type="hidden" id="message_" name="message_" value="<?=$message;?>"/>
		
		<input type="hidden" id="batter_action" name="batter_action"/>
		<input type="hidden" id="runner1_action" name="runner1_action"/>
		<input type="hidden" id="runner2_action" name="runner2_action"/>
		<input type="hidden" id="runner3_action" name="runner3_action"/>
		<input type="hidden" id="runner_select" name="runner_select"/>
		<input type="hidden" id="runner_out" name="runner_out" value="0"/>
		<input type="hidden" id="taja_out" name="taja_out" value="0"/>
	</form>
</div>

<div class="wrap">
	<div class="input">
		<div class="date">
			<p>
				<span><?=$game->game_time1;?></span>
				<span><?=$game->game_time2;?></span>
				<span><?=$game->stadinum;?>경기장</span>
			</p>
			<p>
				<span>기록자 : <?=$this->session->userdata('nickname')?></span>
				<a href="/user/logout">LOGOUT<span></span></a>
			</p>
		</div>
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
				<th colspan="3">각팀 현재 투수</th>
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
				<td><?=$game->away_name;?></td>
				<td><?=$away_line[9]->name;?></td>
				<td><span>투구수 : <?=$pitch[0];?></span></td>
				<td><span>삼진 : <?=$so[0];?></span></td>
				<?php 
					for($i=0;$i<count($score);$i=$i+2){
						if($score[$i+1]=="") echo "<td><span class='red'>".$score[$i]."</span></td>";
						else if($score[$i]=="") echo "<td>&nbsp;</td>"; 
						else echo "<td>".$score[$i]."</td>";
					}
				?>
				<td><?=$rheb[0];?></td>
				<td><?=$rheb[1];?></td>
				<td><?=$rheb[2];?></td>
				<td><?=$rheb[3];?></td>
			</tr>
			<tr>
				<td><?=$game->home_name;?></td>
				<td><?=$home_line[9]->name;?></td>
				<td><span>투구수 : <?=$pitch[1];?></span></td>
				<td><span>삼진 : <?=$so[1];?></span></td>
				<?php 
					for($i=1;$i<count($score);$i=$i+2){
						if($i==23 || $score[$i+1]=="") echo "<td><span class='red'>".$score[$i]."</span></td>";
						else if($score[$i]=="") echo "<td>&nbsp;</td>";
						else echo "<td>".$score[$i]."</td>";
					}
				?>
				<td><?=$rheb[4];?></td>
				<td><?=$rheb[5];?></td>
				<td><?=$rheb[6];?></td>
				<td><?=$rheb[7];?></td>
			</tr>
		</table>
		<div class="game">
			<div class="ground">
				<img src="/public/lib/image/bg_ground.jpg" alt="" usemap="#ground"/>
				<ul class="base">
					<?php 
						if($runner[2]!=0) echo "<li class='base1 on'>";
						else echo "<li class='base1'>";
					?>
					<span></span></li>
					<?php 
						if($runner[1]!=0) echo "<li class='base2 on'>";
						else echo "<li class='base2'>";
					?>
					<span></span></li>
					<?php 
						if($runner[0]!=0) echo "<li class='base3 on'>";
						else echo "<li class='base3'>";
					?>
					<span></span></li>
				</ul>
				<!-- 경기장 이미지맵 -->
				<map name="ground" id="" class="groundmap">
					<area shape="poly" coords="59,238,59,179,118,179,119,118,179,118,180,1,0,1,0,239" href="" target="" alt="" class="gr g01" />
					<area shape="poly" coords="179,118,299,117,299,58,358,57,359,119,478,120,478,0,179,1" href="" target="" alt="" class="gr g02" />
					<area shape="poly" coords="478,0,479,118,538,119,539,179,599,179,599,238,657,238,656,0" href="" target="" alt="" class="gr g03" />
					<area shape="poly" coords="177,418,177,417,179,297,239,298,240,118,120,119,120,178,59,177,59,240,0,239,1,296,59,299,59,356,119,358,117,419" href="" target="" alt="" class="gr g04" />
					<area shape="poly" coords="238,297,239,118,298,119,300,58,357,59,358,117,418,119,417,297" href="" target="" alt="" class="gr g05" />
					<area shape="poly" coords="419,119,538,119,538,177,598,178,600,237,656,238,656,297,599,298,598,358,538,359,538,417,479,417,479,297,419,297" href="" target="" alt="" class="gr g06" />
					<area shape="poly" coords="58,299,58,358,118,360,118,418,178,421,178,538,238,538,238,598,298,599,298,656,0,655,1,297" href="" target="" alt="" class="gr g07" />
					<area shape="rect" coords="179,298,298,418" href="" target="" alt="" class="gr g08" />
					<area shape="rect" coords="299,298,359,419" href="" target="" alt="" class="gr g09" />
					<area shape="rect" coords="359,298,479,419" href="" target="" alt="" class="gr g10" />
					<area shape="rect" coords="178,419,297,539" href="" target="" alt="" class="gr g11" />
					<area shape="rect" coords="299,421,358,539" href="" target="" alt="" class="gr g12" />
					<area shape="rect" coords="359,420,478,539" href="" target="" alt="" class="gr g13" />
					<area shape="poly" coords="239,538,239,598,299,598,298,654,359,656,360,598,418,597,418,538" href="" target="" alt="" class="gr g14" />
					<area shape="poly" coords="359,598,359,599,419,598,419,538,477,537,479,418,539,418,539,359,598,358,601,299,656,299,656,656,359,656" href="" target="" alt="" class="gr g15" />
				</map>
				<ul class="gr_view">
					<li class="g01">
						<div>
							<ul>
								<li><a href="javascript:controller_click('좌홈')">좌홈</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g02">
						<div>
							<ul>
								<li><a href="javascript:controller_click('중홈')">중홈</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g03">
						<div>
							<ul>
								<li><a href="javascript:controller_click('우홈')">우홈</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g04">
						<div>
							<ul>
								<li><a href="javascript:controller_click('좌익수 앞 뜬볼');">좌비</a></li>
								<li><a href="javascript:controller_click('좌전 안타');">좌1</a></li>
								<li><a href="javascript:controller_click('좌익수 방면 2루타');">좌2</a></li>
								<li><a href="javascript:controller_click('좌익수 방면 3루타');">좌3</a></li>
								<li><a href="javascript:controller_click('좌익수 실책');">좌실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g05">
						<div>
							<ul>
								<li><a href="javascript:controller_click('중견수 앞 뜬볼');">중비</a></li>
								<li><a href="javascript:controller_click('중간 안타');">중1</a></li>
								<li><a href="javascript:controller_click('중견수 방면 2루타');">중2</a></li>
								<li><a href="javascript:controller_click('중견수 방면 3루타');">중3</a></li>
								<li><a href="javascript:controller_click('중견수 실책');">중실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g06">
						<div>
							<ul>
								<li><a href="javascript:controller_click('우익수 앞 뜬볼');">우비</a></li>
								<li><a href="javascript:controller_click('우전 안타');">우1</a></li>
								<li><a href="javascript:controller_click('우익수 방면 2루타');">우2</a></li>
								<li><a href="javascript:controller_click('우익수 방면 3루타');">우3</a></li>
								<li><a href="javascript:controller_click('우익수 실책');">우실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g07">
						<div>
							<ul>
								<li><a href="javascript:controller_click('파울 플라이');">파플</a></li>										
								<li><a href="javascript:controller_click('파울 실책');">파실</a></li>										
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g08">
						<div>
							<ul>
								<li><a href="javascript:controller_click('유격수 앞 땅볼');">유땅</a></li>
								<li><a href="javascript:controller_click('유격수 앞 뜬볼');">유비</a></li>
								<li><a href="javascript:controller_click('유격수 앞 번트');">유번</a></li>
								<li><a href="javascript:controller_click('좌중간 안타');">좌중안</a></li>
								<li><a href="javascript:controller_click('유격수 실책');">유실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g09">
						<div>
							<ul>
								<li><a href="javascript:controller_click('2루수 앞 땅볼');">2땅</a></li>
								<li><a href="javascript:controller_click('2루수 앞 뜬볼');">2비</a></li>
								<li><a href="javascript:controller_click('유격수 앞 땅볼');">유땅</a></li>
								<li><a href="javascript:controller_click('유격수 앞 뜬볼');">유비</a></li>
								<li><a href="javascript:controller_click('중전 안타');">중안</a></li>
								<li><a href="javascript:controller_click('2루수 실책');">2실</a></li>
								<li><a href="javascript:controller_click('유격수 실책');">유실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g10">
						<div>
							<ul>
								<li><a href="javascript:controller_click('2루수 앞 땅볼');">2땅</a></li>
								<li><a href="javascript:controller_click('2루수 앞 뜬볼');">2비</a></li>
								<li><a href="javascript:controller_click('2루수 앞 번트');">2번</a></li>
								<li><a href="javascript:controller_click('우중간 안타');">우중안</a></li>
								<li><a href="javascript:controller_click('2루수 실책');">2실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g11">
						<div>
							<ul>
								<li><a href="javascript:controller_click('3루수 앞 땅볼');">3땅</a></li>
								<li><a href="javascript:controller_click('3루수 앞 뜬볼');">3비</a></li>
								<li><a href="javascript:controller_click('3루수 앞 번트');">3번</a></li>
								<li><a href="javascript:controller_click('3루수 쪽 내야안타');">3안</a></li>
								<li><a href="javascript:controller_click('3루수 실책');">3실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g12">
						<div>
							<ul>
								<li><a href="javascript:controller_click('투수 앞 땅볼');">투땅</a></li>
								<li><a href="javascript:controller_click('투수 앞 뜬볼');">투비</a></li>
								<li><a href="javascript:controller_click('투수 앞 번트');">투번</a></li>
								<li><a href="javascript:controller_click('투수 쪽 내야 안타');">투안</a></li>
								<li><a href="javascript:controller_click('투수 실책');">투실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g13">
						<div>
							<ul>
								<li><a href="javascript:controller_click('1루수 앞 땅볼');">1땅</a></li>
								<li><a href="javascript:controller_click('1루수 앞 뜬볼');">1비</a></li>
								<li><a href="javascript:controller_click('1루수 앞 번트');">1번</a></li>
								<li><a href="javascript:controller_click('1루수 쪽 내야안타');">1안</a></li>
								<li><a href="javascript:controller_click('1루수 실책');">1실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g14">
						<div>
							<ul>
								<li><a href="javascript:controller_click('포수 앞 땅볼');">포땅</a></li>
								<li><a href="javascript:controller_click('포수 뜬볼');">포파</a></li>
								<li><a href="javascript:controller_click('포수 앞 번트');">포번</a></li>
								<li><a href="javascript:controller_click('포수 실책');">포실</a></li>
							</ul>
							<span></span>
						</div>
					</li>
					<li class="g15">
						<div>
							<ul>
								<li><a href="javascript:controller_click('파울 플라이');">파플</a></li>
								<li><a href="javascript:controller_click('파울 실책');">파실</a></li>	
							</ul>
							<span></span>
						</div>
					</li>
				</ul>
			</div>
			<div class="view">
				<ul class="st">
					<?php for($i=1; $i<10; $i++){ ?>
						<li <?php if($inning_==$i) echo "class='on'";?> id="inning_<?=$i;?>">
							<a href="/baseball/game/<?=$date?>/<?=$game_no?>/<?=$i;?>"><?=$i;?>회</a>
						</li>
					<?php } ?>
					<li <?php if($inning_==10 || $inning_==11 || $inning_==12) echo "class='on'";?> id="inning_10">
						<a href="/baseball/game/<?=$date?>/<?=$game_no?>/<?=$current_inning?>">연장</a>
					</li>
				</ul>
				<div class="window" id="chating"></div>
				<ul class="BSO">
					<li><b>B</b><span class='B_<?=$ball[0]?>'></span></li>
					<li><b>S</b><span class='S_<?=$ball[1]?>'></span></li>
					<li><b>O</b><span class='O_<?=$ball[2]?>'></span></li>
				</ul>
				<p class="btn"><a href="javascript:player_change()">선수교체 및 수비위치 변경</a></p>
				<p class="btn" id="challenge"><a href="javascript:void(0)">비디오<br/>판독</a></p>
				<span class="clear"></span>
			</div>
		</div>
	</div>
	<div class="click">
		<span style="margin-left: 35px;">
			<a href="javascript:game_toggle();">
				<img id="game_start_img" name="game_start_img" src="<?=($during_game=='N') ? '/public/lib/image/on.png' : '/public/lib/image/off.png';?>">
			</a>
		</span>
		<div class="command">
			<p>커맨드</p>
			<div id="text_comm"></div>
			<a href="javascript:message_cancel();" class="not">입력 취소<span></span></a>
			<a href="javascript:get_game_rule();" class="apply">전 송<span></span></a>
		</div>
		<div class="gbox">
			<a href="javascript:controller_click('스트라이크');" class="w273 h123">스트라이크<span>S</span></a>
			<a href="javascript:controller_click('헛스윙');" class="h123 w113">헛스윙<span>W</span></a>
			<a href="javascript:controller_click('낫아웃');" class="h123 w113">낫아웃<span>E</span></a>
			<a href="javascript:controller_click('볼');" class="btn3 h103">볼<span>A</span></a>
			<a href="javascript:controller_click('파울');" class="btn3 btn2_1 h103">파울<span>D</span></a>
			<a href="javascript:controller_click('사구');" class="btn3 h103">사구<span>Q</span></a>
			<a href="javascript:controller_click('세이프');" class="btn3 h83">세이프<span>Z</span></a>
			<a href="javascript:controller_click('타자아웃');" class="btn3 btn3_1 h83">아웃<span>X</span></a>
			<a href="javascript:controller_click('보크');" class="btn3 h83">보크<span>R</span></a>
			<span class="clear"></span>
		</div>
		<p class="line"></p>
		<div class="gbox PB">
			<a href="javascript:controller_click('3루');" class="btn3" id="3ru">3루<span>3</span></a>
			<a href="javascript:controller_click('2루');" class="btn3 btn3_1" id="2ru">2루<span>2</span></a>
			<a href="javascript:controller_click('1루');" class="btn3" id="1ru">1루<span>1</span></a>					
			<a href="javascript:controller_click('도루 진루');" class="btn3 h73" id="doru">도루진루</a>
			<a href="javascript:controller_click('실책 진루');" class="btn3 btn3_1 h73" id="errorru">실책진루</a>
			<a href="javascript:controller_click('진루');" class="btn3 h73" id="jinru">진루</a>
			<a href="javascript:controller_click('홈인');" class="h105" id="scoreru">홈인</a>
			<a href="javascript:controller_click('주자아웃');" class="btn3 h73" id="outru">아웃</a>
			<a href="javascript:controller_click('주루사');" class="btn3 btn3_1 h73" id="juru4ru">주루사</a>
			<a href="javascript:controller_click('견제사');" class="btn3 h73" id="4ru">견제사</a>
			<span class="clear"></span>
		</div>
	</div>
</div>
<div id="wrap_challenge" style="position:absolute; top:54%; right:55%; z-index:1; display:none;">
	<iframe width="280px" height="240px" src="/baseball/challenge/<?=$game_no?>/<?=$inning_?>" style="position:absolute;">test</iframe>
</div>
<div style="position:absolute; right:180px; bottom:40px;">
	<a href="/edit_mode/main/<?=$date?>/<?=$game_no?>/<?=$inning_?>">Copyright ⓒ ODDS CONNECT Corp. All Rights Reserved.</a>
</div>
</body>

<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
var game_start="<?=$during_game?>";
var runner_name="";
var runner_action="";
var command_="";
var pitching_num=0;
var conn=new WebSocket('ws://210.179.67.38:8080');

$(document).ready(function(){
    setTimeout(function(){send_ratchet();}, 500);
	get_cookie("pitching_num");

	msg=$("#message_").val();
	$("#chating").html(msg);

	for(var i=($("#inning1").val()*1+1); i<=10; i++) {
		$('#inning_'+i).css('background-color', '#BDBDBD');
		if(i==10) $('#inning_'+i+' a').replaceWith('<span style="color:#747474;">연장</span>');
		else $('#inning_'+i+' a').replaceWith('<span style="color:#747474;">'+i+'회</span>');
	}

	for(var i=1; i<6; i++){
		(function (k){
			$(".VS > li:eq("+k+")").click(function(){
				$(".VS_view > li").removeClass("on");
				$(".VS_view > li:eq("+k+")").addClass("on");
				$(".VS > li").removeClass("on"); 
				$(this).addClass("on");
				return false;
			});
		}(i));
	};
	for(var i=0; i<16; i++){
		(function (k){
			$(".groundmap > .gr:eq("+k+")").click(function(){
				controller_click("타격");
				$(".gr_view > li").removeClass("active"); 
				$(".gr_view > li:eq("+k+")").addClass("active"); 
				return false;
			});
		}(i));
	};

	if(<?=$inning_?>>=9 && $("#inning2").val()=="1" && <?=intval($rheb[0])?><<?=intval($rheb[4])?> && game_start=="Y") set_cookie("during_game", "N", true);
	if($("#ball3").val()=="3" && game_start=="Y") change_inning();
});

$(function(){$("a").attr("onfocus","this.blur();")});
$(document).click(function(){$(".active").removeClass("active");});
$("#challenge").click(function(){$("#wrap_challenge").toggle();});

function game_toggle(){
	/* 게임 종료상태 */
	if(game_start=="N"){
		set_cookie("pitching_num", 1, false);
		set_cookie("during_game", "Y", false);

		/* 1회 초에만 게임 시작 메세지 출력 */
		if("<?=$game_data->inning?>"=="1;0"){
			msg="";
			msg="<p class='bold green'>"+$("#game_time1").val()+" "+$("#game_time2").val()+" "+$("#stadinum").val()+" 경기장</p><br/>"+msg;
			msg="<p class='bold green'>"+$("#away_name").val()+" VS "+$("#home_name").val()+" 경기<br/><br/></p>"+msg;
			msg="<p class='bold green'>1회초 "+$("#away_name").val()+" 공격<br/><br/></p>"+msg;
			msg="<p class='bold green'>"+$("#home_name").val()+" 투수 "+$("#batter202").val()+"<br/><br/></p>"+msg;
			msg="<p class='blue'>"+ $("#away_name").val()+" 1번 타자 "+$("#batter112").val()+"<br/><br/></p>"+msg;
			
			$("#chating").html(msg);
			message_send(msg);
		}else $('#game_start_img').attr("src", "/public/lib/image/off.png");
	/* 게임 중 */
	}else{
		var set_message="";
		var num=prompt("1.우천취소 2.우천중지 3.강우콜드");
		if(num=="1") set_message="우천 취소";
		else if(num=="2") set_message="우천 중지";
		else if(num=="3") set_message="강우 콜드";
		else alert("취소 되었습니다.");

		if(set_message!="" && confirm("확인을 누르시면 경기가 종료됩니다.")){
            if(set_message=="우천 취소" || set_message=="우천 중지") update_game_status('rain');
			set_cookie("during_game", "N", false);
			message="<p class='bold red'>"+set_message+"</p><p class='bold green'>"+$("#away_name").val()+" "+$("#rheb1").val()+" : "
					+$("#rheb5").val()+" "+$("#home_name").val()+"</p><p class='bold green'>경기 종료</p><br/>";
			message_send(message);
		}
	}
}

function update_game_status(status){
    $.ajax({
        type:'POST',
        dataType:'text',
        url:'/baseball/update_schedule_status/'+schedule_no+'/'+status
    });
}

function message_send_gameset(message){
	schedule_no=$("#game_no").val();
	inning=$("#inning1").val()+";"+$("#inning2").val();
	pitcher=$("#pitcher").val();
	batter=$("#batter").val();
	$.ajax({
		type:'POST',
		dataType:'text',
		url:'/baseball/message_send',
        data:{schedule_no:schedule_no, inning:inning, pitcher:pitcher, batter:batter, message1:message},
        complete:function(){
            update_game_status('set');
       		location.href=("/baseball/game/<?=$date?>/<?=$game_no?>/<?=$inning_?>");
        }
	});
}

function message_send(message){
	schedule_no=$("#game_no").val();
	inning=$("#inning1").val()+";"+$("#inning2").val();
	pitcher=$("#pitcher").val();
	batter=$("#batter").val();
	$.ajax({
		type:'POST',
		dataType:'text',
		url:'/baseball/message_send',
        data:{schedule_no:schedule_no, inning:inning, pitcher:pitcher, batter:batter, message1:message},
        complete:function(){
        	get_playing_inning();
		}
	});
}
function get_playing_inning(){
	var playing_inning="";
	$.ajax({
		type: "POST",
		url: "/message_/get_playing_inning_ajax/<?=$game_no?>",
		success:function(data){
			playing_inning=data;
		},
		complete:function(){
			stats_send(playing_inning);
		}
	});
}
function stats_send(playing_inning){
	var stats=$("#stat_data").serialize();
	
	$.ajax({
		url:'/baseball/stat',
		dataType:'text',
		type:'POST',
        data:stats,
        complete:function(){
        	location.href=("/baseball/game/<?=$date?>/<?=$game_no?>/"+playing_inning);
		}
	});
}

function message_cancel(){
	$("#text_comm").text("");
	$("#batter_action").val("");
	$("#runner1_action").val("");
	$("#runner2_action").val("");
	$("#runner3_action").val("");
	$("#runner_select").val("");
	$("#runner_out").val("0");
	$("#taja_out").val("0");
}

function set_cookie(_kindof, _num, flag){
	$.ajax({
		type:'POST',
		url:'/baseball/set_cookie_ajax',
        data:{kindof:_kindof, num:_num},
        complete:function(){
			/* 게임 종료 */
			if(flag){
				if(<?=$inning_?> >= 9 && $("#inning2").val()=="1" && <?=intval($rheb[0])?> < <?=intval($rheb[4])?>){
					message="<p class='bold red'><?=$game->home_name?> 승리</p><p class='bold green'><?=$game->away_name?> <?=$rheb[0]?> : <?=$rheb[4]?> <?=$game->home_name?></p><p class='bold green'>경기 종료</p><br>";
					
					message_send_gameset(message);
				}else if(parseInt($("#inning1").val())>=10 && $("#inning2").val()=="0" && <?=intval($rheb[0])?> > <?=intval($rheb[4])?>){
					$("#inning1").val($("#inning1").val()*1-1);
					message="<p class='bold red'><?=$game->away_name?> 승리</p><p class='bold green'><?=$game->away_name?> <?=$rheb[0]?> : <?=$rheb[4]?> <?=$game->home_name?></p><p class='bold green'>경기 종료</p><br>";
					
					message_send_gameset(message);
				}else if($("#inning1").val()=="13" && $("#inning2").val()=="0" && <?=intval($rheb[0])?>==<?=intval($rheb[4])?>){
					$("#inning1").val('12');
					message="<p class='bold red'>무승부</p><p class='bold green'><?=$game->away_name?> <?=$rheb[0]?> : <?=$rheb[4]?> <?=$game->home_name?></p><p class='bold green'>경기 종료</p><br>";
					
					message_send_gameset(message);
				}
			}
        }
	});
}
function get_cookie(_kindof){
	var result="";
	$.ajax({
		type:'POST',
		url:'/baseball/get_cookie_ajax/'+_kindof,
        success:function(data){
        	result=data;
		},
		complete:function(){
			pitching_num=result;
		}
	});
}

function get_game_rule(){
	var rule_="";
	var _command=$("#batter_action").val();

	$.ajax({
		type:'POST',
		url:'/baseball/get_game_rule_ajax',
		data:{command:_command},
		success:function(data){
			rule_ = data;
		},
		complete:function(){
			if(rule_=="null") alert("없는 명령어 조합입니다.");
			else send_(rule_);
		}
	});
}

function player_change(){
<?php
	$home='"';
	$away='"';
	for($i=0; $i<9; $i++){
		$home.=$away_line[$i]->name.';';
		$away.=$home_line[$i]->name.';';
	}
	$home.=$home_line[9]->name.'"';
	$away.=$away_line[9]->name.'"';
?>
	var away=<?=$home?>;
	var home=<?=$away?>;

	var url="";
	var mode=(game_start=="Y")? "edit" : "set";
	if(mode=="edit"){
		var inning=$("#inning1").val()+";"+$("#inning2").val();
		var pitcher_name=($("#inning2").val()=="0")?$("#batter202").val():$("#batter102").val();
		var half=($("#inning2").val()==0)? 'away' : 'home';
		var half_num=($("#inning2").val()==0)? 1 : 2;
		var half_reverse=($("#inning2").val()!=0)? 'away' : 'home';
		var half_num_reverse=($("#inning2").val()==0)? 2 : 1;
		var pitch=($("#inning2").val()==0)? <?=$pitch[0];?> : <?=$pitch[1];?>;
		var so=($("#inning2").val()==0)? <?=$so[0];?> : <?=$so[1];?>;
		var defenders="";
		for(var z=1; z<10; z++){
			defenders=defenders+$("#batter"+half_num_reverse+z+"3").val()+"_"+$("#batter"+half_num_reverse+z+"2").val()+";";
		}
		
		url="?mode="+mode+'&inning='+inning+'&batter_no='+$("#batter").val()+'&half='+half_num;
		url=url+'&'+half+'_batter_no='+$("#taja"+half_num).val();
		url=url+'&'+half+'_fb_runner_no='+$("#runner3").val();
		url=url+'&'+half+'_sb_runner_no='+$("#runner2").val();
		url=url+'&'+half+'_tb_runner_no='+$("#runner1").val();
		url=url+'&'+half_reverse+'_pitcher_no='+$("#pitcher").val();
		url=url+'&pitcher_name='+pitcher_name+'&batter_name='+get_batter_name($("#batter").val())+'&fbr_name='+get_batter_name($("#runner3").val())
			+'&sbr_name='+get_batter_name($("#runner2").val())+'&tbr_name='+get_batter_name($("#runner1").val())+'&pitch='+pitch+'&so='+so
			+"&home="+home+"&away="+away+"&defenders="+defenders;
	}

	location.replace("/baseball/schedule/<?=$date?>/<?=$game->no?>/<?=$inning_?>"+url);
}

function get_runner_name(message){
	if(message=="1루") base_="#runner3";
	else if(message=="2루") base_="#runner2";
	else if(message=="3루") base_="#runner1";
	
	if($("#inning2").val()=="0"){
		if($("#batter111").val()==$(base_).val()) runner_name=message+" "+$("#batter112").val()+" ";
		else if($("#batter121").val()==$(base_).val()) runner_name=message+" "+$("#batter122").val()+" ";
		else if($("#batter131").val()==$(base_).val()) runner_name=message+" "+$("#batter132").val()+" ";
		else if($("#batter141").val()==$(base_).val()) runner_name=message+" "+$("#batter142").val()+" ";
		else if($("#batter151").val()==$(base_).val()) runner_name=message+" "+$("#batter152").val()+" ";
		else if($("#batter161").val()==$(base_).val()) runner_name=message+" "+$("#batter162").val()+" ";
		else if($("#batter171").val()==$(base_).val()) runner_name=message+" "+$("#batter172").val()+" ";
		else if($("#batter181").val()==$(base_).val()) runner_name=message+" "+$("#batter182").val()+" ";
		else if($("#batter191").val()==$(base_).val()) runner_name=message+" "+$("#batter192").val()+" ";
	}else{
		if($("#batter211").val()==$(base_).val()) runner_name=message+" "+$("#batter212").val()+" ";
		else if($("#batter221").val()==$(base_).val()) runner_name=message+" "+$("#batter222").val()+" ";
		else if($("#batter231").val()==$(base_).val()) runner_name=message+" "+$("#batter232").val()+" ";
		else if($("#batter241").val()==$(base_).val()) runner_name=message+" "+$("#batter242").val()+" ";
		else if($("#batter251").val()==$(base_).val()) runner_name=message+" "+$("#batter252").val()+" ";
		else if($("#batter261").val()==$(base_).val()) runner_name=message+" "+$("#batter262").val()+" ";
		else if($("#batter271").val()==$(base_).val()) runner_name=message+" "+$("#batter272").val()+" ";
		else if($("#batter281").val()==$(base_).val()) runner_name=message+" "+$("#batter282").val()+" ";
		else if($("#batter291").val()==$(base_).val()) runner_name=message+" "+$("#batter292").val()+" ";
	}

	if(command_!="") $("#text_comm").html($("#text_comm").html()+"<br/>"+runner_name);
	else $("#text_comm").text(runner_name);
}

function controller_click(message){
	if(juja_num()==0) homerun_word="솔로";
	else if(juja_num()==1) homerun_word="투런";
	else if(juja_num()==2) homerun_word="쓰리런";
	else if(juja_num()==3) homerun_word="만루";
	
	if(game_start=="Y"){
		command_=$("#text_comm").text();
		if($("#ball2").val()=="2" && message=="스트라이크"){
			$("#text_comm").text("삼진 아웃");
			$("#batter_action").val("삼진 아웃");
		}else if($("#ball2").val()=="2" && message=="헛스윙"){
			$("#text_comm").text("헛스윙 삼진 아웃");
			$("#batter_action").val("헛스윙 삼진 아웃");
		}else if($("#ball1").val()=="3" &&(message=="볼")){
			$("#text_comm").text("볼넷 1루 출루");
			$("#batter_action").val("볼넷");
		}else if(message=="사구"){
			$("#text_comm").text("사구 1루 출루");
			$("#batter_action").val("사구");
		}else if(message=="좌홈"){
			$("#text_comm").text("좌월 "+homerun_word+" 홈런");
			$("#batter_action").val("좌월 "+homerun_word+" 홈런");
		}else if(message=="중홈"){
			$("#text_comm").text("중월 "+homerun_word+" 홈런");
			$("#batter_action").val("중월 "+homerun_word+" 홈런");
		}else if(message=="보크"){
			$("#text_comm").text('보크');
			$("#batter_action").val('보크');
		}else if(message=="우홈"){
			$("#text_comm").text("우월 "+homerun_word+" 홈런");
			$("#batter_action").val("우월 "+homerun_word+" 홈런");
		}else if(message=="1루"){
			$("#runner_select").val("1");
			if($("#runner3").val()!="0") get_runner_name(message);
		}else if(message=="2루"){
			$("#runner_select").val("2");
			if($("#runner2").val()!="0") get_runner_name(message);
		}else if(message=="3루"){
			$("#runner_select").val("3");
			if($("#runner1").val()!="0") get_runner_name(message);
		}else if(message=="도루 진루"){
			if($("#runner_select").val()!=""){
				if(runner_name.indexOf("3루")!=-1){
					$("#text_comm").html($("#text_comm").html()+"홈 스틸");
					runner_action="홈 스틸";
					$("#runner3_action").val("홈 스틸");
				}else{
					runner_action=message;
					$("#text_comm").html($("#text_comm").html()+message);
					if($("#runner_select").val()=="1") $("#runner1_action").val("도루 진루");
					else if($("#runner_select").val()=="2") $("#runner2_action").val("도루 진루");
				}
				
				$("#batter_action").val($("#batter_action").val()+" 주자상황");
			}
		}else if(message=="실책 진루"){
			if($("#runner_select").val()!=""){
				if(runner_name.indexOf("3루")!=-1){
					runner_action="실책으로 홈인";
					$("#text_comm").html($("#text_comm").html()+runner_action);
					$("#runner3_action").val("실책 진루");
				}else{
					runner_action="실책으로 진루";
					$("#text_comm").html($("#text_comm").html()+runner_action);
					if($("#runner_select").val()=="1") $("#runner1_action").val("실책 진루");
					else if($("#runner_select").val()=="2") $("#runner2_action").val("실책 진루");
				}
				
				$("#batter_action").val($("#batter_action").val()+" 주자상황");
			}
		}else if(message=="진루"){
			if($("#runner_select").val()!=""){
				if(command_!=""){
					if($("#runner_select").val()=="1"){
						if($("#runner1_action").val()==""){
							$("#runner1_action").val("진루");
							message="2루 진루 ";
							ex_zz=$("#text_comm").html();
							$("#text_comm").html(ex_zz+message);
						}else if($("#runner1_action").val("진루")){
							$("#runner1_action").val("진루진루");
							message="후 3루 진루";
							ex_zz=$("#text_comm").html();
							$("#text_comm").html(ex_zz+message);
						}
					}else if($("#runner_select").val()=="2"){
						if($("#runner2_action").val()==""){
							$("#runner2_action").val("진루");
							message="3루 진루 ";
							ex_zz=$("#text_comm").html();
							$("#text_comm").html(ex_zz+message);
						}
					}
				}
			}
			
			$("#batter_action").val($("#batter_action").val()+" 주자진루");
		}else if(message=="세이프"){
			$("#taja_out").val("2");
			ex_zz=$("#text_comm").html();
			$("#text_comm").html(ex_zz+"<br/>타자세이프");
			$("#batter_action").val($("#batter_action").val()+" 타자세이프");
			if(ex_zz.indexOf("번트")){
				jinru=0;
				if($("#runner1_action").val()=="진루") jinru++;
				if($("#runner2_action").val()=="진루") jinru++;
				if($("#runner3_action").val()=="홈인") jinru++;
				if(jinru>0){
					ex_zz=$("#text_comm").html();
					$("#text_comm").html(ex_zz);
				}
			}else{
				ex_zz=$("#text_comm").html();
				if($("#runner_out").val()!="0") $("#text_comm").html(ex_zz+"<br/>야수선택");
			}
		}else if(message=="주자아웃"){
			if($("#runner_select").val()!=""){
				ex_zz=$("#text_comm").html();
				$("#text_comm").html(ex_zz+" 아웃");
				if($("#runner_select").val()=="1") $("#runner1_action").val("아웃");
				else if($("#runner_select").val()=="2") $("#runner2_action").val("아웃");
				else $("#runner3_action").val("아웃");
				runner_out = $("#runner_out").val();
				$("#runner_out").val(parseInt(runner_out)+1);
	
				$("#batter_action").val($("#batter_action").val()+" 주자아웃");
			}
		}else if(message=="타자아웃"){
			ex_zz=$("#text_comm").html();
			$("#text_comm").html(ex_zz+"<br/>타자 아웃");
			$("#taja_out").val("1");
			
			$("#batter_action").val($("#batter_action").val()+" 타자아웃");
		}else if(message=="견제사" || message=="주루사"){
			if($("#runner_select").val()!=""){
				ex_zz=$("#text_comm").html();
				$("#text_comm").html(ex_zz+" "+message);
				if($("#runner_select").val()=="1") $("#runner1_action").val(message);
				else if($("#runner_select").val()=="2") $("#runner2_action").val(message);
				else $("#runner3_action").val(message);
				runner_out = $("#runner_out").val();
				$("#runner_out").val(parseInt(runner_out)+1);
			}
			
			$("#batter_action").val($("#batter_action").val()+" 주자상황");
		}else if(message=="홈인"){
			if($("#runner_select").val()!=""){
				ex_zz=$("#text_comm").html();
				$("#text_comm").html(ex_zz+" "+message);
				if($("#runner_select").val()=="1") $("#runner1_action").val(message);
				else if($("#runner_select").val()=="2") $("#runner2_action").val(message);
				else $("#runner3_action").val(message);

				$("#batter_action").val($("#batter_action").val()+" 주자진루");
			}
		}else{
			$("#text_comm").text(message);
			$("#batter_action").val(message);
		}
	}
}

function send_(rule_){
	if(game_start=="Y"){
		var batter_message="";
		var runner_message="";
		var final_message="";
		var half=($("#inning2").val()=="0") ? 2 : 1;
		var half_=($("#inning2").val()=="0") ? 1 : 2;
		var object_=rule_.split(";");

		/!* p:피칭카운트+1 *!/
		if(object_[0]=="p") $("#pitch"+half).val(parseInt($("#pitch"+half).val())+1);
		/!* so:삼진카운트+1 *!/
		if(object_[1]=="so") $("#so"+half).val(parseInt($("#so"+half).val())+1);
		/!* b0:볼카운트 리셋, b1:볼카운트+1 *!/
		if(object_[2]=="b0") $("#ball1").val(0); else if(object_[2]=="b1") $("#ball1").val(parseInt($("#ball1").val())+1);
		/!* s0:스트라이크카운트 리셋, s1:스트라이크카운트+1 *!/
		if(object_[3]=="s0") $("#ball2").val(0); else if(object_[3]=="s1" && $("#ball2").val()!="2") $("#ball2").val(parseInt($("#ball2").val())+1);
		/!* o0:아웃카운트 리셋, o1:아웃카운트+1 *!/
		if(object_[4]=="o0") $("#ball3").val(0); else if(object_[4]=="o1") $("#ball3").val(parseInt($("#ball3").val())+1);

		/!* 3루 주자 *!/
		if($("#runner3_action").val()!="") runner_message=runner_(1, $("#runner3_action").val())+runner_message;
		/!* 2루 주자 *!/
		if($("#runner2_action").val()!="") runner_message=runner_(2, $("#runner2_action").val())+runner_message;
		/!* 1루 주자 *!/
		if($("#runner1_action").val()!="") runner_message=runner_(3, $("#runner1_action").val())+runner_message;

		/!* bo1:타자 1루 진루, bo2:타자 2루 진루, bo3:타자 3루 진루 *!/
		if(object_[5]=="bo1") $("#runner3").val($("#taja"+half_).val());
		else if(object_[5]=="bo2") $("#runner2").val($("#taja"+half_).val());
		else if(object_[5]=="bo3") $("#runner1").val($("#taja"+half_).val());

		/!* bc:타자 체인지 *!/
		if(object_[6]=="bc" && $("#ball3").val()!="3"){
			taja_change_stat();
			batter_message=taja_change_message();
		}else if(object_[6]=="bc" && $("#ball3").val()=="3") taja_change_stat();
		else batter_message="";

		/!* r:점수 *!/
		var num=(half==2)? 1:5; if(object_[8]!="") {$("#rheb"+num).val(parseInt($("#rheb"+num).val())+1); $("#now_score").val(parseInt($("#now_score").val())+1);}
		/!* h:안타 *!/
		var num=(half==2)? 2:6; if(object_[9]!="") $("#rheb"+num).val(parseInt($("#rheb"+num).val())+1);
		/!* e:에러 *!/
		var num=(half==2)? 7:3; if(object_[10]!="") $("#rheb"+num).val(parseInt($("#rheb"+num).val())+1);
		/!* b:볼넷 *!/
		var num=(half==2)? 4:8; if(object_[11]!="") $("#rheb"+num).val(parseInt($("#rheb"+num).val())+1);

		/!* 9회 이후 홈팀 끝내기 상황에 타자메시지 안뜨게 하기 위한 if문 *!/
		if(<?=$inning_?>>=9 && $("#inning2").val()=="1" && $("#rheb1").val()*1 < $("#rheb5").val()*1) batter_message="";

		if(object_[14]=="Y") final_message=batter_message+runner_message+object_[12]+pitching_num+"구 "+object_[13];
		else final_message=batter_message+runner_message+object_[12]+object_[13];

		/!* (sm:스텟메시지&중계메시지 or rm:주자메시지) *!/
		if(object_[7]=="sm") {
			if(object_[15]=="Y") set_cookie("pitching_num", 1, false);
			else if(object_[15]=="B") ;
			else set_cookie("pitching_num", pitching_num*1+1, false);

			message_send(final_message);
		}else if(object_[7]=="rm") message_send(runner_message);
	}
}

function runner_(num, action){
	var batter_name=get_batter_name($("#runner"+num).val());
	var half=($("#inning2").val()=="0") ? 2 : 1;
	var r=(half==2) ? 1 : 5;
	var messaging="";
	var action_message="";
	if(num==3) base=1; else if(num==1) base=3; else base=2;
	var num_=(half==2) ? 7 : 3;

	if(base==1 && action=="진루진루"){
		action_message=(base+2)+"루 진루";
		$("#runner"+(num-2)).val($("#runner"+(num)).val());
	}else if(action=="진루진루"){
		action_message="홈인";
		$("#runner"+(num-2)).val($("#runner"+(num)).val());
	}else if(action=="견제사"){
		action_message="견제 아웃";
		$("#ball3").val(parseInt($("#ball3").val())+1);
		if($("#ball3").val()==3) set_cookie("pitching_num", 1, false);
	}else if(base==3 && action=="주루사"){
		action_message="홈에서 주루 아웃";
		$("#ball3").val(parseInt($("#ball3").val())+1);
		if($("#ball3").val()==3) set_cookie("pitching_num", 1, false);
	}else if(action=="주루사"){
		action_message=(base+1)+"루에서 주루 아웃";
		$("#ball3").val(parseInt($("#ball3").val())+1);
		if($("#ball3").val()==3) set_cookie("pitching_num", 1, false);
	}else if(action=="아웃"){
		action_message=action;
		$("#ball3").val(parseInt($("#ball3").val())+1);
		if($("#ball3").val()==3) set_cookie("pitching_num", 1, false);
	}else if(action=="진루"){
		action_message=(base+1)+"루 진루";
		$("#runner"+(num-1)).val($("#runner"+num).val());
	}else if(base!=3 && action=="도루 진루"){
		action_message=(base+1)+"루 도루";
		$("#runner"+(num-1)).val($("#runner"+num).val());
	}else if(base==3 && action=="실책 진루"){
		action_message="실책으로  홈인";
		$("#rheb"+r).val(parseInt($("#rheb"+r).val())+1);
		$("#rheb"+num_).val(parseInt($("#rheb"+num_).val())+1);
		$("#now_score").val(parseInt($("#now_score").val())+1);
	}else if(base!=3 && action=="실책 진루"){
		action_message="실책으로 "+(base+1)+"루  진루";
		$("#rheb"+num_).val(parseInt($("#rheb"+num_).val())+1);
		$("#runner"+(num-1)).val($("#runner"+num).val());
	}else if(action=="홈인" || action=="홈 스틸"){
		action_message=action;
		$("#rheb"+r).val(parseInt($("#rheb"+r).val())+1); 
		$("#now_score").val(parseInt($("#now_score").val())+1);
	}else action_message=(base+1)+"루 진루";

	$("#runner"+num).val(0);
	return "<p class='red'>"+base+"루 주자 "+batter_name+" "+action_message+"</p>";
}

function get_batter_name(position){
	if($("#inning2").val()=="0"){
		for(var ii=1; ii<10; ii++){
			if($("#batter1"+ii+"1").val()==position) return $("#batter1"+ii+"2").val();
		}
	}else{
		for(var jj=1; jj<10; jj++){
			if($("#batter2"+jj+"1").val()==position) return $("#batter2"+jj+"2").val();
		}
	}
}

function juja_num(){
	ex_juja=0;
	if($("#runner1").val()!="0") ex_juja++;
	if($("#runner2").val()!="0") ex_juja++;
	if($("#runner3").val()!="0") ex_juja++;

	return ex_juja;
}
	
function change_inning(){
	too="";
	ta="";
	message="";
	$("#ball2").val(0);
	$("#ball1").val(0);
	$("#ball3").val(0);
	$("#runner1").val("0");
	$("#runner2").val("0");
	$("#runner3").val("0");

	if($("#inning2").val()=="0"){
		$("#inning2").val("1");

		if($("#batter211").val()==$("#taja2").val()){
			$("#batter").val($("#batter211").val());
			ta=$("#batter212").val();
		}else if($("#batter221").val()==$("#taja2").val()){
			$("#batter").val($("#batter221").val());
			ta=$("#batter222").val();
		}else if($("#batter231").val()==$("#taja2").val()){
			$("#batter").val($("#batter231").val());
			ta=$("#batter232").val();
		}else if($("#batter241").val()==$("#taja2").val()){
			$("#batter").val($("#batter241").val());
			ta=$("#batter242").val();
		}else if($("#batter251").val()==$("#taja2").val()){
			$("#batter").val($("#batter251").val());
			ta=$("#batter252").val();
		}else if($("#batter261").val()==$("#taja2").val()){
			$("#batter").val($("#batter261").val());
			ta=$("#batter262").val();
		}else if($("#batter271").val()==$("#taja2").val()){
			$("#batter").val($("#batter271").val());
			ta=$("#batter272").val();
		}else if($("#batter281").val()==$("#taja2").val()){
			$("#batter").val($("#batter281").val());
			ta=$("#batter282").val();
		}else if($("#batter291").val()==$("#taja2").val()){
			$("#batter").val($("#batter291").val());
			ta=$("#batter292").val();
		}
		
		$("#pitcher").val($("#batter101").val());
		too=$("#batter102").val()
		
		message="<p class='bold green'>"+$("#inning1").val()+"회말 "+$("#home_name").val()+" 공격</p><br/><br/>"+message;
		message="<p class='bold green'>"+$("#away_name").val()+" "+"투수 "+too+"</p><br/>"+message;
		message="<p class='blue'>"+$("#home_name").val()+" "+$("#taja2").val()+"번 타자 "+ta+"</p><br/>"+message;
	}else{
		$("#inning2").val("0");
		
		if($("#batter111").val()==$("#taja1").val()){
			$("#batter").val($("#batter111").val());
			ta=$("#batter112").val();
		}else if($("#batter121").val()==$("#taja1").val()){
			$("#batter").val($("#batter121").val());
			ta=$("#batter122").val();
		}else if($("#batter131").val()==$("#taja1").val()){
			$("#batter").val($("#batter131").val());
			ta=$("#batter132").val();
		}else if($("#batter141").val()==$("#taja1").val()){
			$("#batter").val($("#batter141").val());
			ta=$("#batter142").val();
		}else if($("#batter151").val()==$("#taja1").val()){
			$("#batter").val($("#batter151").val());
			ta=$("#batter152").val();
		}else if($("#batter161").val()==$("#taja1").val()){
			$("#batter").val($("#batter161").val());
			ta=$("#batter162").val();
		}else if($("#batter171").val()==$("#taja1").val()){
			$("#batter").val($("#batter171").val());
			ta=$("#batter172").val();
		}else if($("#batter181").val()==$("#taja1").val()){
			$("#batter").val($("#batter181").val());
			ta=$("#batter182").val();
		}else if($("#batter191").val()==$("#taja1").val()){
			$("#batter").val($("#batter191").val());
			ta=$("#batter192").val();
		}
		$("#pitcher").val($("#batter201").val());
		too=$("#batter202").val()
		inning=parseInt($("#inning1").val());

		$("#inning1").val(inning+1);
		message="<p class='bold green'>"+$("#inning1").val()+"회초 "+$("#away_name").val()+" 공격</p><br/><br/>"+message;
		message="<p class='bold green'>"+$("#home_name").val()+" "+"투수 "+too+"</p><br/>"+message;
		message="<p class='blue'>"+$("#away_name").val()+" "+$("#taja1").val()+"번 타자 "+ta+"</p><br/>"+message;
	}
	
	/* 일반 종료 */
	if($("#inning1").val()=="9" && $("#inning2").val()=="1" && <?=intval($rheb[0])?> < <?=intval($rheb[4])?>) set_cookie("during_game", "N", true);
	else if(parseInt($("#inning1").val())>=10 && $("#inning2").val()=="0" && <?=intval($rheb[0])?> > <?=intval($rheb[4])?>) set_cookie("during_game", "N", true);
	else if($("#inning1").val()=="13" && $("#inning2").val()=="0" && <?=intval($rheb[0])?>==<?=intval($rheb[4])?>) set_cookie("during_game", "N", true);
	else message_send(message);
}

function taja_change_message(){
	name="";

	if($("#inning2").val()=="0"){
		if($("#taja1").val()=="1") name=$("#batter112").val();
		else if($("#taja1").val()=="2") name=$("#batter122").val();
		else if($("#taja1").val()=="3") name=$("#batter132").val();
		else if($("#taja1").val()=="4") name=$("#batter142").val();
		else if($("#taja1").val()=="5") name=$("#batter152").val();
		else if($("#taja1").val()=="6") name=$("#batter162").val();
		else if($("#taja1").val()=="7") name=$("#batter172").val();
		else if($("#taja1").val()=="8") name=$("#batter182").val();
		else name=$("#batter192").val();
		message="<p class='blue'>"+$("#away_name").val()+" "+$("#taja1").val()+"번 타자 "+name+"</p><br/>";
	}else{
		if($("#taja2").val()=="1") name=$("#batter212").val();
		else if($("#taja2").val()=="2") name=$("#batter222").val();
		else if($("#taja2").val()=="3") name=$("#batter232").val();
		else if($("#taja2").val()=="4") name=$("#batter242").val();
		else if($("#taja2").val()=="5") name=$("#batter252").val();
		else if($("#taja2").val()=="6") name=$("#batter262").val();
		else if($("#taja2").val()=="7") name=$("#batter272").val();
		else if($("#taja2").val()=="8") name=$("#batter282").val();
		else name=$("#batter292").val();
		message="<p class='blue'>"+$("#home_name").val()+" "+$("#taja2").val()+"번 타자 "+name+"</p><br/>";
	}
	
	return message;
}

function taja_change_stat(){
	if($("#inning2").val()=="0"){
		if($("#taja1").val()=="1"){
			$("#taja1").val("2");
			$("#batter").val($("#batter121").val());
		}else if($("#taja1").val()=="2"){
			$("#taja1").val("3");
			$("#batter").val($("#batter131").val());
		}else if($("#taja1").val()=="3"){
			$("#taja1").val("4");
			$("#batter").val($("#batter141").val());
		}else if($("#taja1").val()=="4"){
			$("#taja1").val("5");
			$("#batter").val($("#batter151").val());
		}else if($("#taja1").val()=="5"){
			$("#taja1").val("6");
			$("#batter").val($("#batter161").val());
		}else if($("#taja1").val()=="6"){
			$("#taja1").val("7");
			$("#batter").val($("#batter171").val());
		}else if($("#taja1").val()=="7"){
			$("#taja1").val("8");
			$("#batter").val($("#batter181").val());
		}else if($("#taja1").val()=="8"){
			$("#taja1").val("9");
			$("#batter").val($("#batter191").val());
		}else{
			$("#taja1").val("1");
			$("#batter").val($("#batter111").val());
		}
	}else{
		if($("#taja2").val()=="1"){
			$("#taja2").val("2");
			$("#batter").val($("#batter221").val());
		}else if($("#taja2").val()=="2"){
			$("#taja2").val("3");
			$("#batter").val($("#batter231").val());
		}else if($("#taja2").val()=="3"){
			$("#taja2").val("4");
			$("#batter").val($("#batter241").val());
		}else if($("#taja2").val()=="4"){
			$("#taja2").val("5");
			$("#batter").val($("#batter251").val());
		}else if($("#taja2").val()=="5"){
			$("#taja2").val("6");
			$("#batter").val($("#batter261").val());
		}else if($("#taja2").val()=="6"){
			$("#taja2").val("7");
			$("#batter").val($("#batter271").val());
		}else if($("#taja2").val()=="7"){
			$("#taja2").val("8");
			$("#batter").val($("#batter281").val());
		}else if($("#taja2").val()=="8"){
			$("#taja2").val("9");
			$("#batter").val($("#batter291").val());
		}else{
			$("#taja2").val("1");
			$("#batter").val($("#batter211").val());
		}
	}
}

function on_key_down() {
    var keycode = event.keyCode;
    if(keycode==83) controller_click('스트라이크');
    else if(keycode==87) controller_click('헛스윙');
    else if(keycode==69) controller_click('낫아웃');
    else if(keycode==65) controller_click('볼');
    else if(keycode==68) controller_click('파울');
    else if(keycode==81) controller_click('사구');
    else if(keycode==90) controller_click('세이프');
    else if(keycode==88) controller_click('타자아웃');
    else if(keycode==82) controller_click('보크');
    else if(keycode==51) controller_click('3루');
    else if(keycode==50) controller_click('2루');
    else if(keycode==49) controller_click('1루');
    else if(keycode==32) get_game_rule();
    else if(keycode==27) message_cancel();
}

function send_ratchet(){
    var id='<?=$game->no;?>';
    var inning='<?=$inning[0]?>';
    var pitcher=($("#inning2").val()=="0")? '<?=$home_line[9]->name;?>':'<?=$away_line[9]->name;?>';
    var p=($("#inning2").val()=="0")? '<?=$pitch[1];?>':'<?=$pitch[0];?>';
    var hitter=get_batter_name($("#batter").val());
    var fb='<?=$runner[2];?>';
    var sb='<?=$runner[1];?>';
    var tb='<?=$runner[0];?>';
    var bso_b='<?=$ball[0];?>';
    var bso_s='<?=$ball[1];?>';
    var bso_o='<?=$ball[2];?>';
    var away_r='<?=$rheb[0];?>';
    var away_h='<?=$rheb[1];?>';
    var away_e='<?=$rheb[2];?>';
    var away_b='<?=$rheb[3];?>';
    var home_r='<?=$rheb[4];?>';
    var home_h='<?=$rheb[5];?>';
    var home_e='<?=$rheb[6];?>';
    var home_b='<?=$rheb[7];?>';
    var score='<?=$game_score->score;?>';
    var json={'id':id,'inning':inning,'pitcher':pitcher,'p':p,'hitter':hitter,'fb':fb,'sb':sb,'tb':tb,'bso_b':bso_b,'bso_s':bso_s,'bso_o':bso_o,'away_r':away_r,'away_h':away_h,'away_e':away_e,'away_b':away_b,'home_r':home_r,'home_h':home_h,'home_e':home_e,'home_b':home_b,'score':score};

    conn.send(JSON.stringify(json));
}
</script>
</html>