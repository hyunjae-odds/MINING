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
$team_arr=array('SK', 'KT', '삼성', 'NC', '두산', '넥센', 'LG', '한화', '롯데', 'KIA');
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
<title> ODDS CONNECT - DataMining </title>
<link href="/public/lib/base1.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="stat_data" id="stat_data">
	<input type="hidden" id="home" name="home" value="<?=$game->home_no?>">
	<input type="hidden" id="away" name="away" value="<?=$game->away_no?>">
	<input type="hidden" id="away_name" name="away_name" value="<?=$game->away_name?>">
	<input type="hidden" id="home_name" name="home_name" value="<?=$game->home_name?>">
	<input type="hidden" id="game_no" name="game_no" value="<?=$game->no;?>" style="width:50px;">
	<input type="hidden" id="inning1" name="inning1" value="<?=$inning[0]?>">
	<input type="hidden" id="inning2" name="inning2" value="<?=$inning[1]?>">
	<input type="hidden" id="pitcher" name="pitcher" value="<?=$game_data->pitcher;?>">
	<input type="hidden" id="start_" name="start_" value="<?=$rows_?>">
	<input type="hidden" id="message_" name="message_" value="<?=$message;?>">
	<input type="hidden" id="team_num" value="">

	<div class="wrap">
		<div class="input">
			<div class="date">
				<p></p>
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
					<td><span>투구수<input type="text" name="pitch1" value="<?=$pitch[0];?>" size="1"></span></td>
					<td><span>삼진<input type="text" name="so1" value="<?=$so[0];?>" size="1"></span></td>
					<?php 
						for($i=0; $i<count($score); $i=$i+2){
							if($score[$i]=="") echo "<td><input type='hidden' id='score_".$i."' value=''></td>";
							else if($score[$i+1]=="") echo "<td><input type='text' id='score_".$i."' name='now_score' value='".$score[$i]."' size='1'></td>";
							else echo "<td><input type='text' id='score_".$i."' value='".$score[$i]."' size='1'> </td>";
						}
					?>
					<td><input type="text" name="rheb1" value="<?=$rheb[0];?>" size="1"></td>
					<td><input type="text" name="rheb2" value="<?=$rheb[1];?>" size="1"></td>
					<td><input type="text" name="rheb3" value="<?=$rheb[2];?>" size="1"></td>
					<td><input type="text" name="rheb4" value="<?=$rheb[3];?>" size="1"></td>
				</tr>
				<tr>
					<td><?=$game->home_name;?></td>
					<td><?=$home_line[9]->name;?></td>
					<td><span>투구수<input type="text" name="pitch2" value="<?=$pitch[1];?>" size="1"></span></td>
					<td><span>삼진<input type="text" name="so2" value="<?=$so[1];?>" size="1"></span></td>
					<?php 
						for($i=1;$i<count($score);$i=$i+2){
							if($score[$i]=="") echo "<td><input type='hidden' id='score_".$i."' value=''></td>";
							else if($i==23 || $score[$i+1]=="") echo "<td><input type='text' id='score_".$i."' name='now_score' value='".$score[$i]."' size='1'></td>";
							else echo "<td><input type='text' id='score_".$i."' value='".$score[$i]."' size='1'> </td>";
						}
					?>
					<td><input type="text" name="rheb5" value="<?=$rheb[4];?>" size="1"></td>
					<td><input type="text" name="rheb6" value="<?=$rheb[5];?>" size="1"></td>
					<td><input type="text" name="rheb7" value="<?=$rheb[6];?>" size="1"></td>
					<td><input type="text" name="rheb8" value="<?=$rheb[7];?>" size="1"></td>
				</tr>
			</table>
			<div class="game">
				<div class="ground" style="padding: 5px 0px 0px 5px;">
					<div>
						<div>
							<table style="margin-left:1%; float:left; width:49%;">
								<tr style="background-color:#BDBDBD;"><td colspan="3"><?=$game->home_name;?></td></tr>
								<tr><td>타순</td><td>이름</td><td>포지션</td></tr>
								<?php foreach($home_line as $key=>$entry){ ?>
									<input type="hidden" id="home_player_<?=$key?>" value="<?=$entry->player?>">
									<tr>
										<td style="width:30px;" id="home_tasun_<?=$key?>"><?=$entry->position?></td>
										<td style="width:110px;"><span><?=$entry->name?></span></td>
										<td style="width:30px;"><?=$entry->subi?></td>
									</tr>
								<?php } ?>
							</table>
							<table style="float:left; width:49%;">
								<tr style="background-color:#BDBDBD;"><td colspan="3"><?=$game->away_name;?></td></tr>
								<tr><td>타순</td><td>이름</td><td>포지션</td></tr>
								<?php foreach($away_line as $key=>$entry){ ?>
									<input type="hidden" id="away_player_<?=$key?>" value="<?=$entry->player?>">
									<tr>
										<td style="width:30px;" id="away_tasun_<?=$key?>"><?=$entry->position?></td>
										<td style="width:110px;"><span><?=$entry->name?></span></td>
										<td style="width:30px;"><?=$entry->subi?></td>
									</tr>
								<?php } ?>
							</table>
							
							<div>
								현재타자 : <input type="text" name="batter" id="batter" value="<?=$game_data->batter;?>" size="1">
								원정타자 : <input type="text" name="taja1" value="<?=$taja[0]?>" size="1">
								홈타자 : <input type="text" name="taja2" value="<?=$taja[1]?>" size="1"><br>
								1루주자 : <input type="text" name="runner3" value="<?=$runner[2];?>" size="1">
								2루주자 : <input type="text" name="runner2" value="<?=$runner[1];?>" size="1">
								3루주자 : <input type="text" name="runner1" value="<?=$runner[0];?>" size="1"><br>
								투구번호 수동 입력 : <input type="text" id="pitching_num" value="" size="1">&nbsp;<button type="button" onclick="set_cookie('pitching_num', 0, true)">변경</button><br>
								게임시작/끝 수동 입력 : <select id="during_game">
                                                        <option value="Y" <?php if($during_game=='Y') echo 'selected'?>>on</option>
                                                        <option value="N" <?php if($during_game=='N') echo 'selected'?>>off</option>
                                                        <option value="" <?php if($during_game=='') echo 'selected'?>>미설정</option>
                                                    </select>
												<button type="button" onclick="set_cookie('during_game', '', true)">저장</button><br>
                                경기상태 : <select id="status">
                                          <option value="live" <?php if($status=='live') echo 'selected';?>>경기중</option>
                                          <option value="rain" <?php if($status=='rain') echo 'selected';?>>우천취소</option>
                                          <option value="set" <?php if($status=='set') echo 'selected';?>>경기종료</option>
                                          <option value="ready" <?php if($status=='ready') echo 'selected';?>>경기전</option>
                                      </select>
                                <button type="button" onclick="update_status_ajax(<?=$game_no;?>, $('#status option:selected').val());">저장</button>
							</div>
						</div>
					</div>
					<ul class="gr_view"></ul>
				</div>
				<div class="view">
					<ul class="st">
						<?php for ($i=1; $i<=9; $i++){ ?>
							<li <?php if($inning_==$i) echo "class='on'";?> id="inning_<?=$i;?>">
								<a href="/edit_mode/main/<?=$date;?>/<?=$game_no;?>/<?=$i;?>"><?=$i;?>회</a>
							</li>
						<?php } ?>
						<li <?php if($inning[0]>9) echo "class='on'";?> id="inning_10"><a href="javascript:void(0)">연장</a></li>
					</ul>
					
					<textarea class="window" id="chating" name="chating" cols="39"></textarea>
					
					<ul class="BSO">
						<li>
							<b>B</b>
							<select name="ball1">
								<option value="0" <?php if($ball[0]=='0') echo 'selected'?>>0</option>
								<option value="1" <?php if($ball[0]=='1') echo 'selected'?>>1</option>
								<option value="2" <?php if($ball[0]=='2') echo 'selected'?>>2</option>
								<option value="3" <?php if($ball[0]=='3') echo 'selected'?>>3</option>
							</select>
						</li>
						<li>
							<b>S</b>
							<select name="ball2">
								<option value="0" <?php if($ball[1]=='0') echo 'selected'?>>0</option>
								<option value="1" <?php if($ball[1]=='1') echo 'selected'?>>1</option>
								<option value="2" <?php if($ball[1]=='2') echo 'selected'?>>2</option>
							</select>
						</li>
						<li>
							<b>O</b>
							<select name="ball3">
								<option value="0" <?php if($ball[2]=='0') echo 'selected'?>>0</option>
								<option value="1" <?php if($ball[2]=='1') echo 'selected'?>>1</option>
								<option value="2" <?php if($ball[2]=='2') echo 'selected'?>>2</option>
							</select>
						</li>
					</ul>
					<p class="btn"><a href="javascript:update_game_score_ajax()">&nbsp;전광판 및 볼카운트 저장&nbsp;&nbsp;</a></p>
					<p class="btn"><a href="javascript:delete_message()">메세지<br/>저장</a></p>
					<span class="clear"></span>
				</div>
			</div>
		</div>
		<div class="click">
			<div class="command" style="height: 20px;">
				<span>팀 선택 : </span>
				<select onchange="get_player_list(this.value)">
					<option value="0">------</option>
					<option value="1">SK</option>
					<option value="2">KT</option>
					<option value="3">삼성</option>
					<option value="4">NC</option>
					<option value="5">두산</option>
					<option value="6">넥센</option>
					<option value="7">LG</option>
					<option value="8">한화</option>
					<option value="9">롯데</option>
					<option value="10">KIA</option>
				</select>
			</div>
			
			<div class="gbox" id="player_list" style="overflow:auto; height: 400px;"></div>
			
			<!-- 선수 관리 -->
			<div class="gbox PB">
				소속 : <select id="players_team_no">
						<option value="1">SK</option>
						<option value="2">KT</option>
						<option value="3">삼성</option>
						<option value="4">NC</option>
						<option value="5">두산</option>
						<option value="6">넥센</option>
						<option value="7">LG</option>
						<option value="8">한화</option>
						<option value="9">롯데</option>
						<option value="10">KIA</option>
					 </select>
				포지션 : <select id="players_position">
						<option value="투수">투수</option>
						<option value="내야수">내야수</option>
						<option value="외야수">외야수</option>
						<option value="포수">포수</option>
					</select>
				<!-- 선수 추가 -->
	 			이름 : <input type="text" id="players_name" size="5">
				등번호 : <input type="text"  id="players_back_num" size="5"><br>
				player_id : <input type="text"  id="player_id" size="5">
				<button type="button" onclick="insert_players()">추가</button>
			</div>
			
			<!-- 경기장 관리 -->
			<div class="gbox PB" style="overflow:auto; height: 140px;">
				<?php foreach($stadium as $key=>$entry){ ?>
					<span id="stadium_num_<?=$entry->no?>" style='display:inline-block;width:20px;'><?=$key+1?></span>
					<span><?=$entry->name?></span>
					<!-- <input type="text" id="stadium_name_<?=$entry->no?>" value="<?=$entry->name?>" size="5"> -->
					<!-- <button type="button" onclick="delete_stadium(<?=$entry->no?>)">삭제</button> -->
					<!-- <button type="button" onclick="update_stadium(<?=$entry->no?>)">저장</button> --><br>
				<?php } ?>
				<br><hr style="display: block !important; margin-right: 7px;"/><br>
				<!-- 경기장 추가 -->
				경기장<input type="text" id="stadium_name" size="13">
				<button type="button" onclick="insert_stadium()">추가</button>
			</div>
			
			<!-- 스케쥴 관리 -->
			<div class="gbox PB" style="overflow:auto; height: 194px;">
				<div>
					날짜 선택<input type="date" id="schedule_date" size="13" value="<?=$date?>">
					<button type="button" onclick="javascript:location.href=('/edit_mode/main/'+$('#schedule_date').val()+'/<?=$game_no?>/<?=$inning_?>');">확인</button>
				</div>
				
				<br><hr style="display: block !important; margin-right: 7px;"/><br>
				<?php if($schedule==null) { ?>
					<span>등록 된 경기가 없습니다.</span><br>
				<?php } ?>
				
				<?php foreach($schedule as $key=>$entry){ ?>
					<span id="stadium_num_<?=$entry->no?>" style='display:inline-block;width:20px;'><?=$key+1?></span>
					<input type="text" id="schedule_gametime_<?=$entry->no?>" value="<?=$entry->game_time?>" size="13">
					<span>원정</span>
					<select id="schedule_awayname_<?=$entry->no?>">
						<?php foreach($team_arr as $key=>$entries){ ?>
							<option <?php if($entries==$entry->away_name) echo 'selected'?> value="<?=$key+1?>"><?=$entries?></option>
						<?php } ?>
					</select>
					<span>홈</span>
					<select id="schedule_homename_<?=$entry->no?>">
						<?php foreach($team_arr as $key=>$entries){ ?>
							<option <?php if($entries==$entry->home_name) echo 'selected'?> value="<?=$key+1?>"><?=$entries?></option>
						<?php } ?>
					</select>
					<span>경기장</span>
					<select id="schedule_stadium_<?=$entry->no?>">
					<?php foreach($stadium as $entries){ ?>
						<option value="<?=$entries->no?>" <?php if($entry->name==$entries->name) echo 'selected'?>><?=$entries->name?></option>
					<?php } ?>
					</select>
					<button type="button" onclick="delete_schedule(<?=$entry->no?>)">삭제</button>
					<button type="button" onclick="update_schedule(<?=$entry->no?>)">저장</button><br>
				<?php } ?>
					<br><hr style="display: block !important; margin-right: 7px;"/><br>
					<!-- 스케쥴 추가 -->
					<span>날짜</span>
					<input type="datetime-local" id="schedule_gametime" size="13">
					<span>원정</span>
					<select id="schedule_away">
						<option id="away_value_0" value="0">------</option>
					<?php for($i=1; $i<11; $i++){ ?>
						<option id="away_value_<?=$i?>" value="<?=$i?>"><?=$team_arr[$i-1]?></option>
					<?php } ?>
					</select>
					<span>홈</span>
					<select id="schedule_home">
						<option id="home_value_0" value="0">------</option>
					<?php for($i=1; $i<11; $i++){ ?>
						<option id="home_value_<?=$i?>" value="<?=$i?>"><?=$team_arr[$i-1]?></option>
					<?php } ?>
					</select>
					<select id="schedule_stadium">
						<?php foreach($stadium as $entry){ ?>
							<option value="<?=$entry->no?>"><?=$entry->name?></option>
						<?php } ?>
					</select>
					<button type="button" onclick="insert_schedule()">추가</button>
			</div>
		</div>
	</div>
