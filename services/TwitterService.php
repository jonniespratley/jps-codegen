<?php 
/**
 * @author Jonnie Spratley
 * @copywrite 2009 Jonnie Spratley
 * @url http://jonniespratley.com
 * @classDescription - PHP Proxy wrapper for the Twitter API. For use with jquery.jTwitter.js
 * @projectDescription - http://code.google.com/p/jquery-jtwitter/ 
 * @example - View the bottom of this class for all php examples.
 */
class TwitterService {
    /**
     * @var - Twitter Username
     */
    private $twitterUser = null;
    /**
     * @var - Twitter Password
     */
    private $twitterPass = null;
    /**
     * @var - Twitter User Agent
     */
    private $twitterUserAgent = null;
    /**
     * @var - Twitter URL
     */
    private $twitterUrl = 'http://twitter.com/';
    /**
     * @var - Twitter Result Object
     */
    private $twitterResult = null;
    /**
     * @var - Twitter Fault Object
     */
    private $twitterFault = null;
    /**
     * @var - Twitter Result Headers
     */
    private $twitterResultHeaders = null;
    /**
     * @var - Twitter Result Format
     */
    private $twitterResultFormat = 'json';
    /**
     * @var - Bool - Request loggin on or off
     */
    private $apiRequestLogging = false;
	/**
	 * @var - String - Request log filename, must have full read/write perms
	 */
    private $apiRequestFilename = 'logs/jtwitter_requests.log';
	/**
	 * @var - Bool - Result loggin on or off
	 */
    private $apiResultLogging = false;
	/**
	 * @var - String - Result log filename, must have full read/write perms
	 */
    private $apiResultFilename = 'logs/jtwitter_results.log';
    
    /**
     * TwitterService instance that allows fully ability to utilitize twitter.com api.  
     * 
     * @example
     * <code>
     * 
     * $service = new TwitterService();
     * $service->set_twitterUser('USERNAME');
     * $service->set_twitterPass('PASSWORD');
     * $service->set_twitterResultFormat('json');
     * 
     * </code>
     * @return Instance of class
     */
    public function __construct() {
    #    error_reporting(0);
    }
    
    /* ****************************************
     * Getters/Setters
     * **************************************** */
    
    /**
     * @param object $str
     */
    public function set_twitterUser($str) {
        $this->twitterUser = $str;
    }
    /**
     * @param object $str
     */
    public function set_twitterPass($str) {
        $this->twitterPass = $str;
    }
    /**
     * @param object $str
     */
    public function set_twitterUserAgent($str) {
        $this->twitterAgent = $str;
    }
    /**
     * @param object $str
     */
    public function set_twitterResultFormat($str) {
        $this->twitterResultFormat = $str;
    }
    /**
     *
     * @return
     * @param object $str
     */
    public function set_twitterResultHeaders($str) {
        $this->twitterResultHeaders = $str;
    }
	 /**
     *
     * @return
     * @param object $str
     */
    public function set_apiRequestLogging($bool) {
        $this->apiRequestLogging = $bool;
    }
	 /**
     *
     * @return
     * @param object $str
     */
    public function set_apiResultLogging($bool) {
        $this->apiResultLogging = $bool;
    }

	/**
     *
     * @return
     * @param object $str
     */
    public function set_apiResultFilename($str) {
        $this->apiResultFilename = $str;
    }	
	/**
     *
     * @return
     * @param object $str
     */
    public function set_apiRequestFilename($str) {
        $this->apiRequestFilename = $str;
    }

	 /**
     *
     * @return
     */
    public function get_apiResultLogging() {
       return $this->apiResultLogging;
    }
	 /**
     *
     * @return
     */
    public function get_apiRequestLogging() {
       return $this->apiRequestLogging;
    }
    /**
     *
     * @return
     */
    public function get_apiRequestFilename() {
        return $this->apiRequestFilename;
    }
	 /**
     *
     * @return
     */
    public function get_apiResultFilename() {
       return $this->apiResultFilename;
    }
    /**
     *
     * @return
     */
    public function get_twitterResultHeaders() {
        return $this->twitterResultHeaders;
    }
    /**
     *
     * @return
     */
    public function get_twitterUser() {
        return $this->twitterUser;
    }
    /**
     *
     * @return
     */
    public function get_twitterPass() {
        return $this->twitterPass;
    }
    /**
     *
     * @return
     */
    public function get_twitterUserAgent() {
        return $this->twitterAgent;
    }
    /**
     *
     * @return
     */
    public function get_twitterResultFormat() {
        return $this->twitterResultFormat;
    }
    
