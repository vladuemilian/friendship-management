<?php namespace Softservlet\Friendship\Laravel;

use Softservlet\Friendship\Laravel\Eloquent\Friendship as DBLayer;
use Softservlet\Friendship\Laravel\FriendshipEloquent as Friendship;
use Softservlet\Friendship\Core\FriendshipRepositoryInterface;
use Softservlet\Friendship\Core\FriendableInterface;
use App;

class FriendshipRepositoryEloquent implements FriendshipRepositoryInterface
{
	
	private $actor;

	/**
	 * @brief - we can get friendships when we know at least
	 * one author, we need to pass a FriendableInterface as
	 * parameter to this class, then we can retrieve other
	 * friendships based on this parameter.
	 *
	 * @param FriendableInterface $user
	 * @param UserRepositoryInterface $userRepository;
	 */
	public function __construct(FriendableInterface $actor)
	{
		$this->actor = $actor;
	}

	/**
	 * @brief - return a friendship between two users
	 *
	 * @param FriendableInterface $user
	 *
	 * @return Softservlet\Friendship\Core\FriendshipInterface
	 */
	 public function getFriendship(FriendableInterface $user)
	 {
		$friendship = App::make('Softservlet\Friendship\Core\FriendshipInterface', array('actor'	=> $this->actor, 'user' => $user)); 
		return $friendship;
	 }

	 /**
	  * @brief - return an array with unconfirmed received friendships requests 
	  *
	  * @param int $limit - the limit of results
	  * @param int $offset - the offset of results
	  * 
	  * @return array FriendableInterface - an array of FriendableInterface objects
	  */
	 public function getPendingFriendships($limit = null, $offset = 0)
	 {
	 	//User repository
	 	//We return a array with FriendshipInterface objects
		$friendships = array();

		$query = DBLayer::where('receiver_id', $this->actor->getId())->where('status', Friendship::PENDING);

		//limit and offset
		if($limit!=null)
		{
			$query->take($limit);
		}
		if($offset!=0)
		{
			$query->skip($offset);
		}

		foreach($query->get() as $friendship)
		{
			$friendships[] = $this->getFriendship($this->actor->find($friendship->receiver_id));
		}
		return $friendships;
	 }


	 /**
	  * @brief - return all friendship requests 
	  *
	  * @param int $limit - the limit of results
	  * @param int $offset - the offset of results
	  *
	  *
	  * @return array FriendableInterface - an array of FriendableInterface objects 
	  */
	 public function getAllFriendships($limit, $offset)
	 {
	 	//User repository
	 	//We return a array with FriendshipInterface objects
		$friendships = array();

		//$query = DBLayer::where('receiver_id', $this->actor->getId())->orWhere('sender_id', $this->actor->getId());
		$query = DBLayer::where(function($qry) 
		{
			$qry->where('sender_id', $this->actor->getId());
		})->orWhere(function($qry)
		{
			$qry->where('receiver_id', $this->actor->getId());
		});
		//limit and offset
		if($limit!=null)
		{
			$query->take($limit);
		}
		if($offset!=0)
		{
			$query->skip($offset);
		}

		foreach($query->get() as $friendship)
		{
			if( $friendship->sender_id == $this->actor->getId() )
			{
				$friendships[] = $this->getFriendship($this->actor->find($friendship->receiver_id));
			}
			else
			{
				$friendships[] = $this->getFriendship($this->actor->find($friendship->sender_id));
			}
		}
	 }

	 /**
	  * @brief - return all friendship requests 
	  *
	  * @param int $limit - the limit of results
	  * @param int $offset - the offset of results
	  *
	  *
	  * @return array FriendableInterface - an array of FriendableInterface objects 
	  */
	 public function getAcceptedFriendships($limit = null, $offset = 0)
	 {
	 	//User repository
	 	//We return a array with FriendshipInterface objects
		$friendships = array();

		//$query = DBLayer::where('receiver_id', $this->actor->getId())->orWhere('sender_id', $this->actor->getId());
		//$query = DBLayer::where('received_id', $this->actor->getId())->where('status', Friendship::PENDING);
		$query = DBLayer::where(function($qry) 
		{
			$qry->where('sender_id', $this->actor->getId());
			$qry->where('status', Friendship::ACCEPTED);
		})->orWhere(function($qry)
		{
			$qry->where('receiver_id', $this->actor->getId());
			$qry->where('status', Friendship::ACCEPTED);
		});

		//limit and offset
		if($limit!=null)
		{
			$query->take($limit);
		}
		if($offset!=0)
		{
			$query->skip($offset);
		}

		foreach($query->get() as $friendship)
		{
			if( $friendship->sender_id == $this->actor->getId() )
			{
				$friendships[] = $this->getFriendship($this->actor->find($friendship->receiver_id));
			}
			else
			{
				$friendships[] = $this->getFriendship($this->actor->find($friendship->sender_id));
			}

		}
		return $friendships;
	 }

	 /**
	  *
	  *
	  *
	  *
	  */
	 public function getDeniedFriendships($limit = null, $offset = 0)
	 {
		return array();
	 }


}
