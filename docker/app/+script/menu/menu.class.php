<?PHP

class MENU_TREE {
	public $child = array();
	public $img = "null";
	public $title = "null";
	public $link = "null";
	public $target = "null";
	public $status = "null";
	public $permition;
	public $kind = 'main';
	public $imgtag = '\'<img src="../images/admin/?" width="13" />\'';
	public $group;
	
	public function __construct($group=array())
	{
		$this->group = $group;
	}
	
	public function addChild($title='', $link='', $img='', $permition='', $target='', $status='')
	{
		$obj = new MENU_TREE($this->group);
		$obj->img = empty($img) ? "null" : str_replace('?', $img, $this->imgtag);
		$obj->title = empty($title) ? "null" : "'$title'";;
		$obj->link = empty($link) ? "null" : "'$link'";
		$obj->target = empty($target) ? "null" : "'$target'";;
		$obj->status = empty($status) ?  $this->title : "'$status'";;
		$obj->permition = $permition;
		$obj->kind = 'sub';
		$this->child[] = $obj;
		return $obj;
	}
	
	public function addSeparator()
	{
		$obj = new MENU_TREE;
		$obj->kind = 'separator';
		$this->child[] = $obj;
		return $obj;
	}
	
	public function make($lang)
	{
		$split = "_cmSplit,\n";
		$res = '';
		if ($this->kind=='separator') {
			return $split;
		};
		$res .= ($this->kind=='main') ? 'var myMenu = [' : "[{$this->img},{$this->title},{$this->link},{$this->target},{$this->status}".($this->child?',':'')."\n";
		$end = "],\n";
		if(!empty($this->child)) {
			$tres = '';
			foreach($this->child as $child) {
				if($child->hasPermition()) {
					$tres .= $child->make();
				}
			}
			$tres = preg_replace("/^$split/", '', $tres);
			$tres = trim(preg_replace("/$split$/", '', $tres));
			if(empty($tres)) {
				$res = '';
				$end = '';
			} else {
				$res .= $tres;
			}	
		}
		
		$dir = $lang == 'en' ? 'hbr' : 'hbl';
		$res .= ($this->kind=='main') ?  "]; \n cmDraw ('myMenuID', myMenu, '$dir', cmThemeOffice, 'ThemeOffice'); \n" : $end;
		while(preg_match("/([^\\]]),\n$split/", $res)) { 
			//remove ineffective spliters
			$res = preg_replace("/([^\\]]),\n$split/", "$1,\n", $res);
		}	
		return $res;
	}	
	
	public function hasPermition()
	{
		if(empty($this->permition)) {
			return true;
		} 
		$list = explode(',', $this->permition);	
		foreach($list as $key=>$val) {
			if(@$this->group[trim($val)]) {
				return true;
			}
		}
		return false;
	}
}

?>