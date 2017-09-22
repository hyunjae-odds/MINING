<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
<title> ODDS CONNECT - DataMining </title>
<link href="/public/lib/base.css" rel="stylesheet" type="text/css">
<style>
	#player1>li:hover, #selection1>li:hover{background-color:#FFFF90;}
	#player2>li:hover, #selection3>li:hover{background-color:#FFFF90;}
</style>
</head>

<body>
<?php if($game!=""){ ?>
	<input type="hidden" id="game_no" value="<?=$game->no;?>" name="game_no"/>
	<input type="hidden" id="home_no" value="<?=$game->home_no;?>"/>
	<input type="hidden" id="away_no" value="<?=$game->away_no;?>"/>
	<input type="hidden" id="token"/>
	<input type="hidden" id="aa"/>
<?php } ?>

<div class="wrap lineup">
	<div>
		<ul class="VS">
			<?php if($schedule==null){ ?>
				<li>등록 된 경기가 없습니다.</li>
			<?php }else{ ?>
	 		<?php foreach($schedule as $entry){
	 			if($game_no==$entry->no){
			 ?> <li class='on'>
		 			<a href="/baseball/schedule/<?=$date?>/<?=$entry->no;?>/0"><?=$entry->away_name;?> vs <?=$entry->home_name;?></a>
		 		</li>
	 		<?php }else{ ?>
		 		<li class="<?php echo ($game != "" && $game->no==$entry->no)?'on':''; ?>">
		 			<a href="/baseball/schedule/<?=$date?>/<?=$entry->no;?>/0"><?=$entry->away_name;?> vs <?=$entry->home_name;?></a>
			 	</li>
	 		<?php }}} ?>
		</ul>

		<?php if($this->input->get('mode')!='edit'){ ?>
			<div style="float: right;">
				날짜 선택<input type="date" id="schedule_date" size="13" value="<?=$date?>">
				<button type="button" onclick="javascript:location.href=('/baseball/schedule/'+$('#schedule_date').val()+'/0/0');">확인</button>
			</div>
		<?php } ?>
        
        <?php if($level<3): ?>
            <div style="float:right;">
            [관전모드] |
                <?php foreach($schedule as $entry){ ?>
                    <a href="javascript:is_game(<?=$entry->no?>)"><?=$entry->away_name;?> vs <?=$entry->home_name;?></a> | 
                <?php } ?>
            </div>
        <?php endif;?>
	
		<?php if($game!=null){ ?>
			<p class="apply"><a href="javascript:confirm();">적용<span></span></a></p>
			<ul class="VS_view">
				<li class="on">
					<!-- 원정 -->
					<div class="visit" id="visit">
						<p class="team">원정</p>
						<div class="selection" >
							<div class="dgray">
								<ul class="st" id="away_batter_no">
									<?php for($i=1; $i<=9; $i++){ ?>
										<li><?php if($this->input->get('away_batter_no')==$i) echo '타자';
												  else if($this->input->get('away_fb_runner_no')==$i) echo '1루';
												  else if($this->input->get('away_sb_runner_no')==$i) echo '2루';
												  else if($this->input->get('away_tb_runner_no')==$i) echo '3루';
												  else echo $i;
										?></li>
									<?php } ?>
								</ul>
								<div class="th">
									<div class="st">타순</div>
									<div class="name">이름</div>
									<div class="position">수비</div>
								</div>
								<ul class="td connectedSortable3" id="selection3" onmousedown="toggleSortable('enable', 'batter', '#selection3')">
									<?php if(isset($away_line_major)){ ?>
										<?php foreach($away_line_major as $entry_major){ ?>
											<?php if($entry_major->subi!=null){ ?>
												<li>
													<div class="num"><?=$entry_major->player;?></div>
													<div class="name" id="<?=$entry_major->player_id;?>"><?=$entry_major->name;?></div>
													<div class="position">
														<p><?=$entry_major->subi ?><a href="javascript:bb(this);" class="btn01"></a></p>
														<ul>
															<li <?php if($entry_major->subi == '포') echo 'class="on"';?>>
																<a href="javascript:aa('포', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">포수</a>
															</li>
															<li <?php if($entry_major->subi == '1') echo 'class="on"';?>>
																<a href="javascript:aa('1', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">1루수</a>
															</li>
															<li <?php if($entry_major->subi == '2') echo 'class="on"';?>>
																<a href="javascript:aa('2', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">2루수</a>
															</li>
															<li <?php if($entry_major->subi == '3') echo 'class="on"';?>>
																<a href="javascript:aa('3', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">3루수</a>
															</li>
															<li <?php if($entry_major->subi == '유') echo 'class="on"';?>>
																<a href="javascript:aa('유', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">유격수</a>
															</li>
															<li <?php if($entry_major->subi == '좌') echo 'class="on"';?>>
																<a href="javascript:aa('좌', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">좌익수</a>
															</li>
															<li <?php if($entry_major->subi == '중') echo 'class="on"';?>>
																<a href="javascript:aa('중', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">중견수</a>
															</li>
															<li <?php if($entry_major->subi == '우') echo 'class="on"';?>>
																<a href="javascript:aa('우', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">우익수</a>
															</li>
															<li <?php if($entry_major->subi == '지') echo 'class="on"';?>>
																<a href="javascript:aa('지', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">지명타자</a>
															</li>
															<li <?php if($entry_major->subi == '대타자') echo 'class="on"';?>>
																<a href="javascript:aa('타', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">대타자</a>
															</li>
															<li <?php if($entry_major->subi == '대주자') echo 'class="on"';?>>
																<a href="javascript:aa('주', 2, <?=$entry_major->player?>, '<?=$entry_major->name?>');">대주자</a>
															</li>
														</ul>
													</div>
												</li>
									<?php }}} ?>
								</ul>
							</div>
							<div class="bench">
								<ul class="st">
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
								</ul>
								<ul class="st st2">
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
								</ul>
								<ul class="td connectedSortable3">
								</ul>
							</div>
							<ul class="lgray ">
								<ul class="st">
									<li id="away_pitcher">투수</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
								</ul>
								<div class="th">
									<div class="st">보직</div>
									<div class="name">이름</div>
									<div class="position">&nbsp;</div>
								</div>
								<ul class="td connectedSortable4" id="selection4" onmousedown="toggleSortable('enable', 'pitcher', '#selection4')">
									<?php if(isset($away_line_major)){ ?>
										<?php foreach($away_line_major as $entry){ ?>
											<?php if($entry->subi==null){ ?>
												<li>
													<div class="num"><?=$entry->player;?></div>
													<div class="name" id="<?=$entry->player_id;?>"><?=$entry->name;?></div>
												</li>
									<?php }}} ?>
								</ul>
							</ul>
						</div>
						<div class="player">
							<div class="dgray">
								<div class="th">
									<div class="num">No.</div>
									<div class="name">이름</div>
								</div>
								<ul class="td connectedSortable3" id="player2" onmousedown="toggleSortable('disable', 'batter', '#selection3')">
									<?php 
										foreach($away_line as $entry){
											if($entry->position!='투수'){
												$flag = 0;
												if(isset($away_line_major)){
													foreach($away_line_major as $entry_major){
														if($entry->player_id==$entry_major->player_id) $flag=1;
												}}
												if($flag==0){
									?>
									<li>
										<div class="num"><?=$entry->back_num?></div>
										<div class="name" id="<?=$entry->player_id;?>"><?=$entry->name?></div>
										<div class="position">
											<?php if($entry->position=="포수"){ ?>
												<p>포<a href="" class="btn01"></a></p>
											<?php }else if($entry->position=="내야수"){ ?>
												<p>1<a href="" class="btn01"></a></p>
											<?php }else{ ?>
												<p>좌<a href="" class="btn01"></a></p>
											<?php } ?>
											<ul>
												<?php if($entry->position=="포수"){ ?> <li class="on"> <?php }else{ ?><li><?php } ?> 
												<a href="javascript:aa('포', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">포수</a></li>
												<?php if($entry->position=="내야수"){ ?> <li class="on"> <?php }else{ ?><li><?php } ?>
												<a href="javascript:aa('1', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">1루수</a></li>
												<li><a href="javascript:aa('2', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">2루수</a></li>
												<li><a href="javascript:aa('3', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">3루수</a></li>
												<li><a href="javascript:aa('유', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">유격수</a></li>
												<?php if($entry->position=="외야수"){ ?> <li class="on"> <?php }else{ ?><li><?php } ?>
												<a href="javascript:aa('좌', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">좌익수</a></li>
												<li><a href="javascript:aa('중', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">중견수</a></li>
												<li><a href="javascript:aa('우', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">우익수</a></li>
												<li><a href="javascript:aa('지', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">지명타자</a></li>
												<li><a href="javascript:aa('타', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">대타자</a></li>
												<li><a href="javascript:aa('주', 2, <?=$entry->back_num?>, '<?=$entry->name?>');">대주자</a></li>
											</ul>
										</div>
									</li>
									<?php }}} ?>									
								</ul>
							</div>
							<div class="lgray">
								<div class="th">
									<div class="num">No.</div>
									<div class="name">이름</div>
								</div>
								<ul class="td connectedSortable4" id="player4" onmousedown="toggleSortable('disable', 'pitcher', '#selection4')">
									<?php 
										foreach($away_line as $entry){
											if($entry->position=='투수'){
												$flag=0;
												if(isset($away_line_major)){
													foreach($away_line_major as $entry_major){
														if($entry->player_id==$entry_major->player_id) $flag=1;
												}}
												if($flag==0){
									?>
									<li>
										<div class="num"><?=$entry->back_num?></div>
										<div class="name" id="<?=$entry->player_id;?>"><?=$entry->name?></div>
									</li>
									<?php }}} ?>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- 홈 -->
					<div class="home">
						<p class="team">홈</p>
						<div class="selection">
							<div class="dgray">
								<ul class="st" id="home_batter_no">
									<?php for($i=1 ; $i<=9; $i++){ ?>
										<li><?php if($this->input->get('home_batter_no')==$i) echo '타자';
												  else if($this->input->get('home_fb_runner_no')==$i) echo '1루';
												  else if($this->input->get('home_sb_runner_no')==$i) echo '2루';
												  else if($this->input->get('home_tb_runner_no')==$i) echo '3루';
												  else echo $i;
										?></li>
									<?php } ?>
								</ul>
								<div class="th">
									<div class="st">타순</div>
									<div class="name">이름</div>
									<div class="position">수비</div>
								</div>
								<ul class="td connectedSortable1" id="selection1" onmousedown="toggleSortable('enable', 'batter', '#selection1')">
									<?php if(isset($home_line_major)){ ?>
										<?php foreach($home_line_major as $entry_major){ ?>
											<?php if($entry_major->subi!=null){ ?>
												<li>
													<div class="num"><?=$entry_major->player;?></div>
													<div class="name" id="<?=$entry_major->player_id;?>"><?=$entry_major->name;?></div>
													<div class="position">
														<p><?=$entry_major->subi;?><a href="javascript:bb(this);" class="btn01"></a></p>
														<ul>
															<li <?php if($entry_major->subi == '포') echo 'class="on"';?>>
																<a href="javascript:aa('포', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">포수</a>
															</li>
															<li <?php if($entry_major->subi == '1') echo 'class="on"';?>>
																<a href="javascript:aa('1', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">1루수</a>
															</li>
															<li <?php if($entry_major->subi == '2') echo 'class="on"';?>>
																<a href="javascript:aa('2', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">2루수</a>
															</li>
															<li <?php if($entry_major->subi == '3') echo 'class="on"';?>>
																<a href="javascript:aa('3', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">3루수</a>
															</li>
															<li <?php if($entry_major->subi == '유') echo 'class="on"';?>>
																<a href="javascript:aa('유', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">유격수</a>
															</li>
															<li <?php if($entry_major->subi == '좌') echo 'class="on"';?>>
																<a href="javascript:aa('좌', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">좌익수</a>
															</li>
															<li <?php if($entry_major->subi == '중') echo 'class="on"';?>>
																<a href="javascript:aa('중', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">중견수</a>
															</li>
															<li <?php if($entry_major->subi == '우') echo 'class="on"';?>>
																<a href="javascript:aa('우', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">우익수</a>
															</li>
															<li <?php if($entry_major->subi == '지') echo 'class="on"';?>>
																<a href="javascript:aa('지', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">지명타자</a>
															</li>
															<li <?php if($entry_major->subi == '대타자') echo 'class="on"';?>>
																<a href="javascript:aa('타', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">대타자</a>
															</li>
															<li <?php if($entry_major->subi == '대주자') echo 'class="on"';?>>
																<a href="javascript:aa('주', 1, <?=$entry_major->player?>, '<?=$entry_major->name?>');">대주자</a>
															</li>
														</ul>
													</div>
												</li>
									<?php }}} ?>
								</ul>
							</div>
							<div class="bench">
								<ul class="st">
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
									<li>벤치</li>
								</ul>
								<ul class="st st2">
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
								</ul>
								<ul class="td connectedSortable" id="player2">
								</ul>
							</div>
							<ul class="lgray">
								<ul class="st">
									<li id="home_pitcher">투수</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
									<li>-</li>
								</ul>
								<div class="th">
									<div class="st">보직</div>
									<div class="name">이름</div>
									<div class="position">&nbsp;</div>
								</div>
								<ul class="td connectedSortable2" id="selection2" onmousedown="toggleSortable('enable', 'pitcher', '#selection2')">
									<?php if(isset($home_line_major)) {
											foreach($home_line_major as $entry){
												if($entry->subi == null){ ?>
												<li>
													<div class="num"><?=$entry->player ?></div>
													<div class="name" id="<?=$entry->player_id;?>"><?=$entry->name ?></div>
												</li>
									<?php }}} ?>
								</ul>
							</ul>
						</div>
						<div class="player">
							<div class="dgray">
								<div class="th">
									<div class="num">No.</div>
									<div class="name">이름</div>
								</div>
								<ul class="td connectedSortable1" id="player1" onmousedown="toggleSortable('disable', 'batter', '#selection1')">
									<?php 
										foreach($home_line as $entry){
											if($entry->position!='투수'){
												$flag=0;
												if(isset($home_line_major)){
													foreach($home_line_major as $entry_major){
														if($entry->player_id==$entry_major->player_id){
															$flag=1;
												}}}
												if($flag==0){
									?>
									<li>
										<div class="num"><?=$entry->back_num?></div>
										<div class="name" id="<?=$entry->player_id;?>"><?=$entry->name?></div>
										<div class="position">
											<?php if($entry->position == "포수"){ ?>
												<p>포<a href="javascript:bb(this);" class="btn01"></a></p>
											<?php }else if($entry->position == "내야수"){ ?>
												<p>1<a href="" class="btn01"></a></p>
											<?php }else{ ?>
												<p>좌<a href="" class="btn01"></a></p>
											<?php } ?>
											<ul>
												<?php if($entry->position=="포수"){ ?> <li class="on"> <?php }else{ ?><li><?php } ?>
												<a href="javascript:aa('포', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">포수</a></li>
												<?php if($entry->position == "내야수"){ ?> <li class="on"> <?php }else{ ?><li><?php } ?>
												<a href="javascript:aa('1', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">1루수</a></li>
												<li><a href="javascript:aa('2', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">2루수</a></li>
												<li><a href="javascript:aa('3', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">3루수</a></li>
												<li><a href="javascript:aa('유', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">유격수</a></li>
												<?php if($entry->position == "외야수"){ ?> <li class="on"> <?php }else{ ?><li><?php } ?>
												<a href="javascript:aa('좌', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">좌익수</a></li>
												<li><a href="javascript:aa('중', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">중견수</a></li>
												<li><a href="javascript:aa('우', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">우익수</a></li>
												<li><a href="javascript:aa('지', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">지명타자</a></li>
												<li><a href="javascript:aa('타', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">대타자</a></li>
												<li><a href="javascript:aa('주', 1, <?=$entry->back_num?>, '<?=$entry->name?>');">대주자</a></li>
											</ul>
										</div>
									</li>
									<?php }}} ?>
								</ul>
							</div>
							<div class="lgray">
								<div class="th">
									<div class="num">No.</div>
									<div class="name">이름</div>
								</div>
								<ul class="td connectedSortable2" id="player3" onmousedown="toggleSortable('disable', 'pitcher', '#selection2')">
									<?php 
										foreach($home_line as $entry){
											if($entry->position=='투수'){
												$flag=0;
												if(isset($home_line_major)){
													foreach($home_line_major as $entry_major){
														if($entry->player_id==$entry_major->player_id) $flag=1;
												}}
												if($flag==0){
									?>
									<li>
										<div class="num"><?=$entry->back_num?></div>
										<div class="name" id="<?=$entry->player_id;?>"><?=$entry->name?></div>
									</li>
									<?php }}} ?>
								</ul>
							</div>
						</div>
					</div>
				</li>
			</ul>
		<?php } ?>
	</div>
