<?php
class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function gets()
	{
		return $this->db->query("SELECT * FROM user")->result();
	}

	function getByEmail($email)
	{
		$result = $this->db->get_where('user', array('email'=>$email))->row();

		return $result;
	}

	function add($option)
	{
		$this->db->set('email', $option['email']);
		$this->db->set('password', $option['password']);
		$this->db->set('nickname', $option['nickname']);
		$this->db->set('created', 'NOW()', false);
		$this->db->insert('user');
		$result = $this->db->insert_id();
		return $result;
	}
}
