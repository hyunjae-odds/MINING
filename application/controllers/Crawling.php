<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Crawling extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('/volleyball/volley_model');
	}

	function players(){
        $source=$this->curl->simple_get('http://www.kovo.co.kr/team/22000_player-search.asp');

        $exp=explode('<p class="tit">현역선수</p>', $source);
        unset($exp[0]);
        foreach($exp as $item):
            $exp_ul=explode('</ul>', $item);
            $exp_li=explode('</li>', $exp_ul[0]);
            foreach($exp_li as $items):
                $player=array('sex'=>'M');
                if(strlen($items)!=10 && strlen($items)!=239):
                    /* TEAM_NO */
                    $exp_team_no1=explode('t_code=', $items);
                    if(sizeof($exp_team_no1) == 2):
                        $exp_team_no2=explode('&', $exp_team_no1[1]);
                        $player['team_no']=$exp_team_no2[0];
                    else:
                        $player['team_no']='';
                    endif;
                    $player['season']=2;

                    /* PLAYER_NO */
                    $exp_player_no1=explode('p_code=', $items);
                    if(sizeof($exp_player_no1) == 2):
                        $exp_player_no2=explode('">', $exp_player_no1[1]);
                        $player['id']=$exp_player_no2[0];
                    else:
                        $player['id']='';
                    endif;

                    /* PLAYER_NAME */
                    $exp_strip_tags=strip_tags($items);
                    $exp_name_team=explode('[', $exp_strip_tags);
                    $player['name']=trim($exp_name_team[0]);
                    $player['team']=(sizeof($exp_name_team) == 2)? str_replace(']', '', $exp_name_team[1]) : '';

                    if(strlen($player['name']) < 16) $this->volley_model->insert_or_update('players', $player, array('id'=>$player['id']));
                endif;
            endforeach;
        endforeach;

        $source=$this->curl->simple_get('http://www.kovo.co.kr/team/22000_player-search.asp?s_part=2');
        $exp=explode('<p class="tit">현역선수</p>', $source);
        unset($exp[0]);
        foreach($exp as $item):
            $exp_ul=explode('</ul>', $item);
            $exp_li=explode('</li>', $exp_ul[0]);
            foreach($exp_li as $items):
                $player=array('sex'=>'W');
                if(strlen($items)!=10 && strlen($items)!=239 && strlen($items)!=237):
                    /* TEAM_NO */
                    $exp_team_no1=explode('t_code=', $items);
                    $exp_team_no2=(sizeof($exp_team_no1) == 2)? explode('&', $exp_team_no1[1]) : '';
                    $player['team_no']=($exp_team_no2 != '')? $exp_team_no2[0] : '';

                    /* PLAYER_NO */
                    $exp_player_no1=explode('p_code=', $items);
                    $exp_player_no2=explode('">', $exp_player_no1[1]);
                    $player['id']=$exp_player_no2[0];

                    /* PLAYER_NAME */
                    $exp_strip_tags=strip_tags($items);
                    $exp_name_team=explode('[', $exp_strip_tags);
                    $player['name']=trim($exp_name_team[0]);
                    $player['team']=str_replace(']', '', $exp_name_team[1]);
                    $player['season']=2;

                    if(strlen($player['name']) < 16) $this->volley_model->insert_or_update('players', $player, array('id'=>$player['id']));
                endif;
            endforeach;
        endforeach;
	}

	function player_detail($all_or_one){
	    $players=($all_or_one == 'all')? $this->volley_model->get('players') : array($this->volley_model->get_where_row('players', array('id'=>$all_or_one)));

        foreach($players as $player):
            if($player->sex=='M') $source=$this->curl->simple_get('http://www.kovo.co.kr/team/21132_player_view.asp?t_code=1001&s_part=1&p_code='.$player->id);
            else $source=$this->curl->simple_get('http://www.kovo.co.kr/team/21132_player_view.asp?t_code=2005&s_part=2&p_code='.$player->id);

            $exp_start=explode('<div class="profile">', $source);
            $exp_end=explode('<!-- //선수 프로필 -->', $exp_start[1]);

            $player_detail=array();
            $player_detail['id']=$player->id;
            /* POSITION */
            $exp_position=explode('&nbsp;&nbsp;<span>', $exp_end[0]);
            $player_detail['position']=strip_tags(trim($exp_position[0]));

            /* SHIRT_NUMBER */
            $exp_shrt_num=explode('.', $exp_end[0]);
            $exp_shrt_num2=explode('</span>', $exp_shrt_num[1]);
            $player_detail['shirt_number']=$exp_shrt_num2[0];

            /* BIRTH */
            $exp_birth=explode('생년월일', $exp_end[0]);
            $exp_birth2=explode('<br />', $exp_birth[1]);
            $exp_birth3=explode(' ', $exp_birth2[0]);
            $player_detail['birth']=str_replace('년', '', $exp_birth3[1]).'-'.str_replace('월', '', $exp_birth3[2]).'-'.str_replace('일', '', $exp_birth3[3]);//월일 할 차

            /* HEIGHT */
            $exp_height=explode('cm', $exp_end[0]);
            $exp_height2=explode(' ', $exp_height[0]);
            $player_detail['height']=$exp_height2[sizeof($exp_height2)-1];

            /* WEIGHT */
            $exp_weight=explode('kg', $exp_end[0]);
            $exp_weight2=explode(' ', $exp_weight[0]);
            $player_detail['weight']=$exp_weight2[sizeof($exp_weight2)-1];

            /* SARGENT */
            $exp_sargent=explode('cm', $exp_end[0]);
            if(sizeof($exp_sargent)==3) $exp_sargent2=explode(' ', $exp_sargent[1]);
            $player_detail['sargent']=(sizeof($exp_sargent)==3)? $exp_sargent2[sizeof($exp_sargent2)-1] : 0;

            /* BEGIN_YEAR */
            $exp_begin_year=explode('프로입단년도', $exp_end[0]);
            if(sizeof($exp_begin_year)>1) $exp_begin_year2=explode(' ', $exp_begin_year[1]);
            $exp_begin_year3=(strlen($exp_begin_year2[1])==10)? str_replace('<br', '', $exp_begin_year2[1]) : $exp_begin_year2[1];
            $player_detail['begin_year']=(sizeof($exp_begin_year)>1)? str_replace('년', '', $exp_begin_year3) : '';
            if(strlen($player_detail['begin_year'])>9):
                $exp_year=explode('(', $player_detail['begin_year']);
                $player_detail['begin_year']=$exp_year[0];
            endif;

            /* COUNTRY */
            if(isset($exp_begin_year2[6])) $player_detail['country']=($exp_begin_year2[6]=='class="wrp_tab' || strlen($exp_begin_year2[6])==16 || strlen($exp_begin_year2[6])==36 || strlen($exp_begin_year2[6])==30)? '대한민국' : str_replace('<br', '', $exp_begin_year2[6]);
            else $player_detail['country']='대한민국';

            $this->volley_model->insert_or_update('player_detail', $player_detail, array('id'=>$player_detail['id']));
        endforeach;

        if($all_or_one != 'all') echo '<script>location.replace("/volleyball/lineup_test/M?date='.date('Y-m-d').'")</script>';
    }

    function schedule(){
        $this->load->library('simple_html_dom');

        $data = $this->volley_model->get_where_row('season_info_master', array('no'=>2));
        $season_date = date('Y-m', strtotime($data->start_dt));
        $end_date = date('Y-m', strtotime($data->end_dt.'+1 month'));

        while(TRUE):
            $html = $this->curl->simple_get('http://www.kovo.co.kr/game/v-league/11110_schedule_list.asp?season='.$data->season_num.'&yymm='.$season_date);
            $dom = $this->simple_html_dom->load($html);
            $table = $dom->find('table.lst_schedule', 0);
            $tr = $table->find('tr');

            $date = '';
            foreach ($tr as $item) :
                $td = $item->find('td');
                if(sizeof($td) > 1) :
                    if($td[2]->plaintext !== '경기가 없습니다.') :
                        $result['season_no'] = $data->no;
                        $result['sex'] = ($td[2]->plaintext === '남자')? 'M' : 'W';
                        $exp_date = explode(' ', $td[0]->plaintext);
                        if(isset($exp_date[1])) $date = $season_date.'-'.$exp_date[1];
                        $result['date'] = $date;
                        $result['time'] = $td[5]->plaintext;
                        $exp_round = explode(' ', $td[8]->plaintext);
                        $result['round'] = substr($exp_round[1], 0, 1);

                        $exp_home = explode('&nbsp;&nbsp;', $td[3]->plaintext);
                        $home_id = $this->volley_model->get_where_row('team_info', array('s_name'=>$exp_home[0]));
                        $result['home_id'] = ($home_id) ? $home_id->id : '';
                        $result['home'] = $exp_home[0];
                        $exp_score = explode(' ', $exp_home[1]);
                        $result['home_score'] = (isset($exp_score[0])) ? $exp_score[0] : '';

                        $exp_away = explode('&nbsp;&nbsp;', $td[4]->plaintext);
                        $away = $exp_away[sizeof($exp_away)-1];
                        $away_id = $this->volley_model->get_where_row('team_info', array('s_name'=>$away));
                        $result['away_id'] = ($away_id) ? $away_id->id : '';
                        $result['away'] = $away;
                        $result['away_score'] = str_replace("&nbsp;", "", $exp_away[0]);

                        $result['stadium'] = $td[6]->plaintext;
                        $result['status'] = ($result['away_score'] === '') ? 'ready' : 'set';
                        $result['lcd'] = '101';
                        $result['scd'] = '002';

                        $this->volley_model->insert('schedule', $result);
                    endif;
                endif;
            endforeach;

            $season_date = date('Y-m', strtotime($season_date.'+1 month'));
            if($season_date == $end_date) break;
        endwhile;
    }

    function do_crawling_daily(){
	    $this->players();
	    $this->player_detail();
//	    $this->schedule(1);
    }

    function schedule_team_id(){
        $schedule = $this->volley_model->get('schedule');

        foreach ($schedule as $index => $item) :
            if($item->time !== '00:00:00'):
                $home_id = $this->volley_model->get_where_row('team_info', array('s_name'=>$item->home))->id;
                $away_id = $this->volley_model->get_where_row('team_info', array('s_name'=>$item->away))->id;

                $this->volley_model->update('schedule', array('home_id'=>$home_id, 'away_id'=>$away_id), array('no'=>$item->no));
            endif;
        endforeach;
    }

    function match_player_stat_team_id(){
        $match_player_stat = $this->volley_model->get('match_player_stat');

        foreach ($match_player_stat as $index => $item) :
            $team_id = $this->volley_model->get_where_row('team_info', array('s_name'=>$item->team_nm))->id;

            $this->volley_model->update('match_player_stat', array('team_id'=>$team_id), array('idx'=>$item->idx));
        endforeach;
    }

    function match_game_stat(){
        $schedule = $this->volley_model->get_where('schedule', array('status'=>'set'));

        foreach ($schedule as $key => $item) :
            $event = $this->volley_model->get_where('event', array('schedule_no'=>$item->no, 'type'=>'message', 'delete_yn'=>'N'));
            foreach ($event as $keys => $items) :
                if($items->message === '서브 득점 성공' || $items->message === '블로킹 득점 성공' || $items->message === '서브 실패') :
                    $result['schedule_no'] = $item->no;
                    $result['home_id'] = $item->home_id;
                    $result['away_id'] = $item->away_id;

                    $match_stat = $this->volley_model->get_where_row('match_game_stat', array('schedule_no'=>$item->no));
                    if($match_stat) :
                        $result['h_sv'] = $match_stat->h_sv;
                        $result['h_bk'] = $match_stat->h_bk;
                        $result['h_svf'] = $match_stat->h_svf;
                        $result['a_sv'] = $match_stat->a_sv;
                        $result['a_bk'] = $match_stat->a_bk;
                        $result['a_svf'] = $match_stat->a_svf;
                    else :
                        $result['h_sv'] = 0;
                        $result['h_bk'] = 0;
                        $result['h_svf'] = 0;
                        $result['a_sv'] = 0;
                        $result['a_bk'] = 0;
                        $result['a_svf'] = 0;
                    endif;

                    $h_a = ($items->attack_side === 'home') ? 'h' : 'a';

                    if($items->message === '서브 득점 성공') $result[$h_a.'_sv']++;
                    if($items->message === '블로킹 득점 성공') $result[$h_a.'_bk']++;
                    if($items->message === '서브 실패') $result[$h_a.'_svf']++;

                    if($match_stat) $this->volley_model->update('match_game_stat', $result, array('idx'=>$match_stat->idx));
                    else $this->volley_model->insert('match_game_stat', $result);
                endif;
            endforeach;
        endforeach;
    }
}