</div>

<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
<script src="/public/lib/js/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var message="";
var mode=("<?=$this->input->get('mode')?>"!="") ? "<?=$this->input->get('mode')?>" : "" ;

$(".btn01").click(function(){ 
	$(".active").removeClass();
	$(this).parent().siblings().addClass("active");
	return false;
});
$(function(){$("a").attr("onfocus","this.blur();")});
$(document).click(function(){$(".active").removeClass("active");});

/* jQuery Sortable */
$(function(){
	$("#selection1, #player1").sortable({connectWith:".connectedSortable1"}).disableSelection();
	$("#selection2, #player3").sortable({connectWith:".connectedSortable2"}).disableSelection();
	$("#selection3, #player2").sortable({connectWith:".connectedSortable3"}).disableSelection();
	$("#selection4, #player4").sortable({connectWith:".connectedSortable4"}).disableSelection();
});
function toggleSortable(toggle, pitcherOrBatter, selectionNum){
	var _length=(pitcherOrBatter=='batter')? 9:1;
		
	if(toggle=='enable')$(selectionNum).sortable("enable");
	else{
		if($(selectionNum).children().length==_length) $(selectionNum).sortable("option", "disabled", true);
	}
}

/* 선수교체 */
if("<?=$this->input->get('mode');?>"=="edit"){
	$("#selection1>li").click(function(){
		if($("#target").length>0){
			$("#selection1>li").css("box-shadow", "");
			$("#selection1>li").removeAttr("id");
			$(this).attr("id", "target");
			$(this).css("box-shadow", "0 0 0 2px red");
		}else if($("#target").length==0){
			$(this).attr("id", "target");
			$(this).css("box-shadow", "0 0 0 2px red");
		}
		checkplayerChange();
	});
	$("#selection2>li").click(function(){
		if($("#target").length>0){
			$("#selection2>li").css("box-shadow", "");
			$("#selection2>li").removeAttr("id");
			$(this).attr("id", "target");
			$(this).css("box-shadow", "0 0 0 2px red");
		}else if($("#target").length==0){
			$(this).attr("id", "target");
			$(this).css("box-shadow", "0 0 0 2px red");
		}
		checkplayerChange();
	});
	$("#player1>li").click(function(){
		$("#player1>li").css("box-shadow", "");
		$("#player1>li").removeAttr("id");
		$(this).attr("id", "substitutePlayer");
		$(this).css("box-shadow", "0 0 0 2px red");
		checkplayerChange();
	});
	$("#player3>li").click(function(){
		$("#player3>li").css("box-shadow", "");
		$("#player3>li").removeAttr("id");
		$(this).attr("id", "substitutePlayer");
		$(this).css("box-shadow", "0 0 0 2px red");
		checkplayerChange();
	});
	function checkplayerChange(){
		if($("#target").length>0 && $("#substitutePlayer").length>0){
			var target_name=$("#target>.name")[0].innerText;
			var target_backnum=$("#target>.num")[0].innerText;
			var target_playerid=$("#target>.name")[0].getAttribute('id');
			var substitute_player=$("#substitutePlayer>.name")[0].innerText;
			var substitute_player_backnum=$("#substitutePlayer>.num")[0].innerText;
			var substitute_player_playerid=$("#substitutePlayer>.name")[0].getAttribute('id');
			
			$("#target>.num")[0].innerText=substitute_player_backnum;
			$("#target>.name")[0].innerText=substitute_player;
			$("#target>.name")[0].setAttribute('id', substitute_player_playerid);
			$("#substitutePlayer>.num")[0].innerText=target_backnum;
			$("#substitutePlayer>.name")[0].innerText=target_name;
			$("#substitutePlayer>.name")[0].setAttribute('id', target_playerid);
			
			$("#target").css("box-shadow", "");
			$("#target").removeAttr("id");
			$("#substitutePlayer").css("box-shadow", "");
			$("#substitutePlayer").removeAttr("id");
		}
	}
	$("#selection3>li").click(function(){
		if($("#target_away").length>0){
			$("#selection3>li").css("box-shadow", "");
			$("#selection3>li").removeAttr("id");
			$(this).attr("id", "target_away");
			$(this).css("box-shadow", "0 0 0 2px #22C3FF");
		}else if($("#target_away").length==0){
			$(this).attr("id", "target_away");
			$(this).css("box-shadow", "0 0 0 2px #22C3FF");
		}
		checkplayerChange_2();
	});
	$("#selection4>li").click(function(){
		if($("#target_away").length>0){
			$("#selection4>li").css("box-shadow", "");
			$("#selection4>li").removeAttr("id");
			$(this).attr("id", "target_away");
			$(this).css("box-shadow", "0 0 0 2px #22C3FF");
		}else if($("#target_away").length==0){
			$(this).attr("id", "target_away");
			$(this).css("box-shadow", "0 0 0 2px #22C3FF");
		}
		checkplayerChange_2();
	});
	$("#player2>li").click(function(){
		$("#player2>li").css("box-shadow", "");
		$("#player2>li").removeAttr("id");
		$(this).attr("id", "substitute_player");
		$(this).css("box-shadow", "0 0 0 2px #22C3FF");
		checkplayerChange_2();
	});
	$("#player4>li").click(function(){
		$("#player4>li").css("box-shadow", "");
		$("#player4>li").removeAttr("id");
		$(this).attr("id", "substitute_player");
		$(this).css("box-shadow", "0 0 0 2px #22C3FF");
		checkplayerChange_2();
	});
	function checkplayerChange_2(){
		if($("#target_away").length>0 && $("#substitute_player").length>0){
			var target_name=$("#target_away>.name")[0].innerText;
			var target_backnum=$("#target_away>.num")[0].innerText;
			var target_playerid=$("#target_away>.name")[0].getAttribute('id');
			var substitute_player=$("#substitute_player>.name")[0].innerText;
			var substitute_player_backnum=$("#substitute_player>.num")[0].innerText;
			var substitute_player_playerid=$("#substitute_player>.name")[0].getAttribute('id');
			
			$("#target_away>.num")[0].innerText=substitute_player_backnum;
			$("#target_away>.name")[0].innerText=substitute_player;
			$("#target_away>.name")[0].setAttribute('id', substitute_player_playerid);
			$("#substitute_player>.num")[0].innerText=target_backnum;
			$("#substitute_player>.name")[0].innerText=target_name;
			$("#substitute_player>.name")[0].setAttribute('id', target_playerid);
			
			$("#target_away").css("box-shadow", "");
			$("#target_away").removeAttr("id");
			$("#substitute_player").css("box-shadow", "");
			$("#substitute_player").removeAttr("id");
		}
	}
}

