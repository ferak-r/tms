<?PHP
$config['db']['dsn']					= "{$config['db']['type']}://{$config['db']['user']}:{$config['db']['pass']}@{$config['db']['server']}:{$config['db']['port']}/{$config['db']['name']}";
$config['db']['options']['debug']		= 2;
$config['db']['options']['portability']	= DB_PORTABILITY_DELETE_COUNT;
$config['db']['options']['persistent']	= false;
?>