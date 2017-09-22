<?php class Crawling_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	/* GET */
	function getTeamNo($teamName){
		$this->db->select('no');
		$this->db->where('team_name', $teamName);
		
		return $this->db->get('teams')->row();
	}
	function getList($table, $playerId){
		return $this->db->get_where($table, array('player_id'=>$playerId))->result();
	}
	function getListWithOrderBy($table, $playerId, $orderBy, $ascOrDesc){
		$this->db->order_by($orderBy, $ascOrDesc);
		return $this->db->get_where($table, array('player_id'=>$playerId))->result();
	}
	function getPlayerIdListByTeam($team_no){
		return $this->db->get_where('player_basic', array('team_no'=>$team_no))->result();
	}
	function getListByTeam($team_no, $playerId){
		$this->db->order_by('name');
		
		return $this->db->get_where('player_basic', array('team_no'=>$team_no, 'player_id'=>$playerId))->result();
	}
	function getPlayerListByTeam($team_no){
		$this->db->select('*');
		$this->db->order_by('player_id', 'DESC');
	
		return $this->db->get_where('players', array('team_no'=>$team_no))->result();
	}
	function getByLimit($table, $limit){
		$this->db->order_by('insert_dt', 'desc');
		$this->db->order_by("rank", "asc"); 
		
		return $this->db->get($table, $limit)->result();
	}
	
	/* INSERT */
	function insertPlayerId($team_no, $player_list){
		for($i=0; $i<count($player_list); $i++){
			$this->db->set('player_id', $player_list[$i]['player_id']);
			$this->db->where('team_no', $team_no);
			$this->db->where('name', $player_list[$i]['name']);

			$this->db->update('players');
		}
	}
	function insert($table, $playerId, $data){
		$this->isValueAndDelete($table, $playerId);
		
		foreach($data as $entry){
			foreach($entry as $entries){
				$this->db->set('player_id', $playerId);
		
				$this->db->insert($table, $entries);
			}
		}
	}
	function insertWithNoId($table, $date, $data){
		$this->db->like('insert_dt', $date, 'after');
		$count=$this->db->get($table)->num_rows();
		
		if($count==0){
			foreach($data as $entry){
				$this->db->set('insert_dt', 'NOW()', false);
				
				$this->db->insert($table, $entry);
			}
		}
	}
	function insertWithType($table, $playerId, $data){
		$this->isValueAndDelete($table, $playerId);
		
		foreach($data as $key=>$entry){
			foreach($entry as $entries){
				$this->db->set('type', $key+1);
				$this->db->set('player_id', $playerId);
				
				$this->db->insert($table, $entries);
			}
		}
	}
	function insertUsedOneForeach($table, $playerId, $data){
		$this->isValueAndDelete($table, $playerId);
	
		foreach($data as $entry){
			$this->db->set('player_id', $playerId);
			$this->db->insert($table, $entry);
		}
	}
	function insertUnusedForeach($table, $playerId, $data){
		$isValue=$this->is_value($table, $playerId);
		
		if($isValue<1 && $data!=null) $this->db->insert($table, $data);
	}
	function insertBackNo($table, $playerId, $data){
		$this->db->where('player_id', $playerId);
		
		$this->db->update($table, $data);
	}
	
	/* UPDATE */
	function updateByThisYear($table, $playerId, $data){
		$is_value=$this->db->get_where($table, array('player_id'=>$playerId, 'year'=>THIS_YEAR))->num_rows();
	
		if($is_value!=0 && $playerId!=0) $this->db->update($table, $data, array('year'=>THIS_YEAR, 'player_id'=>$playerId));
	}
	function updatePlayerId($no, $player_id){
		$this->db->where('no', $no);
	
		$this->db->update('players', array('player_id'=>$player_id));
	}
	
	/* VALIDATION */
	function is_value($table, $playerId){
		return $this->db->get_where($table, array('player_id'=>$playerId))->num_rows();
	}
	function isValueAndDelete($table, $playerId){
		$is_value=$this->is_value($table, $playerId);
		if($is_value>0) $this->db->delete($table, array('player_id'=>$playerId));
	}
}
?>