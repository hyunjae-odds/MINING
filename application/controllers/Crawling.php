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
                    $exp_team_no2=explode('&', $exp_team_no1[1]);
                    $player['team_no']=$exp_team_no2[0];

                    /* PLAYER_NO */
                    $exp_player_no1=explode('p_code=', $items);
                    $exp_player_no2=explode('">', $exp_player_no1[1]);
                    $player['id']=$exp_player_no2[0];

                    /* PLAYER_NAME */
                    $exp_strip_tags=strip_tags($items);
                    $exp_name_team=explode('[', $exp_strip_tags);
                    $player['name']=trim($exp_name_team[0]);
                    $player['team']=str_replace(']', '', $exp_name_team[1]);

                    if(sizeof($player)!=0) $this->volley_model->insert_or_update('players', $player, array('id'=>$player['id']));
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
                    $exp_team_no2=explode('&', $exp_team_no1[1]);
                    $player['team_no']=$exp_team_no2[0];

                    /* PLAYER_NO */
                    $exp_player_no1=explode('p_code=', $items);
                    $exp_player_no2=explode('">', $exp_player_no1[1]);
                    $player['id']=$exp_player_no2[0];

                    /* PLAYER_NAME */
                    $exp_strip_tags=strip_tags($items);
                    $exp_name_team=explode('[', $exp_strip_tags);
                    $player['name']=trim($exp_name_team[0]);
                    $player['team']=str_replace(']', '', $exp_name_team[1]);

                    if(sizeof($player)!=0) $this->volley_model->insert_or_update('players', $player, array('id'=>$player['id']));
                endif;
            endforeach;
        endforeach;
	}

	function player_detail(){
	    $players=$this->volley_model->get('players');

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
    }

    function schedule($season_no){
	    $data=$this->volley_model->get_where_row('season', array('no'=>$season_no));

	    if(sizeof($data) > 0):
            $season_date=date('Y-m', strtotime($data->start_dt));
            $end_date=date('Y-m', strtotime($data->end_dt.'+1 month'));

            while(TRUE):
                $date_static='';
                $source=$this->curl->simple_get('http://www.kovo.co.kr/game/v-league/11110_schedule_list.asp?season='.$data->season_num.'&yymm='.$season_date);

                if($source!=''):
                    $exp_tbody=explode('<tbody>', $source);
                    $exp=explode('</tbody>', $exp_tbody[3]);
                    $exp_tr=explode('</tr>', $exp[0]);
                    foreach($exp_tr as $item):
                        $result=array('season'=>$season_no);
                        if(strlen($item) > 188):
                            $exp_td=explode('<td>', $item);

                            /* DATE */
                            $date=strip_tags(preg_replace("/\s+/", "", $exp_td[0]));
                            $exp_date=explode('(', $date);
                            if($exp_date[0]!='') $date_static=$exp_date[0];
                            $explode_date=explode('.', $date_static);
                            $result['date']=$season_date.'-'.$explode_date[1];

                            if(sizeof($exp_td) > 2):
                                $exp_nbsp=explode('&nbsp;&nbsp;', $exp_td[2]);
                                if(sizeof($exp_nbsp) > 1):
                                    $exp_home=explode('<td class="tright">', $exp_nbsp[0]);
                                    $result['home']=$exp_home[1];
                                    $result['away']=strip_tags(preg_replace("/\s+/", "", $exp_nbsp[3]));
                                    $exp_score=explode(':&nbsp;', strip_tags(preg_replace("/\s+/", "", $exp_nbsp[1])));
                                    $result['home_score']=(isset($exp_score[0]))? $exp_score[0] : 0;
                                    $result['away_score']=(isset($exp_score[1]))? $exp_score[1] : 0;
                                    $result['time']=str_replace('</td>', '', trim($exp_td[3]));
                                    $result['stadium']=str_replace('</td>', '', trim($exp_td[4]));
                                    $result['status']='ready';
                                    $explode_sex=explode('</td>', $exp_td[2]);
                                    $result['sex']=($explode_sex[0]=='남자')? 'M' : 'W';

                                    $this->volley_model->insert_or_update('schedule', $result, array('date'=>$result['date'], 'away'=>$result['away']));
                                endif;
                            endif;
                        endif;
                    endforeach;
                endif;

                $season_date=date('Y-m', strtotime($season_date.'+1 month'));
                if($season_date==$end_date) break;
            endwhile;
        else:
            echo 'MAYBE, SEASON_NO WAS NOT CORRECT.';
        endif;
    }

    function do_crawling_daily(){
	    $this->players();
	    $this->player_detail();
//	    $this->schedule(1);
    }
}