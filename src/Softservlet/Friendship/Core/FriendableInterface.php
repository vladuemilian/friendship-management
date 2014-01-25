<?php namespace Softservlet\Friendship\Core;

interface FriendableInterface 
{
	public function getId(); //return the id of object

	public static function find($id);
}