</form>
<div style="position:absolute; right:180px; bottom:40px;">
	<a href="/baseball/game/<?=$date?>/<?=$game_no?>/<?=$inning_?>">Copyright ⓒ ODDS CONNECT Corp. All Rights Reserved.</a>
</div>
</body>

<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
var game_start="<?=$during_game?>";
var pitching_num=0;

$(document).ready(function(){
	get_cookie("pitching_num");

	$("#chating").html("<?=$message;?>");

	for(var i=($("#inning1").val()*1+1); i<=10; i++) {
		$('#inning_'+i).css('background-color', '#BDBDBD');
		if (i==10) $('#inning_'+i+' a').replaceWith('<span style="color:#747474;">연장</span>');
		else $('#inning_'+i+' a').replaceWith('<span style="color:#747474;">'+i+'회</span>');
	}
});

/* CUSTOM FUNCTION */
function ajax_(ajax_url, _data, alert_message, reload_flag){
	$.ajax({
		type:'POST',
		url:ajax_url,
        data: _data,
        complete:function(){
            if(alert_message!="") alert(alert_message);
            if(reload_flag) location.reload();
        }
	});
}

/* 메시지 관리 */
function message_send(){
	var message=$("#chating").val();
	message=message.replace(/\n/g, "");
	var schedule_no=$("#game_no").val();
	var inning="<?=$inning_?>;"+$("#inning2").val();
	var pitcher=$("#pitcher").val();
	var batter=$("#batter").val();
	var data={schedule_no:schedule_no, inning:inning, pitcher:pitcher, batter:batter, message1:message};

	ajax_('/baseball/message_send', data, "저장 되었습니다.", true);
}
function delete_message(){
	var game_no=$("#game_no").val();
	
	$.ajax({
		type:'POST',
		url:'/edit_mode/delete_message/'+game_no+"/<?=$inning_?>",
        complete:function(){
        	message_send();
        }
	});
}

