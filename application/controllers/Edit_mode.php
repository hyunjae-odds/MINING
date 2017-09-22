<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_mode extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('/baseball/game_model');
	}

	function auth(){
		if(!$this->session->userdata('is_login')){
			$this->load->helper('url');
//			redirect("/");
		}
	}

	/* main controller */
	function main($date, $game_no, $inning){
		$this->auth();

		$stadium=$this->game_model->get_stadium();
		if($date=="") $date=date('Y-m-d');
		$schedule=$this->game_model->schedule($date);

		$game=$this->game_model->get_game($game_no);
		$home_line=$this->game_model->get_team_line($game_no, $game->home_no);
		$away_line=$this->game_model->get_team_line($game_no, $game->away_no);
		$game_data=$this->game_model->read_game_data($game_no);
		$cnt=$this->game_model->row_message($game_no);
		$rows_=$cnt->rows_;

		if($game_data==""){
			$data=array($game_no, "1;0", $home_line[9]->player, $away_line[0]->player, "0;0;0", "0;0", "0;0;0;0;0;0;0;0", "0;0", "0;0;0", $this->session->userdata('email'), "1;1");
			$this->game_model->set_game_data($data);
			$data1=array($game_no, "0;;;;;;;;;;;;;;;;;;;;;;;", $this->session->userdata('email'), "1;0");
			$this->game_model->set_game_score($data1);
			$game_data=$this->game_model->read_game_data($game_no, $inning);
		}

		$game_score=$this->game_model->read_game_score($game_no);
		$game_message="";
		if($rows_!=0) $game_message=$this->game_model->read_game_message($game_data, $inning);
		$during_game=$this->get_cookie("during_game");

		$this->load->view('/baseball/edit_mode', array('game' =>$game, 'home_line'=>$home_line, 'away_line'=>$away_line, 'game_data'=>$game_data, 'game_score'=>$game_score, 'date'=>$date,'status'=>$game->status,
				'rows_'=>$rows_, 'game_message'=>$game_message, 'during_game'=>$during_game, 'game_no'=>$game_no, 'inning_'=>$inning, 'stadium'=>$stadium, 'schedule'=>$schedule));
	}

	/* 메세지 관리 */
	function delete_message($game_no, $inning){
		$this->game_model->delete_message($game_no, $inning);
	}

	/* 선수 관리 */
	function get_player_order_by_backnum_ajax($team_no){
		$player=$this->game_model->get_line_order_by_backnum($team_no);
		$playerList="";
		foreach($player as $entry){
			$playerList.=$entry->no.";";
			$playerList.=$entry->back_num.";";
			$playerList.=$entry->name.";";
			$playerList.=$entry->position.";";
			$playerList.=$entry->player_id.";";
			$playerList.=$entry->delete_yn."::";
		}

		echo $playerList;
	}
	function insert_players_ajax($team_no, $back_num){
		$arr=array('team_no'=>$team_no,'position'=>$this->input->post('position'),'name'=>$this->input->post('name'),'back_num'=>$back_num,'player_id'=>$this->input->post('player_id'));

		$this->game_model->insert('players', $arr);
	}
	function update_players_ajax($player_no, $back_num){
		$delete_yn='N';
		if($this->input->post('is_checked')=='true') $delete_yn='Y';
		$arr=array('position'=>$this->input->post('position'),'name'=>$this->input->post('name'),'back_num'=>$back_num,'player_id'=>$this->input->post('player_id'),'delete_yn'=>$delete_yn);

		$this->game_model->update_player($player_no, $arr);
	}
	function delete_players_ajax($player_no){
		$this->game_model->delete('players', 'no', $player_no);
	}

	/* 경기장 관리 */
	function insert_stadium(){
		$name=$this->input->post('name');
		$this->game_model->insert_stadium($name);
	}
	function update_stadium($table, $no){
		$name=$this->input->post('name');
		$this->game_model->update($table, $no, $name);
	}
	function delete($table, $no){
		$this->game_model->delete($table, 'no', $no);
	}

	/* 스케쥴 관리 */
	function insert_schedule_ajax(){
		$this->load->helper('date');
		$game_time=$this->input->post('game_time');
		$_date=explode("T", $game_time);
		$date=explode("-", $_date[0]);
		$date2=explode(":", $_date[1]);

		$game_time=date('Y-m-d H:i:s', mktime($date2[0], $date2[1], 0, $date[1], $date[2], $date[0]));
		$home_no=$this->input->post('home_no');
		$home_name=$this->input->post('home_name');
		$away_no=$this->input->post('away_no');
		$away_name=$this->input->post('away_name');
		$stadium=$this->input->post('stadium');

		$this->game_model->insert_schedule($game_time, $home_no, $home_name, $away_no, $away_name, $stadium);
	}
	function update_schedule_ajax($schedule_no){
		$this->load->helper('date');
		$game_time=$this->input->post('game_time');
		$_date=explode(" ", $game_time);
		$date=explode("-", $_date[0]);
		$date2=explode(":", $_date[1]);

		$game_time=date('Y-m-d H:i:s', mktime($date2[0], $date2[1], 0, $date[1], $date[2], $date[0]));
		$home_no=$this->input->post('home_no');
		$home_name=$this->input->post('home_name');
		$away_no=$this->input->post('away_no');
		$away_name=$this->input->post('away_name');
		$stadium=$this->input->post('stadium');

		$this->game_model->update_schedule($schedule_no, $game_time, $home_no, $home_name, $away_no, $away_name, $stadium);
	}

	/* 게임 스코어 관리 */
	function update_game_score_ajax($schedule_no){
		$array=array('score'=>$this->input->post('score'));

		$this->game_model->update_game_score_only($schedule_no, $array);
	}

	/* COOKIE GET/SETTER */
	function set_cookie_ajax(){
		$this->auth();

		$this->load->helper('cookie');
		$cookie = array(
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
	function get_cookie_ajax(){
		$this->auth();

		$this->load->helper('cookie');
		echo $this->input->cookie($this->input->post("kindof"));
	}
}
?>
