<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function register(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('nickname', '닉네임', 'required|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[30]|matches[re_password]');
		$this->form_validation->set_rules('re_password', '비밀번호 확인', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view("/user/register");
		} else {
			$hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

			$this->load->model('/user/user_model');
			$this->user_model->add(array(
					'email'=>$this->input->post('email'),
					'nickname'=>$this->input->post('nickname'),
					'password'=>$hash,
                    'level'=>3
			));

			$this->session->set_flashdata('message', '회원가입에 성공했습니다.');
			redirect('/');
		}
	}

	function authentication($site){
		$this->load->model('/user/user_model');
		if(!function_exists('password_hash')) $this->load->helper('password');

		$sex=($this->input->post('sex')==null)? 'M' : $this->input->post('sex');
        $user=$this->user_model->getByEmail($this->input->post('userID'));

		if(isset($user) && password_verify($this->input->post('userPW'), $user->password)){
			$user_profile=array(
				'is_login'=>true,
				'email'=>$user->email,
				'nickname'=>$user->nickname,
                'level'=>$user->level
			);
            $this->session->set_userdata($user_profile);

            if($site=='baseball') redirect('/baseball/schedule/'.date('Y-m-d').'/0/0');
			elseif($site=='volleyball') redirect('/volleyball/lineup/'.$sex);
		}else{
			$this->session->set_flashdata('message', '로그인에 실패 하였습니다.');

            if($site=='baseball') redirect("/");
            elseif($site=='volleyball') redirect('/volleyball/login');
		}
	}

	function logout(){
		$this->session->sess_destroy();
		$this->load->helper('url');
		redirect("/");
	}
}
