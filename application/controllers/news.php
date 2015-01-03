<?php
class News extends CI_Controller{
    public function __construct(){
	parent::__construct();
	$this->load->model('news_model');
    }
    
    //http://localhost/codeigniter/index.php/news/
    public function index(){		
	$data['news'] = $this->news_model->get_news();
	
	$data['title'] = 'Archivo de noticias';

	$this->load->view('templates/header', $data);
	$this->load->view('news/index', $data);
	$this->load->view('templates/footer');
    }
    public function view($slug){
	$data['news_item'] = $this->news_model->get_news($slug);	
	
	if (empty($data['news_item']))	{
	    show_404();
	}
	
	$data['title'] = $data['news_item']['title'];
	$this->load->view('templates/header', $data);
	$this->load->view('news/view', $data);
	$this->load->view('templates/footer');
    }
    //http://localhost/codeigniter/index.php/news/create/
    public function create(){
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$data['title'] =  'Crear un item de noticias';
	
	$this->form_validation->set_rules('title', 'T�tulo', 'required');
	$this->form_validation->set_rules('text', 'Texto', 'required');
	
	if ($this->form_validation->run() === FALSE){
	    $this->load->view('templates/header', $data);
	    $this->load->view('news/create');
	    $this->load->view('templates/footer');
	}else{
	    $this->news_model->set_news();
	    $this->load->view('news/success');
	}
	
	
    }
}