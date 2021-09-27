<?php namespace App\Models;

//use CodeIgniter\Database\ConnectionInterface;

class AdminProfile {

	protected $db;

	public function __construct() {
		$this->db      = \Config\Database::connect();
	}

	public function Login_Validate($arg) {	$result = array('status' => FALSE, 'profile' => []);

		$builder = $this->db->table('profile_admin pu');
		$builder->select('pu.admin_code, pu.admin_mobile, pu.admin_emailid');
		$builder->groupStart();
			$builder->orGroupStart();
				$builder->where('pu.admin_mobile', $arg['mobile']);
				$builder->orWhere('pu.admin_emailid', $arg['mobile']);
				$builder->orWhere('pu.admin_username', $arg['mobile']);
			$builder->groupEnd();
		$builder->groupEnd();
		$builder->where('pu.admin_password', $arg['pwd']);
		$profile = $builder->get();
		//echo $this->db->getLastQuery();
		$profile->resultID->num_rows;
		if($profile->resultID->num_rows == 1) {
			$valid = $profile->getRow();
			$result['status'] = TRUE;
			$result['profile'] = $this->Profile(['code'=>$valid->admin_code])[0];
		}
		$profile->freeResult();
		return $result;
	}

	public function Update_Token($arg) {
		$builder = $this->db->table('profile_admin');
		$builder->set('admin_token', $arg['token']);
		$builder->set('admin_currentlogin', 'NOW(6)', FALSE);
		$builder->set('admin_lastlogin', 'admin_currentlogin', FALSE);
		$builder->where('admin_code', $arg['code']);
		$builder->update();

		return ($this->db->affectedRows() > 0 ? TRUE : FALSE);
	}

	public function Auth($arg) {	$result = array('status' => FALSE, 'profile' => []);

		if(!is_null($arg) && is_array($arg) && array_key_exists('code', $arg) && !empty($arg['code']) && array_key_exists('code', $arg) && !empty($arg['code'])
			&& array_key_exists('token', $arg) && !empty($arg['token']) && array_key_exists('token', $arg) && !empty($arg['token'])) {

			$profile = $this->Profile(['code'=>$arg['code'], 'token'=>$arg['token']]);
			if(sizeof($profile) == 1) {
				$result['status'] = TRUE;
				$result['profile'] = $profile[0];
			}
		}
		return $result;
	}
	
	public function Profile($arg) {	$result = [];
		$builder = $this->db->table('profile_admin pu');
		$builder->select('pu.admin_code, pu.admin_username, pu.admin_mobile, pu.admin_emailid, pu.admin_token, pu.admin_firstname, pu.admin_created, pu.admin_updated, admin_currentlogin, admin_lastlogin');
		//$this->db->from('profile_admin pu');
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('pu.admin_code', $arg['code']) : '');
		(array_key_exists('firstname', $arg) && !is_null($arg['firstname']) && !empty($arg['firstname']) ? $builder->like('pu.admin_firstname', $arg['firstname']) : '');
		(array_key_exists('mobile', $arg) && !is_null($arg['mobile']) && !empty($arg['mobile']) ? $builder->like('pu.admin_mobile', $arg['mobile']) : '');
		(array_key_exists('pwd', $arg) && !is_null($arg['pwd']) && !empty($arg['pwd']) ? $builder->like('pu.admin_password', $arg['pwd']) : '');
		(array_key_exists('token', $arg) && !is_null($arg['token']) && !empty($arg['token']) ? $builder->where('pu.admin_token', $arg['token']) : '');

