<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset-utf-8"/>
    <title> ODDS CONNECT - DataMining </title>
    <link href="/public/lib/volley.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="/public/lib/js/jquery-1.12.4.js"></script>
    <script src="/public/lib/js/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        let prototype=event_obj.prototype;
        let prototype_player=player_obj.prototype;

        /* OBJECT */
        function event_obj() {
            let schedule_no=<?=$schedule->no;?>;
            let set=0;
            let score_no=0;
            let rallying_no=0;
            let message='';
            let delete_yn='N';
            let attack_side='';
            let command='';
            let combo='';
            let type='';
            let home_score='';
            let away_score='';
            let point_str='';
            let focus='false';
        }

        function player_obj() {
            let hm='';
            let hml='';
            let hb='';
            let am='';
            let aml='';
            let ab='';
        }
    </script>
</head>
<body>
<div class="wrap">
    <div class="input">
        <div class="date start">
            <p><span><?=date('Y. m. d', strtotime(date($schedule->date)));?></span><span><?=date('H:i', strtotime(date($schedule->time)));?></span><span><?=$schedule->stadium;?></span><span class="time"></span></p>
            <p>
                <span>기록자 : <?=$session['nickname'];?></span>
                <a href="javascript:game_start();"><?php if($status=='begin') echo '선공선택'; elseif($status=='ing') echo '경기 중'; elseif($status=='ready') echo '경기 시작'; else echo '경기종료';?><span></span></a>
            </p>
        </div>
        <div class="clear"></div>
        <table class="input_table01">
            <caption></caption>
            <colgroup>
                <col width="140px"/><col width=""/><col width=""/><col width=""/><col width=""/><col width=""/><col width="100px"/><col width="140px"/>
            </colgroup>
            <tr>
                <th>팀명</th>
                <?php for($i=1; $i<6; $i++): ?>
                    <?php if($i <= $last_set): ?>
                        <th <?php if($set==$i) echo 'class="ing"';?>><a href="/volleyball/input_test/<?=$schedule->no;?>/<?=$i;?>?team_side=<?=$team_side;?>"><?=$i;?>SET</a></th>
                    <?php else: ?>
                        <th <?php if($set==$i) echo 'class="ing"';?>><a href="javascript:void(0);"><?=$i;?>SET</a></th>
                    <?php endif; ?>
                <?php endfor; ?>
                <th>TOTAL</th>
                <th>SET</th>
            </tr>
            <?php $home_total=0; $away_total=0; ?>
            <tr>
                <td><?=$schedule->home;?></td>
                <?php for($i=0; $i<sizeof($score); $i++): ?><td id="home_<?=$i+1;?>"><?=$score[$i]->home_score; $home_total+=$score[$i]->home_score?></td><?php endfor; ?>
                <?php for($i=0; $i<5-sizeof($score); $i++): ?><td id="home_<?=sizeof($score)+$i+1;?>"></td><?php endfor; ?>
                <td id="home_total"><?=$home_total;?></td>
                <td id="home_set_score"><span class="red"><?=$schedule->home_score;?></span></td>
            </tr>
            <tr>
                <td><?=$schedule->away;?></td>
                <?php for($i=0; $i<sizeof($score); $i++): ?><td id="away_<?=$i+1;?>"><?=$score[$i]->away_score; $away_total+=$score[$i]->away_score?></td><?php endfor; ?>
                <?php for($i=0; $i<5-sizeof($score); $i++): ?><td id="away_<?=sizeof($score)+$i+1;?>"></td><?php endfor; ?>
                <td id="away_total"><?=$away_total;?></td>
                <td id="away_set_score"><span class="red"><?=$schedule->away_score;?></span></td>
            </tr>
        </table>

        <div class="player_w">
            <div class="team1">
                <h3  style="<?=($team_side=='typeA')? 'background: #9D1E25' : 'background: #313D56';?>"><?php if($team_side=='typeA'): ?><?=$schedule->home;?><?php else: ?><?=$schedule->away;?><?php endif;?></h3>
                <div class="table02">
                    <ul>
                        <?php if($team_side=='typeA'): ?>
                            <?php foreach($line_up['hm'] as $item): ?>
                                <?php if($item->position!='LIBERO'): ?>
                                    <li class="hm" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'home', 'out')" style="box-sizing:border-box;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px;text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($line_up['am'] as $item): ?>
                                <?php if($item->position!='LIBERO'): ?>
                                    <li class="am" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'away', 'out')" style="box-sizing:border-box;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px;text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="">
                <h3 style="<?=($team_side=='typeA')? 'background: #313D56' : 'background: #9D1E25';?>"><?php if($team_side=='typeA'): ?><?=$schedule->away;?><?php else: ?><?=$schedule->home;?><?php endif;?></h3>
                <div class="table02">
                    <ul>
                        <?php if($team_side=='typeA'): ?>
                            <?php foreach($line_up['am'] as $item): ?>
                                <?php if($item->position!='LIBERO'): ?>
                                    <li class="am" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'away', 'out')" style="box-sizing:border-box;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left: 80px; text-align: left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($line_up['hm'] as $item): ?>
                                <?php if($item->position!='LIBERO'): ?>
                                    <li class="hm" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'home', 'out')" style="box-sizing:border-box;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px;text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="team1" style="box-sizing:border-box;margin-top:5px;height:38px;">
                <div class="table02">
                    <ul style="height:36px;">
                        <?php if($team_side=='typeA'): ?>
                            <?php foreach($line_up['hm'] as $item): ?>
                                <?php if($item->position=='LIBERO'): ?>
                                    <li class="hml" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'home', 'out');" style="background-color:white;color:black;text-align:left;line-height:38px;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px; text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($line_up['am'] as $item): ?>
                                <?php if($item->position=='LIBERO'): ?>
                                    <li class="aml" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'away', 'out')" style="background-color:white;color:black;text-align:left;line-height:38px;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px;text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="" style="box-sizing:border-box;margin-top:5px;height:38px;">
                <div class="table02">
                    <ul style="height:36px;">
                        <?php if($team_side=='typeA'): ?>
                            <?php foreach($line_up['am'] as $item): ?>
                                <?php if($item->position=='LIBERO'): ?>
                                    <li class="aml" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'away', 'out');" style="background-color:white;color:black;text-align:left;line-height:38px;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px;text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($line_up['hm'] as $item): ?>
                                <?php if($item->position=='LIBERO'): ?>
                                    <li class="hml" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'home', 'out');" style="background-color:white;color:black;text-align:left;line-height:38px;"><span class="pp"><?=$item->name;?></span><span><?=$item->shirt_number;?></span><span style="margin-left:80px;text-align:left;"><?=$item->position;?></span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="team1" style="margin-top: 5px; background-color:rgb(216,216,216);">
                <div class="table01">
                    <ul>
                        <?php if($team_side=='typeA'): ?>
                            <?php foreach($line_up['hb'] as $item): ?>
                                <li class="hb" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'home', 'in');"><span class="pp"><?=$item->name;?></span><span style="margin-left: 20px;"><?=$item->shirt_number;?></span><span style="margin-left: 80px; text-align: left;"><?=$item->position;?></span></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($line_up['ab'] as $item): ?>
                                <li class="ab" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'away', 'in');"><span class="pp"><?=$item->name;?></span><span style="margin-left: 20px;"><?=$item->shirt_number;?></span><span style="margin-left: 80px; text-align: left;"><?=$item->position;?></span></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <div class="" style="margin-top: 5px; background-color:rgb(216,216,216);">
                <div class="table01">
                    <ul>
                        <?php if($team_side=='typeA'): ?>
                            <?php foreach($line_up['ab'] as $item): ?>
                                <li class="ab" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'away', 'in');"><span class="pp"><?=$item->name;?></span><span style="margin-left: 20px;"><?=$item->shirt_number;?></span><span style="margin-left: 80px; text-align: left;"><?=$item->position;?></span></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach($line_up['hb'] as $item): ?>
                                <li class="hb" id="<?=$item->id;?>" value="<?=$item->no;?>" onclick="change_player(this, 'home', 'in');"><span class="pp"><?=$item->name;?></span><span style="margin-left: 20px;"><?=$item->shirt_number;?></span><span style="margin-left: 80px; text-align: left;"><?=$item->position;?></span></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
        <?php if($team_side=='typeA'): ?>
            <img src="/public/lib/volleyball_image/left_side_home.png" width="387px" style="margin-top:7px;box-sizing:border-box;border:1px solid #4f5a63;<?php if($attack_side=='home') echo 'filter:none;';?>" class="home_side" onclick="attack_side_click(this);">
            <img src="/public/lib/volleyball_image/right_side_away.png" width="386px" style="margin-top:7px;box-sizing:border-box;border:1px solid #4f5a63;margin-left:2px;<?php if($attack_side=='away') echo 'filter:none;';?>" class="away_side" onclick="attack_side_click(this);">
        <?php else: ?>
            <img src="/public/lib/volleyball_image/left_side_away.png" width="387px" style="margin-top:7px;box-sizing:border-box;border:1px solid #4f5a63;<?php if($attack_side=='home') echo 'filter:none;';?>" class="away_side" onclick="attack_side_click(this);">
            <img src="/public/lib/volleyball_image/right_side_home.png" width="386px" style="margin-top:7px;box-sizing:border-box;border:1px solid #4f5a63;margin-left:2px;<?php if($attack_side=='away') echo 'filter:none;';?>" class="home_side" onclick="attack_side_click(this);">
        <?php endif;?>
        <span style="position:absolute;left:600px;top:300px;<?=($status=='set')? 'display:inline':'display:none;';?>" id="vic_pic"><h2 style="position:absolute;left:200px;top:800px;color:white;font-size:300%;" id="home_word">경기 끝</h2><img src="/public/lib/volleyball_image/victory.png" width="386px"><button style="position:absolute;" onclick="document.getElementById('vic_pic').style.display='none';"> 닫기 </button></span>

        <iframe src="http://www.kovo.co.kr/main.asp" width="777" height="580" style="display:none;position:absolute;left:30px;top:175px;background-color:white;" frameborder='1' scrolling="yes" id="frame"></iframe>
        <div style="display:none;position:absolute;left:30px;top:518px;background-color:white;width:386px;height:233px;border:1px solid black;background-image:url(/public/lib/volleyball_image/simpan.png);background-size:contain;" id="challenge">
            <div style="margin:5%;">
                <p style="color:white;">MESSAGE</p>
                <select id="challenging">
                    <option>라인 인 or 아웃 관련 챌린지 요청</option>
                    <option>블로킹 성공 or 실패 관련 챌린지 요청</option>
                    <option>네트 관련 챌린지 요청</option>
                    <option>라인침범 관련 챌린지 요청</option>홈
                    <option>리베로 관련 챌린지 요청</option>
                </select>
                <button onclick="challenging_setter();">입력</button><br>
                <select id="challenge_result">
                    <option>챌린지 성공</option>
                    <option>챌린지 실패</option>
                </select>
                <button onclick="challenge_result_setter();">입력</button>
            </div>
            <div style="margin: 5%;">
                <p style="color:white;">SCORE</p>
                <input type="text" value="<?=(sizeof($message)==0)? '' : $message[0]->home_score;?>" size="3" id="home_score_edit">
                <input type="text" value="<?=(sizeof($message)==0)? '' : $message[0]->away_score;?>" size="3" id="away_score_edit">
                <button onclick="edit_score();">입력</button>
            </div>
        </div>

        <!-- 홈 선수교체 OUT -->
        <div id="home_players_out" style="display:none;position:absolute;left:<?=($team_side=='typeA')?'423':'31';?>px;top:241px;background-color:white;width:385px;height:227px;border:1px solid black;background-size:contain;background-repeat:no-repeat;background-position:right;">
            <div style="padding:3%;">
                <h2>OUT</h2><br>
                <p>이름 : <span id="home_out_name"></span></p>
                <p>선수번호 : <span id="home_out_id"></span></p>
                <p>등번호 : <span id="home_out_shirt_number"></span></p>
                <p>포지션 : <span id="home_out_position"></span></p>
                <p>생년월일 : <span id="home_out_birth"></span></p>
                <p>몸무게 : <span id="home_out_weight"></span>kg</p>
                <p>키 : <span id="home_out_height"></span>cm</p>
                <p>서전트점프 : <span id="home_out_sargent"></span>cm</p>
                <p>경력 : <span id="home_out_begin_year"></span></p>
                <p>국적 : <span id="home_out_country"></span></p>
                <span style="position:absolute;top:10px;right:10px;"><button onclick="close_this_box(this, 'hm');"> 닫기 </button></span>
            </div>
        </div>
        <!-- 홈 선수교체 BUTTON -->
        <div id="home_player_change_button" style="display:none;">
            <a style="position:absolute;left:<?=($team_side=='typeA')?'423':'30';?>px;top:475px;background-color:#FAF4C0;width:192.5px;height:26px;border:1px solid black;text-align:center;font-size:16pt;padding-top:10px;" href="javascript:player_change('home');">선수 교체</a>
            <a style="position:absolute;left:<?=($team_side=='typeA')?'615':'223';?>px;top:475px;background-color:#FAF4C0;width:192.5px;height:26px;border:1px solid black;text-align:center;font-size:16pt;padding-top:10px;" href="javascript:player_change_cancel();">취소</a>
        </div>
        <!-- 홈 선수교체 IN -->
        <div id="home_players_in" style="display:none;position:absolute;left:<?=($team_side=='typeA')?'423':'31';?>px;top:518px;background-color:white;width:385px;height:234px;border:1px solid black;background-size:contain;background-repeat:no-repeat;background-position:right;">
            <div style="padding:3%;">
                <h2>IN</h2><br>
                <p>이름 : <span id="home_in_name"></span></p>
                <p>선수번호 : <span id="home_in_id"></span></p>
                <p>등번호 : <span id="home_in_shirt_number"></span></p>
                <p>포지션 : <span id="home_in_position"></span></p>
                <p>생년월일 : <span id="home_in_birth"></span></p>
                <p>몸무게 : <span id="home_in_weight"></span></p>
                <p>키 : <span id="home_in_height"></span></p>
                <p>서전트점프 : <span id="home_in_sargent"></span></p>
                <p>경력 : <span id="home_in_begin_year"></span></p>
                <p>국적 : <span id="home_in_country"></span></p>
                <span style="position:absolute;top:10px;right:10px;"><button onclick="close_this_box(this, 'hb');"> 닫기 </button></span>
            </div>
        </div>

        <!-- 원정 선수교체 OUT -->
        <div id="away_players_out" style="display:none;position:absolute;left:<?=($team_side=='typeA')?'31':'423';?>px;top:241px;background-color:white;width:385px;height:227px;border:1px solid black;background-size:contain;background-repeat:no-repeat;background-position:right;">
            <div style="padding:3%;">
                <h2>OUT</h2><br>
                <p>이름 : <span id="away_out_name"></span></p>
                <p>선수번호 : <span id="away_out_id"></span></p>
                <p>등번호 : <span id="away_out_shirt_number"></span></p>
                <p>포지션 : <span id="away_out_position"></span></p>
                <p>생년월일 : <span id="away_out_birth"></span></p>
                <p>몸무게 : <span id="away_out_weight"></span>kg</p>
                <p>키 : <span id="away_out_height"></span>cm</p>
                <p>서전트점프 : <span id="away_out_sargent"></span>cm</p>
                <p>경력 : <span id="away_out_begin_year"></span></p>
                <p>국적 : <span id="away_out_country"></span></p>
                <span style="position:absolute;top:10px;right:10px;"><button onclick="close_this_box(this, 'am');"> 닫기 </button></span>
            </div>
        </div>
        <!-- 원정 선수교체 BUTTON -->
        <div id="away_player_change_button" style="display:none;">
            <a style="position:absolute;left:<?=($team_side=='typeA')?'30':'423';?>px;top:475px;background-color:#FAF4C0;width:192.5px;height:26px;border:1px solid black;text-align:center;font-size:16pt;padding-top:10px;" href="javascript:player_change('away');">선수 교체</a>
            <a style="position:absolute;left:<?=($team_side=='typeA')?'223':'615';?>px;top:475px;background-color:#FAF4C0;width:192.5px;height:26px;border:1px solid black;text-align:center;font-size:16pt;padding-top:10px;" href="javascript:player_change_cancel();">취소</a>
        </div>
        <!-- 원정 선수교체 IN -->
        <div id="away_players_in" style="display:none;position:absolute;left:<?=($team_side=='typeA')?'31':'423';?>px;top:518px;background-color:white;width:385px;height:234px;border:1px solid black;background-size:contain;background-repeat:no-repeat;background-position:right;">
            <div style="padding:3%;">
                <h2>IN</h2><br>
                <p>이름 : <span id="away_in_name"></span></p>
                <p>선수번호 : <span id="away_in_id"></span></p>
                <p>등번호 : <span id="away_in_shirt_number"></span></p>
                <p>포지션 : <span id="away_in_position"></span></p>
                <p>생년월일 : <span id="away_in_birth"></span></p>
                <p>몸무게 : <span id="away_in_weight"></span></p>
                <p>키 : <span id="away_in_height"></span></p>
                <p>서전트점프 : <span id="away_in_sargent"></span></p>
                <p>경력 : <span id="away_in_begin_year"></span></p>
                <p>국적 : <span id="away_in_country"></span></p>
                <span style="position:absolute;top:10px;right:10px;"><button onclick="close_this_box(this, 'ab');"> 닫기 </button></span>
            </div>
        </div>
    </div>

    <div class="click input_right">
        <div class="view_w">
            <div class="title">
                <p class="home">HOME : <?=$schedule->home;?></p>
                <p class="qt"><?=$set;?>세트</p>
                <p class="away">AWAY : <?=$schedule->away;?></p>
            </div>
            <ul class="view">
                <?php foreach($message as $item): ?>
                    <li onclick="edit_event(this);" id="<?=$item->no;?>">
                        <?php if($item->attack_side=='home'): ?>
                            <p class="home"><b><?=$item->message;?></b></p>
                            <p class="qt"><?php if($item->point_str!='') echo '<span class="'.$item->point_str.'">';?><?=$item->home_score;?>:<?=$item->away_score;?><?php if($item->point_str!='') echo '</span>';?></p>
                            <p class="away"><b><?php if($item->message=='터치 아웃' || $item->message=='벌칙' || $item->message=='범실' || $item->message=='서브 실패' || $item->message=='블로킹 실패' || $item->message=='리시브 실패' || $item->message=='공격 실패' || $item->message=='디그 실패') echo '득점 성공';?></b></p>
                        <?php elseif($item->attack_side=='away'): ?>
                            <p class="home"><b><?php if($item->message=='터치 아웃' || $item->message=='벌칙' || $item->message=='범실' || $item->message=='서브 실패' || $item->message=='블로킹 실패' || $item->message=='리시브 실패' || $item->message=='공격 실패' || $item->message=='디그 실패') echo '득점 성공';?></b></p>
                            <p class="qt"><?php if($item->point_str!='') echo '<span class="'.$item->point_str.'">';?><?=$item->home_score;?>:<?=$item->away_score;?><?php if($item->point_str!='') echo '</span>';?></p>
                            <p class="away"><b><?=$item->message;?></b></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>

        <div class="command">
            <p>커맨드</p>
            <div><span></span></div>
            <a href="javascript:run_keymap(27);" class="not">입력 취소<span></span></a>
            <a href="javascript:run_keymap(32);" class="apply">전 송<span></span></a>
        </div>
        <div class="gbox">
            <a href="javascript:run_keymap(65);" class="btn1">공격 <span>(A)</span></a>
            <a href="javascript:run_keymap(83);" class="btn3">서브 <span>(S)</span></a>
            <a href="javascript:run_keymap(82);" class="btn3 ">리시브 <span>(R)</span></a>
            <a href="javascript:run_keymap(68);" class="btn3 mr0">디그 <span>(D)</span></a>
            <a href="javascript:run_keymap(66);" class="btn3">블로킹 <span>(B)</span></a>
            <a href="javascript:run_keymap(84);" class="btn3 ">터치아웃 <span>(T)</span></a>
            <a href="javascript:run_keymap(86);" class="btn3 mr0">리바운드 <span>(V)</span></a>
            <a href="javascript:run_keymap(90);" class="btn1">성공 <span>(Z)</span></a>
            <span class="clear"></span>
        </div>
        <div class="gbox">
            <a href="javascript:run_keymap(81);" class="btn2">안정 <span>(Q)</span></a>
            <a href="javascript:run_keymap(87);" class="btn2 mr0">불안 <span>(W)</span></a>
            <a href="javascript:run_keymap(69);" class="btn2">타임 <span>(E)</span></a>
            <a href="javascript:run_keymap(71);" class="btn2 mr0">벌칙 <span>(G)</span></a>
            <a href="javascript:run_keymap(67);" class="btn2">챌린지 <span>(C)</span></a>
            <a href="javascript:run_keymap(70);" class="btn2 mr0">범실 <span>(F)</span></a>
            <a href="javascript:run_keymap(88);" class="btn1">실패 <span>(X)</span></a>
            <span class="clear"></span>
        </div>
    </div>
