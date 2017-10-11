<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
	<title> ODDS CONNECT - DataMining </title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link href="/public/lib/volley.css" rel="stylesheet" type="text/css">
    <style>
        input[type="text"] {
            width: 80%; /* 원하는 너비 설정 */
            height: 21px; /* 높이값 초기화 */
            line-height : normal; /* line-height 초기화 */
            padding: .8em .5em; /* 원하는 여백 설정, 상하단 여백으로 높이를 조절 */
            font-family: inherit; /* 폰트 상속 */
            border: 1px solid #999;
            border-radius: 0; /* iSO 둥근모서리 제거 */
            outline-style: none; /* 포커스시 발생하는 효과 제거를 원한다면 */
            -webkit-appearance: none; /* 브라우저별 기본 스타일링 제거 */
            -moz-appearance: none;
            text-align: center;
        }

        .lineup > a > div:hover {
            background-color:#8E8E8E;
            color:white;
        }
    </style>
</head>
<body>
    <div class="wrap lineup" style="<?php if($segment=='lineup_test') echo 'background-color:#ffffdf;';?>">
        <?php if($session['level'] == 3 && $segment=='lineup_test'): ?>
            <a href="javascript:location.href='/volleyball/lineup/<?=$sex;?>?date=<?=$date;?>'"><div style="float:right;margin-top:20px;margin-right:8px;border:1px solid #8E8E8E;height:29px;width:70px;text-align:center;padding-top:10px;">일반모드</div></a>
            <div style="float:right;margin-top:20px;margin-right:-5px;"><input type="text" id="date_picker" value="<?=$date;?>"></div>
        <?php elseif($session['level'] == 3): ?>
            <a href="javascript:location.href='/volleyball/lineup_test/<?=$sex;?>?date=<?=$date;?>'"><div style="float:right;margin-top:20px;margin-right:8px;border:1px solid #8E8E8E;height:29px;width:70px;text-align:center;padding-top:10px;">연습모드</div></a>
            <div style="float:right;margin-top:20px;margin-right:-5px;"><input type="text" id="date_picker" value="<?=$date;?>"></div>
        <?php elseif($segment=='lineup_test'): ?>
            <a href="javascript:showAdminMode(this);"><div style="float:right;margin-top:20px;margin-right:8px;border:1px solid #8E8E8E;height:29px;width:70px;text-align:center;padding-top:10px;">관리자</div></a>
            <a href="javascript:location.href='/volleyball/lineup/<?=$sex;?>?date=<?=$date;?>'"><div style="float:right;margin-top:20px;margin-right:8px;border:1px solid #8E8E8E;height:29px;width:70px;text-align:center;padding-top:10px;">일반모드</div></a>
            <div style="float:right;margin-top:20px;margin-right:-5px;"><input type="text" id="date_picker" value="<?=$date;?>"></div>
        <?php else: ?>
            <a href="javascript:location.href='/volleyball/lineup_test/<?=$sex;?>?date=<?=$date;?>'"><div style="float:right;margin-top:20px;margin-right:8px;border:1px solid #8E8E8E;height:29px;width:70px;text-align:center;padding-top:10px;">연습모드</div></a>
            <div style="float:right;margin-top:20px;margin-right:-5px;"><input type="text" id="date_picker" value="<?=$date;?>"></div>
        <?php endif; ?>

        <ul class="VS">
            <?php if($status=='none'): ?><li><a href="javascript:void(0);">해당 날짜에 경기가 없습니다.</a></li>
            <?php else: ?><li><a href="javascript:void(0);"><?=$schedule->home;?>:<?=$schedule->away;?></a></li><?php endif;?>
        </ul>
        <p class="apply">
            <?php if($status=='set' || $status=='ing' || $status=='begin'): ?><a href="javascript:location.href='/volleyball/<?=($segment==='lineup_test')? 'input_test' : 'input';?>/<?=$schedule->no;?>/<?=$last_set;?>'" id="confirm_btn">이동<span></span></a>
            <?php else: ?><a href="javascript:<?=($segment==='lineup_test')? 'saveLineUp(\'insert_test_line_up_ajax\');' : 'saveLineUp(\'insert_line_up_ajax\')';?>" id="confirm_btn">적용<span></span></a><?php endif;?>
        </p>
        <ul class="VS_view">
            <li class="on">
                <div class="home">
                    <p class="team">홈</p>
                    <div class="selection">
                        <h3>엔트리</h3>
                        <div class="dgray dgray01">
                            <div class="th">
                                <div class="name">이름</div>
                                <div class="number">등번호</div>
                                <div class="position">포지션</div>
                            </div>
                            <ul class="td connectedSortable_home" id="selection_home">
                                <?php if(sizeof($line_up) > 0): ?>
                                    <?php foreach ($line_up['hm'] as $item): ?>
                                        <li>
                                            <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                            <div class="number"><?=$item->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$item->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="dgray bench">
                            <ul class="td connectedSortable_home" id="player_home">
                                <?php if(sizeof($line_up) > 0): ?>
                                    <?php foreach ($line_up['hb'] as $item): ?>
                                        <li>
                                            <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                            <div class="number"><?=$item->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$item->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="player">
                        <h3>등록선수</h3>
                        <div class="dgray">
                            <div class="th">
                                <div class="name">이름</div>
                                <div class="number">등번호</div>
                                <div class="position">포지션</div>
                            </div>
                            <ul class="td connectedSortable_home" id="selection1_home">
                                <?php if($status=='none' || $status=='set'): ?>
                                <?php elseif(sizeof($line_up['hm']) > 0): ?>
                                    <?php foreach ($line_up['hn'] as $item): ?>
                                        <li>
                                            <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                            <div class="number"><?=$item->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$item->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($players['home'] as $home_player): ?>
                                        <li>
                                            <div class="name" id="<?=$home_player->no;?>"><?=$home_player->name;?></div>
                                            <div class="number"><?=$home_player->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$home_player->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="visit">
                    <p class="team">원정</p>
                    <div class="selection" >
                        <h3>엔트리</h3>
                        <div class="dgray dgray01">
                            <div class="th">
                                <div class="name">이름</div>
                                <div class="number">등번호</div>
                                <div class="position">포지션</div>
                            </div>
                            <ul class="td connectedSortable_away" id="selection_away">
                                <?php if(sizeof($line_up) > 0): ?>
                                    <?php foreach ($line_up['am'] as $item): ?>
                                        <li>
                                            <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                            <div class="number"><?=$item->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$item->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="dgray bench">
                            <ul class="td connectedSortable_away" id="player_away">
                                <?php if(sizeof($line_up) > 0): ?>
                                    <?php foreach ($line_up['ab'] as $item): ?>
                                        <li>
                                            <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                            <div class="number"><?=$item->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$item->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="player">
                        <h3>등록선수</h3>
                        <div class="dgray">
                            <div class="th">
                                <div class="name">이름</div>
                                <div class="number">등번호</div>
                                <div class="position">포지션</div>
                            </div>
                            <ul class="td connectedSortable_away" id="selection1_away">
                                <?php if($status=='none' || $status=='set'): ?>
                                <?php elseif(sizeof($line_up['hm']) > 0): ?>
                                    <?php foreach ($line_up['an'] as $item): ?>
                                        <li>
                                            <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                            <div class="number"><?=$item->shirt_number;?></div>
                                            <div class="position">
                                                <p><?=$item->position;?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($players['away'] as $home_player): ?>
                                        <li>
                                            <div class="name" id="<?=$home_player->no;?>"><?=$home_player->name;?></div>
                                            <div class="number"><?=$home_player->shirt_number;?></div>
                                            <div class="position"><p><?=$home_player->position;?></p></div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div id="loading" style="display:none;position:absolute;left:1320px;top:50px;"><img src="/public/lib/volleyball_image/ajax_loader4.gif" style="width:30px;height:30px;"></div>
    <div id="admin_mode" style="display:none;position:fixed;width:280px;height:500px;left:1470px;top:97px;background-color:white;border:1px solid black;">
        <div style="padding: 20px;">
            <h2>권한 관리</h2><br>
                <?php foreach($operators as $operator): ?>
                    <div>
                        <?=$operator->nickname;?>
                        <select id="level_selector_<?=$operator->id;?>">
                            <option <?php if($operator->level==2) echo 'selected';?>>2</option>
                            <option <?php if($operator->level==3) echo 'selected';?>>3</option>
                        </select>
                        <button onclick="sendAjax('update_user_level_ajax', JSON.stringify({id:<?=$operator->id;?>,'level':$('#level_selector_<?=$operator->id;?> option:selected').val()}));">저장</button>
                    </div>
                <?php endforeach; ?><br><br>
            <h2>스케쥴(연습)</h2><br>
            <button onclick="deleteTestMode('this');">현재 초기화</button>
            <button onclick="deleteTestMode('all');">전체 초기화</button>
        </div>
    </div>

    <script src="/public/lib/js/jquery-1.12.4.js"></script>
    <script src="/public/lib/js/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $("a").attr("onfocus","this.blur();");
        });

        /* JQUERY :: SORTABLE */
        $(function() {
            $("#selection_home, #player_home, #selection1_home").sortable({connectWith: ".connectedSortable_home"}).disableSelection();
            $("#selection_away, #player_away, #selection1_away").sortable({connectWith: ".connectedSortable_away"}).disableSelection();
        });

        /* JQUERY :: DATE PICKER */
        $.datepicker.setDefaults({
            dateFormat: 'yy-mm-dd',
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true,
            yearSuffix: '년'
        });
        $(function() {
            $("#date_picker").datepicker();
            $("#date_picker").datepicker("option", "onClose", function (date){location.href="/volleyball/<?=$segment;?>/<?=$sex;?>?date="+date;});
//            $("#date_picker").datepicker("option", "maxDate", "+0d");
        });

        function saveLineUp(segment) {
            let home_major = document.getElementById('selection_home').children;
            let home_bench = document.getElementById('player_home');
            let away_major = document.getElementById('selection_away').children;
            let away_bench = document.getElementById('player_away');
            let home_minor = document.getElementById('selection1_home').children;
            let away_minor = document.getElementById('selection1_away').children;

            let result=[];
            if(validatePlayerSet(home_major, away_major)) {
                let result_hm=[],result_am=[],result_hb=[],result_ab=[],result_hn=[],result_an=[];

                for(let i=0; i<7; i++) {
                    result_hm.push(home_major[i].getElementsByClassName('name')[0].id);
                    result_am.push(away_major[i].getElementsByClassName('name')[0].id);
                }
                for(let i=0; i<6; i++) {
                    result_hb.push(home_bench.getElementsByClassName('name')[i].id);
                    result_ab.push(away_bench.getElementsByClassName('name')[i].id);
                }
                for(let j=0; j<document.getElementById('selection1_home').children.length; j++) {
                    result_hn.push(home_minor[j].getElementsByClassName('name')[0].id);
                }
                for(let k=0; k<document.getElementById('selection1_away').children.length; k++) {
                    result_an.push(away_minor[k].getElementsByClassName('name')[0].id);
                }
                result.push({'schedule_no':<?=($status=='none')? 0:$schedule->no;?>},{'hm':result_hm},{'am':result_am},{'hb':result_hb},{'ab':result_ab},{'hn':result_hn},{'an':result_an});

                sendAjax(segment, JSON.stringify(result));
            }
        }

        function validatePlayerSet(home_major, away_major) {
            if(home_major.length!==7){
                alert('홈 선발 선수를 7명 등록하세요.');
                return false;
            }else if(away_major.length!==7){
                alert('원정 선발 선수를 7명 등록하세요.');
                return false;
            }

            if(document.getElementById('player_home').children.length !== 6) {
                alert('홈 후보 선수를 6명 등록하세요.');
                return false;
            } else if(document.getElementById('player_away').children.length !== 6) {
                alert('원정 후보 선수를 6명 등록하세요.');
                return false;
            }

            let home_libero_cnt=0;
            let away_libero_cnt=0;
            for(let i=0; i<7; i++) if(home_major[i].getElementsByClassName('position')[0].children[0].textContent=='LIBERO') home_libero_cnt++;
            for(let j=0; j<7; j++) if(away_major[j].getElementsByClassName('position')[0].children[0].textContent=='LIBERO') away_libero_cnt++;
            if(home_libero_cnt == 0) {
                alert('홈 선발에 "리베로" 가 없습니다.');
                return false;
            }
            else if(away_libero_cnt == 0) {
                alert('원정 선발에 "리베로" 가 없습니다.');
                return false;
            }else if(home_libero_cnt > 1) {
                alert('홈 선발에 "리베로" 는 한 명만 등록 가능합니다. (현재 : '+home_libero_cnt+')');
                return false;
            }
            else if(away_libero_cnt > 1) {
                alert('원정 선발에 "리베로" 는 한 명만 등록 가능합니다. (현재 : '+away_libero_cnt+')');
                return false;
            }

            return true;
        }

        function sendAjax(segment, data) {
            $.ajax({
                type: 'POST',
                url: '/volleyball/' + segment,
                data: {data: data},
                beforeSend: function() {
                    $('#loading').show();
                    $("#confirm_btn").css({'pointer-events': 'none'});
                },
                complete: function() {
                    if(segment==='insert_line_up_ajax') location.href="/volleyball/input/<?=($status=='none')? 0 : $schedule->no;?>/1";
                    else if(segment==='update_user_level_ajax') location.href='/volleyball/lineup/<?=$sex;?>';
                    else location.href="/volleyball/input_test/<?=($status=='none')? 0 : $schedule->no;?>/1";
                }
            });
        }

        function showAdminMode() {
            if(document.getElementById('admin_mode').style.display === 'inline') document.getElementById('admin_mode').style.display='none';
            else document.getElementById('admin_mode').style.display='inline';
        }

        function deleteTestMode(flag) {
            if(flag === 'this') {
                if(confirm('현재 경기를 초기화 하시겠습니까?')) {
                    $.ajax({
                        type: 'POST',
                        url: '/volleyball/delete_test_mode_ajax/one',
                        data: {schedule_no: <?=($status == 'none') ? 0 : $schedule->no;?>},
                        complete: function () {
                            location.href = '/volleyball/lineup/<?=$sex;?>?date=<?=$date;?>';
                        }
                    });
                }
            } else {
                if(confirm('전체 연습 경기를 초기화 하시겠습니까?')) {
                    $.ajax({
                        type: 'POST',
                        url: '/volleyball/delete_test_mode_ajax/all',
                        data: {schedule_no: <?=($status=='none')? 0 : $schedule->no;?>},
                        complete: function() {
                            location.href='/volleyball/lineup/<?=$sex;?>?date=<?=$date;?>';
                        }
                    });
                }
            }
        }

        $('#date_picker').click(function() {
            <?php foreach ($games as $game): ?>
                for(let i = 0; i < $('.ui-datepicker-calendar > tbody > tr > td').size(); i++) {
                    if($('.ui-datepicker-calendar > tbody > tr > td').eq(i).text() === '<?=$game;?>') {
                        $('.ui-datepicker-calendar > tbody > tr > td').eq(i).css('box-sizing', 'border-box');
                        $('.ui-datepicker-calendar > tbody > tr > td').eq(i).css('border', '1px solid red');
                    }
                }
            <?php endforeach; ?>
        });
    </script>
</body>