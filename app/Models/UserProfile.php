<?php namespace App\Models;

//use CodeIgniter\Database\ConnectionInterface;

class Profile {

	protected $db;

	public function __construct() {
		$this->db      = \Config\Database::connect();
	}

	public function Login_Validate($arg) {	$result = array('status' => FALSE, 'profile' => []);

		$builder = $this->db->table('profile_users pu');
		$builder->select('pu.user_code, pu.user_mobile, pu.user_emailid');
		$builder->groupStart();
			$builder->orGroupStart();
				$builder->where('pu.user_mobile', $arg['mobile']);
				$builder->orWhere('pu.user_emailid', $arg['mobile']);
				$builder->orWhere('pu.user_username', $arg['mobile']);
			$builder->groupEnd();
		$builder->groupEnd();
		$builder->where('pu.user_password', $arg['pwd']);
		$profile = $builder->get();
		//echo $this->db->getLastQuery();
		$profile->resultID->num_rows;
		if($profile->resultID->num_rows == 1) {
			$valid = $profile->getRow();
			$result['status'] = TRUE;
			$result['profile'] = $this->Profile(['code'=>$valid->user_code])[0];
		}
		$profile->freeResult();
		return $result;
	}

	public function Update_Token($arg) {
		$builder = $this->db->table('profile_users');
		$builder->set('user_token', $arg['token']);
		$builder->set('user_currentlogin', 'NOW(6)', FALSE);
		$builder->set('user_lastlogin', 'user_currentlogin', FALSE);
		$builder->where('user_code', $arg['code']);
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
		$builder = $this->db->table('profile_users pu');
		$builder->select('pu.user_code, pu.user_username, pu.user_mobile, pu.user_emailid, pu.user_token, pu.user_firstname, pu.user_created, pu.user_updated, user_currentlogin, user_lastlogin');
		//$this->db->from('profile_users pu');
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('pu.user_code', $arg['code']) : '');
		(array_key_exists('firstname', $arg) && !is_null($arg['firstname']) && !empty($arg['firstname']) ? $builder->like('pu.user_firstname', $arg['firstname']) : '');
		(array_key_exists('mobile', $arg) && !is_null($arg['mobile']) && !empty($arg['mobile']) ? $builder->like('pu.user_mobile', $arg['mobile']) : '');
		(array_key_exists('pwd', $arg) && !is_null($arg['pwd']) && !empty($arg['pwd']) ? $builder->like('pu.user_password', $arg['pwd']) : '');
		(array_key_exists('token', $arg) && !is_null($arg['token']) && !empty($arg['token']) ? $builder->where('pu.user_token', $arg['token']) : '');