		$profile = $builder->get();
		//echo $this->db->getLastQuery();
		if($profile->resultID->num_rows > 0) {
			foreach ($profile->getResult() as $row) {
				$result[] = ['code' => $row->admin_code,
							'username' => $row->admin_username,
							'mobile' => $row->admin_mobile,
							'emailid' => $row->admin_emailid,
							'token' => $row->admin_token,
							'firstname' => $row->admin_firstname,
							'created' => (!is_null($row->admin_created) && !empty($row->admin_created) ? date("d-m-Y / h:i:s A", strtotime($row->admin_created)) : NULL),
							'updated' => (!is_null($row->admin_updated) && !empty($row->admin_updated) ? date("d-m-Y / h:i:s A", strtotime($row->admin_updated)) : NULL),
							'lastlogin' => (!is_null($row->admin_lastlogin) && !empty($row->admin_lastlogin) ? date("d-m-Y / h:i:s A", strtotime($row->admin_lastlogin)) : NULL),
							'currentlogin' => (!is_null($row->admin_currentlogin) && !empty($row->admin_currentlogin) ? date("d-m-Y / h:i:s A", strtotime($row->admin_currentlogin)) : NULL)
							];
			}
		}
		return $result;
	}
	
	public function Update($arg) {	$result = FALSE;
		$builder = $this->db->table('profile_admin');

		(array_key_exists('firstname', $arg) && !empty($arg['firstname']) ? $builder->set('admin_firstname', $arg['firstname']) : '');
		(array_key_exists('gender', $arg) && !empty($arg['gender']) ? $builder->set('admin_gender', $arg['gender']) : '');
		(array_key_exists('mobile', $arg) && !empty($arg['mobile']) ? $builder->set('admin_mobile', $arg['mobile']) : '');
		(array_key_exists('emailid', $arg) && !empty($arg['emailid']) ? $builder->set('admin_emailid', $arg['emailid']) : '');
		(array_key_exists('role', $arg) && !empty($arg['role']) ? $builder->set('admin_role', $arg['role']) : '');
		(array_key_exists('status', $arg) && !empty($arg['status']) ? $builder->set('admin_status', $arg['status']) : '');
		$builder->set('admin_updated', 'NOW(6)', FALSE);
		(array_key_exists('code', $arg) && !empty($arg['code']) ? $builder->where('admin_code', $arg['code']) : '');

		$builder->update();
		echo $this->db->getLastQuery();
		//print_r($this->db->error());
		return $this->db->affectedRows();
	}
	
	public function admin_Total($arg = []) {
		$builder = $this->db->table('profile_admin pu');
		$builder->select('COUNT(pu.admin_code) AS tot');
		if(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code'])) {
			(is_array($arg['code']) ? $builder->whereIn('pu.admin_code', $arg['code']) : $builder->where('pu.admin_code', $arg['code']));
		}
		$total = $builder->get();
		$row = $total->getRow();
		return $row->tot;
	}

	public function admin_Lists($arg = []) { $result = [];

		$arg['pageno'] = (array_key_exists('pageno', $arg) && $arg['pageno'] > 0 ? $arg['pageno'] : 1);
		$arg['limit'] = (array_key_exists('limit', $arg) && $arg['limit'] > 0 ? $arg['limit'] : 10);

		$builder = $this->db->table('profile_admin pu');
		$builder->select('pu.admin_code, pu.admin_firstname, pu.admin_gender, pu.admin_mobile, pu.admin_emailid, pu.admin_token, pu.admin_role, pu.admin_status, pu.admin_created, pu.admin_activated, pu.admin_updated, admin_currentlogin, admin_lastlogin');
		if(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code'])) {
			(is_array($arg['code']) ? $builder->whereIn('pu.admin_code', $arg['code']) : $builder->where('pu.admin_code', $arg['code']));
		}
		
		$start = $arg['pageno'] < 2 ? 0 : (($arg['pageno'] - 1) * $arg['limit']);
		$builder->limit(10, $start);
		$builder->orderBy('pu.admin_firstname', 'ASC');
		$master = $builder->get();
		//echo $this->db->getLastQuery();
		//print_r($this->db->error());
		if($master->resultID->num_rows > 0) {
			$gender = ['M'=>'Male', 'F'=>'Female', 'T'=>'Transgender'];
			foreach ($master->getResult() as $row) {
				$result[] = ['code' => $row->admin_code,
							'firstname' => $row->admin_firstname,
							'gender' => (!empty($row->admin_gender) && !is_null($row->admin_gender) ? $gender[$row->admin_gender] : NULL),
							'mobile' => $row->admin_mobile,
							'emailid' => $row->admin_emailid,
							'token' => $row->admin_token,
							'role' => $row->admin_role,
							'status' => $row->admin_status,
							'created' => $row->admin_created,
							'activated' => (!is_null($row->admin_activated) && !empty($row->admin_activated) ? $row->admin_activated : NULL),
							'updated' => (!is_null($row->admin_updated) && !empty($row->admin_updated) ? $row->admin_updated : NULL),
							'clogin' => (!is_null($row->admin_currentlogin) && !empty($row->admin_currentlogin) ? $row->admin_currentlogin : NULL),
							'llogin' => (!is_null($row->admin_lastlogin) && !empty($row->admin_lastlogin) ? $row->admin_lastlogin : NULL)
							];
			}
		}
		$master->freeResult();
		return $result;
	}
}