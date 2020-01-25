<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mobil extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mobil_model', 'mbl_model');
	}

	public function index_get()
	{
		$kriteria 	= $this->get('kriteria');
		$keyword 	= $this->get('keyword');
		$id 		= $this->get('id');
		if (isset($id)) {
			$mobil = $this->mbl_model->getMobil($id);
		}
		elseif (isset($kriteria, $keyword)) {
			$mobil = $this->mbl_model->cariMobil($kriteria, $keyword);
		}else{
			$mobil = $this->mbl_model->getMobil();
		}

		if ($mobil){
			$this->response([
                    'status' => true,
                    'data' => $mobil
                ], REST_Controller::HTTP_OK);
		}else{
			$this->response([
                    'status' => false,
                    'data' => $mobil,
                    'message' => 'NOT FOUND'
                ], REST_Controller::HTTP_NO_CONTENT);
		}

	}

	public function index_post()
	{
		$data = [
			'no_kerangka'	=>	$this->post('no_kerangka'),
			'no_polisi'		=>	$this->post('no_polisi'),
			'brand'			=>	$this->post('brand'),
			'type'			=>	$this->post('type'),
			'year'			=>	$this->post('year')
		];

		if ($this->mbl_model->createMobil($data) > 0) {
			$this->response([
                    'status' => true,
                    'message' => 'New Mobil has been created'
                ], REST_Controller::HTTP_CREATED);
		}else{
			$this->response([
                    'status' => false,
                    'message' => 'fail to create new data'
                ], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'no_kerangka'	=>	$this->put('no_kerangka'),
			'no_polisi'		=>	$this->put('no_polisi'),
			'brand'			=>	$this->put('brand'),
			'type'			=>	$this->put('type'),
			'year'			=>	$this->put('year')
		];

		if ($this->mbl_model->updateMobil($data, $id) > 0) {
			$this->response([
                    'status' => true,
                    'message' => 'Mobil has been updated'
                ], REST_Controller::HTTP_OK);
		}else{
			$this->response([
                    'status' => false,
                    'message' => 'fail to update data'
                ], REST_Controller::HTTP_NO_CONTENT);
		}
	}	

	public function index_delete()
	{
		$id = $this->delete('id');
		if($id === null){
			$this->response([
                    'status' => false,
                    'message' => 'Provide an ID'
                ], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			if ($this->mbl_model->deleteMobil($id) > 0) {
				$this->response([
                    'status' => true,
                    'id'	=> $id,
                    'message' => 'deleted'
                ], REST_Controller::HTTP_OK);
			}else{
				$this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}

}