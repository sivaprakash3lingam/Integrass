<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Profile extends BaseController {

	public function __construct() {
		$this->profile = model('App\Models\AdminProfile');
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

	public function Index() {
		$input = [];
		$errors = [];
		return view('admin/login', ['input'=> $input, 'error'=>$this->validation->getErrors(), 'alert'=>$this->alert()]);
	}

	public function Login() {
		$input = [];
		$errors = [];
		if ($this->request->getMethod(true) == 'POST') {
			$this->validation->setRules(['username'=>	['label'=>'Login Username', 'rules'=>'required', 'errors'=>['required'=>'Enter Login Username/Mobile No']],
										'password'	=>	['label'=>'First Name', 'rules'=>'required', 'errors'=>['required'=>'Enter Login Password']]]);
		}
		if($this->validation->withRequest($this->request)->run()) {
			$input['username'] = $this->request->getPost('username');
			$input['password'] = $this->request->getPost('password');

			$ml = $this->profile->Login_Validate(['mobile' => $this->request->getPost('username'),
													'pwd' => hash("gost", $this->request->getPost('password'))]);

			if($ml['status']) {
				//echo '<pre>'; print_r($ml['profile']); echo '</pre>';
				$token = base64_encode($this->encrypter->encrypt($ml['profile']['code'].$ml['profile']['mobile'].$ml['profile']['mobile'].$ml['profile']['emailid'].strtotime('NOW')));
				$this->profile->Update_Token(['code'=>$ml['profile']['code'], 'token'=>$token]);
				$this->session->set(['admin'=>['code'=>$ml['profile']['code'], 'token'=>$token]]);
				return redirect()->to('admin/dashboard');
			} else {
				$errors = $this->validation->getErrors();
				$this->session->setFlashdata('alert', ['type'=>'danger', 'title'=>'Authentication Failure', 'msg'=>'Combination of Username and Password not Available']);
			}
		} else {
			$errors = $this->validation->getErrors();
			$this->session->setFlashdata('alert', ['type'=>'danger', 'title'=>'Authentication Failure', 'msg'=>'Invalid login credientiels']);
		}
		 
		return view('admin/login', ['input'=> $input, 'error'=>$this->validation->getErrors(), 'alert'=>$this->alert()]);
	}

	public function Signout() {
		$this->session->remove('admin');
		return redirect()->to(base_url('admin'));
	}

	public function Dashboard() {	$profile = $this->Authenticate();
		if($profile['status'] != TRUE) { return redirect()->to(base_url('admin')); exit(0); }
		else { return view('admin/dashboard', ['profile'=>$profile['profile'], 'alert'=>$this->alert()]); }
	}
}