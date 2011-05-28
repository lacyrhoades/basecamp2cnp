<?php

/**
 * Basecamp API Wrapper for PHP 5.3+ 
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt
 *
 * @category   Sirprize
 * @package    Basecamp
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    MIT License
 */


namespace Sirprize\Basecamp\TodoList\Collection\Observer;


/**
 * Abstract class to observe and print state changes of the observed todoList
 *
 * @category  Sirprize
 * @package   Basecamp
 */
abstract class Abstrakt
{
	
	
	abstract public function onStartSuccess(\Sirprize\Basecamp\TodoList\Collection $collection);
	abstract public function onStartError(\Sirprize\Basecamp\TodoList\Collection $collection);
	
	
	
	protected function _getOnStartSuccessMessage(\Sirprize\Basecamp\TodoList\Collection $collection)
	{
		return "started todoList collection. found ".$collection->count()." todoLists";
	}
	
	
	protected function _getOnStartErrorMessage(\Sirprize\Basecamp\TodoList\Collection $collection)
	{
		return "todoList collection could not be started";
	}
	
}