function aa(aa, bb, cc, dd){
	if(bb==1){
		var target_no=$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").length;
		var target=$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").text();
		var j=0;
		for(var i=0; i<target_no; i=i+12){
			if($("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(0).text()==cc&&$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(1).text()==dd){
				if(aa=='포') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>포<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li class=\"on\"><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
				else if(aa=='1') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>1<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li class=\"on\"><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
				else if(aa=='2') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>2<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li class=\"on\"><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='3') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>3<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li class=\"on\"><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='유') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>유<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li class=\"on\"><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='좌') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>좌<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li class=\"on\"><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='중') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>중<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li class=\"on\"><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='우') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>우<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li class=\"on\"><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='지') $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>지<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li class=\"on\"><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='타') {if($("#home_batter_no>li")[j].innerText!="타자"){alert("타자 상태에서만 가능합니다."); return false;}$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>대타자<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li class=\"on\"><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");}
 				else if(aa=='주') {if($("#home_batter_no>li")[j].innerText!="1루" && $("#home_batter_no>li")[j].innerText!="2루" && $("#home_batter_no>li")[j].innerText!="3루"){alert("주자 상태에서만 가능합니다."); return false;} $("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>대주자<a href=\"javascript:bb(1, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 1, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 1, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 1, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 1, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 1, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 1, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 1, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 1, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 1, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 1, "+cc+", '"+dd+"');\">대타자</a></li><li class=\"on\"><a href=\"javascript:aa('주', 1, "+cc+", '"+dd+"');\">대주자</a></li></ul>");}
 	 		}
			j++;
 		}
	}else{
		var target_no=$("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").length;
		var target=$("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").text();
		var j=0;
		for(var i=0; i<target_no; i=i+12){
 	 		if($("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(0).text()==cc&&$("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(1).text()==dd){
 	 			if(aa=='포') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>포<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li class=\"on\"><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
				else if(aa=='1') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>1<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li class=\"on\"><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
				else if(aa=='2') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>2<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li class=\"on\"><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='3') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>3<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li class=\"on\"><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='유') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>유<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li class=\"on\"><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='좌') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>좌<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li class=\"on\"><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='중') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>중<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li class=\"on\"><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='우') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>우<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li class=\"on\"><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='지') $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>지<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li class=\"on\"><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");
 				else if(aa=='타') {if($("#away_batter_no>li")[j].innerText!="타자"){alert("타자 상태에서만 가능합니다."); return false;} $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>대타자<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li class=\"on\"><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");}
 				else if(aa=='주') {if($("#away_batter_no>li")[j].innerText!="1루" && $("#away_batter_no>li")[j].innerText!="2루" && $("#away_batter_no>li")[j].innerText!="3루"){alert("주자 상태에서만 가능합니다."); return false;} $("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).html("<p>대주자<a href=\"javascript:bb(2, '"+cc+"', '"+dd+"');\" class='btn01'></a></p><ul><li><a href=\"javascript:aa('포', 2, "+cc+", '"+dd+"');\">포수</a></li>	<li><a href=\"javascript:aa('1', 2, "+cc+", '"+dd+"');\">1루수</a></li>	<li><a href=\"javascript:aa('2', 2, "+cc+", '"+dd+"');\">2루수</a></li>	<li><a href=\"javascript:aa('3', 2, "+cc+", '"+dd+"');\">3루수</a></li>	<li><a href=\"javascript:aa('유', 2, "+cc+", '"+dd+"');\">유격수</a></li><li><a href=\"javascript:aa('좌', 2, "+cc+", '"+dd+"');\">좌익수</a></li><li><a href=\"javascript:aa('중', 2, "+cc+", '"+dd+"');\">중견수</a></li><li><a href=\"javascript:aa('우', 2, "+cc+", '"+dd+"');\">우익수</a></li><li><a href=\"javascript:aa('지', 2, "+cc+", '"+dd+"');\">지명타자</a></li><li><a href=\"javascript:aa('타', 2, "+cc+", '"+dd+"');\">대타자</a></li><li class=\"on\"><a href=\"javascript:aa('주', 2, "+cc+", '"+dd+"');\">대주자</a></li></ul>");}
 	 		}
			j++;
 	 	}
 	}
}

