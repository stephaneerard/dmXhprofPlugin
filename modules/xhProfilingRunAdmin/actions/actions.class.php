<?php

/**
 * xhProfilingRunAdmin actions.
 *
 * @package    dmXhprofPlugin
 * @subpackage xhProfilingRunAdmin
 * @author     
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class xhProfilingRunAdminActions extends dmAdminBaseActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$dir = get_cfg_var('xhprof.output_dir');
		
		$_runs = sfFinder::type('file')->in($dir);
		$runs = array();
		
		foreach($_runs as $run)
		{
			$raw = explode('.', basename($run));
			
			$id = $raw[0];
			$source = $raw[1];
			
			$raw = explode('_', $source);
			$env = $raw[1];
			$namespace = $raw[0];
			
			$runs[] = array(
				'id' => $id, 
				'env' => $env, 
				'namespace' => $namespace, 
				'time' => 0, 
				'link' => $this->getHelper()->link('xhProfilingRunAdmin/see')->param('source', $source)->param('id', $id)->text('See')
			);
		}
		
		$this->runs = $runs;
	}
	
	public function executeSee($request)
	{
		$this->source = $request->getParameter('source');
		$this->run = $request->getParameter('id');

		$this->getContext()->getConfiguration()->loadHelpers(array('Url'), $this->getContext()->getModuleName());
		
		$home = public_path('/', true);
		
		//$this->redirect($home . '/dmXhprofPlugin/xhprof_html/index.php?source=' . $source . '&id=' . $id);
	}
}
