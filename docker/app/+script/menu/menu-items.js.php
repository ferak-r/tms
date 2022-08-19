<?PHP
ob_start();
require_once('menu.class.php');
chdir("../../");
require_once('lib/site.module.php');
function makeMenu($user_id, $user_privilages=array(), $lang)
{
	$menu	= new MENU_TREE($user_privilages);
	$menu->addChild('Home', 'index.php?section=operation&module=transport-list&step=transport');
	$menu->addSeparator();
	
	$projects = $menu->addChild('Projects');
		$projects->addChild('Project List', 'index.php?section=operation&module=transport-list&step=transport', 'list.png', 'admin,customer,office,carrier,webcarrier,operation,document,account&customs');
		$projects->addChild('New Project', 'index.php?section=operation&module=transport-admin&step=transport', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$projects->addChild('Project Archive', 'index.php?section=operation&module=transport-list&step=transport&archive=1', 'archive.png', 'admin,customer,office,carrier,operation,document,account&customs');
	$menu->addSeparator();

	$customers = $menu->addChild('Customers');
		$customers->addChild('Customer List', 'index.php?section=admin&module=customer-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$customers->addChild('New Customer', 'index.php?section=admin&module=customer-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
	
	$menu->addSeparator();
	
	$carriers = $menu->addChild('Carriers');
		$carriers->addChild('Carrier List', 'index.php?section=admin&module=carrier-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$carriers->addChild('New Carrier', 'index.php?section=admin&module=carrier-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
	
	$menu->addSeparator();
	
	$equipment = $menu->addChild('Equipment');
		$equipment->addChild('Equipment List', 'index.php?section=admin&module=equipment-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$equipment->addChild('New Equipment', 'index.php?section=admin&module=equipment-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');

	$menu->addSeparator();
	
	$containers = $menu->addChild('Containers');
		$containers->addChild('Container List', 'index.php?section=admin&module=container-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$containers->addChild('New Container', 'index.php?section=admin&module=container-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$containers->addSeparator();
		$containers->addChild('Company Container List', 'index.php?section=admin&module=container-list&companycontainer=1', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$containers->addChild('New Company Container', 'index.php?section=admin&module=container-admin&companycontainer=1', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$containers->addSeparator();
		$containers->addChild('Projects Containers', 'index.php?section=admin&module=container-status-all', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');		
	$menu->addSeparator();

	$lend = $menu->addChild('Lend Container');
		$lend->addChild('Container List', 'index.php?section=admin&module=container-lend-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$lend->addChild('New Container', 'index.php?section=admin&module=container-lend-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
	$menu->addSeparator();

	$offices = $menu->addChild('Offices');
		$offices->addChild('Office List', 'index.php?section=admin&module=office-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$offices->addChild('New Office', 'index.php?section=admin&module=office-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
	$menu->addSeparator();

	$users = $menu->addChild('Users');
		$users->addChild('User List', 'index.php?section=admin&module=user-list', 'list.png', 'admin,customer,office,carrier,operation,document,account&customs');
		$users->addChild('New User', 'index.php?section=admin&module=user-admin', 'new.png', 'admin,customer,office,carrier,operation,document,account&customs');
	$menu->addSeparator();
	
	$email = $menu->addChild('Email', null, (checkReminder($user_id) ? 'arrow.gif' : null));
		$email->addChild('Email List', 'index.php?section=user&module=mail-list', 'list.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');
		$email->addChild('New Email', 'index.php?section=user&module=mail-admin', 'new.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');
	$menu->addSeparator();

	$reminder = $menu->addChild('Reminder');
		$reminder->addChild('Reminder List', 'index.php?section=user&module=reminder-list', 'list.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');
		$reminder->addChild('New Reminder', 'index.php?section=user&module=reminder-admin', 'new.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');
	$menu->addSeparator();

		
	$menu->addSeparator();
	$accessory = $menu->addChild('Accessories');
		$init = $accessory->addChild('Primary Definitions');
			$init->addChild('ComboBox Admin', 'index.php?section=admin&module=combo-list', 'admin.png', 'admin,customer,office,carrier,operation,document,account&customs');
			$init->addSeparator();
			$init->addChild('Status Color List', 'index.php?section=admin&module=statuscolor-list', 'list.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');
			$init->addChild('New Status Color', 'index.php?section=admin&module=statuscolor-admin', 'new.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');

		$accessory->addSeparator();
		$report = $accessory->addChild('Reports');
			$report->addChild('Raw Reports', 'index.php?section=admin&module=report-list&page=1', 'list.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');
			$report->addChild('Favorite Reports', 'index.php?section=admin&module=report-list&cmd=favor&page=1', 'list.png', 'admin, customer, carrier, container, customs, operation, document, office, account&customs');	
		$accessory->addSeparator();
				
		$backup = $accessory->addChild(T_('Backup Files'));
			$backup->addChild(T_('Create Backup File'), 'index.php?section=admin&module=exportdb', 'export.png', 'admin,customer,office,carrier,operation,document,account&customs');
			$backup->addChild(T_('Restore Backup File'), 'index.php?section=admin&module=importdb', 'import.png', 'admin,customer,office,carrier,operation,document,account&customs');	
		$accessory->addSeparator();	
		$accessory->addChild('Exit', 'index.php?section=guest&module=login&logincmd=logout', 'shutdown.png');
	return $menu->make('en');
}
ob_clean();
unset($trace_val);

echo @makeMenu($user->id, $user->group, 'en');
?>
//