<?php

/**
 * dmXhprofPlugin configuration.
 *
 * @package     dmXhprofPlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class dmXhprofPluginConfiguration extends sfPluginConfiguration
{
	const VERSION = '1.0.0-DEV';

	/**
	 * @see sfPluginConfiguration
	 */
	public function initialize()
	{
		$this->enableModules();
	}
	
	protected function enableModules()
	{
		sfConfig::set('sf_enabled_modules', array_unique(array_merge(array('xhProfilingRunAdmin'), sfConfig::get('sf_enabled_modules', array()))));
	}
}