    /* ****************************************
     * Status Methods
     * **************************************** */
    /**
     * Removes a single status update from the Twitter timeline.
     * @return
     * @param object $id
     */
    public function status_deleteTweet($id) {
        #statuses/destroy/id.json
        $data = array('id'=>$id);
		  $query = http_build_query($data, '', '&'); 
        return $this->_POST( 'status', 'statuses/destroy/'.$id.'.'.$this->twitterResultFormat, $query);
    }
    /**
     * Returns a list of people who follow you.
     * @return
     * @param string $id[optional]
     * @param int $page[optional]
     */
    public function status_getFollowers( $id = null, $page = 1) {
        $data = array('page'=>$page);
        
        $query = http_build_query($data, '', '&');
        
        #statuses/followers.json/statuses/followers.xml
        return $this->_GET( 'followers', 'statuses/followers.'.$this->twitterResultFormat, $query);
    }
    /**
     * Returns a list of people you follow.
     * @return
     * @param object $id[optional]
     * @param object $page[optional]
     */
    public function status_getFriendsFollowers($id = null, $page = 1) {
        $data = array('id'=>$id, 'page'=>$page);
        $query = http_build_query($data, '', '&');
        
        #statuses/friends.json
        return $this->_GET( 'friendsFollowers', 'statuses/friends/'.$id.'.'.$this->twitterResultFormat, $query);
    }
    /**
     * Returns the most recent status updates made by people you follow.
     * @return
     * @param object $since[optional]
     * @param object $sinceid[optional]
     * @param object $count[optional]
     * @param object $page[optional]
     */
    public function status_getFriendsTimeline($count = 40, $page = 1, $since = null, $since_id = null) {
        $data = array('count'=>$count, 'page'=>$page);
        $query = http_build_query($data, '', '&');
        #statuses/friends_timeline.json
        return $this->_GET( 'friendsTimeline', 'statuses/friends_timeline.'.$this->twitterResultFormat, $query);
    }
    /**
     * Returns the most recent status updates from public accounts with custom pictures.
     * @return
     */
    public function status_getPublicTimeline() {
        #statuses/public_timeline.json
        return $this->_GET( 'publicTimeline', 'statuses/public_timeline.'.$this->twitterResultFormat);
    }
    /**
     * Returns the most recent status updates for a specific account.
     * @return
     * @param object $id[optional]
     * @param object $since[optional]
     * @param object $since_id[optional]
     * @param object $count[optional]
     * @param object $page[optional]
     */
    public function status_getUserTimeline($id = null, $count = 40, $page = 1) {
        $data = array( 'id' => $id, 'count'=>$count, 'page'=>$page);
        $query = http_build_query($data, '', '&');
        #statuses/user_timeline/id.json
        return $this->_GET( 'userTimeline', 'statuses/user_timeline/'.$id.'.'.$this->twitterResultFormat, $query);
    }
    /**
     * Returns the most recent status updates from people who have replied to you.
     * @return
     * @param object $since[optional]
     * @param object $since_id[optional]
     * @param object $count[optional]
     * @param object $page[optional]
     */
    public function status_getReplies($count = 10, $page = 1, $since = null, $since_id = null) {
        $data = array('count'=>$count, 'page'=>$page, 'since' => $since, 'since_id' => $since_id);
        $query = http_build_query($data, '', '&');
        #statuses/replies.json
        return $this->_GET( 'replies', 'statuses/replies.'.$this->twitterResultFormat, $query);
    }
    /**
     * Returns a single status update with the given ID.
     * @return
     * @param object $id
     */
    public function status_showTweet($id) {
        #statuses/show/id.json
        return $this->_GET( 'status', 'statuses/show/'.$id.'.'.$this->twitterResultFormat);
    }
    /**
     * Creates a new status update authored by you.
     * @return
     * @param object $text
     */
    public function status_postTweet($text) {
        $data = array('status'=>$text);
        $query = http_build_query($data);
        #statuses/update.json
        return $this->_POST( 'status', 'statuses/update.'.$this->twitterResultFormat, $query);
    }
    
    /* ****************************************
     * User Methods
     * **************************************** */
    
    /**
     * Returns your profile and statistical details.
     * @return
     * @param object $id
     */
    public function user_showProfile($id) {
        #users/show/id.json
        return $this->_GET( 'userProfile', 'users/show/'.$id.'.'.$this->twitterResultFormat);
    }
    
    /* ****************************************
     * Message Methods
     * **************************************** */
    
