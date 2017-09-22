<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Baseball extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('/baseball/game_model');
	}

	function auth(){
        $this->load->helper('url');
		if(!$this->session->userdata('is_login')) redirect("/");
	}

	function schedule($date, $game_no, $inning){
		$this->auth();

		if($date=="" || $date==null) $date=date('Y-m-d');
		$schedule=$this->game_model->schedule($date);

		$level=$this->game_model->get_user_level($this->session->userdata('email'));//접속자 권한::170615_updated

		if($game_no!=0){
			$game=$this->game_model->get_game($game_no);
			$home_line=$this->game_model->get_line($game->home_no);
			$away_line=$this->game_model->get_line($game->away_no);
			$home_line_major=$this->game_model->get_team_line($game_no, $game->home_no);
			$away_line_major=$this->game_model->get_team_line($game_no, $game->away_no);

			if($inning==0 || $inning==null){
				$this->load->model('/message/message_model');
				$inning=$this->message_model->getCurrentInning($game_no);
			}

			$this->load->view('/baseball/schedule', array('schedule'=>$schedule, 'game' =>$game, 'home_line'=>$home_line, 'away_line'=>$away_line, 'level'=>$level,
					          'home_line_major'=>$home_line_major, 'away_line_major'=>$away_line_major, 'game_no'=>$game_no, 'inning'=>$inning, 'date'=>$date));
		}else{
			$this->load->view('/baseball/schedule', array('schedule'=>$schedule, 'game' =>'', 'game_no'=>$game_no, 'inning'=>$inning, 'date'=>$date, 'level'=>$level));
		}
	}

	function line_up(){
		$this->auth();

		$token=explode(';', $this->input->post("token"));
		$line_up=array("","","","","","","");
		$line_up[6]=$this->session->userdata('email');

		for($i=0; $i<count($token); $i++){
			if($i%6==0) $line_up[0]=$token[$i];//경기 번호
			else if($i%6==1) $line_up[1]=$token[$i];//팀 번호
			else if($i%6==2) $line_up[2]=$token[$i];//타순, 투수 구분
			else if($i%6==3) $line_up[3]=$token[$i];//선수 번호
			else if($i%6==4) $line_up[4]=$token[$i];//수비
			else if($i%6==5){
				$line_up[5]=$token[$i];//player_id
                $line_up_count=$this->game_model->cnt_line_up($line_up[0]);

				if($line_up_count > 0 && $i==5) $this->game_model->delete_line_up($line_up);
				$this->game_model->set_line_up($line_up);
//                $this->game_model->set_line_up_start($line_up[0], $line_up[1], $line_up[5], $line_up[4], $line_up[6], $line_up[2]);//선발선수들 저장(line_up_record)::170614_updated
			}
		}

		$schedule=$this->game_model->get_where_row('schedule', array('no'=>$this->input->post('game_no')));
		if($schedule->away_starter=='' && $schedule->home_starter==''):
            $this->update_schedule_status($this->input->post('game_no'), 'live');
            $this->game_model->update_starter('schedule', $this->input->post('game_no'), $this->input->post('away_starter'), $this->input->post('home_starter'));
		endif;
	}

	function game($date, $game_no, $inning){
		$this->auth();

		$this->load->helper('cookie');
		$duringGame=$this->input->cookie('during_game');

		$cookie=array(
			'name'   => 'during_game',
			'value'  => 'N',
			'domain' => COOKIE_DOMAIN,
			'expire' => '21600'
		);
		if($duringGame==null) $this->input->set_cookie($cookie);

		$this->load->model("/message/message_model");
		$current_inning=$this->message_model->getCurrentInning($game_no);

		if($date=="") $date=date('Y-m-d');
		$game=$this->game_model->get_game($game_no);
		$home_line=$this->game_model->get_team_line($game_no, $game->home_no);
		$away_line=$this->game_model->get_team_line($game_no, $game->away_no);
		$game_data=$this->game_model->read_game_data($game_no);
		$cnt=$this->game_model->row_message($game_no);
		$rows_=$cnt->rows_;

		if($game_data==""){
			$data=array($game_no, "1;0", $home_line[9]->position, $away_line[0]->position, "0;0;0", "0;0", "0;0;0;0;0;0;0;0", "0;0", "0;0;0", $this->session->userdata('email'), "1;1");
			$this->game_model->set_game_data($data);
			$data1=array($game_no, "0;;;;;;;;;;;;;;;;;;;;;;;", $this->session->userdata('email'), "1;0");
			$this->game_model->set_game_score($data1);
			$game_data=$this->game_model->read_game_data($game_no, $inning);
		}

		$game_score=$this->game_model->read_game_score($game_no);
		$game_message="";
		if($rows_!=0) $game_message=$this->game_model->read_game_message($game_data, $inning);
		$during_game=$this->get_cookie("during_game");

		$this->load->view('/baseball/game', array('game' =>$game,'home_line'=>$home_line,'away_line'=>$away_line,'game_data'=>$game_data,'game_score'=>$game_score,
						  'current_inning'=>$current_inning,'rows_'=>$rows_,'game_message'=>$game_message,'during_game'=>$during_game,'game_no'=>$game_no,
						  'inning_'=>$inning,'date'=>$date));
	}

	function message_send(){
		$this->auth();

		$schedule_no=$this->input->post("schedule_no");
		$inning=$this->input->post("inning");
		$pitcher=$this->input->post("pitcher");
		$batter=$this->input->post("batter");
		$message=$this->input->post("message1");

		$data = array($schedule_no, $inning, $pitcher, $batter, $message, $this->session->userdata('email'));
		$this->game_model->set_game_message($data);
	}

	function stat(){
		$this->auth();

		$game_no=$this->input->post("game_no");
		$inning1=$this->input->post("inning1");
		$inning2=$this->input->post("inning2");
		$pitcher=$this->input->post("pitcher");
		$batter=$this->input->post("batter");
		$runner1=$this->input->post("runner1");
		$runner2=$this->input->post("runner2");
		$runner3=$this->input->post("runner3");
		$pitch1=$this->input->post("pitch1");
		$pitch2=$this->input->post("pitch2");
		$rheb1=$this->input->post("rheb1");
		$rheb2=$this->input->post("rheb2");
		$rheb3=$this->input->post("rheb3");
		$rheb4=$this->input->post("rheb4");
		$rheb5=$this->input->post("rheb5");
		$rheb6=$this->input->post("rheb6");
		$rheb7=$this->input->post("rheb7");
		$rheb8=$this->input->post("rheb8");
		$so1=$this->input->post("so1");
		$so2=$this->input->post("so2");
		$ball1=$this->input->post("ball1");
		$ball2=$this->input->post("ball2");
		$ball3=$this->input->post("ball3");

		$taja1=$this->input->post("taja1");
		$taja2=$this->input->post("taja2");

		$now_score=$this->input->post("now_score");

		$game_score=$this->game_model->read_game_score($game_no);
		$score_=explode(";", $game_score->score);
		$score="";

		if($game_score->inning!=$inning1.";".$inning2){
			for($i=0; $i<count($score_); $i++){
				if($score_[$i]==""){
					$score_[$i]=0;
					break;
				}
			}
		}else{
			for($i=0; $i<count($score_); $i++){
				if($score_[$i+1]==""){
					$score_[$i]=$now_score;
					$i=25;
				}
			}
		}
		$bb="";
		for($i=0;$i<24;$i++){
			if($i==23) $score.=$score_[$i];
			else $score.=$score_[$i].";";
		}

		$data=array($game_no, $inning1.";".$inning2, $pitcher, $batter, $runner1.";".$runner2.";".$runner3, $pitch1.";".$pitch2, $rheb1.";".$rheb2.";".$rheb3.";".$rheb4.";".$rheb5.";".$rheb6.";".$rheb7.";".$rheb8, $so1.";".$so2, $ball1.";".$ball2.";".$ball3, $this->session->userdata('email'), $taja1.";".$taja2);

		$this->game_model->update_game_data($data);
		$data1=array($game_no, $score, $this->session->userdata('email'), $inning1.";".$inning2);
		$this->game_model->update_game_score($data1);
	}

	function update_pitching_ajax(){
		$this->game_model->update_pitch_so($this->input->post("game_no"), $this->input->post("pitch"), $this->input->post("so"));
	}

	function set_cookie_ajax(){
		$this->auth();

		$this->load->helper('cookie');
		$cookie=array(
				'name'   => $this->input->post("kindof"),
				'value'  => $this->input->post("num"),
				'domain' => COOKIE_DOMAIN,
				'expire' => '21600'
		);
		delete_cookie($this->input->post("kindof"));
		$this->input->set_cookie($cookie);
	}

	function get_cookie($kind){
		$this->auth();

		$this->load->helper('cookie');
		return $this->input->cookie($kind);
	}

	function get_cookie_ajax($_kindof){
		$this->auth();

		$this->load->helper('cookie');
		echo $this->input->cookie($_kindof);
	}

	function is_game_ajax(){
		$this->load->model('/message/message_model');
		$is_game=$this->message_model->getMessage($this->input->post("game_no"));

		if(isset($is_game[0]->no)) echo true;
	}

	function get_game_rule_ajax(){
		$this->auth();

		$command=$this->input->post("command");

		$object = $this->game_model->get_game_rule($command);

		if ($object==null) echo "null";
		else echo $object->rule;
	}

	function challenge($game_no, $inning){
		$game=$this->game_model->get_game($game_no);
		$home_line=$this->game_model->get_team_line($game_no, $game->home_no);
		$away_line=$this->game_model->get_team_line($game_no, $game->away_no);
		$game_data=$this->game_model->read_game_data($game_no);

		$this->load->view("/baseball/challenge", array('game' =>$game, 'game_data'=>$game_data, 'home_line'=>$home_line, 'away_line'=>$away_line, 'inning'=>$inning));
	}

	function set_line_up_record_ajax(){
	    $schedule_no=$this->input->post('schedule_no');
        $change_players=$this->input->post('change_player');
        $exp=explode(',', $change_players);

        foreach($exp as $key=>$item):
            $home_away=($key==0)? 'home' : 'away';

            $exp2=explode('_', $item);
            foreach($exp2 as $items):
                $exp3=explode(';', $items);
                $result=array('tasoon'=>$exp3[0], 'name'=>$exp3[1], 'position'=>$exp3[2]);
                $insert_id=($this->session->userdata('email')==null)? '' : $this->session->userdata('email');

                $this->game_model->set_line_up_record($schedule_no, $home_away, $result, $insert_id);
            endforeach;
        endforeach;
    }

    function update_schedule_status($game_no, $status){
	    $status=($status=='')? '' : urldecode($status);
        $this->game_model->update_schedule_status($game_no, $status);
    }
}
