<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Permissions.
 *
 * @package    Sentry/Permissions
 * @category   Sentry
 * @author     happyDemon Maxim Kerstens
 * @copyright  (c) 2013 Maxim Kerstens
 * @license    MIT
 */
class Permissions {
	/**
	 * @var Config|null
	 */
	protected $_list = null;

	/**
	 * Get the active Permissions instance
	 *
	 * @return Permissions
	 */
	public static function instance()
	{
		static $inst = null;

		if($inst == null)
			$inst = new Permissions();

		return $inst;
	}

	/**
	 * Load the config file reader to initiate the Permissions object
	 */
	public function __construct() {
		$this->_list = new Config();
		$this->_list->attach(new Config_File('permissions'));
	}

	/**
	 * Check if a permission has been defined somewhere
	 *
	 * @param $permission string Name of the permission
	 * @return bool
	 */
	public function exists($permission) {
		return in_array($permission, $this->list_permissions());
	}

	/**
	 * Return all defined permissions (results get stored at the first run)
	 *
	 * @return array
	 */
	public function all()
	{
		static $list = null;

		if($list == null)
		{
			$perms = array();

			$paths = array_keys(Kohana::list_files('permissions'));

			foreach ($paths as $path)
			{
				$set = str_replace(array('permissions'.DIRECTORY_SEPARATOR, '.php'), '', $path);

				$list = $this->_list->load($set)->as_array();

				foreach ($list as $k => $v)
				{
					if (is_int($k))
					{
							$perms[] = $set . '.' . $v;
					}
					else
					{
						$perms = $this->_process_perms($v, $set . '.' . $k, $perms);
					}
				}
			}
			sort($perms);

			$list = $perms;
		}

		return $list;
	}

	/**
	 * Flatten permissions
	 *
	 * @param $permissions array List of permissions to run through
	 * @param $parent string Permission prefix
	 * @param $list array List to add the flat permissions to
	 * @return array
	 */
	protected function _process_perms($permissions, $parent, $list)
	{
		foreach ($permissions as $k => $v)
		{
			if (is_int($k))
			{
				$list[] = $parent . '.' . $v;
			}
			else
			{
				$id = $parent . '.' . $k;
				$list = $this->_process_perms($v, $id, $list);
			}
		}
		return $list;
	}

	/**
	 * Return all defined permissions (results get stored at the first run)
	 *
	 *
	 *
	 * @return array
	 */
	public function split($exclude)
	{
		static $list = null;

		if($list == null)
		{
			$perms = array('keep' => array(), 'owned' => array());

			$paths = array_keys(Kohana::list_files('permissions'));

			foreach ($paths as $path)
			{
				$set = str_replace(array('permissions'.DIRECTORY_SEPARATOR, '.php'), '', $path);

				$list = $this->_list->load($set)->as_array();

				foreach ($list as $k => $v)
				{
					if (is_int($k))
					{
						if (!in_array($set . '.' . $v, $exclude))
						{
							$perms['keep'][] = $set . '.' . $v;
						}
						else
						{
							$perms['owned'][] = $set . '.' . $v;
						}
					}
					else
					{
						$perms = $this->_process_perms_split($v, $set . '.' . $k, $perms, $exclude);
					}
				}
			}
			$list = $perms;
		}

		sort($perms['owned']);
		sort($perms['keep']);
		return $list;
	}
	/**
	 * Flatten permissions and split them up
	 *
	 * @param $permissions array List of permissions to run through
	 * @param $parent string Permission prefix
	 * @param $list array List to add the flat permissions to
	 * @return array
	 */
	protected function _process_perms_split($permissions, $parent, $list, $exclude)
	{
		foreach ($permissions as $k => $v)
		{
			if (is_int($k))
			{
				if (!in_array($parent . '.' . $v, $exclude))
				{
					$list['keep'][] = $parent . '.' . $v;
				}
				else
				{
					$list['owned'][] = $parent . '.' . $v;
				}
			}
			else
			{
				$id = $parent . '.' . $k;
				$list = $this->_process_perms_split($v, $id, $list, $exclude);
			}
		}
		return $list;
	}
}
