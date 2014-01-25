<?php namespace Softservlet\Friendship\Core;

use Softservlet\Friendship\Core\FriendableInterface;

/**
 * @author Vladu Emilian Sorin <vladu@softservlet.com>
 *
 * @version 1.0
 */

interface FriendshipInterface
{
	/**
	 * @brief - create a friendship between $sender and $receiver
	 *
	 * @return bool - true on success, false otherwise
	 */
	public function send();

	/**
	 * @brief - check if a friendship exists.
	 *
	 * @param $status - a friendship exists in 3 types: PENDING, ACCEPTED,
	 * DENIED.
	 *
	 * @return bool - true if friendship exists, false otherwise
	 */
	public function exists($status);

	/**
	 * @brief - if a friendship was sent, you will accept that friendship
	 *
	 * @return bool - true in case of success, false otherwise
	 */
	 public function accept();

	 /**
	  * @brief - if a friendship was sent, you can deny it
	  *
	  * @return bool - true in case of success, false otherwise
	  */
	 public function deny();

	 /**
	  * @brief - completly remove the friendship between two users
	  *
	  * @return bool - true in case of success, false otherwise
	  */
	 public function delete();
}
