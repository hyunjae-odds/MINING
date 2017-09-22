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

    function lineup(){
	    $this->auth();

	    $date=($this->input->get('date')==null)? date('Y-m-d'): $this->input->get('date');

	    $schedule=$this->volley_model->get_schedule('schedule', array('date'=>$date, 'sex'=>$this->input->get('sex')));
	    $line_up=($schedule->is_schedule=='G')? $this->volley_model->get_lineup($schedule->no, 'starting'):'';
	    $players=($schedule->is_schedule=='T')? $this->volley_model->get_this_days_players($schedule->home, $schedule->away):'';

        $this->load->view('/volleyball/lineup', array('date'=>$date,'schedule'=>$schedule,'line_up'=>$line_up,'players'=>$players));
    }

    function input($schedule_no, $set){
        $schedule=$this->volley_model->get_schedule('schedule', array('no'=>$schedule_no));
        $session=$this->session->all_userdata();
        $attack_side=($this->input->get('attack_side')==null)? $this->volley_model->get_last_attack_side($schedule):$this->input->get('attack_side');
        $last_set=($this->input->get('last_set')==null)? $this->volley_model->get_last_set($schedule):$this->input->get('last_set');
        $served_side=$this->volley_model->get_first_attack_side($schedule_no, $last_set);
        $team_side=($this->input->get('team_side')==null)? 'typeA':$this->input->get('team_side');

        $line_up=$this->volley_model->get_lineup($schedule->no, 'ing');
        $status=$this->volley_model->get_where_row('schedule', array('no'=>$schedule->no))->status;
        $message=$this->volley_model->get_message($schedule, $set);
        $score=$this->volley_model->get_score($schedule->no, $last_set);

        $this->load->view('/volleyball/input', array('schedule'=>$schedule,'line_up'=>$line_up,'session'=>$session,'status'=>$status,'message'=>$message,'attack_side'=>$attack_side,'last_set'=>$last_set,'score'=>$score,'served_side'=>$served_side,'set'=>$set,'team_side'=>$team_side));
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

    function insert_event_ajax(){
        $this->volley_model->insert_event(json_decode($this->input->post('data')));
    }

    function del_event_ajax(){
        $this->volley_model->update('event', array('delete_yn'=>'Y'), array('no'=>$this->input->post('data')));
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

    function update_set_score_ajax(){
        $schedule_no=$this->input->post('schedule_no');
        $home_score=$this->input->post('home_score');
        $away_score=$this->input->post('away_score');

        $this->volley_model->update('schedule', array('home_score'=>$home_score,'away_score'=>$away_score), array('no'=>$schedule_no));
    }

    function update_ajax(){
        $this->volley_model->update($this->input->post('table'), array('status'=>$this->input->post('status')), array('no'=>$this->input->post('schedule_no')));
    }
}