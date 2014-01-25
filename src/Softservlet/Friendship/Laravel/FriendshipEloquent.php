<?php namespace Softservlet\Friendship\Laravel;

use Softservlet\Friendship\Core\FriendshipInterface;
use Softservlet\Friendship\Core\FriendableInterface;
use Softservlet\Friendship\Laravel\Eloquent\Friendship as DBLayer;

/**
 * @author Vladu Emilian Sorin <vladu@softservlet.com>
 *
 * @version 1.0
 */

class FriendshipEloquent implements FriendshipInterface
{
	// a friendship may be in three phases: PENDING,
	// ACCEPTED, and DENIED. We define  here constants that
	// represent those states.
	const PENDING = 0;
	const ACCEPTED = 1;
	const DENIED = 2;

	//sender 
	private $sender = null;

	//receiver
	private $receiver = null;

	/*/
	 * @brief - This class requires a sender and a receiver
	 */
	public function __construct(FriendableInterface $actor, FriendableInterface $user)
	{
		$this->actor = $actor;
		$this->user = $user;
	}

	/**
	 * @brief - send a friendship from sender to receiver
	 * 
	 * @return bool - true if success, false otherwise
	 */
	public function send()
	{
		$friendship = new DBLayer;
		$friendship->sender_id = $this->actor->getId();
		$friendship->receiver_id = $this->user->getId();
		$friendship->status = $this::PENDING;
		$friendship->created = time();
		return $friendship->save();
	}

	/**
	 * @brief - check if a friendship exists between a sender 
	 * and a receiver
	 *
	 * @param int $status - a defined constant that's represents
	 * the friendship status
	 *
	 * @return bool - true if exists, false otherwise
	 */
	public function exists($status = null)
	{
		$exists = DBLayer::where(function($query)
		{
			$query->where('sender_id', $this->actor->getId())->where('receiver_id', $this->user->getId());
		})
		->orWhere(function($query)
		{
			$query->where('receiver_id', $this->actor->getId())->where('sender_id', $this->user->getId());
		});

		if($status != null)
		{
			$exists = $exists->where('status', $status); 
		}
		return (bool) $exists->count();
	}

	/**
	 * @brief - accept a friendship. The sender should call
	 * this method in order to accept a friendship from receiver.
	 *
	 * @return bool - true in case of success, false otherwise
	 */
	public function accept()
	{
		$friendship = DBLayer::where(function($query)
		{
			$query->where('sender_id', $this->actor->getId())->where('receiver_id', $this->user->getId());
		})
		->orWhere(function($query)
		{
			$query->where('receiver_id', $this->actor->getId())->where('sender_id', $this->user->getId());
		})->update(array('status'	=> $this::ACCEPTED));
		return (bool) $friendship;
	}

	/**
	 * @brief - the receiver has posibility to deny a friendship
	 *
	 * @return bool
	 */
	public function deny()
	{
		$friendship = DBLayer::where(function($query)
		{
			$query->where('sender_id', $this->actor->getId())->where('receiver_id', $this->user->getId());
		})
		->orWhere(function($query)
		{
			$query->where('receiver_id', $this->actor->getId())->where('sender_id', $this->user->getId());
		})->update(array('status'	=> $this::DENIED));
		return (bool) $friendship;
	}

	/**
	 * @brief - delete a friendship between a sender and a receiver
	 *
	 * @return bool
	 */
	public function delete()
	{
		$friendship = DBLayer::where(function($query)
		{
			$query->where('sender_id', $this->actor->getId())->where('receiver_id', $this->user->getId());
		})
		->orWhere(function($query)
		{
			$query->where('receiver_id', $this->actor->getId())->where('sender_id', $this->user->getId());
		})->delete();
		return (bool) $friendship;
	}
}
