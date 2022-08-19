<?PHP

class mySmarty extends Smarty {
	function mySmarty(){
		global $config;
		parent::__construct();
		$this->template_dir= $config['template_dir'];
		//$this->config_dir  = $config['config_dir'];
		$this->compile_dir = $config['compile_dir'];
		$this->cache_dir   = $config['cache_dir'];

		$this->assign("title",$config['title']);
		$this->assign("self",$_SERVER['PHP_SELF']);
		$this->assign("query",$_SERVER['QUERY_STRING']);
		$href_query = htmlentities ($_SERVER['QUERY_STRING']);
		$this->assign("href",$_SERVER['PHP_SELF'].(empty($href_query) ? '' : '?'.$href_query));
		$this->assign("root",@substr($_SERVER['DOCUMENT_ROOT'],0,-1));
	}
}

class SMARTY_DATASET {
/*********************************************
**	name:		SMARTY_DATASET				**
**	version:	1.0							**
**	kind:		CLASS Implementation		**
**	author:		M.Molayee					**
**	edit date:	26 Aug 2006					**
**	PHP Ver.:	5+							**
*********************************************/

//	minimum system
//	$result = $db->getall("select * from xxcity limit 21, 5 ");
//	$myset = new SMARTY_DATASET($result /* db result set */, 'xcityid' /* default id name */, array('edit','delete') /* visible btns */, true /* show checkbaxes */);
//	$myset->addCol('نام شهر' /* title */, '<a href="">{xcityid}: {xcity}</a>' /* value */, '40%' /* width */, 'headerclass', '' /* header additional */, 'rowclass', '' /* row additional */);
//	$smarty->assign('dataset', $myset->renderDataset()); // use exactly as left

	
	public $id;
	public $showcheckbox;
	public $button;
	public $dataset = array();
	public $sortprefix;
	public $sortby;
	public $sortorder;
	public $hidenew = false;
	public $class = array('asc'=>'', 'desc'=>'');
	public $sorthtml = '<a href="#" onclick="sortList2(\'[[sortprefix]]_sortby\', \'[[sortprefix]]_order\', \'[[sortby]]\', \'[[sortorder]]\')">[[text]]</a>';
	
	private $_cnt = 0;
	
	public function __construct($result=array(), $id='id', $sortprefix='', $sortby='', $sortorder='', $ascclass='', $descclass='', $btn=array(), $showcheckbox=false)
	{
	   $this->dataset['result'] =& $result;
	   $this->id =& $id;
	   $this->showcheckbox =& $showcheckbox;
	   $this->sortprefix =& $sortprefix;
	   $this->sortby =& $sortby;
	   $this->sortorder =& $sortorder;
	   $this->class['asc'] =& $ascclass;
	   $this->class['desc'] =& $descclass;
	   $this->showButton($btn);
	}
	
	public function __destruct()
	{}
		
	public function showButton($btn)
	{
		unset($this->dataset['button']);
		$btn = is_array($btn) ? $btn : array($btn);
		foreach($btn as $key=>$val) {
			$this->dataset['button'][$val] = empty($key) ? true : $key;
		}
	}
		
	public function addCol($title='', $value='', $width='', $sort='')
	{
		$this->dataset['sort'][$this->_cnt]					= $sort;
		$this->dataset['header'][$this->_cnt]['text']		= empty($title) ? '&nbsp;' : $this->_render($title);
		$this->dataset['header'][$this->_cnt]['width']		= $width;
		$this->dataset['row'][$this->_cnt]['text']			= empty($value) ? '&nbsp;' : $this->_render($value);
//		$this->dataset['row'][$this->_cnt]['class']			= $rowclass;
//		$this->dataset['header'][$this->_cnt]['property']	= $headeradd;
//		$this->dataset['row'][$this->_cnt]['property']		= $rowadd;
		$this->_cnt++;
	}
		
	public function renderDataset()
	{
		foreach($this->dataset['header'] as $key=>$val) {
			if($this->dataset['sort'][$key]){
				$trans = array(	"[[sortprefix]]"=>$this->sortprefix,
								"[[sortby]]"=>$this->dataset['sort'][$key],
								"[[sortorder]]"=>(($this->sortby==$this->dataset['sort'][$key] and $this->sortorder=="ASC") ? "desc" : "asc"),
								"[[text]]"=>$this->dataset['header'][$key]['text']);
				$this->dataset['header'][$key]['class'] = ($this->sortby==$this->dataset['sort'][$key]) ? $this->class[($this->sortorder=="ASC") ? "asc" : "desc"] : "";
				$this->dataset['header'][$key]['text'] = strtr($this->sorthtml, $trans);		
			}
		}		
		$this->dataset['showcheckbox'] =& $this->showcheckbox;	
		$this->dataset['id'] =& $this->id;	
		$this->dataset['hidenew'] =& $this->hidenew;
		return $this->dataset;
	}
	
	public function reset($result=array(), $id='id', $sortprefix='', $sortby='', $sortorder='', $ascclass='', $descclass='', $btn=array(), $showcheckbox=false)
	{
		$this->id='';
		$this->showcheckbox = false;
		$this->button = '';
		$this->dataset = array();
		$this->_cnt = 0;		
		$this->class = array('asc'=>'', 'desc'=>'');
		$this->__construct($result, $id, $sortprefix, $sortby, $sortorder, $ascclass, $descclass, $btn, $showcheckbox);
	}
	
	private function _render($txt)
	{	// make {$item.xfield} from {xfield}
		$txt2 = $txt;
		$tr = array();
		while(preg_match('/{([^}]+)}/', $txt2, $ar)) {
			$tmp = explode($ar[0], $txt2, 2);
			$txt2= $tmp[1];
			$tr[$ar[0]] = '{$item.'.$ar[1].'}';
		}
		return strtr($txt, $tr);
	}
}
?>