		$profile = $builder->get();
		//echo $this->db->getLastQuery();
		if($profile->resultID->num_rows > 0) {
			foreach ($profile->getResult() as $row) {
				$result[] = ['code' => $row->user_code,
							'username' => $row->user_username,
							'mobile' => $row->user_mobile,
							'emailid' => $row->user_emailid,
							'token' => $row->user_token,
							'firstname' => $row->user_firstname,
							'created' => (!is_null($row->user_created) && !empty($row->user_created) ? date("d-m-Y / h:i:s A", strtotime($row->user_created)) : NULL),
							'updated' => (!is_null($row->user_updated) && !empty($row->user_updated) ? date("d-m-Y / h:i:s A", strtotime($row->user_updated)) : NULL),
							'lastlogin' => (!is_null($row->user_lastlogin) && !empty($row->user_lastlogin) ? date("d-m-Y / h:i:s A", strtotime($row->user_lastlogin)) : NULL),
							'currentlogin' => (!is_null($row->user_currentlogin) && !empty($row->user_currentlogin) ? date("d-m-Y / h:i:s A", strtotime($row->user_currentlogin)) : NULL)
							];
			}
		}
		return $result;
	}
	
	public function Update($arg) {	$result = FALSE;
		$builder = $this->db->table('profile_users');

		(array_key_exists('firstname', $arg) && !empty($arg['firstname']) ? $builder->set('user_firstname', $arg['firstname']) : '');
		(array_key_exists('gender', $arg) && !empty($arg['gender']) ? $builder->set('user_gender', $arg['gender']) : '');
		(array_key_exists('mobile', $arg) && !empty($arg['mobile']) ? $builder->set('user_mobile', $arg['mobile']) : '');
		(array_key_exists('emailid', $arg) && !empty($arg['emailid']) ? $builder->set('user_emailid', $arg['emailid']) : '');
		(array_key_exists('role', $arg) && !empty($arg['role']) ? $builder->set('user_role', $arg['role']) : '');
		(array_key_exists('status', $arg) && !empty($arg['status']) ? $builder->set('user_status', $arg['status']) : '');
		$builder->set('user_updated', 'NOW(6)', FALSE);
		(array_key_exists('code', $arg) && !empty($arg['code']) ? $builder->where('user_code', $arg['code']) : '');

		$builder->update();
		echo $this->db->getLastQuery();
		//print_r($this->db->error());
		return $this->db->affectedRows();
	}
	
	public function user_Total($arg = []) {
		$builder = $this->db->table('profile_users pu');
		$builder->select('COUNT(pu.user_code) AS tot');
		if(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code'])) {
			(is_array($arg['code']) ? $builder->whereIn('pu.user_code', $arg['code']) : $builder->where('pu.user_code', $arg['code']));
		}
		$total = $builder->get();
		$row = $total->getRow();
		return $row->tot;
	}

	public function user_Lists($arg = []) { $result = [];

		$arg['pageno'] = (array_key_exists('pageno', $arg) && $arg['pageno'] > 0 ? $arg['pageno'] : 1);
		$arg['limit'] = (array_key_exists('limit', $arg) && $arg['limit'] > 0 ? $arg['limit'] : 10);

		$builder = $this->db->table('profile_users pu');
		$builder->select('pu.user_code, pu.user_firstname, pu.user_gender, pu.user_mobile, pu.user_emailid, pu.user_token, pu.user_role, pu.user_status, pu.user_created, pu.user_activated, pu.user_updated, user_currentlogin, user_lastlogin');
		if(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code'])) {
			(is_array($arg['code']) ? $builder->whereIn('pu.user_code', $arg['code']) : $builder->where('pu.user_code', $arg['code']));
		}
		
		$start = $arg['pageno'] < 2 ? 0 : (($arg['pageno'] - 1) * $arg['limit']);
		$builder->limit(10, $start);
		$builder->orderBy('pu.user_firstname', 'ASC');
		$master = $builder->get();
		//echo $this->db->getLastQuery();
		//print_r($this->db->error());
		if($master->resultID->num_rows > 0) {
			$gender = ['M'=>'Male', 'F'=>'Female', 'T'=>'Transgender'];
			foreach ($master->getResult() as $row) {
				$result[] = ['code' => $row->user_code,
							'firstname' => $row->user_firstname,
							'gender' => (!empty($row->user_gender) && !is_null($row->user_gender) ? $gender[$row->user_gender] : NULL),
							'mobile' => $row->user_mobile,
							'emailid' => $row->user_emailid,
							'token' => $row->user_token,
							'role' => $row->user_role,
							'status' => $row->user_status,
							'created' => $row->user_created,
							'activated' => (!is_null($row->user_activated) && !empty($row->user_activated) ? $row->user_activated : NULL),
							'updated' => (!is_null($row->user_updated) && !empty($row->user_updated) ? $row->user_updated : NULL),
							'clogin' => (!is_null($row->user_currentlogin) && !empty($row->user_currentlogin) ? $row->user_currentlogin : NULL),
							'llogin' => (!is_null($row->user_lastlogin) && !empty($row->user_lastlogin) ? $row->user_lastlogin : NULL)
							];
			}
		}
		$master->freeResult();
		return $result;
	}
}