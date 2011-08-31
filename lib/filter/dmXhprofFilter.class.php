<?php
class dmXhprofFilter extends dmInitFilter
{
	public function execute($filterChain)
	{
		if(extension_loaded('xhprof') && sfConfig::get('app_xhprof_enabled'))
		{
			$pluginPath = sfConfig::get('sf_plugins_dir') . '/dmXhprofPlugin/lib/vendor/xhprof/';
			require_once $pluginPath . 'xhprof_lib/utils/xhprof_lib.php';
			require_once $pluginPath . 'xhprof_lib/utils/xhprof_runs.php';

			if($this->getContext()->getRequest()->isXmlHttpRequest())
			{
				$this->getContext()->getEventDispatcher()->connect('dm.context.end', array($this, 'listenToDmContextEndForXhr'));
			}
			else
			{
				$this->getContext()->getEventDispatcher()->connect('dm.context.end', array($this, 'listenToDmContextEndForHtml'));
			}
			xhprof_enable(sfConfig::get('app_xhprof_level', XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY));
		}

		$filterChain->execute($filterChain);
	}

	protected function getXHProfUILink($profiler_namespace, $run_id)
	{
		return sprintf('http://%s/index.php?run=%s&source=%s',
		sfConfig::get('app_xhprof_ui.link', 'localhost/xhprof/xhprof_html/'),
		$run_id,
		$profiler_namespace);
	}

	protected function getNamespace()
	{
		return dmArray::last(explode(DIRECTORY_SEPARATOR, sfConfig::get('sf_root_dir'))) . '_' . sfConfig::get('sf_environment');
	}

	protected function saveRun()
	{
		$profiler_namespace = $this->getNamespace();
		$xhprof_data = xhprof_disable();
		$xhprof_runs = new XHProfRuns_Default();
		$run_id = $xhprof_runs->save_run($xhprof_data, $profiler_namespace);
		return $this->getXHProfUILink($profiler_namespace, $run_id);
	}

	public function listenToDmContextEndForXhr($event)
	{
		$profiler_url = $this->saveRun();
		$this->getContext()->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array($profiler_url)));
	}

	public function listenToDmContextEndForHtml($event)
	{
		$profiler_url = $this->saveRun();

		if(sfConfig::get('app_xhprof_outputlink', false))
		{
			echo '<a href="'.$profiler_url.'" target="_blank">Profiler output</a>';
		}

		$this->getContext()->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array($profiler_url)));
	}
}