    /**
     * Returns the most recent direct messages you have received.
     * @return
     * @param object $since[optional]
     * @param object $since_id[optional]
     * @param object $page[optional]
     * @param object $count[optional]
     */
    public function message_getMessages($count = 30, $page = 1, $since = null, $since_id = null) {
        $data = array('count'=>$count, 'page'=>$page, 'since' => $since, 'since_id' => $since_id);
        $query = http_build_query($data, '', '&');
        
        #direct_messages.json
        return $this->_GET(  'messages', 'direct_messages.'.$this->twitterResultFormat, $query);
    }
    
    /**
     * Deletes an existing direct message received by you.
     * @return
     * @param object $id
     */
    public function message_deleteMessage($id) {
        #direct_messages/destroy/id.json
        $data = array('id'=>$id);
        
        return $this->_POST(  'messages', 'direct_messages/destroy/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Creates a new direct message sent from you to another user.
     * @return
     * @param object $user
     * @param object $text
     */
    public function message_createMessage($user, $text) {
        #direct_messages/new.json
        $data = array('user'=>$user, 'text'=>$text);
        
        return $this->_POST(  'messages', 'direct_messages/new.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Returns the most recent direct messages you have sent.
     * @return
     * @param object $since[optional]
     * @param object $since_id[optional]
     * @param object $page[optional]
     * @param object $count[optional]
     */
    public function message_getSentMessages($count = 30, $page = 1, $since = null, $since_id = null) {
		$data = array('count'=>$count, 'page'=>$page, 'since' => $since, 'since_id' => $since_id);
        $query = http_build_query($data, '', '&');
        
        #direct_messages/sent.json
        return $this->_GET( 'messages', 'direct_messages/sent.'.$this->twitterResultFormat, $query);
    }
    
    /* ****************************************
     * Friendship Methods
     * **************************************** */
    
    /**
     * Creates a new follow relationship between you and another Twitter member.
     * @return
     * @param object $id
     */
    public function friendship_followMember($id) {
        #/friendships/create/id.json
        $data = array('id'=>$id, 'follow'=>$id);
        
        return $this->_POST( 'friends', 'friendships/create/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Removes an existing follow relationship with another Twitter member.
     * @return
     * @param object $id
     */
    public function friendship_unfollowMember($id) {
        #/friendships/destroy/id.json
        $data = array('id'=>$id);
        
        return $this->_POST( 'friends', 'friendships/destroy/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Verifies whether one Twitter member is following another.
     * @return
     * @param object $userA
     * @param object $userB
     */
    public function friendship_confirmFollow($userA, $userB) {
        #/friendships/exists.json
        $data = array('user_a'=>$userA, 'user_b'=>$userB);
        
        return $this->_GET( 'friends', 'friendships/exists.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     *
     * @return
     * @param object $id
     */
    public function status_getFollowing($id) {
        #friends/ids.json
        return $this->_GET( 'friends', 'friends/'.$id.'.'.$this->twitterResultFormat);
    }
    
    /* ****************************************
     * Favorite Methods
     * **************************************** */
    
    /**
     * Returns a list of all status updates you’ve flagged as favorites.
     * @return
     * @param object $id[optional]
     * @param object $page[optional]
     */
    public function favorite_getFavorites($id = null, $page = 1) {
        $data = array( 'id' => $id, 'page'=>$page);
        $query = http_build_query($data, '', '&');
        
        #favorites.json
        return $this->_GET( 'favorites', 'favorites/'.$id.'.'.$this->twitterResultFormat, $query);
    }
    
    /**
     * Flags a status update as a favorite.
     * @return
     * @param object $id
     */
    public function favorite_createFavorite($id) {
        #favorites/create/id.json
        $data = array('id'=>$id);
        
        return $this->_POST( 'favorites', 'favorites/create/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Removes an existing flag on one of the authenticating member’s favorite status updates.
     * @return
     * @param object $id
     */
    public function favorite_deleteFavorite($id) {
        #favorites/destroy/id.json
        $data = array('id'=>$id);
        
        return $this->_POST( 'favorites', 'favorites/destroy/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }

    
    /* ****************************************
     * Block Methods
     * **************************************** */
    
    /**
     * Keeps another member from following your updates.
     * @return
     * @param object $id
     */
    public function block_blockMember($id) {
        #blocks/create/id.json
        $data = array('id'=>$id);
        
        return $this->_POST('block', 'blocks/create/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Allows another member to once again follow your updates.
     * @return
     * @param object $id
     */
    public function block_unBlockMember($id) {
        #blocks/destroy/id.json
        $data = array('id'=>$id);
        
        return $this->_POST('block', 'blocks/destroy/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }

    /**
     * Allows another member to once again follow your updates.
     * @return
     * @param object $id
     */
    public function block_exists($id) {
        #blocks/destroy/id.json
        $data = array('id'=>$id);
        
        return $this->_GET('block', 'blocks/exists/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
	
    /* ****************************************
     * Social Methods
     * **************************************** */
    
    /**
     * Gets the full list of people you follow.
     * @return - array
     */
    public function social_getAllFriends() {
        #/friends/ids.xml
        return $this->_GET('social', 'friends/ids.'.$this->twitterResultFormat);
    }
    
    /**
     * Gets the full list of people who follow you
     * @return - array
     */
    public function social_getAllFollowers() {
        #/followers/ids.xml
        return $this->_GET( 'social', 'followers/ids.'.$this->twitterResultFormat);
    }

    
    /* ****************************************
     * Account Methods
     * **************************************** */
    
    /**
     * Checks to see how many hourly hits on the API are left for your account
     * @return
     */
    public function account_rateLimit() {
        #account/rate_limit_status.format
        return $this->_GET( 'rate', 'account/rate_limit_status.'.$this->twitterResultFormat);
    }
    
    /**
     * Tells Twitter that your application is finished using your access credentials
     * @return
     */
    public function account_endSession() {
        #http://twitter.com/account/end_session.format
        return $this->_GET('account', 'account/end_session.'.$this->twitterResultFormat);
    }
    
    /**
     * Confirms that the supplied user account credentials are valid.
     * 
     * @example
     * <code>
     * $service->account_verifyCredentials();
     * </code>
     * @return 
     */
    public function account_verifyCredentials() {
        #/account/verify_credentials.format
        return $this->_GET('verify','account/verify_credentials.'.$this->twitterResultFormat);
    }
    
    /**
     * Selects a device for you to use to receive updates.
     * @return
     * @param object $device
     */
    public function account_updateDevice($device) {
        #/account/update_delivery_device.xml
        $data = array('device'=>$device);
        
        return $this->_POST('account','account/update_delivery_device.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Changes the location information stored in your profile.
     * @return
     * @param object $location
     */
    public function account_updateLocation($location) {
        #/account/update_location.xml
        $data = array('location'=>$location);
        
        return $this->_POST('account','account/update_location.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * 	Sets the values of selected fields found in the “Account” tab under the settings on the Twitter website.
     * @return
     * @param object $name[optional]
     * @param object $email[optional]
     * @param object $url[optional]
     * @param object $location[optional]
     * @param object $description[optional]
     */
    public function account_updateProfile($name = null, $email = null, $url = null, $location = null, $description = null) {
        #/account/update_profile.xml
        $data = array('name'=>$name, 'email'=>$email, 'url'=>$url, 'location'=>$location, 'description'=>$description);
        
        return $this->_POST('account','account/update_profile.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Changes the background image on the authenticating user’s member profile web page.
     * @return
     * @param object $image
     */
    public function account_updateBackgroundImage($image) {
        #/account/update_profile_background_image.xml
        $data = array('image'=>$image);
        
        return $this->_POST('account','account/update_profile_background_image.'.$this->twitterResultFormat, $data);
    }

    
    /**
     * Changes the color scheme applied to the authenticating member’s profile page.
     * @return
     * @param object $profile_background_color[optional] - The background color, visible only if no background image is used for the member profile.
     * @param object $profile_text_color[optional] - The color of the primary text in the profile.
     * @param object $profile_link_color[optional] - The color of the links used on the page.
     * @param object $profile_sidebar_fill_color[optional] - The shading used in the righthand sidebar.
     * @param object $profile_sidebar_border_color[optional] - The border colors used for lines in the sidebar.
     */
    public function account_updateProfileColors($profile_background_color = null, $profile_text_color = null, $profile_link_color = null, $profile_sidebar_fill_color = null, $profile_sidebar_border_color = null) {
    
        #/account/update_profile_colors.xml
        $data = array('profile_background_color'=>$profile_background_color, 'profile_text_color'=>$profile_text_color, 'profile_link_color'=>$profile_link_color, 'profile_sidebar_fill_color'=>$profile_sidebar_fill_color, 'profile_sidebar_border_color'=>$profile_sidebar_border_color);
        
        return $this->_POST('account', 'account/update_profile_colors.'.$this->twitterResultFormat, http_build_query($data));
    }
    
    /**
     * Changes the picture associated with the authenticating member’s account and displayed with that user’s tweets
     * @return
     * @param object $image
     */
    public function account_updateProfileImage($image) {
        #/account/update_profile_image.xml
        $data = array('image'=>$image);
        
        return $this->_POST( 'account', 'account/update_profile_image.'.$this->twitterResultFormat, $data);
    }

    
    /* ****************************************
     * Notification Methods
     * **************************************** */
    /**
     * Tells Twitter to start sending an author’s updates to the preferred device.
     * @return
     * @param object $id
     */
    public function notification_turnOn($id) {
        #/notifications/follow/id.xml
        $data = array('id'=>$id);
        
        return $this->_POST( 'notifications', 'notifications/follow/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }
    /**
     * Tells Twitter to stop sending an author’s updates to the specified device.
     * @return
     * @param object $id
     */
    public function notification_turnOff($id) {
        #/notifications/leave/id.xml
        $data = array('id'=>$id);
        
        return $this->_POST( 'notifications', 'notifications/leave/'.$id.'.'.$this->twitterResultFormat, http_build_query($data));
    }

    
    /* ****************************************
     * Search Methods
     * **************************************** */
    /**
     * Searches for keyword matches in tweet content.
     * @return
     * @param object $query
     * @param object $since[optional]
     * @param object $since_id[optional]
     * @param object $page[optional]
     * @param object $rpp[optional]
     * @param object $geocode[optional]
     * @param object $lang[optional]
     * @param object $show_user[optional]
     * @param object $callback[optional]
     */
    public function search_keywords($query, $since = null, $since_id = null, $max_id = null, $page = null, $callback = null) {
        #search.twitter.com/search.atom?q=query
        $this->twitterUrl = 'search.twitter.com/search.'.$this->twitterResultFormat;
        
        $data = array('q'=>$query, 'page' => $page, 'since_id'=>$since_id, 'max_id' => $max_id, 'since' => $since, 'callback'=>$callback);
        
        return $this->_GET( 'search', '?'.http_build_query($data));
    }
    /**
     * Returns the current top keyword trends in the public timeline.
     * @return
     */
	public function search_trends() {
        #search.twitter.com/trends.json
        $this->twitterUrl = 'search.twitter.com/';
        return $this->_GET( 'trends', 'trends.'.$this->twitterResultFormat);
    }

	public function search_currentTrends() {
        #search.twitter.com/trends.json
        $this->twitterUrl = 'search.twitter.com/';
        return $this->_GET( 'trends', 'trends/current.'.$this->twitterResultFormat);
    }

	public function search_dailyTrends() {
        #search.twitter.com/trends.json
        $this->twitterUrl = 'search.twitter.com/';
        return $this->_GET( 'trends', 'trends/daily.'.$this->twitterResultFormat);
    }

	public function search_weeklyTrends() {
        #search.twitter.com/trends.json
        $this->twitterUrl = 'search.twitter.com/';
        return $this->_GET( 'trends', 'trends/weekly.'.$this->twitterResultFormat);
    }

    
    /* ****************************************
     * Help Methods
     * **************************************** */
    /**
     * Verifies whether your application’s connection to the Twitter API is working.
     * @return
     */
    public function help_test() {
        #help/test.json
        return $this->_GET( 'test', 'help/test.'.$this->twitterResultFormat);
    }

    
    /* ****************************************
     * Call Helper Methods
     * **************************************** */
    /**
     *
     * @return
     * @param object $mode
     * @param object $data[optional]
     */
    private function _GET($mode, $resource, $data = null) {
    
        $url = $this->twitterUrl.$resource;
        ($data != null) ? $url .= '?'.$data : '';
        
        $tp_curlHandle = curl_init($url);
        
        curl_setopt($tp_curlHandle, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($tp_curlHandle, CURLOPT_RETURNTRANSFER, true);
        
        if ($mode != 'publicTimeline' || $mode != 'verify' || $mode != 'userTimeline' || 'friendsTimeline' ) {
            if ($this->get_twitterUser() != '' && $this->get_twitterPass() != '') {
                curl_setopt($tp_curlHandle, CURLOPT_USERPWD, $this->get_twitterUser().':'.$this->get_twitterPass());
            }
        }

        if ($this->get_apiRequestLogging()) {
            $fh = fopen($file = $this->get_apiRequestFilename(), 'a');
            
            curl_setopt($tp_curlHandle, CURLOPT_STDERR, $fh);
            curl_setopt($tp_curlHandle, CURLOPT_WRITEHEADER, $fh);
            
        }
        
        $result = curl_exec($tp_curlHandle);
        $headerResult = curl_getinfo($tp_curlHandle);
        curl_close($tp_curlHandle);
        
        if ($this->get_apiResultLogging()) {
            $this->_LOG($mode, $result);
        }
        
        if ($headerResult['http_code'] === 200) {
            return $result;
        } else {
            return 'false';
        }
        
    }
    
    /**
     * I post a request to the Twitter API
     * @return
     * @param object $mode - The mode in the rest api to post to.
     * @param object $data - The assoc array of name/value data to the server
     */
    private function _POST($mode, $resource, $data) {
        $tp_curlHandle = curl_init($this->twitterUrl.$resource);
        
		//If request logging is on
        if ($this->get_apiRequestLogging()) {
            $fh = fopen($file = $this->get_apiRequestFilename(), 'a');
            curl_setopt($tp_curlHandle, CURLOPT_STDERR, $fh);
            curl_setopt($tp_curlHandle, CURLOPT_WRITEHEADER, $fh);
            $this->_LOG($mode, $data);
        }
        
        curl_setopt($tp_curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($tp_curlHandle, CURLOPT_POST, true);
        curl_setopt($tp_curlHandle, CURLOPT_POSTFIELDS, $data);
       
 		 //FileSize sending when updating image or bg 800kb
        /*To send a file append @FILENAME to the post fields
         if ( $mode == 'account/update_profile_image.'.$this->twitterResultFormat || 'account/update_profile_background_image.'.$this->twitterResultFormat)
         {
         $file_to_upload = array( 'image'=>'@'.$data['image'] );
         $fp = fopen($data['image'],'r'); // Open the file
         curl_setopt($tp_curlHandle, CURLOPT_POSTFIELDS, $file_to_upload);
         curl_setopt($tp_curlHandle, CURLOPT_UPLOAD,true);
         curl_setopt($tp_curlHandle, CURLOPT_INFILE, $fp);
         curl_setopt($tp_curlHandle, CURLOPT_INFILESIZE, filesize($data['image']));
         }
         */
        
        if ($this->get_twitterUser() != '' && $this->get_twitterPass() != '') {
            curl_setopt($tp_curlHandle, CURLOPT_USERPWD, $this->get_twitterUser().':'.$this->get_twitterPass());
        } else {
            throw new Exception('You must provide a username and/or password.');
            exit();
        }
        
        $result = curl_exec($tp_curlHandle);
        $headerResult = curl_getinfo($tp_curlHandle);
        
        curl_close($tp_curlHandle);

        //Check if logging is on
        if ($this->get_apiResultLogging()) {
            $this->_LOG($mode, $result);
        }
        
		//If the result is successfull, return it
        if ($headerResult['http_code'] === 200) {
            return $result;
        } else {
            return 'false';
        }
    }

    
    /* ****************************************
     * Utility Methods
     * **************************************** */
    /**
     *
     * @return
     * @param object $type
     * @param object $var
     */
    private function _LOG($type, $var) {
    
        //write to log file
        $file = $this->get_apiResultFilename();
        
        //append to end of content in log fil
        $fp = fopen($file, "a+");
        
        //Date [Sat Jul 11 02:04:15 2009] [error] [client 127.0.0.1]
        $date = date('[D M j Y H:i:s] ', mktime());
        
        $contents = "\n".$date.'['.$type.'] '.$var;
        
        fwrite($fp, $contents);
        
        fclose($fp);
    }
    
    
    public function trimUrl($longurl) 
    {
		$data = array('longurl' => $longurl );
		
		$url = 'http://is.gd/api.php?';
		$tp_curlHandle = curl_init($url.http_build_query($data)); 
		curl_setopt($tp_curlHandle, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($tp_curlHandle);
		
		curl_close($tp_curlHandle);
		return $result;
    }
    //TODO: Implement twitt pic api methods
    
    
}//Ends Twitter Service


header('Content-type: text/plain');

/* ****************************************
 * REST Type Service Proxy
 * **************************************** */

$tp_requestData = null;

//My Dogs account - Dont change anything, but you can update and follow as many people as you want.
//$tp_user = 'rubybabylove';
//$tp_pass = 'laurellie';

$tp_user = '';
$tp_pass = '';
$tp_mode = '';

$service = new TwitterService();
$service->set_twitterUser($tp_user);
$service->set_twitterPass($tp_pass);
$service->set_twitterResultFormat('json');
$service->set_apiRequestLogging(true);
$service->set_apiResultLogging(true);


//ALL WORKING CALLS
//echo $service->account_verifyCredentials();

//STATUS
//echo $service->status_getFriendsFollowers($tp_user);
//echo $service->status_getFollowing($tp_user);
//echo $service->status_getReplies();
//echo $service->status_getFollowers();
//http://twitter.com/statuses/user_timeline/.json
//echo $service->status_getUserTimeline('9115522');
//echo $service->status_getPublicTimeline();
//echo $service->status_getFriendsTimeline();

//$statustext = 'Momma take me potty, Poppa is outside.';
//echo $service->status_postTweet($statustext);

//$statusId = '3120240498';
//echo $service->status_showTweet($statusId);
//$statusId = '3120240498';
//echo $service->status_deleteTweet($statusId);

//SEARCH
//echo $service->search_trends();
//$query = 'Flex';
//echo $service->search_keywords($query);

//MESSAGES
//echo $service->message_getSentMessages();
//echo $service->message_getMessages();

//ACCOUNT
//echo $service->account_rateLimit();
//$location = 'New York';
//echo $service->account_updateLocation($location);
//$device = 'sms';
//echo $service->account_updateDevice($device);

//$profile_background_color = 'ffff00';
//$profile_text_color = '212121';
//$profile_link_color = 'ff0000';
//$profile_sidebar_fill_color = '555555';
//$profile_sidebar_border_color = 'b9b9b9';
//echo $service->account_updateProfileColors($profile_background_color,$profile_text_color,$profile_link_color,$profile_link_color,$profile_sidebar_border_color);

//$name = 'Ruby Poopy';
//$email = 'rubyspratley@gmail.com';
//$url = 'http://ruby.com';
//$location = 'Fair Oaks, Ca';
//$description = 'I am the cutest and best little puppy in the whole wide world.';
//echo $service->account_updateProfile($name, $email, $url, $location, $description);

//FRIENDSHIP
//$followid = '34638894';
//echo $service->friendship_followMember($followid);
//echo $service->friendship_confirmFollow('rubybabylove', '34638894');
//echo $service->friendship_unfollowMember($followid);

//BLOCK
//$memId = '34638894';
//echo $service->block_blockMember($memId);
//echo $service->block_unBlockMember($memId);

//MESSAGE
//$msgid = '278902230';
//echo $service->message_deleteMessage($msgid);
//$msguser = 'jonniespratley';
//$msgtext = 'I love you poppa';
//echo $service->message_createMessage($msguser, $msgtext);

//FAVORITE
//$favid = '3120872696';
//echo $service->favorite_createFavorite($favid);
//echo $service->favorite_deleteFavorite($favid);
//echo $service->favorite_getFavorites();

//SOCIAL
//echo $service->social_getAllFollowers();
//Result: [49924398,7774922,50263171,49895883,49155319,48947861,9115522,9102382]

//echo $service->social_getAllFriends();
//Result: [50263171,49155319,49895883,48947861,9115522,9303572,7774922,9102382]
//echo $service->account_endSession();







/* NOT WORKING CALLS 
 $image = '/Volumes/WWW/JonnieSpratleysProjects/TwitterPod/ruby.jpg';
 echo $service->account_updateBackgroundImage($image);
 $image = 'IMAGE_PATH';
 echo $service->account_updateProfileImage($image);
 */


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $tp_requestData = $_GET;
        if (isset($_GET['u'])) {
            $tp_user = $_GET['u'];
            $service->set_twitterUser($tp_user);
            unset($tp_requestData['u']);
        }
        if (isset($_GET['p'])) {
            $tp_pass = $_GET['p'];
            $service->set_twitterPass($tp_pass);
            unset($tp_requestData['p']);
        }
        if (isset($_GET['m'])) {
            $tp_mode = $_GET['m'];
            unset($tp_requestData['m']);
        }
        
        switch ($tp_mode) {
            case 'help_test':
                echo $service->help_test();
                break;
			case 'trimUrl':
				echo json_encode(array('newurl' => $service->trimUrl($tp_requestData['longurl'])));
				break;     
            case 'getFollowers':
                echo $service->status_getFollowers($tp_requestData['page']);
                break;
            case 'getFriendsFollowers':
                echo $service->status_getFriendsFollowers($tp_user);
                break;
            case 'getFriendsTimeline':
                echo $service->status_getFriendsTimeline($tp_requestData['count'], $tp_requestData['page']);
                break;
            case 'getPublicTimeline':
                echo $service->status_getPublicTimeline();
                break;
            case 'getUserTimeline':
                echo $service->status_getUserTimeline($tp_requestData['user'], $tp_requestData['count'], $tp_requestData['page']);
                break;
            case 'getReplies':
                echo $service->status_getReplies($tp_requestData['count'], $tp_requestData['page']);
                break;
            case 'showTweet':
                echo $service->status_showTweet($tp_requestData['id']);
                break;
            case 'showProfile':
                echo $service->user_showProfile($tp_user);
                break;
            case 'getMessages':
                echo $service->message_getMessages($tp_requestData['count'], $tp_requestData['page']);
                break;
            case 'getSentMessages':
                echo $service->message_getSentMessages($tp_requestData['count'], $tp_requestData['page']);
                break;
            case 'getFollowing':
                echo $service->status_getFollowing($tp_user,$tp_requestData['count'], $tp_requestData['page']);
                break;
            case 'getFavorites':
                echo $service->favorite_getFavorites($tp_user, $tp_requestData['page']);
                break;
            case 'getAllFriends':
                echo $service->social_getAllFriends();
                break;
            case 'getAllFollowers':
                echo $service->social_getAllFollowers();
                break;
            case 'getRateLimit':
                echo $service->account_rateLimit();
                break;
            case 'verifyCredentials':
                echo $service->account_verifyCredentials();
                break;
            case 'searchKeywords':
				//$query, $since = null, $since_id = null, $max_id = null, $page = null, $callback = null
                echo $service->search_keywords(isset($tp_requestData['q']),isset($tp_requestData['since']),isset($tp_requestData['sinceid']),isset($tp_requestData['maxid']),isset($tp_requestData['page']) );
                break;
            case 'searchTrends':
                echo $service->search_trends();
                break;
                
            /*
             default:
             throw new Exception('Error, You must specify a mode when calling via GET. Please use ?m=YOUR MODE.');
             exit ();
             break;
             */
        }

        
        break;//ends if GET
    case 'POST':
        $tp_requestData = $_POST;
        if (isset($_POST['u'])) {
            $tp_user = $_POST['u'];
            $service->set_twitterUser($tp_user);
            unset($tp_requestData['u']);
        }
        if (isset($_POST['p'])) {
            $tp_pass = $_POST['p'];
            $service->set_twitterPass($tp_pass);
            unset($tp_requestData['p']);
        }
        if (isset($_POST['m'])) {
            $tp_mode = $_POST['m'];
            unset($tp_requestData['m']);
        }
        switch ($tp_mode) {
            case 'createFavorite':
                echo $service->favorite_createFavorite($tp_requestData['id']);
                break;
            case 'deleteFavorite':
                echo $service->favorite_deleteFavorite($tp_requestData['id']);
                break;
            case 'blockMember':
                echo $service->block_blockMember($tp_requestData['id']);
                break;
            case 'unblockMember':
                echo $service->block_unBlockMember($tp_requestData['id']);
                break;
            case 'followMember':
                echo $service->friendship_followMember($tp_requestData['id']);
                break;
            case 'confirmFollow':
                echo $service->friendship_confirmFollow($tp_requestData['a'], $tp_requestData['b']);
                break;
            case 'unfollowMember':
                echo $service->friendship_unfollowMember($tp_requestData['id']);
                break;
            case 'createMessage':
                echo $service->message_createMessage($tp_requestData['user'], $tp_requestData['text']);
                break;
            case 'postTweet':
                echo $service->status_postTweet($tp_requestData['status']);
                break;
            case 'deleteTweet':
                echo $service->status_deleteTweet($tp_requestData['id']);
                break;
            case 'endSession':
                echo $service->account_endSession();
                break;
            case 'updateDevice':
                echo $service->account_updateDevice($tp_requestData['device']);
                break;
            case 'updateLocation':
                echo $service->account_updateLocation($tp_requestData['location']);
                break;
            case 'updateProfile':
                echo $service->account_updateProfile($tp_requestData['n'], $tp_requestData['e'], $tp_requestData['url'], $tp_requestData['l'], $tp_requestData['d']);
                break;
            case 'updateBackgroundImage':
                echo $service->account_updateBackgroundImage($tp_requestData['image']);
                break;
            case 'updateProfileColors':
                echo $service->account_updateProfileColors($tp_requestData['bg'], $tp_requestData['t'], $tp_requestData['sbg'], $tp_requestData['sb']);
                break;
            case 'updateProfileImage':
                echo $service->account_updateProfileImage($tp_requestData['image']);
                break;
            case 'notification_turnOn':
                echo $service->notification_turnOn($tp_requestData['id']);
                break;
            case 'notification_turnOff':
                echo $service->notification_turnOff($tp_requestData['id']);
                break;

                
            /*
             default:
             throw new Exception('Error, You must specify a mode when calling via POST. Please use ?m=YOUR MODE.');
             exit ();
             break;
             */
        }
        break;//ends if POST
}


?>