/* 전광판 및 볼카운트 관리 */
function update_game_score_ajax(){
	var score="";
	for(var i=0; i<24; i++){
		if(i!=23) score=score+$('#score_'+i).val()+';';
		else score=score+$('#score_'+i).val();
	}

	$.ajax({
		type:'POST',
		url:'/edit_mode/update_game_score_ajax/'+$("#game_no").val(),
		data:{score:score},
        complete:function(){
        	stats_send();
        }
	});
}
function stats_send(){
	var stats=$("#stat_data").serialize();
	
	ajax_('/baseball/stat', stats, "저장 되었습니다.", true);
}

/* 선수 관리 */
function get_player_list(team_num){
	var player_list="";
	$("#team_num").val(team_num);
	
	$.ajax({
		type:"POST",
		url:"/edit_mode/get_player_order_by_backnum_ajax/"+team_num,
        success:function(data){
        	player_list=data;
        },
    	complete:function(){
    		var player=player_list.split("::");
    		var result="";
    		
    		for(var i = 0; i<player.length-1; i++){
    			player_detail=player[i].split(";");
    			if(player_detail[5]=="Y") player_detail[5]="checked"; else player_detail[5]="";
    			result=result+"<span style='display:inline-block;width:20px;'>"+i+"</span>"+"<input type='checkbox' id='checkbox_"+i+"' "+player_detail[5]+"><input type='hidden' id='no_"+i+"' value='"
    			+player_detail[0]+"'><input type='text' id='position_"+i+"' value='"+player_detail[3]+"' size='5'><input type='text' id='name_"
    			+i+"' value='"+player_detail[2]+"' size='5'><input type='text' id='back_num_"+i+"' value='"+player_detail[1]+"' size='5'>"
				+"<input type='text' id='player_id_"+i+"' value='"+player_detail[4]+"' size='5'><button type='button' onclick='update_players("+i+")'>저장</button><br>";
			}
    		$("#player_list").html(result);
    	}
	});
}
function insert_players(){
	var team_num=$("#players_team_no").val();
	var _position=$("#players_position").val();
	var _name=$("#players_name").val();
	var back_num=$("#players_back_num").val();
	var player_id=$("#player_id").val();
	var data={position:_position, name:_name};

	$.ajax({
		type:'POST',
		url:'/edit_mode/insert_players_ajax/'+team_num+'/'+back_num,
		data:{position:_position, name:_name, player_id:player_id},
		complete:function(){
			get_player_list(team_num);
		}
	});
}
function update_players(num){
	var team_num=$("#team_num").val();
	var player_num=$("#no_"+num).val();
	var _position=$("#position_"+num).val();
	var _name=$("#name_"+num).val();
	var back_num=$("#back_num_"+num).val();
	var player_id=$("#player_id_"+num).val();
	var data={position:_position, name:_name};
	var isChecked=$('#checkbox_'+num).is(':checked');

	$.ajax({
		type:'POST',
		url:'/edit_mode/update_players_ajax/'+player_num+'/'+back_num,
		data:{position:_position, name:_name, player_id:player_id, is_checked:isChecked},
		complete:function(){
			get_player_list(team_num);
		}
	});
}

