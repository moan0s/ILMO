<?php

class config_php_file
{

	/**
	* Indicates whether the php config file has been loaded.
	*
	* @var bool
	*/
	protected $config_loaded = false;

	/**
	* The content of the php config file
	*
	* @var array
	*/
	protected $config_data = array();

	/**
	* The path to the config file. (Default: $phpbb_root_path . 'config.' . $php_ext)
	*
	* @var string
	*/
	protected $config_file;

	private $defined_vars;

	/**
	* Constructor
	*
	* @param string $phpbb_root_path phpBB Root Path
	* @param string $php_ext php file extension
	*/
	function __construct($filepath)
	{
		if (!file_exists($filepath)) {
			echo "File does not exist";
		}
		else {
			$this->config_file = $filepath;
		}
	}

	/**
	* Set the path to the config file.
	*
	* @param string $config_file
	*/
	public function set_config_file($config_file)
	{
		$this->config_file = $config_file;
		$this->config_loaded = false;
	}

	/**
	* Returns an associative array containing the variables defined by the config file.
	*
	* @return array Return the content of the config file or an empty array if the file does not exists.
	*/
	public function get_all()
	{
		$this->load_config_file();

		return $this->config_data;
	}

	/**
	* Return the value of a variable defined into the config.php file or null if the variable does not exist.
	*
	* @param string $variable The name of the variable
	* @return mixed Value of the variable or null if the variable is not defined.
	*/
	public function get($variable)
	{
		$this->load_config_file();

		return isset($this->config_data[$variable]) ? $this->config_data[$variable] : null;
	}

	/**
	* Load the config file and store the information.
	*
	* @return null
	*/
	protected function load_config_file()
	{
		if (!$this->config_loaded && file_exists($this->config_file))
		{
			$this->defined_vars = get_defined_vars();

			require($this->config_file);
			$this->config_data = array_diff_key(get_defined_vars(), $this->defined_vars);

			$this->config_loaded = true;
		}
		var_dump($this->config_file);
	}
}
