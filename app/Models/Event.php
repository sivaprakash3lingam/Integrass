<?php namespace App\Models;

//use CodeIgniter\Database\ConnectionInterface;
use DateTime;
use DateTimeZone;

class Event {

	protected $db;

	public function __construct() {
		$this->db      = \Config\Database::connect();
	}

	public function EventCount($arg) {	$result = [];
		$builder = $this->db->table('events e');
		$builder->select('COUNT(e.event_sno) as tot');
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('e.event_code', $arg['code']) : '');
		(array_key_exists('title', $arg) && !is_null($arg['title']) && !empty($arg['title']) ? $builder->like('e.event_title', $arg['title']) : '');
		$builder->GroupStart();
			(array_key_exists('from', $arg) && !is_null($arg['from']) && !empty($arg['from']) ? $builder->where('e.event_startdate BETWEEN \''. $arg['from'].'\' AND \''.$arg['to'].'\'') : '');
			(array_key_exists('to', $arg) && !is_null($arg['to']) && !empty($arg['to']) ? $builder->orwhere('e.event_enddate BETWEEN \''. $arg['from'].'\' AND \''.$arg['to'].'\'') : '');
		$builder->groupEnd();
		(array_key_exists('privacy', $arg) && !is_null($arg['privacy']) && !empty($arg['privacy']) ? $builder->where('e.event_privacy', $arg['privacy']) : '');
		(array_key_exists('status', $arg) && !is_null($arg['status']) && !empty($arg['status']) ? $builder->like('e.event_status', $arg['status']) : '');
		$ff = $builder->get();
		//echo $this->db->getLastQuery();
		return $ff->getRow()->tot;
	}

	public function Event_single($arg) {	$result = [];
		$builder = $this->db->table('events e');
		$builder->select('e.event_code, e.event_user_code, pu.user_firstname, pu.user_mobile, pu.user_emailid, e.event_title, e.event_desc, e.event_startdate, e.event_starttime, e.event_enddate, e.event_endtime, e.event_privacy, e.event_status, e.event_created, e.event_updated');
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('e.event_code', $arg['code']) : '');
		$builder->join('profile_users pu', 'pu.user_code = e.event_user_code', 'left');
		$event = $builder->get();
		//echo $this->db->getLastQuery();
		$row = $event->getRow();
		if($event->resultID->num_rows > 0) {
			$e = ['code' => $row->event_code,
				'user_code' => $row->event_user_code,
				'firstname' => $row->user_firstname,
				'mobile' => $row->user_mobile,
				'emailid' => $row->user_emailid,
				'title' => $row->event_title,
				'desc' => $row->event_desc,
				'startdate' => date("d-m-Y", strtotime($row->event_startdate)),
				'starttime' => $row->event_starttime,
				'enddate' => date("d-m-Y", strtotime($row->event_enddate)),
				'endtime' => $row->event_endtime,
				'privacy' => $row->event_privacy,
				'status' => $row->event_status,
				'created' => (!is_null($row->event_created) && !empty($row->event_created) ? date("d-m-Y/h:i:s A", strtotime($row->event_created)) : NULL),
				'updated' => (!is_null($row->event_created) && !empty($row->event_created) ? date("d-m-Y/h:i:s A", strtotime($row->event_created)) : NULL)];
		} else { $e = []; }
		return $e;
	}
	
	public function DataList($arg) {	$result = [];
		$builder = $this->db->table('events e');
		$builder->select('e.event_code, e.event_user_code, pu.user_firstname, pu.user_mobile, pu.user_emailid, e.event_title, e.event_desc, e.event_startdate, e.event_starttime, e.event_enddate, e.event_endtime, e.event_privacy, e.event_status, e.event_created, e.event_updated');
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('e.event_code', $arg['code']) : '');
		(array_key_exists('title', $arg) && !is_null($arg['title']) && !empty($arg['title']) ? $builder->like('e.event_title', $arg['title']) : '');
		$builder->GroupStart();
			(array_key_exists('from', $arg) && !is_null($arg['from']) && !empty($arg['from']) ? $builder->where('e.event_startdate BETWEEN \''. $arg['from'].'\' AND \''.$arg['to'].'\'') : '');
			(array_key_exists('to', $arg) && !is_null($arg['to']) && !empty($arg['to']) ? $builder->orwhere('e.event_enddate BETWEEN \''. $arg['from'].'\' AND \''.$arg['to'].'\'') : '');
		$builder->groupEnd();
		(array_key_exists('privacy', $arg) && !is_null($arg['privacy']) && !empty($arg['privacy']) ? $builder->where('e.event_privacy', $arg['privacy']) : '');
		(array_key_exists('status', $arg) && !is_null($arg['status']) && !empty($arg['status']) ? $builder->like('e.event_status', $arg['status']) : '');
		$builder->join('profile_users pu', 'pu.user_code = e.event_user_code', 'left');

		$builder->limit($arg['start'], $arg['limit']);
		$builder->orderBy('e.event_startdate ASC');

		$profile = $builder->get();
		//echo $this->db->getLastQuery();
		if($profile->resultID->num_rows > 0) {
			$gender = ['M'=>'Male', 'F'=>'Female', 'T'=>'Transgender'];
			foreach ($profile->getResult() as $row) {
				$result[] = ['code' => $row->event_code,
							'user_code' => $row->event_user_code,
							'firstname' => $row->user_firstname,
							'mobile' => $row->user_mobile,
							'emailid' => $row->user_emailid,
							'title' => $row->event_title,
							'desc' => $row->event_desc,
							'startdate' => date("d-m-Y", strtotime($row->event_startdate)),
							'starttime' => $row->event_starttime,
							'enddate' => date("d-m-Y", strtotime($row->event_enddate)),
							'endtime' => $row->event_endtime,
							'privacy' => $row->event_privacy,
							'status' => $row->event_status,
							'created' => (!is_null($row->event_created) && !empty($row->event_created) ? date("d-m-Y / h:i:s A", strtotime($row->event_created)) : NULL),
							'updated' => (!is_null($row->event_created) && !empty($row->event_created) ? date("d-m-Y / h:i:s A", strtotime($row->event_created)) : NULL)];
			}
		}
		return $result;
	}

	public function Addnew($arg) {
		$builder = $this->db->table('events');
		$builder->set('event_user_code', $arg['usercode']);
		$builder->set('event_title', $arg['title']);
		$builder->set('event_desc', $arg['desc']);
		$builder->set('event_startdate', date("Y-m-d", strtotime($arg['startdate'])));
		$builder->set('event_starttime', $arg['starttime']);
		$builder->set('event_enddate', date("Y-m-d", strtotime($arg['enddate'])));
		$builder->set('event_endtime', $arg['endtime']);
		$builder->set('event_privacy', $arg['privacy']);
		$builder->set('event_status', $arg['status']);
		$builder->set('event_created', ((DateTime::createFromFormat('U.u', microtime(TRUE)))->setTimezone(new DateTimeZone('Asia/Kolkata')))->format("Y-m-d H:i:s.u"));
		$builder->insert();
		//echo $this->db->getLastQuery();
		//print_r($this->db->error());
		$sno = $this->db->insertID();
		$result = ($this->db->affectedRows() > 0 ? ['status'=>TRUE, 'sno'=>$sno] : ['status'=>FALSE]);
		return $result;
	}

	public function Update($arg, $code) {
		$builder = $this->db->table('events');
		(array_key_exists('title', $arg) && !is_null($arg['title']) && !empty($arg['title']) ? $builder->set('event_title', $arg['title']) : '');
		(array_key_exists('desc', $arg) && !is_null($arg['desc']) && !empty($arg['desc']) ? $builder->set('event_desc', $arg['desc']) : '');
		(array_key_exists('startdate', $arg) && !is_null($arg['startdate']) && !empty($arg['startdate']) ? $builder->set('event_startdate', date("Y-m-d", strtotime($arg['startdate']))) : '');
		(array_key_exists('starttime', $arg) && !is_null($arg['starttime']) && !empty($arg['starttime']) ? $builder->set('event_starttime', $arg['starttime']) : '');
		(array_key_exists('enddate', $arg) && !is_null($arg['enddate']) && !empty($arg['enddate']) ? $builder->set('event_enddate', date("Y-m-d", strtotime($arg['enddate']))) : '');
		(array_key_exists('endtime', $arg) && !is_null($arg['endtime']) && !empty($arg['endtime']) ? $builder->set('event_endtime', $arg['endtime']) : '');
		(array_key_exists('privacy', $arg) && !is_null($arg['privacy']) && !empty($arg['privacy']) ? $builder->set('event_privacy', $arg['privacy']) : '');
		(array_key_exists('status', $arg) && !is_null($arg['status']) && !empty($arg['status']) ? $builder->set('event_status', $arg['status']) : '');
		$builder->set('event_updated', ((DateTime::createFromFormat('U.u', microtime(TRUE)))->setTimezone(new DateTimeZone('Asia/Kolkata')))->format("Y-m-d H:i:s.u"));
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('event_code', $arg['code']) : '');
		$builder->update();
		//echo $this->db->getLastQuery();
		//print_r($this->db->error());
		$result = ($this->db->affectedRows() > 0 ? ['status'=>TRUE, 'affected'=>$this->db->affectedRows()] : ['status'=>FALSE]);
		return $result;
	}

	public function Delete($code) {
		$builder = $this->db->table('events');
		(array_key_exists('status', $arg) && !is_null($arg['status']) && !empty($arg['status']) ? $builder->set('event_status', 'Deleted') : '');
		$builder->set('event_updated', ((DateTime::createFromFormat('U.u', microtime(TRUE)))->setTimezone(new DateTimeZone('Asia/Kolkata')))->format("Y-m-d H:i:s.u"));
		(array_key_exists('code', $arg) && !is_null($arg['code']) && !empty($arg['code']) ? $builder->where('event_code', $arg['code']) : '');
		$builder->update();
		//echo $this->db->getLastQuery();
		//print_r($this->db->error());
		$result = ($this->db->affectedRows() > 0 ? ['status'=>TRUE, 'affected'=>$this->db->affectedRows()] : ['status'=>FALSE]);
		return $result;
	}
}