<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        // $this->load->model("m_login");
        $this->load->library('form_validation');
        // $this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        $this->load->view("admin/login_page.php");
    }
    public function login_act()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $where = array(
                'username' => $username,
                'password' => $password
        );

        $cek = $this->user_model->cek($where);
        
		if($cek->num_rows() == 1)
		{
			foreach($cek->result() as $data){
				$sess_data['id'] = $data->id;
				$sess_data['username'] = $data->username;
                $sess_data['level'] = $data->level;
                $this->session->set_userdata($sess_data);
            }
            

			if($this->session->userdata('level') == '1')
			{
				redirect('admin/overview');
			}
			elseif($this->session->userdata('level') == 'sales')
			{
				redirect('sales/sales');
			}   
			elseif($this->session->userdata('level') == 'sdi')
			{
				redirect('home');
			}
		}
		else
		{
			$this->session->set_flashdata('pesan', 'Maaf, kombinasi username dengan password salah.');
            redirect('admin/login');
		}
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('admin/login'));
    }

    public function test()
    {
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('foo' => 'bar')));
    }
}