/* 경기장 관리 */
function insert_stadium(){
	var _name=$("#stadium_name").val();
	var data={name:_name};

	if($("#stadium_name").val()!="") ajax_("/edit_mode/insert_stadium/stadinum", data, "", true);
}
function update_stadium(no){
	var _num=$("#stadium_num_"+no).text();
	var _name=$("#stadium_name_"+no).val();
	var data={name:_name};

	ajax_('/edit_mode/update/stadinum/'+_num, data, "", true);
}
function delete_stadium(no){
	if(confirm("정말로 삭제 하시겠습니까?")){
		var _num=$("#stadium_num_"+no).text();

		ajax_('/edit_mode/delete/stadinum/'+_num, "", "삭제 되었습니다.", true);
	}
}

/* 스케쥴 관리 */
function insert_schedule(){
	var _game_time=$("#schedule_gametime").val();
	var _home_no=$("#schedule_home").val();
	var _home_name=$("#home_value_"+_home_no).text();
	var _away_no=$("#schedule_away").val();
	var _away_name=$("#away_value_"+_away_no).text();
	var _stadium=$("#schedule_stadium").val();
	var data={game_time:_game_time, home_no:_home_no, home_name:_home_name, away_no:_away_no, away_name:_away_name, stadium:_stadium};
	console.log(_game_time);
	if(_home_no!="0" && _home_no!="0" && _game_time!="") ajax_('/edit_mode/insert_schedule_ajax', data, "추가 되었습니다.", true);
}
function update_schedule(no){
	var _game_time=$("#schedule_gametime_"+no).val();
	var _stadium=$("#schedule_stadium_"+no).val();
	var _home_no=$("#schedule_homename_"+no).val();
	var _home_name=$("#schedule_homename_"+no+" option:selected").text();
	var _away_no=$("#schedule_awayname_"+no).val();
	var _away_name=$("#schedule_awayname_"+no+" option:selected").text();
	var data={game_time:_game_time, home_no:_home_no, home_name:_home_name, away_no:_away_no, away_name:_away_name, stadium:_stadium};

	ajax_('/edit_mode/update_schedule_ajax/'+no, data, "저장 되었습니다.", true);
}
function delete_schedule(no){
	if(confirm("정말로 삭제 하시겠습니까?")) ajax_('/edit_mode/delete/schedule/'+no, "", "삭제 되었습니다.", true);
}

/* COOKIE GET/SETTER */
function set_cookie(_kindof, _num, flag){
	if(_kindof=='pitching_num') _num=$("#pitching_num").val();
	if(_kindof=='during_game') _num=$("#during_game").val();
	
	$.ajax({
		type:'POST',
		url:'/edit_mode/set_cookie_ajax',
        data:{kindof:_kindof, num:_num},
        complete:function(){
			if(flag) location.reload();
        }
	});
}
function get_cookie(_kindof){
	var result="";
	
	$.ajax({
		type:'POST',
		url:'/edit_mode/get_cookie_ajax',
		data:{kindof:_kindof},
        success:function(data){
        	result=data;
		},
		complete:function(){
			$("#pitching_num").val(result);
		}
	});
}

function update_status_ajax(schedule_no, status){
    $.ajax({
        type:'POST',
        dataType:'text',
        url:'/baseball/update_schedule_status/'+schedule_no+'/'+status,
        complete:function(){
            location.reload();
        }
    });
}
</script>
</html>