//bb:홈,원정   cc:선수번호, dd:선수명
function bb(bb, cc, dd){
	if(bb==1){
		var target_no=$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").length;
		for(var i=0; i<target_no; i=i+12){
			if($("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(0).text()==cc&&$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(1).text()==dd){
				$(".active").removeClass();
				$("div.home").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).find("p").siblings().addClass("active");
				return false;
			}
		}
	}else{
		var target_no=$("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").length;
		for(var i=0; i<target_no; i=i+12){
			if($("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(0).text()==cc&&$("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(1).text()==dd){
				$(".active").removeClass();
				$("div.visit").eq(0).find("div").eq(0).find("div").eq(0).find("ul").eq(1).find("li").eq(i).find("div").eq(2).find("p").siblings().addClass("active");
				return false;
			}
		}
	}
}

function confirm(){
	var lineup_token="";
	var s_1="#selection1>li>.num";
	var s_2="#selection2>li>.num";
	var s_3="#selection3>li>.num";
	var s_4="#selection4>li>.num";
	
	/* 빈 선수 발리데이션 */
	if($(s_1).length!=9 || $(s_2).length==0 || $(s_3).length!=9 || $(s_4).length==0){
		alert("선발 설정이 올바르지 않습니다.");
		return false;
	}
	/* 포지션 발리데이션 */
	var checked=0;
	var special_arr=new Array('대타자','대주자');
	var standard_arr=new Array('1','2','3','우','유','좌','중','지','포');
	var away_validation_arr=new Array();
	var home_validation_arr=new Array();
	
	for(var i=0; i<9; i++){
		away_validation_arr.push($('#selection3>li>.position>p')[i].innerText);
	}
	for(var i=0; i<9; i++){
		home_validation_arr.push($('#selection1>li>.position>p')[i].innerText);
	}
	/* 원정 */
	for(var i=0; i<away_validation_arr.length; i++){
		for(var j=0; j<standard_arr.length; j++){
			if(away_validation_arr[i]==standard_arr[j]){
				standard_arr.splice(j, 1);
				checked+=1;
			}
		}
	}
	var check_no=9;
	for(var i=0; i<away_validation_arr.length; i++){
		for(var j=0; j<special_arr.length; j++){
			if(away_validation_arr[i]==special_arr[j]){
				check_no=check_no-1;
			}
		}
	}
	if(checked!=check_no){
		alert('원정 선수 포지션 설정이 잘못 되었습니다.');
		return false;
	}
	/* 홈 */
	var checked=0;
	var standard_arr=new Array('1','2','3','우','유','좌','중','지','포');
	for(var i=0; i<home_validation_arr.length; i++){
		for(var j=0; j<standard_arr.length; j++){
			if(home_validation_arr[i]==standard_arr[j]){
				standard_arr.splice(j, 1);
				checked+=1;
			}
		}
	}
	var check_no=9;
	for(var i=0; i<home_validation_arr.length; i++){
		for(var j=0; j<special_arr.length; j++){
			if(home_validation_arr[i]==special_arr[j]){
				check_no=check_no-1;
			}
		}
	}
	if(checked!=check_no){
		alert('홈 선수 포지션 설정이 잘못 되었습니다.');
		return false;
	}

	/* token_set */
	for(var i=0; i<9; i++){
		lineup_token=lineup_token+$("#game_no").val()+";"+$("#home_no").val()+";"+(i+1)+";"+$(s_1)[i].innerText+";"+$("#selection1>li>.position>p")[i].innerText+";"+$("#selection1>li>.name")[i].getAttribute("id")+";";
	}
	lineup_token=lineup_token+$("#game_no").val()+";"+$("#home_no").val()+";투;"+$(s_2)[0].innerText+";;"+$("#selection2>li>.name").attr("id")+";";
	for(var i=0; i<9; i++){
		lineup_token=lineup_token+$("#game_no").val()+";"+$("#away_no").val()+";"+(i+1)+";"+$(s_3)[i].innerText+";"+$("#selection3>li>.position>p")[i].innerText+";"+$("#selection3>li>.name")[i].getAttribute("id")+";";
	}
	lineup_token=lineup_token+$("#game_no").val()+";"+$("#away_no").val()+";투;"+$(s_4)[0].innerText+";;"+$("#selection4>li>.name").attr("id")+";";

	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

	var defenders="<?=$this->input->get("defenders");?>".split(";");
	var LF_name="";
	var CF_name="";
	var RF_name="";
	var FB_name="";
	var SB_name="";
	var SS_name="";
	var TB_name="";
	var C_name="";
	var DH_name="";

	for(var h=0; h<defenders.length; h++){
		var value=defenders[h].split("_");
		if(value[0]=="좌") LF_name=value[1];
		else if(value[0]=="중") CF_name=value[1];
		else if(value[0]=="우") RF_name=value[1];
		else if(value[0]=="1") FB_name=value[1];
		else if(value[0]=="2") SB_name=value[1];
		else if(value[0]=="유") SS_name=value[1];
		else if(value[0]=="3") TB_name=value[1];
		else if(value[0]=="포") C_name=value[1];
		else if(value[0]=="지") DH_name=value[1];
	}

	/* 게임 중 */
	if("<?=$this->input->get('mode')?>"=="edit"){
		var change_player_list=set_change_player().split("_");
		var pitcher_message="투수 "+"<?=$this->input->get("pitcher_name")?>"+" -> ";
		var batter_message="타자 "+"<?=$this->input->get("batter_name")?>"+" -> ";
		var FR_message="1루 주자 "+"<?=$this->input->get("fbr_name")?>"+" -> ";
		var SR_message="2루 주자 "+"<?=$this->input->get("sbr_name")?>"+" -> ";
		var TR_message="3루 주자 "+"<?=$this->input->get("tbr_name")?>"+" -> ";
		var LF_message="좌익수 "+LF_name+" -> ";
		var CF_message="중견수 "+CF_name+" -> ";
		var RF_message="우익수 "+RF_name+" -> ";
		var TB_message="3루수 "+TB_name+" -> ";
		var SS_message="유격수 "+SS_name+" -> ";
		var SB_message="2루수 "+SB_name+" -> ";
		var FB_message="1루수 "+FB_name+" -> ";
		var C_message="포수 "+C_name+" -> ";
		var DH_message="지명타자 "+DH_name+" -> ";
		var batter=change_player_list[0].split(";");
		var defender=change_player_list[1].split(";");
		
		for(var j=0; j < batter.length; j++){
			if(batter[j]!=""){
				var array_=batter[j].split("::");
				
				if(array_[0]=="타자") message=message+"<p class='bold blue'>"+batter_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="1루") message=message+"<p class='bold red'>"+FR_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="2루") message=message+"<p class='bold red'>"+SR_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="3루") message=message+"<p class='bold red'>"+TR_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="투수") message=message+"<p class='bold green'>"+pitcher_message+array_[1]+"(으)로 교체</p>";
			}
		}
		for(var jj=0; jj<defender.length; jj++){
			if(defender[jj]!=""){
				var array_=defender[jj].split("::");
				var before_job='';
				var defenders_old='<?=$this->input->get("defenders");?>';
				var defenders_old_splitted=defenders_old.split(';');
				for(var zz=0; zz<defenders_old_splitted.length; zz++){
					var splitted=defenders_old_splitted[zz].split('_');
					if(splitted[1]==array_[1]){
						if(splitted[0]=="좌") before_job="좌익수 "+array_[1]+" -> ";
						else if(splitted[0]=="중") before_job="중견수 "+array_[1]+" -> ";
						else if(splitted[0]=="우") before_job="우익수 "+array_[1]+" -> ";
						else if(splitted[0]=="1") before_job="1루수 "+array_[1]+" -> ";
						else if(splitted[0]=="2") before_job="2루수 "+array_[1]+" -> ";
						else if(splitted[0]=="3") before_job="3루수 "+array_[1]+" -> ";
						else if(splitted[0]=="유") before_job="유격수 "+array_[1]+" -> ";
						else if(splitted[0]=="포") before_job="포수 "+array_[1]+" -> ";
						else if(splitted[0]=="지") before_job="지명타자 "+array_[1]+" -> ";
						else if(splitted[0]=="대타자") before_job="대타자 "+array_[1]+" -> ";
						else if(splitted[0]=="대주자") before_job="대주자 "+array_[1]+" -> ";
					}
				}
				
				if(array_[0]=="좌") message=message+"<p class='bold'>"+LF_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="중") message=message+"<p class='bold'>"+CF_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="우") message=message+"<p class='bold'>"+RF_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="1") message=message+"<p class='bold'>"+FB_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="2") message=message+"<p class='bold'>"+SB_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="3") message=message+"<p class='bold'>"+TB_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="유") message=message+"<p class='bold'>"+SS_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="포") message=message+"<p class='bold'>"+C_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="지") message=message+"<p class='bold'>"+DH_message+array_[1]+"(으)로 교체</p>";
				else if(array_[0]=="좌in") message=message+"<p class='bold'>"+before_job+"좌익수로 수비 위치 변경</p>";
				else if(array_[0]=="중in") message=message+"<p class='bold'>"+before_job+"중견수로 수비 위치 변경</p>";
				else if(array_[0]=="우in") message=message+"<p class='bold'>"+before_job+"우익수로 수비 위치 변경</p>";
				else if(array_[0]=="1in") message=message+"<p class='bold'>"+before_job+"1루수로 수비 위치 변경</p>";
				else if(array_[0]=="2in") message=message+"<p class='bold'>"+before_job+"2루수로 수비 위치 변경</p>";
				else if(array_[0]=="3in") message=message+"<p class='bold'>"+before_job+"3루수로 수비 위치 변경</p>";
				else if(array_[0]=="유in") message=message+"<p class='bold'>"+before_job+"유격수로 수비 위치 변경</p>";
				else if(array_[0]=="포in") message=message+"<p class='bold'>"+before_job+"포수로 수비 위치 변경</p>";
				else if(array_[0]=="지in") message=message+"<p class='bold'>"+before_job+"지명타자로 변경</p>";
			}
		}
		/* 변경사항이 없을 때 */
		if(change_player_list[0]==";;;;;;;;;" && change_player_list[1]==";;;;;;;;;"){
			location.href=("/baseball/game/<?=$date?>/<?=$game_no?>/<?=$inning?>");
		/* 변경사항이 있을 때 */
		}else{
			<?php $home_pitcher_num='';
				if(isset($home_line_major)){
					foreach($home_line_major as $entry){
						if($entry->subi == null) $home_pitcher_num=$entry->player;
				}}
				$away_pitcher_num='';
				if(isset($away_line_major)){
					foreach($away_line_major as $entry){
						if($entry->subi == null) $away_pitcher_num=$entry->player;
				}}?>
			/* 전반 */
			if("<?=$this->input->get('half')?>"=="1"){
				/* 홈팀 투수 변경이 있을 때 */
				if($("#selection2>li>.num").text()!="<?=$home_pitcher_num?>"){
					var pitch_=("<?=$this->input->get('half')?>"=="1") ? "<?=$this->input->get('pitch')?>"+";"+"0" : "0"+";"+"<?=$this->input->get('pitch')?>";
					var so_=("<?=$this->input->get('half')?>"=="1") ? "<?=$this->input->get('so')?>"+";"+"0" : "0"+";"+"<?=$this->input->get('so')?>";
					set_cookie("pitching_num", 1, false);
					$.ajax({
						type:'POST',
						url:'/baseball/update_pitching_ajax',
						data:{game_no:"<?=$game_no?>", pitch:pitch_, so:so_},
						complete:function(){
							$.ajax({
								url:'/baseball/line_up',
								type:'POST',
						        data:{token:lineup_token},
						        complete:function(){
									go_to_game(message);
						        }
							});
						}
					});
				/* 홈팀 투수 변경이 없을 때 */
				}else{
					$.ajax({
						url:'/baseball/line_up',
						type:'POST',
				        data:{token:lineup_token},
				        complete:function(){
							go_to_game(message);
				        }
					});
				}
			/* 후반 */
			}else{
				/* 원정팀 투수 변경이 있을 때 */
				if($("#selection4>li>.num").text()!="<?=$away_pitcher_num?>"){
					var pitch_=("<?=$this->input->get('half')?>"=="1") ? "<?=$this->input->get('pitch')?>"+";"+"0" : "0"+";"+"<?=$this->input->get('pitch')?>";
					var so_=("<?=$this->input->get('half')?>"=="1") ? "<?=$this->input->get('so')?>"+";"+"0" : "0"+";"+"<?=$this->input->get('so')?>";
					set_cookie("pitching_num", 1, false);
					$.ajax({
						type:'POST',
						url:'/baseball/update_pitching_ajax',
						data:{game_no:"<?=$game_no?>", pitch:pitch_, so:so_},
						complete:function(){
							$.ajax({
								url:'/baseball/line_up',
								type:'POST',
						        data:{token:lineup_token},
						        complete:function(){
									go_to_game(message);
						        }
							});
						}
					});
				/* 원정팀 투수 변경이 없을 때 */
				}else{
					$.ajax({
						url:'/baseball/line_up',
						type:'POST',
				        data:{token:lineup_token},
				        complete:function(){
							go_to_game(message);
				        }
					});
				}
			}
		}
	/* 게임시작 전 */
	}else{
		var away_starter=$('#selection4 li .name').text();
		var home_starter=$('#selection2 li .name').text();

		$.ajax({
			url:'/baseball/line_up',
			type:'POST',
	        data:{token:lineup_token, away_starter:away_starter, home_starter:home_starter, game_no:<?=$game_no;?>},
	        complete:function(){
	        	go_to_game("");
	        }
		});
	}
}

