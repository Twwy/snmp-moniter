<?php

class snmp_moniter{
	public $ip = false;
	public $community = 'public';	

	//系统描述
	public function sysDescr(){
		return $this->format(snmprealwalk($this->ip, $this->community, 'system.sysDescr.0'));
	}

	//连续开机时间
	public function sysUpTime(){
		return $this->format(snmprealwalk($this->ip, $this->community, 'system.sysUpTime.0'));

	}

	//系统名称
	public function sysName(){
                return $this->format(snmprealwalk($this->ip, $this->community, 'system.sysName.0'));
	}

	//当前连接
	public function netstat(){
		$result = snmprealwalk($this->ip, $this->community, '1.3.6.1.2.1.6.13.1.1');
		$return = array();
		foreach($result as $key => $value){
			$name = explode('.', $key);
			$return[] = array(
				$name[0],
				"{$name[1]}.{$name[2]}.{$name[3]}.{$name[4]}",
				$name[5],
				"{$name[6]}.{$name[7]}.{$name[8]}.{$name[9]}",
				$name[10],
				str_replace('INTEGER: ', '', $value)
			);
		}
		return $return;
	}

	//内存memory   (未完成)
	public function memory(){
		$memory = array();
		$memory['total'] = $this->format(snmprealwalk($this->ip, $this->community, '1.3.6.1.2.1.25.2.2.0'));
		return $memory;
	}

	//硬盘
	public function disk(){
		$disk = array();
		$result = snmprealwalk($this->ip, $this->community, '1.3.6.1.2.1.25.2');
		foreach($result as $key => $value){
			if($label = strstr($key , 'hrStorageDescr')){
				$label = explode('.', $label);
				$label = $label[1];
				if(($name = strstr($value, '/')) || strstr($value, '\\')){
					if($name === false) $name = $this->format($value);
					if(($size = $this->format($result["HOST-RESOURCES-MIB::hrStorageSize.{$label}"])) != 0){
						$disk[] = array(
							'name' => $name,
							'total' => $size,
							'used' => $this->format($result["HOST-RESOURCES-MIB::hrStorageUsed.{$label}"]) 
						);
					}
				}
			}
		}
		return $disk;
	}


	//swap(windows中的虚拟内存)
	public function swap(){

	}

	//进程列表
	public function run(){

	}


	private function format($result){
		if(!$result) return false;
		if(is_array($result)) $result = array_shift($result);
		$result = str_replace('STRING: ','', $result);
		$result = str_replace('INTEGER: ','', $result);
		return $result;
	}

}

?>
