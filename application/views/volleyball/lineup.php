<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
	<title> ODDS CONNECT - DataMining </title>
	<link href="/public/lib/volley.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
            -moz-appearance: none; appearance: none;
            text-align: center;
        }
    </style>
</head>
	<body>
		<div class="wrap lineup">
            <div style="float: right; margin-top: 20px; margin-right: 70px;"><input type="text" id="date_picker" value="<?=$date;?>"></div>
			<ul class="VS">
                <?php if($schedule->is_schedule!='F'): ?>
                    <li><a href="javascript:void(0);"><?=$schedule->home;?>:<?=$schedule->away;?></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);">해당 날짜에 경기가 없습니다.</a></li>
                <?php endif; ?>
            </ul>
			<p class="apply"><a href="javascript:saveLineUp();" id="confirm_btn">적용<span></span></a></p>
			<ul class="VS_view">
				<li class="on">
					<div class="home">
						<p class="team">홈</p>
						<div class="selection" >
							<h3>엔트리</h3>
							<div class="dgray dgray01">
								<div class="th">
									<div class="name">이름</div>
									<div class="number">등번호</div>
									<div class="position">포지션</div>
								</div>
								<ul class="td connectedSortable_home" id="selection_home">
                                    <?php if($schedule->is_schedule=='G'): ?>
                                        <?php foreach ($line_up['hm'] as $item): ?>
                                            <li>
                                                <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                                <div class="number"><?=$item->shirt_number;?></div>
                                                <div class="position">
                                                    <p><?=$item->position;?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </ul>
							</div>
							<div class="dgray bench">
								<ul class="td connectedSortable_home" id="player_home">
                                    <?php if($schedule->is_schedule=='G'): ?>
                                        <?php foreach ($line_up['hb'] as $item): ?>
                                            <li>
                                                <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                                <div class="number"><?=$item->shirt_number;?></div>
                                                <div class="position">
                                                    <p><?=$item->position;?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
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
                                    <?php if($schedule->is_schedule=='T'): ?>
                                        <?php foreach ($players['home'] as $home_player): ?>
                                            <li>
                                                <div class="name" id="<?=$home_player->no;?>"><?=$home_player->name;?></div>
                                                <div class="number"><?=$home_player->shirt_number;?></div>
                                                <div class="position">
                                                    <p><?=$home_player->position;?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php elseif($line_up!=''): ?>
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
                                    <?php if($schedule->is_schedule=='G'): ?>
                                        <?php foreach ($line_up['am'] as $item): ?>
                                            <li>
                                                <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                                <div class="number"><?=$item->shirt_number;?></div>
                                                <div class="position">
                                                    <p><?=$item->position;?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </ul>
							</div>
							<div class="dgray bench">
								<ul class="td connectedSortable_away" id="player_away">
                                    <?php if($schedule->is_schedule=='G'): ?>
                                        <?php foreach ($line_up['ab'] as $item): ?>
                                            <li>
                                                <div class="name" id="<?=$item->no;?>"><?=$item->name;?></div>
                                                <div class="number"><?=$item->shirt_number;?></div>
                                                <div class="position">
                                                    <p><?=$item->position;?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
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
                                    <?php if($schedule->is_schedule=='T'): ?>
                                        <?php foreach ($players['away'] as $home_player): ?>
                                            <li>
                                                <div class="name" id="<?=$home_player->no;?>"><?=$home_player->name;?></div>
                                                <div class="number"><?=$home_player->shirt_number;?></div>
                                                <div class="position">
                                                    <p><?=$home_player->position;?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php elseif($line_up!=''): ?>
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
                                    <?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
        <div id="loading" style="display:none; position:fixed; left: 77%; top: 5%;"><img src="/public/lib/volleyball_image/ajax_loader4.gif" style="width: 30px; height: 30px;"></div>

        <script src="/public/lib/js/jquery-1.12.4.js"></script>
        <script src="/public/lib/js/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
            $(function(){
                $("a").attr("onfocus","this.blur();")
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
                $("#date_picker").datepicker("option", "onClose", function (date){location.href="/volleyball/lineup/<?=$sex;?>?date="+date;});
            });

            function saveLineUp(){
                var home_major = document.getElementById('selection_home').children;
                var home_bench = document.getElementById('player_home');
                var away_major = document.getElementById('selection_away').children;
                var away_bench = document.getElementById('player_away');
                var home_minor = document.getElementById('selection1_home').children;
                var away_minor = document.getElementById('selection1_away').children;

                var result=[];
                if(validatePlayerSet(home_major, away_major)){
                    var result_hm=[],result_am=[],result_hb=[],result_ab=[],result_hn=[],result_an=[];

                    for(var i=0; i<7; i++){
                        result_hm.push(home_major[i].getElementsByClassName('name')[0].id);
                        result_am.push(away_major[i].getElementsByClassName('name')[0].id);
                    }
                    for(var i=0; i<6; i++){
                        result_hb.push(home_bench.getElementsByClassName('name')[i].id);
                        result_ab.push(away_bench.getElementsByClassName('name')[i].id);
                    }
                    for(var j=0; j<document.getElementById('selection1_home').children.length; j++){
                        result_hn.push(home_minor[j].getElementsByClassName('name')[0].id);
                    }
                    for(var k=0; k<document.getElementById('selection1_away').children.length; k++){
                        result_an.push(away_minor[k].getElementsByClassName('name')[0].id);
                    }
                    result.push({'schedule_no':<?=$schedule->no;?>},{'hm':result_hm},{'am':result_am},{'hb':result_hb},{'ab':result_ab},{'hn':result_hn},{'an':result_an});

                    sendAjax('insert_line_up_ajax', JSON.stringify(result));
                }
            }

            function validatePlayerSet(home_major, away_major){
                if(home_major.length!==7){
                    alert('홈 선발 선수를 7명 등록하세요.');
                    return false;
                }else if(away_major.length!==7){
                    alert('원정 선발 선수를 7명 등록하세요.');
                    return false;
                }

                var home_libero_cnt=0;
                var away_libero_cnt=0;
                for(var i=0; i<7; i++) if(home_major[i].getElementsByClassName('position')[0].children[0].textContent=='LIBERO') home_libero_cnt++;
                for(var j=0; j<7; j++) if(away_major[j].getElementsByClassName('position')[0].children[0].textContent=='LIBERO') away_libero_cnt++;
                if(home_libero_cnt == 0) {
                    alert('홈 선발에 "리베로" 가 없습니다.');
                    return false;
                }
                else if(away_libero_cnt == 0){
                    alert('원정 선발에 "리베로" 가 없습니다.');
                    return false;
                }else if(home_libero_cnt > 1){
                    alert('홈 선발에 "리베로" 는 한 명만 등록 가능합니다. (현재 : '+home_libero_cnt+')');
                    return false;
                }
                else if(away_libero_cnt > 1){
                    alert('원정 선발에 "리베로" 는 한 명만 등록 가능합니다. (현재 : '+away_libero_cnt+')');
                    return false;
                }

                return true;
            }

            function sendAjax(func, data){
                $.ajax({
                    type:'POST',
                    url:'/volleyball/'+func,
                    data:{data:data},
                    beforeSend: function(){
                        $('#loading').show();
                        $("#confirm_btn").css({ 'pointer-events': 'none' });
                    },
                    complete: function(){
                        location.href="/volleyball/input/<?=$schedule->no;?>/1";
                    }
                });
            }
        </script>
    </body>
</html>
