<?php namespace Softservlet\Friendship\Core;

use Softservlet\Friendship\Core\FriendableInterface;

interface FriendshipRepositoryInterface
{
	/**
	 * @brief - return a friendship between two users
	 *
	 * @param FriendableInterface $user
	 *
	 * @return Softservlet\Friendship\Core\FriendshipInterface
	 */
	 public function getFriendship(FriendableInterface $user);

	/**
	  * @brief - return an array with unconfirmed sent friendships requests 
	  *
	  * @param int $limit - the limit of results
	  * @param int $offset - the offset of results
	  * 
	  * @return array FriendableInterface - an array of FriendableInterface objects
	  */
	 public function getPendingFriendships($limit, $offset);

	 /**
	  * @brief - return all friendship requests 
	  *
	  * @param int $limit - the limit of results
	  * @param int $offset - the offset of results
	  *
	  * @return array FriendableInterface - an array of FriendableInterface objects 
	  */
	 public function getAllFriendships($limit, $offset);

	 /**
	  * @brief - return all friendship requests 
	  *
	  * @param int $limit - the limit of results
	  * @param int $offset - the offset of results
	  *
	  * @return array FriendableInterface - an array of FriendableInterface objects 
	  */
	 public function getAcceptedFriendships($limit, $offset);
}
