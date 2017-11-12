<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Volleyball extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('/volleyball/volley_model');
	}

    function auth(){
        if(!$this->session->userdata('is_login')) redirect("/");
    }

	function login(){
	    $this->load->view('/volleyball/login');
    }

    function lineup($sex){
	    $this->auth();

	    $date=($this->input->get('date')==null)? date('Y-m-d'): $this->input->get('date');
	    $session=$this->session->all_userdata();
	    $schedule=$this->volley_model->get_schedule('schedule', array('date'=>$date, 'sex'=>$sex));
        $status=$this->get_status($schedule);
	    $line_up=$this->volley_model->get_lineup($schedule, $status);
        $players=$this->volley_model->get_today_players($schedule);
        $operators=$this->volley_model->get_operators();
        $segment=$this->uri->segment(2);
        $last_set=$this->volley_model->get_last_set($schedule);
        $games=$this->volley_model->get_schedule_on_month('schedule', $date);

        $this->load->view('/volleyball/lineup', array('session'=>$session,'sex'=>$sex,'date'=>$date,'schedule'=>$schedule,'line_up'=>$line_up,'players'=>$players,'status'=>$status,'operators'=>$operators,'segment'=>$segment,'last_set'=>$last_set,'games'=>$games));
    }
    function lineup_test($sex){
        $this->auth();

        $date=($this->input->get('date')==null)? date('Y-m-d'): $this->input->get('date');
        $session=$this->session->all_userdata();
        $schedule=$this->volley_model->get_schedule('test_schedule', array('date'=>$date, 'sex'=>$sex));
        $status=$this->get_status($schedule);
        $line_up=$this->volley_model->get_lineup_test($schedule, $status);
        $players=$this->volley_model->get_today_players($schedule);
        $operators=$this->volley_model->get_operators();
        $segment=$this->uri->segment(2);
        $last_set=$this->volley_model->get_last_set_test($schedule);
        $games=$this->volley_model->get_schedule_on_month('test_schedule', $date);

        $this->load->view('/volleyball/lineup', array('session'=>$session,'sex'=>$sex,'date'=>$date,'schedule'=>$schedule,'line_up'=>$line_up,'players'=>$players,'status'=>$status,'operators'=>$operators,'segment'=>$segment,'last_set'=>$last_set,'games'=>$games));
    }

    function input($schedule_no, $set){
        $schedule=$this->volley_model->get_schedule('schedule', array('no'=>$schedule_no));
        $session=$this->session->all_userdata();
        if(!isset($session['nickname'])) echo "<script>document.location.href='".$_SERVER['HTTP_HOST']."/volleyball/login';</script>";

        $attack_side=($this->input->get('attack_side')==null)? $this->volley_model->get_last_attack_side($schedule):$this->input->get('attack_side');
        $last_set=($this->input->get('last_set')==null)? $this->volley_model->get_last_set($schedule):$this->input->get('last_set');
        $served_side=$this->volley_model->get_first_attack_side($schedule_no, $last_set);
        $team_side=($this->input->get('team_side')==null)? 'typeA':$this->input->get('team_side');

        $players=$this->volley_model->get_today_players($schedule);
//        $line_up=$this->volley_model->get_lineup($schedule, 'ing');
        $status=$this->volley_model->get_where_row('schedule', array('no'=>$schedule->no))->status;
        $message=$this->volley_model->get_message($schedule, $set);
        $score=$this->volley_model->get_score($schedule->no, $last_set);

        $this->load->view('/volleyball/input', array('schedule'=>$schedule,'players'=>$players,'session'=>$session,'status'=>$status,'message'=>$message,'attack_side'=>$attack_side,'last_set'=>$last_set,'score'=>$score,'served_side'=>$served_side,'set'=>$set,'team_side'=>$team_side));
    }
    function input_test($schedule_no, $set){
        $schedule=$this->volley_model->get_schedule('test_schedule', array('no'=>$schedule_no));
        $session=$this->session->all_userdata();
        if(!isset($session['nickname'])) echo "<script>document.location.href='".$_SERVER['HTTP_HOST']."/volleyball/login';</script>";

        $attack_side=($this->input->get('attack_side')==null)? $this->volley_model->get_last_attack_side($schedule):$this->input->get('attack_side');
        $last_set=($this->input->get('last_set')==null)? $this->volley_model->get_last_set_test($schedule) : $this->input->get('last_set');
        $served_side=$this->volley_model->get_first_attack_side_test($schedule_no, $last_set);
        $team_side=($this->input->get('team_side')==null)? 'typeA' : $this->input->get('team_side');

        $players=$this->volley_model->get_today_players($schedule);
//        $line_up=$this->volley_model->get_lineup_test($schedule, 'ing');
        $status=$this->volley_model->get_where_row('test_schedule', array('no'=>$schedule->no))->status;
        $message=$this->volley_model->get_message_test($schedule, $set);
        $score=$this->volley_model->get_score_test($schedule->no, $last_set);

        $this->load->view('/volleyball/input_test', array('schedule'=>$schedule,'players'=>$players,'session'=>$session,'status'=>$status,'message'=>$message,'attack_side'=>$attack_side,'last_set'=>$last_set,'score'=>$score,'served_side'=>$served_side,'set'=>$set,'team_side'=>$team_side));
    }

    /* COMMON */
    function get_status($schedule){
        if(sizeof($schedule) == 0) $status='none';
        elseif($schedule->status=='ready') $status='ready';
        elseif($schedule->status=='ing' || $schedule->status=='begin') $status='ing';
        else $status='set';

        return $status;
    }

    function get_is_set_line_up() {
        return $this->volley_model->get_is_set_line_up($this->input->post('schedule_no'));
    }
    function get_is_set_test_line_up() {
        return $this->volley_model->get_is_set_test_line_up($this->input->post('schedule_no'));
    }

    /* AJAX */
    function insert_line_up_ajax(){
        $data=json_decode($this->input->post('data'));
        $area=array('hm','am','hb','ab','hn','an');
        $area2=array('hm','am','hb','ab');

        foreach($area as $key=>$items):
            foreach($data[$key+1]->$items as $item):
                $this->volley_model->insert_or_update('line_up', array('schedule_no'=>$data[0]->schedule_no, 'p_no'=>$item, 'area'=>$items, 'status'=>'starting'), array('schedule_no'=>$data[0]->schedule_no,'p_no'=>$item, 'status'=>'starting'));
            endforeach;
        endforeach;

        foreach($area2 as $keys=>$items):
            foreach($data[$keys+1]->$items as $item):
                $this->volley_model->insert_or_update('line_up', array('schedule_no'=>$data[0]->schedule_no, 'p_no'=>$item, 'area'=>$items, 'status'=>'ing'), array('schedule_no'=>$data[0]->schedule_no,'p_no'=>$item, 'status'=>'ing'));
            endforeach;
        endforeach;
    }
    function insert_test_line_up_ajax(){
        $data=json_decode($this->input->post('data'));
        $area=array('hm','am','hb','ab','hn','an');
        $area2=array('hm','am','hb','ab');

        foreach($area as $key=>$items):
            foreach($data[$key+1]->$items as $item):
                $this->volley_model->insert_or_update('test_line_up', array('schedule_no'=>$data[0]->schedule_no, 'p_no'=>$item, 'area'=>$items, 'status'=>'starting'), array('schedule_no'=>$data[0]->schedule_no,'p_no'=>$item, 'status'=>'starting'));
            endforeach;
        endforeach;

        foreach($area2 as $keys=>$items):
            foreach($data[$keys+1]->$items as $item):
                $this->volley_model->insert_or_update('test_line_up', array('schedule_no'=>$data[0]->schedule_no, 'p_no'=>$item, 'area'=>$items, 'status'=>'ing'), array('schedule_no'=>$data[0]->schedule_no,'p_no'=>$item, 'status'=>'ing'));
            endforeach;
        endforeach;
    }

    function insert_event_ajax(){
        echo $this->volley_model->insert_event(json_decode($this->input->post('data')));
    }
    function insert_test_event_ajax(){
        echo $this->volley_model->insert_event_test(json_decode($this->input->post('data')));
    }

    function del_event_ajax(){
        $this->volley_model->update('event', array('delete_yn'=>'Y'), array('no'=>$this->input->post('data')));
    }
    function del_test_event_ajax(){
        $this->volley_model->update('test_event', array('delete_yn'=>'Y'), array('no'=>$this->input->post('data')));
    }

    function get_player_detail_ajax(){
        $result=$this->volley_model->get_player_detail_with_name($this->input->post('id'));

        echo json_encode($result);
    }

    function player_change_ajax(){
        $schedule_no=$this->input->post('schedule_no');
        $home_away=$this->input->post('home_away');
        $major=json_decode($this->input->post('major'));
        $bench=json_decode($this->input->post('bench'));

        $this->volley_model->update_lineup($schedule_no, $home_away, $major->p_no, $bench->p_no);
    }
    function test_player_change_ajax(){
        $schedule_no=$this->input->post('schedule_no');
        $home_away=$this->input->post('home_away');
        $major=json_decode($this->input->post('major'));
        $bench=json_decode($this->input->post('bench'));

        $this->volley_model->update_lineup_test($schedule_no, $home_away, $major->p_no, $bench->p_no);
    }

    function update_set_score_ajax(){
        $schedule_no=$this->input->post('schedule_no');
        $home_score=$this->input->post('home_score');
        $away_score=$this->input->post('away_score');

        $this->volley_model->update('schedule', array('home_score'=>$home_score,'away_score'=>$away_score), array('no'=>$schedule_no));
    }
    function update_test_set_score_ajax(){
        $schedule_no=$this->input->post('schedule_no');
        $home_score=$this->input->post('home_score');
        $away_score=$this->input->post('away_score');

        $this->volley_model->update('test_schedule', array('home_score'=>$home_score,'away_score'=>$away_score), array('no'=>$schedule_no));
    }

    function insert_ajax(){
        $table=$this->input->post('table');
        $data=json_decode($this->input->post('data'));
        $area=array('hm','hb','am','ab');
        foreach ($data as $key=>$item):
            foreach ($item as $keys=>$items):
                $obj['schedule_no']=$this->input->post('schedule_no');
                $obj['p_no']=$items->p_no;
                $obj['area']=$area[$key];
                $obj['status']='set';

                $this->volley_model->insert($table, $obj);
            endforeach;
        endforeach;
    }
    function update_ajax(){
        $this->volley_model->update($this->input->post('table'), array('status'=>$this->input->post('status')), array('no'=>$this->input->post('schedule_no')));
    }

    function insert_or_update_ajax(){
        $count=$this->get_is_set_line_up();

        $data=json_decode($this->input->post('data'));
        $area=array('hm','hb','am','ab');

        if($count > 0):
            foreach ($data as $key=>$item):
                foreach ($item as $keys=>$items):
                    $obj['schedule_no']=$this->input->post('schedule_no');
                    $obj['p_no']=$items->p_no;
                    $obj['area']=$area[$key];
                    $obj['status']='set';

                    $this->volley_model->update('line_up', $obj, array('schedule_no'=>$obj['schedule_no'],'area'=>$obj['area'],'p_no'=>$obj['p_no'],'status'=>$obj['status']));
                endforeach;
            endforeach;
        else:
            foreach ($data as $key=>$item):
                foreach ($item as $keys=>$items):
                    $obj['schedule_no']=$this->input->post('schedule_no');
                    $obj['p_no']=$items->p_no;
                    $obj['area']=$area[$key];
                    $obj['status']='set';

                    $this->volley_model->insert('line_up', $obj);
                endforeach;
            endforeach;
        endif;
    }
    function insert_or_update_test_ajax(){
        $count=$this->get_is_set_test_line_up();

        $data=json_decode($this->input->post('data'));
        $area=array('hm','hb','am','ab');

        if($count > 0):
            foreach ($data as $key=>$item):
                foreach ($item as $keys=>$items):
                    $obj['schedule_no']=$this->input->post('schedule_no');
                    $obj['p_no']=$items->p_no;
                    $obj['area']=$area[$key];
                    $obj['status']='set';

                    $this->volley_model->update('test_line_up', $obj, array('schedule_no'=>$obj['schedule_no'],'area'=>$obj['area'],'p_no'=>$obj['p_no'],'status'=>$obj['status']));
                endforeach;
            endforeach;
        else:
            foreach ($data as $key=>$item):
                foreach ($item as $keys=>$items):
                    $obj['schedule_no']=$this->input->post('schedule_no');
                    $obj['p_no']=$items->p_no;
                    $obj['area']=$area[$key];
                    $obj['status']='set';

                    $this->volley_model->insert('test_line_up', $obj);
                endforeach;
            endforeach;
        endif;
    }

    function update_user_level_ajax() {
        $data=json_decode($this->input->post('data'));
        $this->volley_model->update_user_level($data->id, $data->level);
    }

    function delete_test_mode_ajax($all_or_one) {
        $this->volley_model->delete_test_mode($all_or_one, $this->input->post('schedule_no'));
    }

    function update_event($table) {
        $home_score = $this->input->post('home_score');
        $away_score = $this->input->post('away_score');
        $message = $this->input->post('message');
        $id = $this->input->post('id');

        $this->volley_model->update_event($table, $id, array('home_score'=>$home_score, 'away_score'=>$away_score, 'message'=>$message));
    }

    function get_player_ajax() {
        $source=$this->curl->simple_get('http://www.kovo.co.kr/team/21132_player_view.asp?t_code=2005&s_part=2&p_code='.$this->input->post('id'));

        $exp1=explode('<p class="name">', $source);
        $exp2=explode('</p>', $exp1[1]);

        $exp3=explode('" selected>', $source);
        $exp4=explode('</option>', $exp3[1]);
        $exp5=explode('<option value="', $exp3[0]);

        $exp6=explode('/</span><strong>', $source);
        $exp7=explode('</strong>', $exp6[1]);
        $sex=($exp7[0] == '남자부') ? 'M' : 'W';

        $result=array('season'=>2,'sex'=>$sex,'id'=>$this->input->post('id'),'name'=>$exp2[0],'team'=>$exp4[0],'team_no'=>$exp5[sizeof($exp5)-1],'useable'=>'Y','history'=>'N');

        echo json_encode($result);
    }

    function add_player_ajax() {
        $data=json_decode($this->input->post('data'));
        $this->volley_model->insert_or_update('players', $data, array('id'=>$data->id));
    }

    function get_teams_ajax() {
        echo json_encode($this->volley_model->get_teams($this->input->post('sex')));
    }

    function get_players_by_team_ajax() {
        echo json_encode($this->volley_model->get_where('players', array('team_no'=>$this->input->post('team_no'))));
    }

    function get_player_position_ajax() {
        echo $this->volley_model->get_player_position($this->input->post('id'));
    }

    function update_player_position_ajax() {
        echo $this->volley_model->update_player_position($this->input->post('id'), $this->input->post('position'));
    }

    function update_player_history() {
        echo json_encode($this->volley_model->update_player_history($this->input->post('id')));
    }

    function insert_player_ajax() {
        $data = json_decode($this->input->post('data'));
        $this->volley_model->insert('players', $data);
    }

    function update_game_status_ajax() {
        $this->volley_model->update_schedule_status($this->input->post('table'), $this->input->post('schedule_no'));
    }

    function match_game_stat_ajax() {
        $result['schedule_no'] = $this->input->post('schedule_no');
        $result['home_id'] = $this->volley_model->get_where_row('team_info', array('s_name'=>$this->input->post('home')))->id;
        $result['away_id'] = $this->volley_model->get_where_row('team_info', array('s_name'=>$this->input->post('away')))->id;

        $match_stat = $this->volley_model->get_where_row('match_game_stat', array('schedule_no'=>$result['schedule_no']));
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

        $home_away = ($this->input->post('attack_side') === 'home') ? 'h' : 'a';

        if($this->input->post('sv') === 'o') $result[$home_away.'_sv']++;
        if($this->input->post('bk') === 'o') $result[$home_away.'_bk']++;
        if($this->input->post('svf') === 'o') $result[$home_away.'_svf']++;

        if($match_stat) $this->volley_model->update('match_game_stat', $result, array('idx'=>$match_stat->idx));
        else $this->volley_model->insert('match_game_stat', $result);
    }

    function del_match_game_stat_ajax() {
        $result['schedule_no'] = $this->input->post('schedule_no');
        $result['home_id'] = $this->volley_model->get_where_row('team_info', array('s_name'=>$this->input->post('home')))->id;
        $result['away_id'] = $this->volley_model->get_where_row('team_info', array('s_name'=>$this->input->post('away')))->id;

        $match_stat = $this->volley_model->get_where_row('match_game_stat', array('schedule_no'=>$result['schedule_no']));
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

        $home_away = ($this->input->post('attack_side') === 'home') ? 'h' : 'a';

        if($this->input->post('sv') === 'o') $result[$home_away.'_sv']--;
        if($this->input->post('bk') === 'o') $result[$home_away.'_bk']--;
        if($this->input->post('svf') === 'o') $result[$home_away.'_svf']--;

        if($match_stat) $this->volley_model->update('match_game_stat', $result, array('idx'=>$match_stat->idx));
        else $this->volley_model->insert('match_game_stat', $result);
    }

    function change_set_score_ajax() {
        $home_away = $this->input->post('home_away');
        $set_score = $this->input->post('set_score');
        $schedule_no = $this->input->post('schedule_no');

        $this->volley_model->update('schedule', array($home_away.'_score'=>$set_score), array('no'=>$schedule_no));
    }
}