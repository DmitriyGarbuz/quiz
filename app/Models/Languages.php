<?php 

namespace App\Models;
use \Config\Database as Database;
use \CodeIgniter\Database\ConnectionInterface;
use \CodeIgniter\Model;

class Languages extends Model
{
	
	protected $DBGroup = 'default';
    protected $table = 'languages';    
	protected $primaryKey = 'id';
	protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $protectFields = false;
	
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
	
	function getConfigLanguage () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		return $builder->get()->getResultArray();
	
	}
	
	function getConfLang($prefix='') {
		
		$langnames = $this->getConfigLanguage(); 
		$array=array();
		foreach ($langnames as $one) { $array[$one['nick']] = $one['param'.$prefix]; }
		return $array;
		
	}
	
	function giveLangParam ($param) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		$builder->where ('nick',$param);
		$config = $builder->get()->getRowArray();
		return $config['param'.session('Langtext')];
	
	}
	
	function getLangNames () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		return $builder->get()->getResultArray();
		
	}
	
	function editLangNames ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		$builder->where ('nick',$data['nick']);
		return $builder->update($data);
		
	}
	
	function getLangNamesScr () {
	
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		$builder->where ('jscr',1);
		return $builder->get()->getResultArray();
	
	}
	
	function getModLangNames ($url='') {
	
		$db = \Config\Database::connect();
		$builder = $db->table('langnames');
		if ($url!='') { $url = '_'.$url; }
		$builder->orderBy ('nick','asc');
		$builder->select ('nick,param'.$url.',jscr');
		return $builder->get()->getResultArray();
	
	}
	
	function addLanguage ($data) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('languages');
		$builder->insert ($data);
		
		$prefix = $data['url'];
		
		$Database = new Database;
		$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_langnames');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_langnames` ADD `param_$prefix` varchar(255) NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_articles');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` ADD `text_$prefix` longtext NOT NULL"); } 
		if (!in_array('info_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` ADD `info_$prefix` longtext NOT NULL"); } 
		if (!in_array('title_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` ADD `title_$prefix` longtext NOT NULL"); } 
		if (!in_array('description_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` ADD `description_$prefix` longtext NOT NULL"); } 
		if (!in_array('keywords_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` ADD `keywords_$prefix` longtext NOT NULL"); } 
			
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_banchapters');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_banchapters` ADD `param_$prefix` longtext NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_uservars');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_uservars` ADD `param_$prefix` varchar(255) NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_bannotes');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_bannotes` ADD `param_$prefix` longtext NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_banshablon');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_banshablon` ADD `param_$prefix` longtext NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_feedback');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedback` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('secondName_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedback` ADD `secondName_$prefix` varchar(255) NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_feedbackparams');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedbackparams` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedbackparams` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_chapters');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('link_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `link_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `text_$prefix` longtext NOT NULL"); } 
		if (!in_array('info_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `info_$prefix` longtext NOT NULL"); } 
		if (!in_array('title_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `title_$prefix` longtext NOT NULL"); } 
		if (!in_array('description_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `description_$prefix` longtext NOT NULL"); } 
		if (!in_array('keywords_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` ADD `keywords_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_gallery');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_gallery` ADD `text_$prefix` longtext NOT NULL"); } 
		if (!in_array('link_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_gallery` ADD `link_$prefix` varchar(255) NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_letters');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('theme_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_letters` ADD `theme_$prefix` longtext NOT NULL"); } 
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_letters` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_moduls');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_moduls` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_notes');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` ADD `text_$prefix` longtext NOT NULL"); } 
		if (!in_array('title_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` ADD `title_$prefix` longtext NOT NULL"); } 
		if (!in_array('description_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` ADD `description_$prefix` longtext NOT NULL"); } 
		if (!in_array('keywords_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` ADD `keywords_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_notetabs');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notetabs` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notetabs` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_pollparams');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_pollparams` ADD `name_$prefix` varchar(255) NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_polls');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_polls` ADD `name_$prefix` varchar(255) NOT NULL"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_slider');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('link_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_slider` ADD `link_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_slider` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_userparams');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_userparams` ADD `name_$prefix` varchar(255) NOT NULL"); }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_userparams` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_usertabdata');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_usertabdata` ADD `text_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_users');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('whyactive_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_users` ADD `whyactive_$prefix` longtext NOT NULL"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_usertabs');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (!in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_usertabs` ADD `name_$prefix` varchar(255) NOT NULL"); }
		
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='organization_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('organization_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='footer_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('footer_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='header_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('header_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='header1_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('header1_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='header2_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('header2_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaTitleAccount_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaTitleAccount_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaDescriptionAccount_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaDescriptionAccount_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaTitleRegistration_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaTitleRegistration_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaDescriptionRegistration_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaDescriptionRegistration_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaTitleSearch_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaTitleSearch_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaDescriptionSearch_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaDescriptionSearch_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaTitlePage404_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaTitlePage404_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='metaDescriptionPage404_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('metaDescriptionPage404_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='from_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('from_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='fromName_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('from_$prefix', '')"); } 
		$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='body_$prefix'");
		if ($result->num_rows==0) { $mysqli->query("INSERT INTO `ns_config` (`name`, `param`) VALUES ('from_$prefix', '')"); } 
		
	}
	
	function delLanguage ($id) {
	
		$db = \Config\Database::connect();
		$builder = $db->table('languages');
		$builder->where ('id',$id);
		$language = $builder->get()->getRowArray();
		
		$prefix = $language['url'];
		
		$Database = new Database;
		$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_langnames');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_langnames` DROP `param_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_articles');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` DROP `name_$prefix`"); }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` DROP `text_$prefix`"); } 
		if (in_array('info_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` DROP `info_$prefix`"); } 
		if (in_array('title_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` DROP `title_$prefix`"); } 
		if (in_array('description_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` DROP `description_$prefix`"); } 
		if (in_array('keywords_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_articles` DROP `keywords_$prefix`"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_banchapters');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_banchapters` DROP `param_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_uservars');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_uservars` DROP `param_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_bannotes');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_bannotes` DROP `param_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_banshablon');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('param_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_banshablon` DROP `param_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_feedback');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedback` DROP `name_$prefix`"); }
		if (in_array('secondName_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedback` DROP `secondName_$prefix`"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_feedbackparams');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedbackparams` DROP `name_$prefix`"); }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_feedbackparams` DROP `text_$prefix`"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_chapters');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `name_$prefix`"); }
		if (in_array('link_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `link_$prefix`"); }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `text_$prefix`"); } 
		if (in_array('info_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `info_$prefix`"); } 
		if (in_array('title_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `title_$prefix`"); } 
		if (in_array('description_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `description_$prefix`"); } 
		if (in_array('keywords_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_chapters` DROP `keywords_$prefix`"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_gallery');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_gallery` DROP `text_$prefix`"); }
		if (in_array('link_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_gallery` DROP `link_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_letters');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_letters` DROP `text_$prefix`"); }
		if (in_array('theme_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_letters` DROP `theme_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_moduls');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_moduls` DROP `text_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_notes');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` DROP `name_$prefix`"); }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` DROP `text_$prefix`"); } 
		if (in_array('title_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` DROP `title_$prefix`"); } 
		if (in_array('description_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` DROP `description_$prefix`"); } 
		if (in_array('keywords_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notes` DROP `keywords_$prefix`"); } 
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_notetabs');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notetabs` DROP `text_$prefix`"); }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_notetabs` DROP `name_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_pollparams');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_pollparams` DROP `name_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_polls');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_polls` DROP `name_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_slider');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('link_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_slider` DROP `link_$prefix`"); }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_slider` DROP `text_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_userparams');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_userparams` DROP `name_$prefix`"); }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_userparams` DROP `text_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_usertabdata');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('text_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_usertabdata` DROP `text_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_users');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('whyactive_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_users` DROP `whyactive_$prefix`"); }
		
		$field_array = array();
		$result = $mysqli->query('SHOW columns FROM ns_usertabs');
		while($row = mysqli_fetch_array($result)){ $field_array[] = $row['Field']; }
		if (in_array('name_'.$prefix, $field_array)) { $result = $mysqli->query("ALTER TABLE `ns_usertabs` DROP `name_$prefix`"); }
		
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='organization_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='footer_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='header_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='header1_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaTitleAccount_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaDescriptionAccount_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaTitleRegistration_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaDescriptionRegistration_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaTitleSearch_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaDescriptionSearch_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaTitlePage404_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='metaDescriptionPage404_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='header2_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='from_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='fromName_$prefix'");
		$mysqli->query("DELETE FROM `ns_config` WHERE `name`='body_$prefix'");
		
		$db = \Config\Database::connect();
		$builder = $db->table('languages');
		$builder->where ('id',$id);
		$builder->delete();
		
	}
		
}