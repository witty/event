## Basic usage

	Event::add('foo:bar', 'callback');
	Event::add('foo:bar', array($obj, 'method'));
	Event::notify('foo:bar', array('foo' => 'bar'));
	Event::remove_listener('foo:bar', 'callback');
	Event::remove('foo:bar');

## Attention

when notifying event, event param should be an array, it is convient for latter add param to this array.
