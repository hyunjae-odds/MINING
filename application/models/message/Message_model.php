<?php
class Message_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	function getMessage($game_no){
		$this->db->where('schedule_no', $game_no);
		$this->db->order_by("no", "desc");
		return $this->db->get('game_message')->result();
	}
	
	function getMessageAjax($schedule_no, $inning){
		$this->db->where('schedule_no', $schedule_no);
		$this->db->like('inning', $inning, 'after');
		$this->db->order_by("no", "desc");
		return $this->db->get('game_message')->result();
	}
	
	function getCurrentInning($schedule_no){
		$this->db->distinct();
		$this->db->select('inning');
		$this->db->where('schedule_no', $schedule_no);
		$this->db->order_by('inning', 'desc');
		$result=$this->db->get('game_message')->result();
		
		$num=array();
		foreach($result as $entry){
			$piece=explode(";", $entry->inning);
			array_push($num, intval($piece[0]));
		}
		if($num==null) $num=array(0,0);
		
		return max($num);
	}
}
?>