<?php  $challenge_arr=array("아웃/세이프", "아웃/파울", "파울/홈런", "홈런/2루타", "볼/사구", "파울/삼진", "파울/폭투", "파울/사구", "파울/페어", "포구성공/포구실패", "볼인/볼데드"); ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
<title> ODDS CONNECT - DataMining </title>
<title></title>
</head>

<body style="background-color: white;">
<div>
	<div>
		<div>
			<span>신청팀 선택 : </span>
			<input type="radio" name="team_select" value="home"><?=$game->home_name;?>
			<input type="radio" name="team_select" value="away"><?=$game->away_name;?>
		</div>
		<div>
			<span>선수 선택 : </span>
			<select id="home_player_name">
				<option value="<?=$game->home_name;?>"><?=$game->home_name;?></option>					
				<?php for($i=0; $i<9; $i++){ ?>
					<option value="<?=$home_line[$i]->name?>"><?=$home_line[$i]->name?></option>
				<?php } ?>
			</select>
			<select id="away_player_name">
				<option value="<?=$game->away_name;?>"><?=$game->away_name;?></option>
				<?php for($i=0; $i<9; $i++){ ?>
					<option value="<?=$away_line[$i]->name?>"><?=$away_line[$i]->name?></option>
				<?php } ?>
			</select>
		</div>
		<div>
			<span>이슈 선택 : </span>
			<select id="challenge">
				<option value="">------------------------------</option>
				<?php for($i=0; $i<count($challenge_arr); $i++){ ?>
					<option value="<?=$challenge_arr[$i]?>"><?=$challenge_arr[$i]?></option>
				<?php } ?>
			</select>
		</div>
	</div><br><hr><br>
	<div id="challenge_select" style="display:none;">
		<div>
			<span>현재 판정 : </span>
			<input type="radio" name="before" value="0"/><span id="challenge_0"></span>
			<input type="radio" name="before" value="1"/><span id="challenge_1"></span>
		</div>
	</div>
	<div id="challenge_result" style="display:none;">
		<span>판정 결과 : </span>
		<input type="radio" name="after" value="0"/><span id="challenge_3"></span>
		<input type="radio" name="after" value="1"/><span id="challenge_4"></span>
	</div><br>
	<div>
		<button onclick="challenging();" style="margin-left: 30%;">메세지 전송</button>
	</div>
</div>
</body>

<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
<script>
$("#challenge").change(function(){
	var option_value=($('#challenge option:selected').val()).split("/");
	$("#challenge_select").show();
	$("#challenge_result").show();
	$("#challenge_0").text(option_value[0]);
	$("#challenge_1").text(option_value[1]);
	$("#challenge_3").text(option_value[0]);
	$("#challenge_4").text(option_value[1]);
});

function challenging(){
	var message="";
	var result="";
	
	var team=$('input[name=team_select]:checked').val();
	var team_korean=(team=="home") ? "<?=$game->home_name;?>" : "<?=$game->away_name;?>";

	var player_name="";
	if($('#home_player_name').val()=="<?=$game->home_name;?>") player_name=$('#away_player_name').val();
	else if($('#away_player_name').val()=="<?=$game->away_name;?>") player_name=$('#home_player_name').val();
	
	var challenge_before=$('input[name=before]:checked').val();
	var challenge_after=$('input[name=after]:checked').val();
	challenge_before=(challenge_before=="0") ? $("#challenge_0").text() : $("#challenge_1").text();
	challenge_after=(challenge_after=="0") ? $("#challenge_3").text() : $("#challenge_4").text();

	if($('input[name=after]:checked').val()==undefined) message="<p class='green'>"+team_korean+"에서 "+player_name+" "+challenge_before+" 관련 합의판정 요청</p>";
	else{
		result=($('input[name=before]:checked').val()==$('input[name=after]:checked').val())? "실패" : "성공";
		message="<p class='green'>합의판정 결과 : "+challenge_before+" -> "+challenge_after+" 요청"+result+"</p>";
	}
	
	message_send(message);
}

function message_send(message){
	schedule_no="<?=$game->no?>";
	inning="<?=$game_data->inning?>";
	pitcher="<?=$game_data->pitcher?>";
	batter="<?=$game_data->batter?>";
	$.ajax({
		type:'POST',
		url:'/baseball/message_send',
        data:{schedule_no:schedule_no, inning:inning, pitcher:pitcher, batter:batter, message1:message},
        complete:function(){
        	var chatting=parent.document.getElementById("chating");
        	chatting.innerHTML=message+chatting.innerHTML;
        }
	});
}
</script>
</html>