<?php

namespace Craft;

class TrimmerTwigExtension extends \Twig_Extension
{
	protected $env;

	public function getName()
	{
		return 'Trimmer';
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

	public function trimit($str, $length, $word = true, $html = true, $ellipsis = "...")
	{
		// Let's make sure our inputs are correct
		$length = (!is_numeric($length)) ? 100 : $length;
		$word = (!in_array(strtolower($word), array("no","false")) || $word !== false);
		
		// Remove HTML tags.
        if ($html != true)
        {
		  $str = $this->_strip_html_tags($str);
        }
		
		// Only try and truncate / add ellipsis if our string length is longer than our length limit
		if(strlen($str) > $length)
		{
			$str = ( ($word) ? $this->_truncateByWord($str,$length) : substr($str,0,$length) ).$ellipsis;
		}
		
		return $str;
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
	
	private function _strip_html_tags($text)
	{
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
				// Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
				'@</?((article)|(section)|(address)|(header)|(footer)|(figure)|(nav)|(aside))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0", "\n\$0",
			),
			$text );
		return strip_tags($text);
	}
}