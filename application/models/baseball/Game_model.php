<?php class Game_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

    function get($table){
        return $this->db->get($table)->result();
    }

    function get_select($table, $select){
        $this->db->select($select);
        return $this->db->get($table)->result();
    }

    function get_query($query){
        return $this->db->query($query)->result();
    }

    function get_where($table, $where){
        return $this->db->get_where($table, $where)->result();
    }

    function get_where_row($table, $where){
        return $this->db->get_where($table, $where)->row();
    }

    function update_schedule_status($schedule_no, $status){
        $this->db->where('no', $schedule_no);
        $this->db->update('schedule', array('status'=>$status));
    }
	
	/* schedule */
	function schedule($date){
		$this->db->select('schedule.no, game_time, home_no, home_name, away_no, away_name, stadinum.name, schedule.status');
		$this->db->join('stadinum', 'stadinum.no = schedule.stadinum');
		$this->db->like('game_time', $date,'after');
		
		return $this->db->get('schedule')->result();
	}

	function insert_schedule($game_time, $home_no, $home_name, $away_no, $away_name, $stadium){
		$this->db->set('game_time', $game_time);
		$this->db->set('home_no', $home_no);
		$this->db->set('home_name', $home_name);
		$this->db->set('away_no', $away_no);
		$this->db->set('away_name', $away_name);
		$this->db->set('stadinum', $stadium);
		
		$this->db->insert('schedule');
	}

	function set_line_up_start($schedule_no, $team_no, $player_id, $position, $insert_id, $pitcher_yn){
	    $check_value=$this->db->get_where('line_up_start', array('schedule_no'=>$schedule_no, 'team_no'=>$team_no))->row();

	    if($check_value->p==null || $check_value->c==null || $check_value->first==null || $check_value->second==null || $check_value->third==null || $check_value->ss==null || $check_value->lf==null || $check_value->cf==null || $check_value->rf==null || $check_value->dh==null):
            $position_arr=array('좌'=>'lf','중'=>'cf','우'=>'rf','지'=>'dh','유'=>'ss','3'=>'third','2'=>'second','1'=>'first','포'=>'c','투'=>'p');
            if($pitcher_yn=='투') $position='투';

            $cnt=$this->db->get_where('line_up_start', array('schedule_no'=>$schedule_no, 'team_no'=>$team_no))->num_rows();
            if($cnt==0):
                $this->db->select('game_time');
                $game_time=$this->db->get_where('schedule', array('no'=>$schedule_no))->row();

                $this->db->set('game_date', $game_time->game_time);
                $this->db->set('schedule_no', $schedule_no);
                $this->db->set('team_no', $team_no);
                $this->db->set($position_arr[$position], $player_id);
                $this->db->set('insert_id', $insert_id);
                $this->db->set('insert_dt', 'NOW()', false);

                $this->db->insert('line_up_start');
            else:
                $this->db->where('schedule_no', $schedule_no);
                $this->db->where('team_no', $team_no);

                $this->db->update('line_up_start', array($position_arr[$position]=>$player_id));
            endif;
        endif;
	}

	function set_line_up_record($schedule_no, $home_away, $data, $insert_id){
	    $schedule=$this->db->get_where('schedule', array('no'=>$schedule_no))->row();
	    $team_no=($home_away=='away')? $schedule->away_no : $schedule->home_no;
        $player_id_row=$this->db->get_where('players', array('team_no'=>$team_no, 'name'=>$data['name']))->row();
        $player_id=$player_id_row->player_id;
        $data['position']=preg_replace('/\r\n|\r|\n/','', $data['position']);

        $this->db->set('insert_id', $insert_id);
        $this->db->set('insert_dt', 'NOW()', false);
        $this->db->insert('line_up_record', array('schedule_no'=>$schedule_no, 'team_no'=>$team_no, 'player_id'=>$player_id, 'tasoon'=>$data['tasoon'], 'position'=>$data['position']));
    }

	function update_schedule($no, $game_time, $home_no, $home_name, $away_no, $away_name, $stadium){
		$this->db->set('game_time', $game_time);
		$this->db->set('home_no', $home_no);
		$this->db->set('home_name', $home_name);
		$this->db->set('away_no', $away_no);
		$this->db->set('away_name', $away_name);
		$this->db->set('stadinum', $stadium);
		$this->db->where('no', $no);
		
		$this->db->update('schedule');
	}

	function get_game($no){
		return $this->db->query("select s.*, DATE_FORMAT(s.game_time, '%Y.%m.%d') as game_time1, DATE_FORMAT(s.game_time, '%H:%i') as game_time2, s.home_no, s.home_name, s.away_no, s.away_name, s1.name as stadinum from schedule as s, stadinum s1 where s.stadinum=s1.no and s.no=".$no)->row();
	}

	function update_starter($table, $game_no, $away_starter, $home_starter){
		$this->db->where('no', $game_no);
		$this->db->update($table, array('away_starter'=>$away_starter, 'home_starter'=>$home_starter));
	}
	
	/* stadium */
	function insert_stadium($name){
		$this->db->set('name', $name);
		$this->db->insert('stadinum');
	}

	function get_stadium(){
		return $this->db->get('stadinum')->result();
	}

	function update_stadium($table, $no, $name){
		$this->db->set('name', $name);
		$this->db->where('no', $no);
		$this->db->update($table);
	}
	
	/* line_up */
	function get_line($no){
		$this->db->order_by('name');
		$this->db->where('team_no', $no);
		$this->db->where('delete_yn', 'N');
		
		return $this->db->get('players')->result();
	}

	function get_line_order_by_backnum($no){
		$this->db->order_by('back_num');
		$this->db->where('team_no', $no);
		
		return $this->db->get('players')->result();
	}

	function set_line_up($line_up){
		$this->db->set('insert_time','NOW()', false);
		$this->db->insert('line_up', array('schedule_no'=>$line_up[0],'team'=>$line_up[1],'player'=>$line_up[3],'position'=>$line_up[2],'subi'=>$line_up[4],'player_id'=>$line_up[5],'insert_id'=>$line_up[6]));
	}

	function cnt_line_up($game_no){
		return $this->db->query("SELECT no FROM line_up WHERE schedule_no='".$game_no."'")->num_rows();
	}

	function get_team_line($game_no, $team_no){
		return $this->db->query("select l.*, p.name from line_up as l, players as p where l.team=p.team_no and l.player_id=p.player_id and l.schedule_no='".$game_no."' and l.team='".$team_no."' order by l.no asc")->result();
	}

	function delete_line_up($line_up){
		$this->db->where('schedule_no', $line_up[0]);
		$this->db->delete('line_up');
	}
	
	/* game_message */
	function row_message($game_no){
		return $this->db->query("select count(*) as rows_ from game_message where schedule_no='".$game_no."'")->row();
	}

	function read_game_message($game_data, $inning){
		if($inning=="0") {$split=explode(";", $game_data->inning); $inning_=$split[0];}
		else $inning_=$inning;
		
		$this->db->where('schedule_no', $game_data->schedule_no);
		/* 연장상황을 위한 if문 */
		if($inning_=='11'){
			$this->db->like('inning', '10;', 'after');
			$this->db->or_like('inning', '11;', 'after');
		}else if($inning_=='12'){
			$this->db->like('inning', '10;', 'after');
			$this->db->or_like('inning', '11;', 'after');
			$this->db->or_like('inning', '12;', 'after');
		}else $this->db->like('inning', $inning_.';', 'after');
		$this->db->order_by("no", "asc");
		
		return $this->db->get('game_message')->result();
	}

	function delete_message($game_no, $inning){
		$this->db->where('schedule_no', $game_no);
		$this->db->like('inning', $inning, 'after');
		$this->db->delete('game_message');
	}

	function set_game_message($data){
		$this->db->set('insert_dt','NOW()', false);
		$this->db->insert('game_message', array(
				'schedule_no'=>$data[0],
				'inning'=>$data[1],
				'pitcher'=>$data[2],
				'batter'=>$data[3],
				'message'=>$data[4],
				'insert_id'=>$data[5],
		));
	}
	
	/* game_data */
	function read_game_data($game_no){
		return $this->db->get_where('game_data', array('schedule_no'=>$game_no))->row();
	}

	function set_game_data($data){
		$this->db->set('insert_dt','NOW()', false);
		$this->db->insert('game_data', array(
				'schedule_no'=>$data[0],
				'inning'=>$data[1],
				'pitcher'=>$data[2],
				'batter'=>$data[3],
				'runner'=>$data[4],
				'pitch'=>$data[5],
				'rheb'=>$data[6],
				'so'=>$data[7],
				'ball'=>$data[8],
				'insert_id'=>$data[9],
				'taja'=>$data[10]
		));
	}

	function update_game_data($data){
		$this->db->set('insert_dt','NOW()', false);
		$where = "schedule_no=".$data[0];
		$this->db->update('game_data', array(
				'inning'=>$data[1],
				'pitcher'=>$data[2],
				'batter'=>$data[3],
				'runner'=>$data[4],
				'pitch'=>$data[5],
				'rheb'=>$data[6],
				'so'=>$data[7],
				'ball'=>$data[8],
				'insert_id'=>$data[9],
				'taja'=>$data[10]
		), $where);
	}

	function update_pitch_so($game_no, $pitch, $so){
		$this->db->where('schedule_no', $game_no);
		$this->db->update('game_data', array('pitch'=>$pitch,'so'=>$so));
	}
	
	/* game_score */
	function read_game_score($game_no){
		$this->db->where('schedule_no', $game_no);
		return $this->db->get('game_score')->row();
	}

	function set_game_score($data){
		$this->db->set('insert_dt','NOW()', false);
		$this->db->insert('game_score', array(
				'schedule_no'=>$data[0],
				'score'=>$data[1],
				'insert_id'=>$data[2],
				'inning'=>$data[3],
		));
	}

	function update_game_score($data){
		$this->db->set('insert_dt','NOW()', false);
		$where = "schedule_no=".$data[0];
		$this->db->update('game_score', array(
				'score'=>$data[1],
				'insert_id'=>$data[2],
				'inning'=>$data[3],
		), $where);
	}

	function update_game_score_only($schedule_no, $array){
		$this->db->where('schedule_no', $schedule_no);
		
		$this->db->update('game_score', $array);
	}
	
	/* players */
	function insert($table, $arr){
		$this->db->insert($table, $arr);
	}

	function update_player($no, $arr){
		$this->db->where('no', $no);
		
		$this->db->update('players', $arr);
	}
	
	/* game_rule */
	function get_game_rule($command){
		return $this->db->get_where('game_rule', array('command'=>$command))->row();
	}
	
	/* CUSTOM */
	function delete($table, $column, $no){
		$this->db->where($column, $no);
		$this->db->delete($table);
	}

	function setPastPlayerId(){
		$line_up=$this->db->get_where('line_up', array('player_id'=>'0'))->result();
		$players=$this->db->get('players')->result();
		
		foreach($line_up as $item):
			foreach($players as $entry):
				if($item->team==$entry->team_no && $item->player==$entry->back_num):
					$this->db->where('team', $item->team);
					$this->db->where('player', $item->player);
					$this->db->update('line_up', array('player_id'=>$entry->player_id));
				endif;
			endforeach;
		endforeach;
	}

	function get_user_level($email){
        $user=$this->db->get_where('user', array('email'=>$email))->row();

        return ($user==null)?3 : $user->level;
    }
}