function go_to_game(message){
	if(message!=""){
		inning="<?=$inning?>;<?=$this->input->get('half')*1-1?>";
		pitcher="투";
		batter="<?=$this->input->get('batter_no')?>";
		$.ajax({
			type:'POST',
			dataType:'text',
			url:'/baseball/message_send',
			data:{schedule_no:"<?=$game_no?>", inning:inning, pitcher:pitcher, batter:batter, message1:message},
			complete:function(){
				location.replace("/baseball/game/<?=$date?>/<?=$game_no?>/<?=$inning?>");
			}
		});
	}else location.replace("/baseball/game/<?=$date?>/<?=$game_no?>/<?=$inning?>");
}

function set_change_player(){
	var change_player="";
	var home_batter="<?=$this->input->get('home')?>".split(";");
	var away_batter="<?=$this->input->get('away')?>".split(";");
	var defenders="<?=$this->input->get("defenders");?>".split(";");
	var home_away_batter=("<?=$this->input->get('half')?>"=="2") ? home_batter : away_batter;
	var home_away_batter_reverse=("<?=$this->input->get('half')?>"=="2") ? away_batter : home_batter;
	var selection_1or3=("<?=$this->input->get('half')?>"=="2") ? '#selection1>li>.name' : '#selection3>li>.name';
	var selection_2or4=("<?=$this->input->get('half')?>"=="2") ? '#selection4>li>.name' : '#selection2>li>.name';
	var selection_3or1=("<?=$this->input->get('half')?>"=="2") ? '#selection3>li>.name' : '#selection1>li>.name';
	var selection_3or1_p=("<?=$this->input->get('half')?>"=="2") ? "#selection3>li>.position>p" : "#selection1>li>.position>p";
	var home_away=("<?=$this->input->get('half')?>"=="2") ? 'home' : 'away';
	var home_away_reverse=("<?=$this->input->get('half')?>"=="2") ? 'home' : 'away';

	/* 공격팀 타자 변경 확인 */
	for(var ii=0; ii<home_away_batter.length-1; ii++){
		if(home_away_batter[ii]!=$(selection_1or3)[ii].innerText) change_player=change_player+$("#"+home_away+"_batter_no > li")[ii].innerText+"::"+$(selection_1or3)[ii].innerText;
		change_player=change_player+";";
	}
	/* 수비팀 투수 변경 확인 */
	if($(selection_2or4)[0].innerText!=home_away_batter[9]) change_player=change_player+$("#"+home_away_reverse+"_pitcher")[0].innerText+"::"+$(selection_2or4)[0].innerText;
	change_player=change_player+"_";
	/* 수비팀 수비 변경 확인 */
	for(var ii = 0; ii < home_away_batter_reverse.length-1; ii++){
		var value=defenders[ii].split("_");
		if(home_away_batter_reverse[ii]!=$(selection_3or1)[ii].innerText) change_player=change_player+$(selection_3or1_p)[ii].innerText+"::"+$(selection_3or1)[ii].innerText;
		else if(value[0]!=$(selection_3or1_p)[ii].innerText) change_player=change_player+$(selection_3or1_p)[ii].innerText+"in::"+$(selection_3or1)[ii].innerText;
		change_player=change_player+";";
	}

	/* -------------------------------- 선발 라인업 저장::170614_updated START -------------------------------- */
    var inning='<?=$this->input->get('inning');?>'.split(';');
    var splitted_change_player=change_player.split('_');
    var spl_home_player=(inning[1]==0)? splitted_change_player[1].split(';') : splitted_change_player[0].split(';');
    var spl_away_player=(inning[1]==0)? splitted_change_player[0].split(';') : splitted_change_player[1].split(';');
    var result_set='';
    var away_pitcher_str='';
    var home_pitcher_str='';
    for(var i=0; i<spl_home_player.length; i++){
        if(spl_home_player[i]!=''){
            var name = spl_home_player[i].split('::');

            if(name[0]=='투수'){
                var str='투;'+$('#selection4 > li > .name')[0].innerText+';'+$('#selection4 > li > .num')[0].innerText;
                away_pitcher_str=str;
            }else{
                for(var j=0; j<9; j++){
                    if(name[1] == $('#selection1 > li > .name')[j].innerText){
                        var str=(j+1)+';'+$('#selection1 > li > .name')[j].innerText+';'+$('#selection1 > li > .position')[j].innerText;
                        result_set=result_set+str+'_';
                    }
                }
            }
        }
    }
    result_set=result_set.slice(0,-1);
    result_set=result_set+',';
    for(var i=0; i<spl_away_player.length; i++){
        if(spl_away_player[i]!=''){
            var name=spl_away_player[i].split('::');

            if(name[0]=='투수'){
                var str='투;'+$('#selection2 > li > .name')[0].innerText+';'+$('#selection2 > li > .num')[0].innerText;
                home_pitcher_str=str;
            }else{
                for(var j=0; j<9; j++){
                    if(name[1] == $('#selection3 > li > .name')[j].innerText){
                        var str=(j+1)+';'+$('#selection3 > li > .name')[j].innerText+';'+$('#selection3 > li > .position')[j].innerText;
                        result_set=result_set+str+'_';
                    }
                }
            }
        }
    }
    result_set=result_set+away_pitcher_str;
    if(home_pitcher_str!=''){
        var piece=result_set.split(',');
        result_set=piece[0]+'_'+home_pitcher_str+','+piece[1];
    }
    $.ajax({
        type:'POST',
        url:'/baseball/set_line_up_record_ajax',
        data:{change_player:result_set, schedule_no:<?=$game_no?>}
    });
    /* -------------------------------- 선발 라인업 저장::170614_updated END -------------------------------- */

	return change_player;
}

/* 관전모드 게임 시작 여부 체크 및 컨펌 */
function is_game(no){
	var result="";
	
	$.ajax({
		type:'POST',
		url:'/baseball/is_game_ajax',
        data:{game_no:no},
        success:function(data){
        	result=data;
	    },
	    complete:function(){
	    	(result=="1") ? location.replace("/message_/playball/<?=$date?>/"+no+"/0") : alert("게임 시작 전 입니다.");
	    }
	});
}

function set_cookie(_kindof, _num, flag){
	$.ajax({
		type:'POST',
		url:'/baseball/set_cookie_ajax',
        data:{kindof:_kindof, num:_num}
	});
}

</script>
</body>
</html>