</div>
<div id="dialog-confirm" title="이벤트 메세지 수정/삭제" style="display:none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>수정 : 이벤트 메세지를 수정합니다.<br>삭제 : 이벤트 메세지를 삭제합니다.<br>닫기 : 창을 닫습니다.</p>
</div>
<div id="dialog-form" title="메세지 입력 후 변경 버튼을 누르면 메세지가 수정됩니다." style="display:none;">
    <label for="home_score">홈 점수&nbsp;&nbsp;&nbsp; : </label>
    <input type="text" name="home_score" id="home_score" class="text ui-widget-content ui-corner-all" size="3"><br>
    <label for="away_score">원정 점수 : </label>
    <input type="text" name="away_score" id="away_score" class="text ui-widget-content ui-corner-all" size="3"><br>
    <label for="message_edited">메세지 : </label>
    <input type="text" name="message_edited" id="message_edited" class="text ui-widget-content ui-corner-all">
</div>

<script>
    function game_start() {
        prototype.set=<?=$last_set;?>;

        if('<?=$status;?>'==='ready') {
            prototype.command = 'start';
            prototype.message = '경기 시작';
            prototype.schedule_no =<?=$schedule->no;?>;
            prototype.type = 'notice';
            prototype.set = 1;

            $.ajax({
                type:'POST',
                url:'/volleyball/update_ajax',
                data:{table:'test_schedule',schedule_no:<?=$schedule->no;?>,'status':'begin'},
                complete: function() {
                    $.ajax({
                        type: 'POST',
                        url: '/volleyball/insert_test_event_ajax',
                        data: {data: JSON.stringify(prototype)},
                        complete: function() {
                            location.href = "/volleyball/input_test/<?=$schedule->no;?>/<?=$set;?>?team_side=<?=$team_side;?>";
                        }
                    });
                }
            });
        } else if ('<?=$status;?>'==='begin') {
            if(prototype.attack_side==undefined) prototype.attack_side='home';
            else if(prototype.attack_side==='home') prototype.attack_side='away';
            else if(prototype.attack_side==='away') prototype.attack_side='home';

            side_sign_changer();
        } else if ('<?=$status;?>'==='set') {
        } else {
            if('<?=$team_side;?>'==='typeA') location.href='/volleyball/input_test/<?=$schedule->no;?>/<?=$set;?>?team_side=typeB';
            else location.href='/volleyball/input_test/<?=$schedule->no;?>/<?=$set;?>?team_side=typeA';
        }
    }

    function show_i_frame() {
        if(document.getElementById('frame').style.display=='none') document.getElementById('frame').style.display='inline';
        else document.getElementById('frame').style.display='none';
    }

    function send_ajax(segment, data, bool) {
        let id=0;

        $.ajax({
            type:'POST',
            url:'/volleyball/'+segment,
            data:{data:data},
            success: function(d) {
                if(bool) id=d;
            },
            complete: function() {
                if(bool==='re') location.reload();
                else if(bool) document.getElementsByClassName('view')[0].children[0].id=id;
            }
        });
    }

    function update_ajax(table, schedule_no, status, boolean) {
        $.ajax({
            type:'POST',
            url:'/volleyball/update_ajax',
            data:{table:table,schedule_no:schedule_no,'status':status},
            complete: function() {
                if(boolean) location.reload();
            }
        });
    }

    function run_keymap(e) {
        if('<?=$status;?>'!=='set') {
            if (e === undefined) {
                if (event.keyCode === 73) show_i_frame();
                else if (event.keyCode === 81 || event.keyCode === 87 || event.keyCode === 88 || event.keyCode === 90) combo_checker(event.keyCode);
                else command_checker(event.keyCode);
            } else {
                if (e === 73) show_i_frame();
                else if (e === 81 || e === 87 || e === 88 || e === 90) combo_checker(e);
                else command_checker(e);
            }
        }
    }

    function command_checker(key_code) {
        let message='';

        switch(key_code) {
//          서브
            case 83 :
                message='서브 시도';
                prototype.command=key_code;
                prototype.combo=0;
                prototype.message='서브 시도';
                prototype.type = 'message';
                prototype.focus = 'T';
                prototype.point_str = '';
                break;
//          공격
            case 65 :
                message='공격 시도';
                prototype.command=key_code;
                prototype.combo=0;
                prototype.message='공격 시도';
                prototype.type = 'message';
                prototype.focus = 'T';
                prototype.point_str = '';
                break;
//          리시브
            case 82 :
                message=(prototype.message==='리시브')? '리시브 볼 넘김':'리시브';
                prototype.command=key_code;
                prototype.combo=0;
                prototype.message=message;
                prototype.type =(prototype.message==='리시브 볼 넘김')? 'message':'yet';
                prototype.focus =(prototype.message==='리시브 볼 넘김')? 'T':'F';
                prototype.point_str = '';
                break;
//          디그
            case 68 :
                message='디그';
                prototype.command=key_code;
                prototype.combo=0;
                prototype.message='디그';
                prototype.type = 'yet';
                prototype.focus = 'F';
                prototype.point_str = '';
                break;
//          블로킹
            case 66 :
                message='유효 블로킹';
                prototype.command=key_code;
                prototype.combo=0;
                prototype.message='유효 블로킹';
                prototype.type = 'message';
                prototype.focus = 'T';
                prototype.point_str = '';
                break;
//          리바운드
            case 86 :
                message='블로킹 리바운드';
                prototype.command=key_code;
                prototype.combo=1;
                prototype.message='블로킹 리바운드';
                prototype.type = 'message';
                prototype.focus = 'F';
                prototype.point_str = '';
                break;
//          터치 아웃
            case 84 :
                message='터치 아웃';
                prototype.command=key_code;
                prototype.combo=1;
                prototype.message='터치 아웃';
                prototype.type='message';
                prototype.focus='T';
                prototype.point_str = '';
                break;
//          벌칙
            case 71 :
                message='벌칙';
                prototype.command=key_code;
                prototype.combo=1;
                prototype.message='벌칙';
                prototype.focus='T';
                prototype.type='message';
                break;
//          타임
            case 69 :
                message='타임';
                prototype.command=key_code;
                prototype.combo=1;
                prototype.message='타임';
                prototype.type='message';
                prototype.point_str = '';
                break;
//          범실
            case 70 :
                message = '범실';
                prototype.command = key_code;
                prototype.combo = 0;
                prototype.message = '범실';
                prototype.type = 'message';
                prototype.focus='T';
                prototype.point_str = '';
                break;
//          챌린지
            case 67 :
                if(prototype.attack_side==='home') document.getElementById('challenge').style.left='30px';
                else document.getElementById('challenge').style.left='423px';

                if(document.getElementById('challenge').style.display==='none') document.getElementById('challenge').style.display='block';
                else document.getElementById('challenge').style.display='none';
                break;

//          ESC
            case 27 :
                prototype.command = '';
                prototype.message = '';
                document.getElementsByClassName('command')[0].children[1].children[0].textContent='';
                break;
//          SPACE BAR
            case 32 :
                if(validate(prototype)) {
                    prototype.rallying_no++;
                    insert_event(score_changer());
                    send_ajax('insert_test_event_ajax', JSON.stringify(prototype), true);
                    count_reset();
                    set_end_checker();

                    attack_side_changer();
                    side_sign_changer();
                }
                break;
        }

        document.getElementsByClassName('command')[0].children[1].children[0].textContent=message;
        if(prototype.attack_side!=undefined) document.getElementsByClassName('command')[0].children[1].children[0].className=prototype.attack_side;
    }

    function combo_checker(key_code) {
        let message='';

        switch(key_code) {
//          성공
            case 90 :
                if(prototype.command === 83) {
                    message = '서브 득점 성공';
                    prototype.combo = key_code;
                    prototype.message = '서브 득점 성공';
                    prototype.type = 'message';
                    prototype.focus = 'F';
                } else if(prototype.command === 65) {
                    message = '공격 득점 성공';
                    prototype.combo = key_code;
                    prototype.message = '공격 득점 성공';
                    prototype.type = 'message';
                    prototype.focus = 'F';
                } else if(prototype.command === 66) {
                    message = '블로킹 득점 성공';
                    prototype.combo = key_code;
                    prototype.message = '블로킹 득점 성공';
                    prototype.type = 'message';
                    prototype.focus = 'F';
                }
                break;
//          실패
            case 88 :
                if(prototype.command === 83) {
                    message = '서브 실패';
                    prototype.combo = key_code;
                    prototype.message = '서브 실패';
                    prototype.type = 'message';
                } else if(prototype.command === 82) {
                    message = '리시브 실패';
                    prototype.combo = key_code;
                    prototype.message = '리시브 실패';
                    prototype.type = 'message';
                } else if(prototype.command === 68) {
                    message = '디그 실패';
                    prototype.combo = key_code;
                    prototype.message = '디그 실패';
                    prototype.type = 'message';
                } else if(prototype.command === 65) {
                    message = '공격 실패';
                    prototype.combo = key_code;
                    prototype.message = '공격 실패';
                    prototype.type = 'message';
                } else if(prototype.command === 66) {
                    message = '블로킹 실패';
                    prototype.combo = key_code;
                    prototype.message = '블로킹 실패';
                    prototype.type = 'message';
                }
                break;
//          안정
            case 81 :
//              리시브
                if(prototype.command === 82) {
                    message = '리시브 안정';
                    prototype.combo = key_code;
                    prototype.message = '리시브 안정';
                    prototype.type = 'message';
//              디그
                } else if(prototype.command === 68) {
                    message = '디그 안정';
                    prototype.combo = key_code;
                    prototype.message = '디그 안정';
                    prototype.type = 'message';
                }
                break;
//          불안
            case 87 :
//              리시브
                if(prototype.command === 82) {
                    message = '리시브 불안';
                    prototype.combo=key_code;
                    prototype.message='리시브 불안';
                    prototype.type = 'message';
//              디그
                } else if(prototype.command === 68) {
                    message = '디그 불안';
                    prototype.combo = key_code;
                    prototype.message = '디그 불안';
                    prototype.type = 'message';
                }
                break;
        }

        document.getElementsByClassName('command')[0].children[1].children[0].textContent=message;
    }

    function set_end_checker() {
        /* 듀스 체크 */
        let end_num=(<?=$set;?>===5)? 15 : 25;
        let end_num_minus=(<?=$set;?>===5)? 14 : 24;

        if((prototype.home_score > end_num || prototype.away_score > end_num) && (prototype.home_score*1 === prototype.away_score*1+2 || prototype.home_score*1+2 === prototype.away_score*1)) get_reset();
        else if((prototype.home_score == end_num && prototype.away_score < end_num_minus || prototype.away_score == end_num && prototype.home_score < end_num_minus)) get_reset();
    }

    function game_set_checker() {
        let win=(prototype.home_score > prototype.away_score)? 'home':'away' ;
        let home_set_score=document.getElementById('home_set_score').children[0].textContent;
        let away_set_score=document.getElementById('away_set_score').children[0].textContent;

        return ((home_set_score === '2' && win === 'home') || (away_set_score === '2' && win === 'away'));
    }

    function get_reset() {
        let win=(prototype.home_score > prototype.away_score)? 'home':'away' ;
        let win_team=(win==='home')? '<?=$schedule->home;?>':'<?=$schedule->away;?>';
        prototype.message=prototype.set+'세트 종료 '+win_team+' 승';
        prototype.score_no=0;
        prototype.rallying_no=0;
        prototype.home_score=0;
        prototype.away_score=0;
        prototype.command=0;
        prototype.combo=0;
        prototype.type='notice';

        let home_score=(win_team==='<?=$schedule->home;?>')? <?=$schedule->home_score;?>+1:<?=$schedule->home_score;?>;
        let away_score=(win_team==='<?=$schedule->away;?>')? <?=$schedule->away_score;?>+1:<?=$schedule->away_score;?>;

        $.ajax({
            type:'POST',
            url:'/volleyball/insert_test_event_ajax',
            data:{data:JSON.stringify(prototype)},
            complete: function() {
                if(game_set_checker()) {
                    prototype.message='경기 종료';
                } else {
                    prototype.set++;
                    prototype.message=prototype.set+'세트 시작';
                }

                $.ajax({
                    type:'POST',
                    url:'/volleyball/insert_test_event_ajax',
                    data:{data:JSON.stringify(prototype)},
                    complete: function() {
                        $.ajax({
                            type:'POST',
                            url:'/volleyball/update_test_set_score_ajax',
                            data:{schedule_no:<?=$schedule->no;?>,home_score:home_score,away_score:away_score},
                            complete: function() {
                                if(prototype.message!=='경기 종료') location.href="/volleyball/input_test/<?=$schedule->no;?>/<?=$set+1;?>?team_side=<?=$team_side;?>";
                                else {
                                    $.ajax({
                                        type:'POST',
                                        url:'/volleyball/update_ajax',
                                        data:{table:'test_schedule',schedule_no:<?=$schedule->no;?>,'status':'set'},
                                        complete: function() {
                                            let all=[];
                                            let hm=[];
                                            let hb=[];
                                            let am=[];
                                            let ab=[];
                                            let player=[];
                                            for(let i=0; i<6; i++) {
                                                player={'p_no':document.getElementsByClassName('table02')[0].children[0].children[i].value,'name':document.getElementsByClassName('table02')[0].children[0].children[i].children[0].textContent};
                                                hm.push(player);
                                            }
                                            all.push(hm);
                                            hm.push({'p_no':document.getElementsByClassName('table02')[2].children[0].children[0].value,'name':document.getElementsByClassName('table02')[2].children[0].children[0].children[0].textContent});
                                            for(let j=0; j<6; j++) {
                                                player={'p_no':document.getElementsByClassName('table01')[0].children[0].children[j].value,'name':document.getElementsByClassName('table01')[0].children[0].children[j].children[0].textContent};
                                                hb.push(player);
                                            }
                                            all.push(hb);
                                            for(let i=0; i<6; i++) {
                                                player={'p_no':document.getElementsByClassName('table02')[1].children[0].children[i].value,'name':document.getElementsByClassName('table02')[1].children[0].children[i].children[0].textContent};
                                                am.push(player);
                                            }
                                            all.push(am);
                                            am.push({'p_no':document.getElementsByClassName('table02')[3].children[0].children[0].value,'name':document.getElementsByClassName('table02')[3].children[0].children[0].children[0].textContent});
                                            for(let j=0; j<6; j++) {
                                                player={'p_no':document.getElementsByClassName('table01')[0].children[0].children[j].value,'name':document.getElementsByClassName('table01')[0].children[0].children[j].children[0].textContent};
                                                ab.push(player);
                                            }
                                            all.push(ab);

                                            $.ajax({
                                                type:'POST',
                                                url:'/volleyball/insert_or_update_test_ajax',
                                                data:{schedule_no:<?=$schedule->no;?>, data:JSON.stringify(all)},
                                                complete: function() {
                                                    location.reload();
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            }
        });
    }

    function insert_event(str) {
        if('<?=$status;?>'==='begin') update_ajax('test_schedule', <?=$schedule->no;?>, 'ing', true);

        if(prototype.attack_side==='home') {
            home_message='<p class="home"><b>'+prototype.message+'</b></p>';
            away_message=(prototype.message==='터치 아웃' || prototype.message==='벌칙' || prototype.message==='범실' || prototype.message==='서브 실패' || prototype.message==='블로킹 실패' || prototype.message==='리시브 실패' || prototype.message==='공격 실패' || prototype.message==='디그 실패')? '<p class="away"><b>득점 성공</b></p>':'<p class="away"><b></b></p>';
        } else if(prototype.attack_side==='away') {
            home_message=(prototype.message==='터치 아웃' || prototype.message==='벌칙' || prototype.message==='범실' || prototype.message==='서브 실패' || prototype.message==='블로킹 실패' || prototype.message==='리시브 실패' || prototype.message==='공격 실패' || prototype.message==='디그 실패')? '<p class="home"><b>득점 성공</b></p>':'<p class="home"><b></b></p>';
            away_message='<p class="away"><b>'+prototype.message+'</b></p>';
        }
        let score=(str==='')? '<p class="qt">'+prototype.home_score+':'+prototype.away_score+'</p>' : '<p class="qt"><span class="'+str+'">'+prototype.home_score+':'+prototype.away_score+'</span></p>';

//      메세지
        if($('.view > li').length===0) $('.view').append('<li onclick="edit_event(this);">'+home_message+score+away_message+'</li>');
        else $('.view > li').eq(0).before('<li onclick="edit_event(this);">'+home_message+score+away_message+'</li>');

//      전광판
        document.getElementById('home_<?=$last_set;?>').textContent=prototype.home_score;
        document.getElementById('away_<?=$last_set;?>').textContent=prototype.away_score;
    }

    function validate(prototype) {
        let result=true;
        if(prototype.type==='yet') {
            alert('실패/안정/불안 중 하나를 콤보로 입력하세요.');
            result=false;
        } else if(document.getElementsByClassName('command')[0].children[1].children[0].textContent==='') {
            alert('명령어를 입력하세요');
            result=false;
        }

        return result;
    }

    function attack_side_changer() {
        if(prototype.combo===0 || prototype.combo===88 || prototype.command===84 || prototype.command===70 || prototype.command===71) {
            if(prototype.attack_side==='home') prototype.attack_side='away';
            else prototype.attack_side='home';
        }
    }

    function side_sign_changer() {
        if(event_obj.prototype.attack_side==='home') {
            document.getElementsByClassName('home_side')[0].style.filter='none';
            document.getElementsByClassName('away_side')[0].style.filter='grayscale(100%)';
        }else {
            document.getElementsByClassName('home_side')[0].style.filter='grayscale(100%)';
            document.getElementsByClassName('away_side')[0].style.filter='none';
        }
    }

    function attack_side_click(e){
        e.style.filter='none';

        if(e.className==='home_side') prototype.attack_side='home';
        else prototype.attack_side='away';

        side_sign_changer();
    }

    function score_changer() {
        let str='';
//      성공
        if(prototype.combo===90) {
            if(prototype.attack_side==='home') {
                prototype.home_score++;
                document.getElementById('home_total').textContent=document.getElementById('home_total').textContent*1+1;
                prototype.point_str='l_s';
                str = 'l_s';
            } else {
                prototype.away_score++;
                document.getElementById('away_total').textContent=document.getElementById('away_total').textContent*1+1;
                prototype.point_str='r_s';
                str = 'r_s';
            }
//      실패
        } else if(prototype.combo===88 || prototype.command===84 || prototype.command===71 || prototype.command===70) {
            if(prototype.attack_side==='away') {
                prototype.home_score++;
                document.getElementById('away_total').textContent=document.getElementById('away_total').textContent*1+1;
                prototype.point_str='l_s';
                str = 'l_s';
            } else {
                prototype.away_score++;
                document.getElementById('home_total').textContent=document.getElementById('home_total').textContent*1+1;
                prototype.point_str='r_s';
                str = 'r_s';
            }

            prototype.focus = 'T';
        }

        return str;
    }

    function count_reset() {
        if(prototype.combo===90 || prototype.combo===88 || prototype.command===84 || prototype.command===71 || prototype.command===70) {
            prototype.rallying_no = 0;
            prototype.score_no++;
            prototype.point_str = '';
        }
    }

    function event_setter() {
//      최초 게임 시작 시 객체 값 선언
        if(document.getElementsByClassName('view')[0].children.length === 0) {
            prototype.schedule_no = <?=$schedule->no;?>;
            prototype.set = <?=$last_set;?>;
            prototype.score_no = 1;
            prototype.rallying_no = 0;
            prototype.combo = 0;
            prototype.type = 'message';
            prototype.home_score = 0;
            prototype.away_score = 0;
            prototype.attack_side = ('<?=$served_side;?>'==='home')? 'away':'home';
            side_sign_changer();
//              페이지 새로고침 했을 때 객체값 선언
        } else if(prototype.set==undefined) {
            let event=<?=json_encode($message);?>;

            prototype.schedule_no = <?=$schedule->no;?>;
            prototype.set = event[0].set;
            prototype.score_no = event[0].score_no;
            prototype.rallying_no = event[0].rallying_no;
            prototype.attack_side = event[0].attack_side;
            prototype.home_score = event[0].home_score;
            prototype.away_score = event[0].away_score;

            if(event[0].focus==='T'){
                if(prototype.attack_side==='home') {
                    prototype.attack_side='away';
                    side_sign_changer();
                } else {
                    prototype.attack_side='home';
                    side_sign_changer();
                }
            }
        }
    }

    function player_change_cancel() {
        prototype_player.hm='x';
        prototype_player.hml='x';
        prototype_player.hb='x';
        prototype_player.am='x';
        prototype_player.aml='x';
        prototype_player.ab='x';
        document.getElementById('home_player_change_button').style.display = 'none';
        document.getElementById('home_players_in').style.display = 'none';
        document.getElementById('home_players_out').style.display = 'none';
        document.getElementById('away_player_change_button').style.display = 'none';
        document.getElementById('away_players_in').style.display = 'none';
        document.getElementById('away_players_out').style.display = 'none';

        checker_controller();
    }

    function checker_controller() {
        let home_major =('<?=$team_side;?>'==='typeA')? document.getElementsByClassName('table02')[0].children[0].children : document.getElementsByClassName('table02')[1].children[0].children;
        let home_libero =('<?=$team_side;?>'==='typeA')? document.getElementsByClassName('table02')[2].children[0].children[0] : document.getElementsByClassName('table02')[3].children[0].children[0];
        let home_minor =('<?=$team_side;?>'==='typeA')? document.getElementsByClassName('table01')[0].children[0].children : document.getElementsByClassName('table01')[1].children[0].children;
        let away_major =('<?=$team_side;?>'==='typeA')? document.getElementsByClassName('table02')[1].children[0].children : document.getElementsByClassName('table02')[0].children[0].children;
        let away_libero =('<?=$team_side;?>'==='typeA')? document.getElementsByClassName('table02')[3].children[0].children[0] : document.getElementsByClassName('table02')[2].children[0].children[0];
        let away_minor =('<?=$team_side;?>'==='typeA')? document.getElementsByClassName('table01')[1].children[0].children : document.getElementsByClassName('table01')[0].children[0].children;

        /* ANOTHER AREA */
        if(prototype_player.hm==='x') for(let q=0; q<home_major.length; q++) home_major[q].style.backgroundColor='white';
        if(prototype_player.hml==='x') home_libero.style.backgroundColor='white';
        if(prototype_player.hb==='x') for(let z=0; z<home_minor.length; z++) home_minor[z].style.backgroundColor='#D3D2D3';
        if(prototype_player.am==='x') for(let s=0; s<away_major.length; s++) away_major[s].style.backgroundColor='white';
        if(prototype_player.aml==='x') away_libero.style.backgroundColor='white';
        if(prototype_player.ab==='x') for(let w=0; w<away_minor.length; w++) away_minor[w].style.backgroundColor='#D3D2D3';

        /* BUTTON */
        if((prototype_player.hm==='o' || prototype_player.hml==='o') && prototype_player.hb==='o') document.getElementById('home_player_change_button').style.display = 'inline';
        else if((prototype_player.am==='o' || prototype_player.aml==='o') && prototype_player.ab==='o') document.getElementById('away_player_change_button').style.display = 'inline';
    }

    function change_player(e, home_away, in_or_out) {
        for (let u = 0; u < e.parentNode.children.length; u++) {
            e.parentNode.children[u].style.backgroundColor = (in_or_out==='out') ? 'white' : '#D3D2D3';
        }
        e.style.backgroundColor = '#FAF4C0';

        if (e.className === 'hm') {
            prototype_player.hm = 'o';
            prototype_player.hml = 'x';
            prototype_player.away = 'x';
        } else if (e.className === 'hml') {
            prototype_player.hml = 'o';
            prototype_player.hm = 'x';
            prototype_player.away = 'x';
        } else if (e.className === 'hb') {
            prototype_player.hb = 'o';
            prototype_player.away = 'x';
        } else if(e.className==='am') {
            prototype_player.am='o';
            prototype_player.aml='x';
            prototype_player.away = 'o';
        } else if(e.className==='aml') {
            prototype_player.am='x';
            prototype_player.aml='o';
            prototype_player.away = 'o';
        } else if(e.className==='ab') {
            prototype_player.ab = 'o';
            prototype_player.away = 'o';
        }
        checker_controller();

        let detail = [];
        $.ajax({
            type:'POST',
            url:'/volleyball/get_player_detail_ajax',
            data:{id:e.id},
            success: function(data){
                detail=JSON.parse(data);
            },
            complete: function(){
                document.getElementById(home_away+'_players_'+in_or_out).style.backgroundImage="url('http://www.kovo.co.kr/upfiles/player/"+detail.id+".jpg')";
                document.getElementById(home_away+'_'+in_or_out+'_id').textContent=detail.id;
                document.getElementById(home_away+'_'+in_or_out+'_name').textContent=detail.name;
                document.getElementById(home_away+'_'+in_or_out+'_shirt_number').textContent=detail.shirt_number;
                document.getElementById(home_away+'_'+in_or_out+'_position').textContent=detail.position;
                document.getElementById(home_away+'_'+in_or_out+'_birth').textContent=detail.birth;
                document.getElementById(home_away+'_'+in_or_out+'_weight').textContent=detail.weight;
                document.getElementById(home_away+'_'+in_or_out+'_height').textContent=detail.height;
                document.getElementById(home_away+'_'+in_or_out+'_sargent').textContent=detail.sargent;
                document.getElementById(home_away+'_'+in_or_out+'_begin_year').textContent=detail.begin_year;
                document.getElementById(home_away+'_'+in_or_out+'_country').textContent=detail.country;
                document.getElementById(home_away+'_players_'+in_or_out).style.display='inline';
            }
        });
    }

    function close_this_box(e, locate) {
        e.parentNode.parentNode.parentNode.style.display='none';
        e.parentNode.style.backgroundColor='white';

        if(locate==='hm'){
            prototype_player.hm='x';
            prototype_player.hml='x';
            document.getElementById('home_player_change_button').style.display = 'none';
        } else if(locate==='hb') {
            prototype_player.hb='x';
            document.getElementById('home_player_change_button').style.display = 'none';
        } else if(locate==='am') {
            prototype_player.am='x';
            prototype_player.aml='x';
            document.getElementById('away_player_change_button').style.display = 'none';
        } else if(locate==='ab') {
            prototype_player.ab='x';
            document.getElementById('away_player_change_button').style.display = 'none';
        }

        checker_controller();
    }

    function player_change(home_away) {
        if(home_away==='home' && '<?=$team_side;?>'==='typeA') number=0;
        else if(home_away==='away' && '<?=$team_side;?>'==='typeA') number=1;
        else if(home_away==='home' && '<?=$team_side;?>'==='typeB') number=1;
        else if(home_away==='away' && '<?=$team_side;?>'==='typeB') number=0;

        /* MAJOR */
        for (let h=0; h<document.getElementsByClassName('table02')[number].children[0].children.length; h++) {
            if (document.getElementsByClassName('table02')[number].children[0].children[h].style.backgroundColor !== 'white') {
                major_no=h;
                major_player={
                    id:document.getElementsByClassName('table02')[number].children[0].children[h].id,
                    p_no:document.getElementsByClassName('table02')[number].children[0].children[h].value,
                    name:document.getElementsByClassName('table02')[number].children[0].children[h].children[0].textContent,
                    shirt_number:document.getElementsByClassName('table02')[number].children[0].children[h].children[1].textContent,
                    position:document.getElementsByClassName('table02')[number].children[0].children[h].children[2].textContent
                };
            }
        }
        /* LIBERO */
        if (document.getElementsByClassName('table02')[2].children[0].children[0].style.backgroundColor !== 'white') {
            major_no=99;
            major_player={
                id:document.getElementsByClassName('table02')[2].children[0].children[0].id,
                p_no:document.getElementsByClassName('table02')[2].children[0].children[0].value,
                name:document.getElementsByClassName('table02')[2].children[0].children[0].children[0].textContent,
                shirt_number:document.getElementsByClassName('table02')[2].children[0].children[0].children[1].textContent,
                position:document.getElementsByClassName('table02')[2].children[0].children[0].children[2].textContent
            };
        } else if (document.getElementsByClassName('table02')[3].children[0].children[0].style.backgroundColor !== 'white') {
            major_no=88;
            major_player={
                id:document.getElementsByClassName('table02')[3].children[0].children[0].id,
                p_no:document.getElementsByClassName('table02')[3].children[0].children[0].value,
                name:document.getElementsByClassName('table02')[3].children[0].children[0].children[0].textContent,
                shirt_number:document.getElementsByClassName('table02')[3].children[0].children[0].children[1].textContent,
                position:document.getElementsByClassName('table02')[3].children[0].children[0].children[2].textContent
            };
        }
        /* BENCH */
        for (let g=0; g<document.getElementsByClassName('table01')[number].children[0].children.length; g++) {
            if (document.getElementsByClassName('table01')[number].children[0].children[g].style.backgroundColor !== 'rgb(211, 210, 211)') {
                bench_no=g;
                bench_player={
                    id:document.getElementsByClassName('table01')[number].children[0].children[g].id,
                    p_no:document.getElementsByClassName('table01')[number].children[0].children[g].value,
                    name:document.getElementsByClassName('table01')[number].children[0].children[g].children[0].textContent,
                    shirt_number:document.getElementsByClassName('table01')[number].children[0].children[g].children[1].textContent,
                    position:document.getElementsByClassName('table01')[number].children[0].children[g].children[2].textContent
                };
            }
        }

        /* 선발 선수 교체 */
        if (major_no === 99) {
            document.getElementsByClassName('table02')[2].children[0].children[0].id = bench_player.id;
            document.getElementsByClassName('table02')[2].children[0].children[0].p_no = bench_player.p_no;
            document.getElementsByClassName('table02')[2].children[0].children[0].children[0].textContent = bench_player.name;
            document.getElementsByClassName('table02')[2].children[0].children[0].children[1].textContent = bench_player.shirt_number;
            document.getElementsByClassName('table02')[2].children[0].children[0].children[2].textContent = bench_player.position;
        } else if (major_no === 88) {
            document.getElementsByClassName('table02')[3].children[0].children[0].id = bench_player.id;
            document.getElementsByClassName('table02')[3].children[0].children[0].p_no = bench_player.p_no;
            document.getElementsByClassName('table02')[3].children[0].children[0].children[0].textContent = bench_player.name;
            document.getElementsByClassName('table02')[3].children[0].children[0].children[1].textContent = bench_player.shirt_number;
            document.getElementsByClassName('table02')[3].children[0].children[0].children[2].textContent = bench_player.position;
        } else {
            document.getElementsByClassName('table02')[number].children[0].children[major_no].id = bench_player.id;
            document.getElementsByClassName('table02')[number].children[0].children[major_no].p_no = bench_player.p_no;
            document.getElementsByClassName('table02')[number].children[0].children[major_no].children[0].textContent = bench_player.name;
            document.getElementsByClassName('table02')[number].children[0].children[major_no].children[1].textContent = bench_player.shirt_number;
            document.getElementsByClassName('table02')[number].children[0].children[major_no].children[2].textContent = bench_player.position;
        }

        /* 후보 선수 교체 */
        document.getElementsByClassName('table01')[number].children[0].children[bench_no].id = major_player.id;
        document.getElementsByClassName('table01')[number].children[0].children[bench_no].p_no = major_player.p_no;
        document.getElementsByClassName('table01')[number].children[0].children[bench_no].children[0].textContent = major_player.name;
        document.getElementsByClassName('table01')[number].children[0].children[bench_no].children[1].textContent = major_player.shirt_number;
        document.getElementsByClassName('table01')[number].children[0].children[bench_no].children[2].textContent = major_player.position;

        /* MESSAGE */
        prototype.command='';
        prototype.combo=0;
        prototype.attack_side=home_away;
        prototype.message=bench_player.name+' IN / '+major_player.name+' OUT';
        prototype.type='player_change';
        send_ajax('insert_test_event_ajax', JSON.stringify(prototype), false);
        insert_event('');
        prototype.rallying_no++;

        /* BOX CLOSER */
        player_change_cancel();

        $.ajax({
            type: 'POST',
            url: '/volleyball/test_player_change_ajax',
            data: {
                schedule_no:<?=$schedule->no;?>,
                home_away: home_away,
                major: JSON.stringify(major_player),
                bench: JSON.stringify(bench_player)
            }
        });
    }

    function edit_event(obj) {
        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                '수정': function() {
                    $( this ).dialog( "close" );

                    let message = (obj.children[0].children[0].textContent === '' || obj.children[0].children[0].textContent === '득점 성공')? obj.children[2].children[0].textContent : obj.children[0].children[0].textContent;
                    let score = (obj.children[1].children.length === 0)? obj.children[1].textContent : obj.children[1].children[0].textContent;
                    $('#message_edited').val(message);
                    $('#home_score').val(score[0]);
                    $('#away_score').val(score[2]);

                    update_event(obj);
                },
                '삭제': function() {
                    send_ajax('del_test_event_ajax', obj.id, 're');
                },
                '닫기': function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function update_event(obj) {
        $( "#dialog-form" ).dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                '변경': function() {
                    let table = 'test_event';
                    let home_score = $('#home_score').val();
                    let away_score = $('#away_score').val();
                    let message = $('#message_edited').val();

                    $.ajax({
                        type:'POST',
                        url:'/volleyball/update_event/'+table,
                        data:{id:obj.id, home_score:home_score, away_score:away_score, message:message},
                        complete: function() {
                            location.reload();
                        }
                    });
                },
                '취소': function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function challenging_setter() {
        prototype.command = '67';
        prototype.combo = 1;
        prototype.message = document.getElementById('challenging').selectedOptions[0].textContent;
        prototype.type = 'challenge';

        document.getElementsByClassName('command')[0].children[1].children[0].textContent=prototype.message;
    }

    function challenge_result_setter() {
        prototype.command = '67';
        prototype.combo = 1;
        prototype.message = document.getElementById('challenge_result').selectedOptions[0].textContent;
        prototype.type = 'challenge';

        document.getElementsByClassName('command')[0].children[1].children[0].textContent=prototype.message;
    }

    function edit_score() {
        prototype.type = 'challenge';
        prototype.command = '67';
        prototype.combo = '0';
        prototype.home_score = document.getElementById('home_score_edit').value;
        prototype.away_score = document.getElementById('away_score_edit').value;
        prototype.message = '챌린지 결과로 인한 점수 변경';

        document.getElementsByClassName('command')[0].children[1].children[0].textContent=prototype.message;
    }

    $(function() {
        $("a").attr("onfocus","this.blur();")
    });

    $(document).ready(function() {
        event_setter();
    });

    window.onkeydown=function() {
        run_keymap();
    }
</script>
</body>
</html>