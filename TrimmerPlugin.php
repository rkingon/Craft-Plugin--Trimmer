<?php

namespace Craft;

class TrimmerPlugin extends BasePlugin
{
	public function getName()
	{
		return Craft::t('Trimmer');
	}

	public function getVersion()
	{
		return '1.0';
	}

	public function getDeveloper()
	{
		return 'Roi Kingon';
	}

	public function getDeveloperUrl()
	{
		return 'http://www.roikingon.com';
	}

	public function addTwigExtension()
	{
		Craft::import('plugins.trimmer.twigextensions.TrimmerTwigExtension');
		return new TrimmerTwigExtension();
	}
}
