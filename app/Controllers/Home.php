<?php

namespace App\Controllers;

class Home extends BaseController
{
    
	public function __construct() {
		$this->event = model('App\Models\Event');
		$this->returns = array('access' => FALSE, 'status' => FALSE, 'title' => "Authentication Failure", 'msg' => 'Login to Continue');
	}

	public function Index() {
        return view('eventlist');
    }

	public function EventList() {
		$this->returns['access'] = TRUE;
		$this->returns['status'] = TRUE;
		$arg = ['start' => (!is_null($this->request->getGet('start')) && !empty($this->request->getGet('start')) ? $this->request->getGet('start') : 0),
				'limit' => (!is_null($this->request->getGet('length')) && !empty($this->request->getGet('length')) ? $this->request->getGet('length') : 10),
				'from' => (!is_null($this->request->getGet('from')) && !empty($this->request->getGet('from')) ? date("Y-m-d", strtotime($this->request->getGet('from'))) : date('Y-m-01')),
				'to' => (!is_null($this->request->getGet('to')) && !empty($this->request->getGet('to')) ? date("Y-m-d", strtotime($this->request->getGet('to'))) : date('Y-m-d')),
				'title' => (!is_null($this->request->getGet('title')) && !empty($this->request->getGet('title')) ? $this->request->getGet('title') : NULL),
				'privacy' => 'Public',
				'status' => 'Approved'
				];

		$this->returns['draw'] = $this->request->getGet('draw');
		$this->returns['recordsTotal'] =$this->event->EventCount($arg);
		$this->returns['recordsFiltered'] = $this->event->EventCount($arg);
		$this->returns['data'] =  $this->event->DataList($arg);

		return $this->response->setJSON($this->returns);
	}
}
