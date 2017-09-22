<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Message_ extends CI_Controller{

	function __construct(){
		parent::__construct();

		$this->load->helper('form');
		$this->load->model('/baseball/game_model');
		$this->load->model('/message/message_model');
	}

	function index(){
		$schedule = $this->game_model->schedule();

		$this->load->view('/message/index', array('schedule'=>$schedule));
	}

	function playball_by_teamno(){
		$result = $this->game_model->get_game_by_team_no($this->input->get('name'));
		$this->playball($result->no, 0);
	}

	function playball($date, $game_no, $inning){
		/* 경기_목록 */
		$schedule = $this->game_model->schedule($date);
		/* 전광판 */
		$game_data = $this->game_model->read_game_data($game_no);
		$game_score = $this->game_model->read_game_score($game_no);
		/* 경기_상세 */
		$schedule_detail = $this->game_model->get_game($game_no);
		$home_line_major = $this->game_model->get_team_line($game_no, $schedule_detail->home_no);
		$away_line_major = $this->game_model->get_team_line($game_no, $schedule_detail->away_no);
		/* 메세지 */
		$playingInning = $this->message_model->getCurrentInning($game_no);

		$this->load->view('/message/message', array('game_no'=>$game_no, 'schedule'=>$schedule, 'playingInning'=>$playingInning, 'selectedInning'=>$inning,
						  'game_data'=>$game_data, 'game_score'=>$game_score, 'detail'=>$schedule_detail, 'home_line_major'=>$home_line_major,
						  'away_line_major'=>$away_line_major, 'date'=>$date));
	}

	function get_messsage_ajax($schedule_no, $inning){
		/* 전광판 */
		$game_data = $this->game_model->read_game_data($schedule_no);
		$game_score = $this->game_model->read_game_score($schedule_no);
		/* 메세지 */
		$result = $this->message_model->getMessageAjax($schedule_no, $inning);

		$message = $game_data->pitch.'::'.$game_data->so.'::'.$game_data->ball.'::'.$game_data->rheb.'::'.$game_score->score.'::';
		foreach($result as $entry) $message = $message.$entry->message;

		echo $message;
	}

	function get_playing_inning_ajax($schedule_no){
		echo $this->message_model->getCurrentInning($schedule_no);
	}

	function get_playing_player_ajax($game_no, $home_no, $away_no){
		$away_line_major = $this->game_model->get_team_line($game_no, $away_no);
		$home_line_major = $this->game_model->get_team_line($game_no, $home_no);

		$result = '';
		foreach ($away_line_major as $key=>$entry) {
			($key != 9) ? $result = $result.$entry->player.';' : $result = $result.$entry->player.'::';
		}
		foreach ($home_line_major as $key=>$entry){
			($key != 9) ? $result = $result.$entry->player.';' : $result = $result.$entry->player;
		}

		echo $result;
	}
}
