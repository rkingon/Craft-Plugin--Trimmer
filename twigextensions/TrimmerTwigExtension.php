<?php

namespace Craft;

class TrimmerTwigExtension extends \Twig_Extension
{
	protected $env;

	public function getName()
	{
		return 'Roi Kingon';
	}

	public function getFilters()
	{
		return array('trimit' => new \Twig_Filter_Method($this, 'trimit'));
	}
	
	public function getFunctions()
	{
		return array('trimit' => new \Twig_Function_Method($this, 'trimit'));
	}

	public function initRuntime(\Twig_Environment $env)
	{
		$this->env = $env;
	}

	public function trimit($str, $length, $word = true, $ellipsis = "...")
	{
		// Let's make sure our inputs are correct
		$length = (!is_numeric($length)) ? 100 : $length;
		$word = (!in_array(strtolower($word), array("no","false")) || $word !== false);
		
		// Remove HTML tags.
		$str = strip_tags($str);
		
		// No need if our total length is less than the strings length
		if(strlen($str) <= $length)
		{
			return $str;
		}
		
		// Truncate by either word or char, then return with ellipsis
		return ( ($word) ? $this->_truncateByWord($str,$length) : substr($str,0,$length) ).$ellipsis;
	}
	
	private function _truncateByWord($str, $length)
	{
		// Truncate Text
		$str = substr($str, 0, $length);
		$str = substr($str, 0, strrpos($str," "));
		
		// Trim It
		$str = trim( str_replace("&nbsp;", " ", $str) );
		
		// Loose all ending puncuation, then return truncated text
		return preg_replace("/\.\W*$/", "", $str);
	}
	
}