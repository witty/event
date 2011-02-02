<?php
/**
 * Event Class
 *
 * @author lzyy http://blog.leezhong.com
 * @version 0.1.0
 */
class Event extends Witty_Base
{
	/**
	 * @var array store internal events
	 */
	protected static $_events = array();

	/**
	 * @var boolean check if events has been dealed. if true, after listeners will not executed any more
	 */
	protected static $_done = FALSE;

	/**
	 * add event listener
	 *
	 * @param string $event event name
	 * @param mixed $listener listener, string or 
	 */
	public static function add($event, $listener)
	{
		empty($_events[$event]) && $_events[$event] = array();
		if (!in_array($listener, $_events[$event]))
		{
			Event::$_events[$event][] = $listener;
		}
	}

	/**
	 * remove event, event's listeners will removed too
	 *
	 * @param string $event eventname
	 */
	public static function remove($event)
	{
		unset(Event::$_events[$event]);
	}

	/**
	 * check if an event has curtain listener 
	 *
	 * @param string $event event name
	 * @param mixed $listener listener
	 * @return boolean
	 */
	public static function has_listener($event, $listener)
	{
		empty(Event::$_events[$event]) && Event::$_events[$event] = array();
		return in_array($listener, Event::$_events[$event]);
	}

	/**
	 * mark event has been dealed
	 */
	public static function done()
	{
		Event::$_done = TRUE;
	}

	/**
	 * get all events, include events' listeners
	 * @return array
	 */
	public static function get_events()
	{
		return self::$_events;
	}

	/**
	 * remove listener
	 *
	 * @param string $event event name
	 * @param mixed $listener listener
	 */
	public static function remove_listener($event, $listener)
	{
		$key = array_search($listener, Event::$_events[$event]);
		if ($key !== FALSE)
		{
			unset(Event::$_events[$event][$key]);
		}
	}

	/**
	 * get an events' all listeners
	 *
	 * @param string $event event name
	 * @return array
	 */
	public static function get_listeners($event)
	{
		empty(Event::$_events[$event]) && Event::$_events[$event] = array();
		return Event::$_events[$event];
	}

	/**
	 * trigger event
	 *
	 * @param string $event eventname
	 * @param array $param param
	 * @return mixed
	 */
	public static function notify($event, $param)
	{
		empty(Event::$_events[$event]) && Event::$_events[$event] = array();
		$result = null;
		foreach (Event::$_events[$event] as $listener)
		{
			$result = call_user_func($listener, $param);
			// if listener has return value, the return value will be the param, like filter
			if (!is_null($result))
			{
				$param = $result;
			}
			if (Event::$_done === TRUE)
			{
				break ;
			}
		}
		return is_null($result) ? NULL : $result;
	}
}
