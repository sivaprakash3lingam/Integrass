<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Events extends BaseController {

	public function __construct() {
		$this->profile = model('App\Models\AdminProfile');
		$this->event = model('App\Models\Event');
		$this->returns = array('access' => FALSE, 'status' => FALSE, 'title' => "Authentication Failure", 'msg' => 'Login to Continue');
	}

	protected function Authenticate() { $profile = ['status'=>FALSE, 'profile'=>[]];
		if(!is_null($this->session->get('admin')) && is_array($this->session->get('admin')) &&
			array_key_exists('code', $this->session->get('admin')) && !is_null($this->session->get('admin')['code']) &&
			array_key_exists('token', $this->session->get('admin')) && !is_null($this->session->get('admin')['token'])) {
			$profile = $this->profile->Auth(['code' => $this->session->get('admin')['code'], 'token' => $this->session->get('admin')['token']]);
		}
		return $profile;
	}

	protected function alert() { return view('alert_message', ['flash'=>$this->session->getFlashdata('alert')]); }

	public function Datalist() { $auth = $this->Authenticate();
		if($auth['status']) {
			$this->returns['access'] = TRUE;
			$this->returns['status'] = TRUE;
			$arg = ['start' => (!is_null($this->request->getGet('start')) && !empty($this->request->getGet('start')) ? $this->request->getGet('start') : 0),
					'limit' => (!is_null($this->request->getGet('length')) && !empty($this->request->getGet('length')) ? $this->request->getGet('length') : 10),
					'from' => (!is_null($this->request->getGet('from')) && !empty($this->request->getGet('from')) ? date("Y-m-d", strtotime($this->request->getGet('from'))) : date('Y-m-01')),
					'to' => (!is_null($this->request->getGet('to')) && !empty($this->request->getGet('to')) ? date("Y-m-d", strtotime($this->request->getGet('to'))) : date('Y-m-d')),
					'title' => (!is_null($this->request->getGet('title')) && !empty($this->request->getGet('title')) ? $this->request->getGet('title') : NULL),
					'privacy' => (!is_null($this->request->getGet('privacy')) && !empty($this->request->getGet('privacy')) ? $this->request->getGet('privacy') : NULL),
					'status' => (!is_null($this->request->getGet('status')) && !empty($this->request->getGet('status')) ? $this->request->getGet('status') : NULL)
					];

			$this->returns['draw'] = $this->request->getGet('draw');
			$this->returns['recordsTotal'] =$this->event->EventCount($arg);
			$this->returns['recordsFiltered'] = $this->event->EventCount($arg);
			$this->returns['data'] =  $this->event->DataList($arg);
		}
		return $this->response->setJSON($this->returns);
	}

	public function Addform() { $profile = $this->Authenticate();
		if($profile['status'] != TRUE) { return redirect()->to(base_url('admin')); exit(0); }
		else { return view('admin/event/addform', ['profile'=>$profile['profile'], 'alert'=>$this->alert()]); }
	}

	public function Addnew() { $auth = $this->Authenticate();
		if($auth['status']) {
			$this->returns['access'] = TRUE;
			$input = [];
			$errors = [];
			if ($this->request->getMethod(true) == 'POST') {
				$this->validation->setRules(['title'=>	['label'=>'Event Title', 'rules'=>'required', 'errors'=>['required'=>'Enter Event Title']],
											'startdate'	=>	['label'=>'Event Start Date', 'rules'=>'required', 'errors'=>['required'=>'Select Event Start Date']],
											'enddate'	=>	['label'=>'Event End Date', 'rules'=>'required', 'errors'=>['required'=>'Select Event End Date']]
											]);
			}
			if($this->validation->withRequest($this->request)->run()) {
				$input['usercode'] = $this->request->getPost('usercode');
				$input['title'] = $this->request->getPost('title');
				$input['desc'] = $this->request->getPost('desc');
				$input['startdate'] = $this->request->getPost('startdate');
				$input['starttime'] = $this->request->getPost('starttime');
				$input['enddate'] = $this->request->getPost('enddate');
				$input['endtime'] = $this->request->getPost('endtime');
				$input['privacy'] = 'Private';
				$input['status'] = 'Pending';

				$state = $this->event->Addnew($input);

				$this->returns['status'] = $state['status'];
				$this->returns['title'] = ($state['status'] ? 'Success' : 'Failure');
				$this->returns['msg'] = ($state['status'] ? 'Event Created Successfully' : 'Unable to Create Event. Please Try Again.');

				$this->session->setFlashdata('alert', ['type'=>'success', 'title'=>$this->returns['title'], 'msg'=>$this->returns['msg']]);
			}
		}
		return $this->response->setJSON($this->returns);
	}

	public function Editform($code) { $profile = $this->Authenticate();
		if($profile['status'] != TRUE) { return redirect()->to(base_url('admin')); exit(0); }
		else {
			$event = $this->event->Event_single(['code'=>$code]);
			return view('admin/event/editform', ['profile'=>$profile['profile'], 'event'=> $event, 'alert'=>$this->alert()]);
		}
	}

	public function Update($code) { $auth = $this->Authenticate();
		if($auth['status']) {
			$this->returns['access'] = TRUE;
			$input = [];
			$errors = [];
			if ($this->request->getMethod(true) == 'POST') {
				$this->validation->setRules(['title'=>	['label'=>'Event Title', 'rules'=>'required', 'errors'=>['required'=>'Enter Event Title']],
											'startdate'	=>	['label'=>'Event Start Date', 'rules'=>'required', 'errors'=>['required'=>'Select Event Start Date']],
											'enddate'	=>	['label'=>'Event End Date', 'rules'=>'required', 'errors'=>['required'=>'Select Event End Date']]
											]);
			}
			if($this->validation->withRequest($this->request)->run()) {
				$input['code'] = $code;
				$input['title'] = $this->request->getPost('title');
				$input['desc'] = $this->request->getPost('desc');
				$input['startdate'] = $this->request->getPost('startdate');
				$input['starttime'] = $this->request->getPost('starttime');
				$input['enddate'] = $this->request->getPost('enddate');
				$input['endtime'] = $this->request->getPost('endtime');
				//$input['privacy'] = 'Private';
				//$input['status'] = 'Pending';

				$state = $this->event->Update($input, $code);

				$this->returns['status'] = $state['status'];
				$this->returns['title'] = ($state['status'] ? 'Success' : 'Failure');
				$this->returns['msg'] = ($state['status'] ? 'Event Updated Successfully' : 'Unable to Update Event Details. Please Try Again.');

				$this->session->setFlashdata('alert', ['type'=>'success', 'title'=>$this->returns['title'], 'msg'=>$this->returns['msg']]);
			}
		}
		return $this->response->setJSON($this->returns);
	}

	public function Delete($code) { $auth = $this->Authenticate();
		if($auth['status']) {
			$this->returns['access'] = TRUE;
			$input['code'] = $code;
			$input['status'] = 'Deleted';

			$state = $this->event->Update($input, $code);

			$this->returns['status'] = $state['status'];
			$this->returns['title'] = ($state['status'] ? 'Success' : 'Failure');
			$this->returns['msg'] = ($state['status'] ? 'Event Deleted Successfully' : 'Unable to Delete Event Details. Please Try Again.');
			$this->session->setFlashdata('alert', ['type'=>'success', 'title'=>$this->returns['title'], 'msg'=>$this->returns['msg']]);
		}
		return $this->response->setJSON($this->returns);
	}

	public function Privacy($code) { $auth = $this->Authenticate();
		if($auth['status']) {
			$this->returns['access'] = TRUE;
			$input['code'] = $code;
			$input['privacy'] = $this->request->getPost('privacy');

			$state = $this->event->Update($input, $code);

			$this->returns['status'] = $state['status'];
			$this->returns['title'] = ($state['status'] ? 'Success' : 'Failure');
			$this->returns['msg'] = ($state['status'] ? 'Event Privacy Updated Successfully' : 'Unable to Update the Event Privacy Details. Please Try Again.');
			$this->session->setFlashdata('alert', ['type'=>'success', 'title'=>$this->returns['title'], 'msg'=>$this->returns['msg']]);
		}
		return $this->response->setJSON($this->returns);
	}

	public function Status($code) { $auth = $this->Authenticate();
		if($auth['status']) {
			$this->returns['access'] = TRUE;
			$input['code'] = $code;
			$input['status'] = $this->request->getPost('status');

			$state = $this->event->Update($input, $code);

			if($state['status'] && $input['status'] == 'Approved') {

				$profile = $this->event->Event_single(['code' => $code]);

				if(!empty($prfile['emailid']) && !is_null($prfile['emailid'])) {
					$email = \Config\Services::email();
					
					$mailconfig['wordWrap'] = true;
					$mailconfig['mailType'] = 'html';

					$email->initialize($mailconfig);

					$email->setFrom('admin@integrass.com', 'Integrass');
					$email->setTo($profile['emailid']);
					$email->setSubject('Event Approved');
					$email->setMessage('<p><strong>Your Event ('.$profile['code'].') has approved to public view.</strong></p>');

					if(!$email->send()) {
						$this->returns['mailerror'] = $email->printDebugger(['headers']);;
					}
				}
			}

			$this->returns['status'] = $state['status'];
			$this->returns['title'] = ($state['status'] ? 'Success' : 'Failure');
			$this->returns['msg'] = ($state['status'] ? 'Event Status Updated Successfully' : 'Unable to Update the Event Status Details. Please Try Again.');
			$this->session->setFlashdata('alert', ['type'=>'success', 'title'=>$this->returns['title'], 'msg'=>$this->returns['msg']]);
		}
		return $this->response->setJSON($this->returns);
	}
}