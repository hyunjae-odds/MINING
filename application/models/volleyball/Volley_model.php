<?php class Volley_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

    function get_mining_db(){
        $db['hostname']='210.180.118.148';
        $db['username']='mining';
        $db['password']='tkqwlf4Qkdlxld!';
        $db['database']='volleyball_mining';
        $db['dbdriver']='mysqli';
        $db['dbprefix']='';
        $db['pconnect']=FALSE;
        $db['db_debug']=TRUE;
        $db['cache_on']=FALSE;
        $db['cachedir']='/application/cache';
        $db['char_set']='utf8';
        $db['dbcollat']='utf8_general_ci';
        $db['swap_pre']='';
        $db['encrypt']=FALSE;
        $db['compress']=FALSE;
        $db['stricton']=FALSE;
        $db['failover']=array();
        $db['save_queries']=TRUE;

        return $this->load->database($db, TRUE);
    }

	/* INSERT */
    function insert($table, $data){
        $MINING=$this->get_mining_db();

        $MINING->set('insert_dt', 'NOW()', false);
        $MINING->insert($table, $data);
    }

    function insert_or_update($table, $data, $where){
        $MINING=$this->get_mining_db();

        $beforeData=$MINING->get_where($table, $where)->row();
        if(sizeof($beforeData)==0):
            $MINING->set('insert_dt', 'NOW()', false);
            $MINING->insert($table, $data);
        else:
            $MINING->set('update_dt', 'NOW()', false);
            $MINING->where('no', $beforeData->no);
            $MINING->update($table, $data);
        endif;
    }

    function insert_event($data){
        $MINING=$this->get_mining_db();

        $MINING->set('insert_dt', 'NOW()', false);
        $MINING->insert('event', $data);
    }

    /* GET */
    function get($table){
        $MINING=$this->get_mining_db();

        return $MINING->get($table)->result();
    }

    function get_where($table, $where){
        $MINING=$this->get_mining_db();

        return $MINING->get_where($table, $where)->result();
    }

    function get_where_row($table, $where){
        $MINING=$this->get_mining_db();

        return $MINING->get_where($table, $where)->row();
    }

    function get_this_days_players($home, $away){
        $result=array();
        $MINING=$this->get_mining_db();
        if($home=='GS칼텍스') $home='GS 칼텍스';
        elseif($away=='GS칼텍스') $away='GS 칼텍스';

        $MINING->select('players.no,players.name,player_detail.shirt_number,player_detail.position');
        $MINING->where('useable', 'Y');
        $MINING->where('history', 'N');
        $MINING->where('team', $home);
        $MINING->join('player_detail', 'player_detail.id=players.id');
        $result['home']=$MINING->get('players')->result();

        $MINING->select('players.no,players.name,player_detail.shirt_number,player_detail.position');
        $MINING->where('useable', 'Y');
        $MINING->where('history', 'N');
        $MINING->where('team', $away);
        $MINING->join('player_detail', 'player_detail.id=players.id');
        $result['away']=$MINING->get('players')->result();

        return $result;
    }

    function get_lineup($schedule_no, $status){
        $result=array();
        $area=array('hm','hb','hn','am','ab','an');
        $MINING=$this->get_mining_db();

        $MINING->select('players.no, players.id, players.name, players.team, line_up.area, player_detail.shirt_number, player_detail.position');
        $MINING->join('players', 'line_up.p_no=players.no');
        $MINING->join('player_detail', 'players.id=player_detail.id');
        $line_up=$MINING->get_where('line_up', array('line_up.schedule_no'=>$schedule_no, 'players.history'=>'N', 'status'=>$status))->result();

        foreach($area as $items):
            $area_arr=array();
            foreach($line_up as $item) if($item->area==$items) array_push($area_arr, $item);
            $result[$items]=$area_arr;
        endforeach;

        return $result;
    }

    function get_schedule($table, $where){
        $result=$this->get_where_row($table, $where);
        $line_up=(sizeof($result) > 0)? $this->get_where('line_up', array('schedule_no'=>$result->no)) : '';

        if(sizeof($result)==0) $result=(object) array('no'=>0, 'is_schedule'=>'F');
        elseif(sizeof($line_up) > 0) $result->is_schedule='G';
        else $result->is_schedule='T';

        return $result;
    }

    function get_message($schedule, $set){
        $MINING=$this->get_mining_db();

        $MINING->order_by('score_no', 'DESC');
        $MINING->order_by('rallying_no', 'DESC');

        return $MINING->get_where('event', array('schedule_no'=>$schedule->no,'set'=>$set,'delete_yn'=>'N','type !='=>'notice'))->result();
    }

    function get_last_set($schedule){
        $MINING=$this->get_mining_db();

        $MINING->select('set');
        $MINING->distinct();
        $MINING->order_by('set', 'DESC');
        $result=$MINING->get_where('event', array('schedule_no'=>$schedule->no,'type'=>'notice'))->row();

        $result=(sizeof($result) > 0)? $result->set : 0;

        return $result;
    }

    function get_last_attack_side($schedule){
        $MINING=$this->get_mining_db();

        $MINING->select('attack_side');
        $MINING->order_by('no', 'DESC');
        $result=$MINING->get_where('event', array('schedule_no'=>$schedule->no), 1)->row();
        $result=(sizeof($result) > 0)? $result->attack_side : '';

        return $result;
    }

    function get_score($schedule_no, $last_set){
        $MINING=$this->get_mining_db();
        $result=array();

        for($i=1; $i<=$last_set; $i++):
            $MINING->select('home_score, away_score');
            $MINING->order_by('no', 'DESC');
            $event=$MINING->get_where('event', array('schedule_no'=>$schedule_no, 'set'=>$i,'type'=>'message'))->row();
            if(sizeof($event) == 0) $event=(object)array('home_score'=>'0','away_score'=>'0');

            array_push($result, $event);
        endfor;

        return $result;
    }

    function get_first_attack_side($schedule_no, $last_set){
        $MINING=$this->get_mining_db();

        $MINING->select('attack_side');
        $MINING->order_by('score_no', 'ASC');
        $MINING->order_by('rallying_no', 'ASC');
        $result=$MINING->get_where('event', array('schedule_no'=>$schedule_no,'type'=>'message','set'=>$last_set-1))->row();

        return (sizeof($result)==0)? '':$result->attack_side;
    }

    function get_player_detail_with_name($id){
        $MINING=$this->get_mining_db();

        $MINING->select('player_detail.*, players.name');
        $MINING->join('players', 'players.id=player_detail.id');

        return $MINING->get_where('player_detail', array('player_detail.id'=>$id))->row();
    }

    /* UPDATE */
    function update($table, $data, $where){
        $MINING=$this->get_mining_db();

        $MINING->set('update_dt', 'NOW()', false);
        $MINING->update($table, $data, $where);
    }

    function update_lineup($schedule_no, $home_away, $major_p_no, $bench_p_no){
        $area_major=($home_away=='home')? 'hm':'am';
        $area_bench=($home_away=='home')? 'hb':'ab';
        $MINING=$this->get_mining_db();

        $MINING->set('update_dt', 'NOW()', false);
        $MINING->update('line_up', array('schedule_no'=>$schedule_no,'area'=>$area_major,'status'=>'ing','p_no'=>$bench_p_no), array('schedule_no'=>$schedule_no,'area'=>$area_major,'status'=>'ing','p_no'=>$major_p_no));

        $MINING->set('update_dt', 'NOW()', false);
        $MINING->update('line_up', array('schedule_no'=>$schedule_no,'area'=>$area_bench,'status'=>'ing','p_no'=>$major_p_no), array('schedule_no'=>$schedule_no,'area'=>$area_bench,'status'=>'ing','p_no'=>$bench_p_no));
    }
}
