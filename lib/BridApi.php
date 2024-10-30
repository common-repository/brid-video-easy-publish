<?php

/**
 * Brid Api Class
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 */
class BridAPI
{
    public $oauth_token;
    public $oauth_provider;
    public $api_endpoint;
    public $options;
    public $client;
    public $code;
    public $body;

    /**
     * HTTP Methods
     */
    const HTTP_METHOD_GET    = 'GET';
    const HTTP_METHOD_POST   = 'POST';
    const HTTP_METHOD_PUT    = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';
    const HTTP_METHOD_HEAD   = 'HEAD';

    // DON'T CHANGE THIS
    const AUTHORIZATION_PATH = '/api/authorize';
    const TOKEN_PATH         = '/api/token';

    static $default_options = array('api_version' => 1, 'content_type' => 'json');

    public function __construct()
    {
        $this->client = new \League\OAuth2\Client\Provider\GenericProvider([
            'redirectUri'             => admin_url('admin.php?page=brid-video-config-setting'),
            'urlAuthorize'            => Brid::getConst('OAUTH_PROVIDER') . '/api/authorize',
            'urlAccessToken'          => Brid::getConst('OAUTH_PROVIDER') . '/api/token',
            'urlResourceOwnerDetails' => Brid::getConst('OAUTH_PROVIDER') . '/api/resource',
        ]);

        $this->oauth_token    = BridOptions::getOption('oauth_token');
        $this->oauth_provider = Brid::getConst('OAUTH_PROVIDER');
        $this->api_endpoint   = Brid::getConst('API_URL') . '/apiv3';
    }

    /*
    * Set access token
    * @param (string) $token
    */
    public function setAccessToken($token)
    {
        $this->oauth_token = $token;
    }

    public function getAccessToken()
    {
        return $this->oauth_token;
    }

    /**
     * Get authorization URL
     * @param (string) $redirect_uri Redirect Uri
     * @return (string) Authentication Url
     */
    public function authorizationUrl($redirect_uri)
    {
        $parameters = array_merge(array(), array(
            'response_type' => 'code',
            'redirect_uri'  => $redirect_uri
        ));
        return $this->oauth_provider . self::AUTHORIZATION_PATH . '?' . http_build_query($parameters, '', '&');
    }

    /**
     * Get access token
     * @param string $code
     * 
     * @return
     * $accessToken->getToken() 
     * $accessToken->getRefreshToken()
     * $accessToken->getExpires()
     * ($accessToken->hasExpired() ? 'expired' : 'not expired')
     * 
     */
    public function accessToken($code)
    {
        // Try to get an access token using the authorization code grant.
        $accessToken = $this->client->getAccessToken('authorization_code', [
            'code' => $code
        ]);

        return $accessToken;
    }

    /**
     * Fetch a protected ressource
     *
     * @param string $protected_ressource_url Protected resource URL
     * @param array  $parameters Array of parameters
     * @param string $http_method HTTP Method to use (POST, PUT, GET, HEAD, DELETE)
     * @param array  $http_headers HTTP headers
     * @return array
     */
    public function fetch($protected_resource_url, array $parameters = array(), $http_method = self::HTTP_METHOD_GET, array $http_headers = array())
    {
        $http_headers['Authorization'] = 'Bearer ' . $this->oauth_token;
        return $this->executeRequest($protected_resource_url, $parameters, $http_method, $http_headers);
    }

    /**
     * Execute a request
     *
     * @param string $url URL
     * @param mixed $parameters Array of parameters
     * @param string $http_method HTTP Method
     * @param array $http_headers HTTP Headers
     * @return array
     */
    private function executeRequest($url, array $parameters = array(), $http_method = self::HTTP_METHOD_GET, array $http_headers = null)
    {
        $args = array(
            'method' => $http_method,
            'body' => $parameters,
            'headers' => $http_headers
        );

        $response = wp_remote_request($url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $body = false;
        $error = false;

        if (!is_wp_error($response)) {
            $entity = wp_remote_retrieve_body($response);
            if ($entity) {
                $body = $entity;
            }
        } else {
            $body = $response;
            $error = $response->get_error_message();
        }

        return $this->prepareResponse($code, $body, $error);
    }

    private function prepareResponse($code, $body, $error)
    {
        return array(
            'code' => $code,
            'body' => $body,
            'error' => $error,
        );
    }

    /**
     * Make APi GET/POST call
     * @param (array) $arguments - array('url'=>'method_name', 'params'=>'POST ARRAY if we want to make post request - optional')
     * @param string $output (json, obj, array)
     *
     */
    public function call($arguments, $output = 'array')
    {
        $output_type = gettype($output);

        if ($output_type == 'boolean') {

            $output = $output ? 'obj' : 'json';
        }

        //Try session caching
        $url = $this->api_endpoint . '/' . $arguments['url'] . '.json';

        if (!empty($arguments['query'])) {
            foreach ($arguments['query'] as $k => $queryPart) {
                $arguments['query'][$k] = str_replace(":", "=", $queryPart);
            }
            $queryStr = implode('&', $arguments['query']);
            $url .= "?{$queryStr}";
        }

        if (isset($arguments['params'])) {
            //POST
            $response = $this->fetch($url, $arguments['params'], self::HTTP_METHOD_POST, $this->http_headers());
        } else {
            //GET
            $response = $this->fetch($url, array(), self::HTTP_METHOD_GET, $this->http_headers());
        }

        if (isset($response['body'])) {

            $this->body = $response['body'];
        }

        $this->code = $response['code'];

        //Will issue on nignix or apache not set to parse these responses
        if (!headers_sent()) {
            header('Brid-Api-Url: ' . $url);
        }
        if ($output == 'json' && !headers_sent()) {
            header('Content-type: application/json');
        }

        //Return body on success
        if ($this->code == 500 || $this->code == 404) {

            $response['body'] = empty($response['body']) || !$response['body'] ? '{"msg":"Unknown error or empty error response. No response from api."}' : $response['body'];
        }

        return $this->parseOutput($response['body'], $output);
    }

    /**
     * Make APi GET call
     * @param (array) $arguments - array('url'=>'method_name', 'query'=>'ARRAY if we want to pass query params')
     * @param string $output (json, obj, array)
     *
     */
    public function callGet($arguments, $output = 'array')
    {
        $output_type = gettype($output);

        if ($output_type == 'boolean') {
            $output = $output ? 'obj' : 'json';
        }

        // Try session caching
        $url = $this->api_endpoint . '/' . $arguments['url'] . '.json';

        if (!empty($arguments['query'])) {
            foreach ($arguments['query'] as $k => $queryPart) {
                $arguments['query'][$k] = str_replace(":", "=", $queryPart);
            }
            $queryStr = implode('&', $arguments['query']);
            $url .= "?{$queryStr}";
        }

        //GET
        $response = $this->fetch($url, array(), self::HTTP_METHOD_GET, $this->http_headers());

        if (isset($response['body'])) {

            $this->body = $response['body'];
        }

        $this->code = $response['code'];

        //Will issue on nignix or apache not set to parse these responses
        if (!headers_sent()) {
            header('Brid-Api-Url: ' . $url);
        }
        if ($output == 'json' && !headers_sent()) {
            header('Content-type: application/json');
        }

        //Return body on success
        if ($this->code == 500 || $this->code == 404) {

            $response['body'] = empty($response['body']) || !$response['body'] ? '{"msg":"Unknown error or empty error response. No response from api."}' : $response['body'];
        }

        return $this->parseOutput($response['body'], $output);
    }

    /**
     * Parse response body depending of the output
     * @param $response_body
     * @param string $output
     */
    private function parseOutput($response_body, $output = 'obj')
    {
        if (!is_string($response_body)) return $response_body;

        switch ($output) {

            case 'json':
                return $response_body;
                break;

            case 'array':
                return json_decode($response_body, true);
                break;

            case 'obj':
            default:
                return json_decode($response_body);
                break;
        }
    }

    /**
     * Set custom WP headers
     */
    public function http_headers()
    {
        global $wp_version;

        $header_site_id = BridOptions::getOption('site');
        $header_user_id = BridOptions::getOption('user_id');

        $header_site = !empty($header_site_id) ? " | Partner ID/" . $header_site_id : "";
        $header_user = !empty($header_user_id) ? " | User ID/" . $header_user_id : "";

        return array(
            'User-Agent' => "WordPress/{$wp_version} | BridVideo/" . BRID_PLUGIN_VERSION . $header_site . $header_user,
            'X-Site' => $_SERVER['HTTP_HOST'],
        );
    }

    /**
     * Dataset players - All player data info
     * @param (int) $id Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function players($id = null, $encode = 'obj')
    {
        $id = intval($id);
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is required.');
        }

        $players = $this->call(array('url' => 'players/' . $id), $encode);

        return $players;
    }

    /**
     * Dataset players - All player data info
     * @param (int) $partner_id Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function adTags($partner_id = null, $type = '')
    {
        $partner_id = intval($partner_id);
        if ($partner_id == null || $partner_id == 0 || !is_numeric($partner_id)) {
            throw new InvalidArgumentException('Partner id is required.');
        }

        $tags = $this->call(array('url' => 'adTagList/' . $partner_id . '/' . $type), true);

        return $tags;
    }

    /**
     * List players id => name
     * @param (int) $id Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function playersList($id = null, $encode = 'obj')
    {
        $id = intval($id);
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is required.');
        }

        $players = $this->call(array('url' => 'playersList/' . $id), $encode);

        return $players;
    }

    /**
     * Get api instance for pretty calls $api->get()->video($id)
     */
    public function get()
    {
        return $this;
    }

    /**
     * Add Video
     * @param (array) $_post - Post array video
     * @param (bool) $encode - obj for StdClass,
     */
    protected function addVideo($_post = array(),  $encode = 'obj')
    {
        if (isset($_post['data']['Video'])) {
            $_post = $_post['data']['Video'];
        }
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (isset($_post['channel_id_youtube'])) {
            $_post['channel_id'] = $_post['channel_id_youtube'];
        }
        if (!isset($_post['channel_id']) || empty($_post['channel_id'])) {
            throw new InvalidArgumentException('Channel id is required.');
        }
        if (!isset($_post['partner_id']) || empty($_post['partner_id'])) {
            throw new InvalidArgumentException('Partner id is required.');
        }
        if (!isset($_post['external_url']) && empty($_post['external_url'])) {
            if (!isset($_post['mp4']) || empty($_post['mp4'])) {
                throw new InvalidArgumentException('Mp4 Url is required.');
            }
        }
        if (!isset($_post['name']) || empty($_post['name'])) {
            throw new InvalidArgumentException('Video title is required.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            $post['data[Video][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => 'video/add', 'params' => $post), $encode);
    }

    /**
     * Edit Video
     * @param (array) $_post - Post fetch array with url
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function fetchVideoViaUrl($_post = array(), $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['partner_id']) || empty($_post['partner_id'])) {
            throw new InvalidArgumentException('Partner id is required.');
        }
        if (!isset($_post['videoUrl']) || empty($_post['videoUrl'])) {
            throw new InvalidArgumentException('videoUrl is required.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            $post['data[Video][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'fetchVideoViaUrl', 'params' => $post), $encode);
    }

    /**
     * Edit Video
     * @param (array) $_post - Post array video
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function editVideo($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['id']) || $_post['id'] == 0 || !is_numeric($_post['id'])) {
            throw new InvalidArgumentException('Video id is required.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            if ($k === 'sites') {
                $post['data[Video][' . $k . ']'] = implode(',', $v);
            } else {
                $post['data[Video][' . $k . ']'] = $v;
            }

            if ($k == 'Ad') {
                foreach ($v as $my => $ad) {
                    $post['data[Ad][' . $my . ']'] = $ad;
                }
            }
        }

        return $this->call(array('url' => "video/edit/{$_post['id']}", 'params' => $post), $encode);
    }

    protected function uninstall($oauthCode, $encode = 'obj')
    {
        return $this->call(array('url' => 'uninstall/' . $oauthCode), $encode);
    }

    /**
     * Add Playlist
     * @param (array) $_post - Post array playlist with videos
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function addPlaylist($_post = array(), $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['name'])) { //Name
            throw new InvalidArgumentException('Playlist name is required.');
        }
        if (!isset($_post['partner_id'])) { //Name
            throw new InvalidArgumentException('Playlist partner_id is required.');
        }
        if (!isset($_post['ids'])) { //Video ids
            throw new InvalidArgumentException('Videos Ids (ids) is required post param.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            if ($k != 'ids') {
                $post['data[Playlist][' . $k . ']'] = $v;
            } else {
                $post['data[Video][' . $k . ']'] = $v;
            }
        }

        return $this->call(array('url' => 'playlist/add', 'params' => $post), $encode);
    }

    protected function addVideoPlaylist($_post = array(), $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['id'])) { //CSV
            throw new InvalidArgumentException('Playlist id (id) is required post param.');
        }
        if (!isset($_post['ids'])) { //CSV
            throw new InvalidArgumentException('Videos Ids (ids) is required post param.');
        }

        $post = array();
        foreach ($_post as $k => $v) {
            if ($k != 'ids') {
                $post['data[Playlist][' . $k . ']'] = $v;
            } else {
                $post['data[Video][' . $k . ']'] = $v;
            }
        }

        return $this->call(array('url' => "playlist/add_videos/{$_post['id']}", 'params' => $_post), $encode);
    }

    /**
     * Edit Playlist
     * @param (int) $id - Playlist id
     * @param (array) $_post - Post array playlist data
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function editPlaylist($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['id'])) { //Name
            throw new InvalidArgumentException('Playlist id is required.');
        }
        if (!isset($_post['partner_id'])) { //Name
            throw new InvalidArgumentException('Playlist partner_id is required.');
        }

        $post = array();
        foreach ($_post as $k => $v) {
            if ($k != 'ids') {
                $post['data[Playlist][' . $k . ']'] = $v;
            } else {
                $post['data[Video][' . $k . ']'] = $v;
            }
        }
        return $this->call(array('url' => "playlist/edit/{$_post['id']}", 'params' => $post), $encode);
    }

    /**
     * Get video
     * @param (int) $id - Video id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function video($id = null,  $encode = 'obj')
    {
        $id = (int)$id;
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is invalid.');
        }

        $video = $this->call(array('url' => 'video/view/' . $id), $encode);

        //Fix dat format
        if (isset($video->Video))
            $video->Video->publish = implode('-', array_reverse(explode('-', $video->Video->publish)));

        $disable_shortcode = BridOptions::getOption('disable_shortcode');

        // If "2", than we need to add new "trace_all" encoding status field
        if ($disable_shortcode == 2) {
            $ids['ids'] = $video->Video->id;
            // Get "trace_all" statuses for video id
            $trace_all = $this->checkAllStatuses($ids);

            // Add "trace_all" to video response
            if (isset($trace_all->{$video->Video->id})) {
                $video->Video->trace_all = $trace_all->{$video->Video->id};
            } else {
                // if not found, than set to "0" - it means that all encodings are done
                $video->Video->trace_all = 0;
            }
        }

        return $video;
    }

    /**
     * Replace video after re-upload
     * @param (int) $id - Video id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function replaceVideo($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['id'])) { //Name
            throw new InvalidArgumentException('Video id is required.');
        }
        if (!isset($_post['upload_source_url'])) { //Name
            throw new InvalidArgumentException('Playlist upload_source_url is required.');
        }
        $post = [
            'Video' => [
                'id' => $_post['id'],
                'original_filename' => $_post['original_filename'],
                'original_file_size' => $_post['original_file_size'],
                'upload_source_url' => $_post['upload_source_url'],
                'xml_url' => $_post['xml_url'],
            ]
        ];

        $video = $this->call(array('url' => 'video/reUploadVideo', 'params' => $post), $encode);

        return $video;
    }

    protected function getPlaylistR($playlist, $id, $encode)
    {
        if (!empty($playlist->paging->Video->nextPage)) {
            $playlist_next = $this->callGet(array('url' => 'playlist/view/' . $id, 'query' => ['limit=100', 'page=' . ($playlist->paging->Video->page + 1)]), $encode);
            $playlist_next->data->Video = array_merge($playlist->data->Video, $playlist_next->data->Video);
            return $this->getPlaylistR($playlist_next, $id, $encode);
        }
        return $playlist;
    }

    /**
     * Get playlist
     * @param (int) $id - Playlist id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function playlist($id = null,  $encode = 'obj')
    {
        $id = (int)$id;
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Playlist id is invalid.');
        }
        $playlist_s = $this->callGet(array('url' => 'playlist/view/' . $id, 'query' => ['limit=100']), $encode);
        $playlist = $this->getPlaylistR($playlist_s, $id, $encode);

        //Fix date format
        if (isset($playlist->Playlist))
            $playlist->Playlist->publish = implode('-', array_reverse(explode('-', $playlist->Playlist->publish)));

        return $playlist;
    }

    /**
     * Delete videos
     * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'ids'=>'1,2,3')
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     **/
    protected function deleteVideos($_p = array(),  $encode = 'obj')
    {
        if (!empty($_p)) {
            if (isset($_p['partner_id'])) $_p['partner_id'] = (int)$_p['partner_id'];
        }
        if (!isset($_p['partner_id']) || $_p['partner_id'] == 0) {
            throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
        }
        if (isset($_p) && !isset($_p['ids'])) { //CSV
            throw new InvalidArgumentException('Ids (ids) is required post param.');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Video][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => 'video/delete', 'params' => $post), $encode);
    }

    /**
     * Delete Ad
     * @param (array) $_post - Post array $_POST = array('id'=>AD_ID)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     **/
    protected function deleteAd($_p = array(),  $encode = 'obj')
    {
        if (!isset($_p['id']) || $_p['id'] == 0) {
            throw new InvalidArgumentException('Ad id (id) is required post param.');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Ad][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => 'deleteAd', 'params' => $post), $encode);
    }

    /**
     * Delete video from playlist
     * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'id'=>1, 'video_id'=>2)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function removeVideoPlaylist($_post, $encode = 'obj')
    {
        if (!empty($_post)) {
            if (isset($_post['partner_id'])) $_post['partner_id'] = (int)$_post['partner_id'];
            if (isset($_post['video_id'])) $_post['ids'] = (int)$_post['video_id'];
            if (isset($_post['id'])) $_post['id'] = (int)$_post['id'];
        }
        if (!isset($_post['partner_id']) || $_post['partner_id'] == 0) {
            throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
        }
        if (!isset($_post['id']) || $_post['partner_id'] == 0) { //CSV
            throw new InvalidArgumentException('Id (id) is required post param.');
        }
        if (!isset($_post['ids']) || $_post['ids'] == 0) { //CSV
            throw new InvalidArgumentException('Video id (video_id) is required post param.');
        }

        $post = array();

        foreach ($_post as $k => $v) {
            $post['data[Playlist][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => "playlist/delete_videos/{$_post['id']}", 'params' => $post), $encode);
    }

    /**
     * Sort Playlist
     * @param (array) $_post - Post array playlist data $_post['id'] = Playlist id, $_post['ids'] = csv
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function sortVideos($_post = array(), $encode = 'obj')
    {
        if (!empty($_post)) {
            if (isset($_post['id'])) $_post['id'] = (int)$_post['id'];
            if (isset($_post['partner_id'])) $_post['partner_id'] = (int)$_post['partner_id'];
        }
        if (!isset($_post['partner_id']) || $_post['partner_id'] == 0) {
            throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
        }
        if (!isset($_post['id']) || $_post['partner_id'] == 0) { //CSV
            throw new InvalidArgumentException('Playlist id (id) is required post param.');
        }
        if (!isset($_post['sort']) || $_post['sort'] == 0) { //CSV
            throw new InvalidArgumentException('Video ids (sort) is required post param (csv).');
        }

        $post = array();
        foreach ($_post as $k => $v) {
            $post['data[Playlist][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => "playlist/sort/{$_post['id']}", 'params' => $post), $encode);
    }

    /**
     * Clear playlist
     * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'id'=>1)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function clearPlaylist($_post = array(), $encode = 'obj')
    {
        if (!empty($_post)) {
            if (isset($_post['id'])) $_post['id'] = intval($_post['id']);
            if (isset($_post['partner_id'])) $_post['partner_id'] = intval($_post['partner_id']);
        }
        if (!isset($_post['partner_id']) || $_post['partner_id'] == 0) {
            throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
        }
        if (!isset($_post['id']) || $_post['partner_id'] == 0) { //CSV
            throw new InvalidArgumentException('Playlist id (id) is required post param.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            $post['data[Playlist][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => "playlist/clear/{$_post['id']}", 'params' => $post), $encode);
    }

    /**
     * Delete playlists
     * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'ids'=>'1,2,3')
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function deletePlaylists($_p = array(),  $encode = 'obj')
    {
        if (!empty($_p)) {
            if (isset($_p['partner_id'])) $_p['partner_id'] = intval($_p['partner_id']);
        }
        if (!isset($_p['partner_id']) || $_p['partner_id'] == 0) {
            throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
        }
        if (isset($_p) && !isset($_p['ids'])) {
            throw new InvalidArgumentException('Ids (ids) is required post param.');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Playlist][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'playlist/delete', 'params' => $post), $encode);
    }

    /**
     * Get ffmpeg info
     * @param (array) $_post - Post array $_POST = array('url'=>'http://www.my.video.com/1.mp4')
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function ffmpegInfo($_post = array(),  $encode = 'obj')
    {
        if (isset($_post) && !isset($_post['url'])) {
            throw new InvalidArgumentException('Url parameter is empty or invalid.');
        }

        return $this->call(array('url' => 'video/ffmpegInfo/', 'params' => $_post), $encode);
    }

    /**
     * Get partner info
     * @param (int) $id - Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function partner($id = null,  $encode = 'obj')
    {
        $id = (int)$id;
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is invalid.');
        }

        return $this->call(array('url' => 'partner/view/' . $id), $encode);
    }

    /**
     * Add partner
     * @param (int) $id - Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function addPartner($_post = array(), $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['domain'])) { //Name
            throw new InvalidArgumentException('Playlist name is required.');
        }
        if (!isset($_post['user_id'])) { //Name
            throw new InvalidArgumentException('Playlist partner_id is required.');
        }

        $post = array();
        foreach ($_post as $k => $v) {

            $post['data[Partner][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => 'addPartner', 'params' => $post), $encode);
    }

    /**
     * Call used to intercept exceptions
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            try {
                $r = call_user_func_array(array($this, $method), $arguments);

                if (isset($r->code) && $r->code == 1) {

                    throw new Exception('Api error code: ' . $r->code . '<br/>Api error msg: ' . $r->error . '<br/>Api error name: ' . $r->name . '<br/>Api error url: ' . $r->url);
                }
                return $r;
            } catch (InvalidArgumentException $i) {

                $this->displayException($i);
            } catch (Exception $e) {
                $this->displayException($i);
            }
        } else {
            $class = new ReflectionClass('BridApi');

            $methods = $class->getMethods();

            die('Method (' . $method . ') does not exist. Please visit: <a href="https://brid.zendesk.com/hc/en-us/categories/200078691-Developer-API">Brid developer api Documentation page</a> for further information.');
        }
    }

    /**
     * Get videos - LIST
     * @param (int) $id - Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function videos($id = null, $encode = 'obj')
    {
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is invalid (videos).');
        }
        $id = (int)$id;
        //Append for pagiantion/ordering
        $append = '';
        $search = '';
        $options = array('url' => 'video/all/' . $id);

        if (isset($_POST['apiQueryParams'])) {
            $options['url'] .= '/' . $_POST['apiQueryParams'];
        }

        if (isset($_SESSION['Brid.Video.Search']) && $_SESSION['Brid.Video.Search'] != '') {

            $_POST['Video']['search'] = $search = $_SESSION['Brid.Video.Search'];
            $options['query'][] = "search:" . $_SESSION['Brid.Video.Search'];
            $options['params'] = $_POST;
        }

        if (isset($_POST['subaction'])) {
            if (in_array($_POST['subaction'], array('addPlaylist', 'addPlaylistyt'))) {
                $options['params']['videos_type'] = $_POST['subaction'] == 'addPlaylist' ? 0 : 1;
            }
        }

        if (isset($_POST['playlistType'])) {
            $options['params']['videos_type'] = $_POST['playlistType'];
        }
        if (isset($_POST['limit'])) {
            $options['params']['limit'] = $_POST['limit'];
        }
        $videoSet = $this->call($options, $encode);

        //Change date to d/m/Y format
        if (!empty($videoSet->data)) {
            foreach ($videoSet->data as $k => $v) {
                $v->Video->publish = implode('-', array_reverse(explode('-', $v->Video->publish)));
            }
        }

        return $videoSet;
    }

    /**
     * Get videos - LIST for post section
     * @param (int) $id - Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function getVideosPost($id = null, $encode = 'obj')
    {
        $url = "video/all/{$id}";
        $query = [];
        if (isset($_POST['apiQueryParams'])) {
            $query[] = $_POST['apiQueryParams'];
        }
        if (isset($_POST['search'])) {
            $query[] = "search:" . $_POST['search'];
        }
        if (isset($_POST['searchTag']) && !empty($_POST['searchTag'])) {
            $query[] = "searchTag:" . urlencode($_POST['searchTag']);
        }
        if (isset($_POST['searchChannel']) && !empty($_POST['searchChannel'])) {
            $query[] = "searchChannel:" . urlencode($_POST['searchChannel']);
        }
        if (isset($_POST['status']) && $_POST['status'] != "") {
            $query[] = "status:" . $_POST['status'];
        }
        if (isset($_POST['partners']) && !empty($_POST['partners'])) {
            $query[] = "partners:" . implode(",", $_POST['partners']);
        }
        if (isset($_POST['carouselOnly']) && !empty($_POST['carouselOnly'])) {
            $query[] = "carouselOnly:" . $_POST['carouselOnly'];
            $query[] = "includeCarouselVideos:1";
        }

        // If upload tab is closed, than we will remove all unpublished videos - if status is not 1, video will be skipped
        if (BridOptions::getOption('hide_upload_video')) {
            $query[] = "excludeNotPublished:true";
        }

        $videosDataset = $this->callGet(array('url' => $url, 'query' => $query), $encode);

        $disable_shortcode = BridOptions::getOption('disable_shortcode');
        // If "2", than we need to add new "trace_all" encoding status field
        if ($disable_shortcode == 2 && (isset($videosDataset->data))) {
            // Get video ids from video response
            $ids = [];
            $data = array_map(function ($item) {
                return $item->Video->id;
            }, $videosDataset->data);

            // Make comma delimited string
            $ids['ids'] = implode(",", $data);

            // Get "trace_all" statuses for all video ids
            $trace_all = $this->checkAllStatuses($ids);

            // Merge "trace_all" status to video response
            array_map(function ($item) use ($trace_all) {
                if (isset($trace_all->{$item->Video->id})) {
                    $item->Video->trace_all = $trace_all->{$item->Video->id};
                } else {
                    // if not found, than set to "0" - it means that all encodings are done
                    $item->Video->trace_all = 0;
                }
            }, $videosDataset->data);
        }

        return $videosDataset;
    }

    /**
     * Get playlists - LIST
     * @param (int) $id - Site id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function playlists($id,  $encode = 'obj')
    {
        $id = (int)$id;
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is invalid (playlists).');
        }
        //Append for pagiantion/ordering
        $append = '';
        $search = '';
        $options = array('url' => 'playlists/' . $id);

        //Save and invalidate search string
        if (isset($_POST['search'])) {
            $_SESSION['Brid.Playlist.Search'] = $_POST['search'];
        }

        if (isset($_SESSION['Brid.Playlist.Search']) && $_SESSION['Brid.Playlist.Search'] != '') {

            $_POST['Playlist']['search'] = $search = $_SESSION['Brid.Playlist.Search'];
            $options['params'] = $_POST;
        }
        if (isset($_POST['limit'])) {
            $options['params']['limit'] = $_POST['limit'];
        }

        $url = "playlist/all/{$id}";
        $query = [];
        if (isset($_POST['apiQueryParams'])) {
            $query[] = $_POST['apiQueryParams'];
        }
        if (isset($_POST['search'])) {
            $query[] = "search:" . $_POST['search'];
        }
        $playlistSet = $this->callGet(array('url' => $url, 'query' => $query), $encode);

        //Change date to d/m/Y format
        if (!empty($playlistSet->data)) {
            foreach ($playlistSet->data as $k => $v) {
                $v->Playlist->publish = implode('-', array_reverse(explode('-', $v->Playlist->publish)));
            }
        }

        return $playlistSet;
    }

    /**
     * Get user
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function userinfo($encode = 'obj')
    {
        return $this->call(array('url' => 'user/info'), $encode);
    }

    /**
     * Get aws credentials
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function aws_credentials($encode = 'obj')
    {
        return $this->call(array('url' => 'user/awsCredentials'), $encode);
    }

    /**
     * Get sites list
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function sitesList($encode = 'obj')
    {
        return $this->call(array('url' => 'sitesList'), $encode);
    }

    /**
     * Get units list
     * @param (int) $partnerId - default site partner id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function unitsList($partnerId = null, $encode = 'obj')
    {
        return $this->call(array('url' => 'unitsList', 'params' => array('partnerId' => $partnerId)), $encode);
    }

    /**
     *  Display exception in json style so frontend can display it
     *
     * @param (Exception) $i - Exception object
     */
    public function displayException($i)
    {
        if (!headers_sent())
            header('X-Error: By Brid Api');
        $error = array('name' => $i->getMessage(), 'message' => $i->getFile(), 'error' => $i->getMessage(), 'class' => get_class($i));
        if ($i->getCode() != 0) {
            $error['code'] = $i->getCode();
        }

        echo json_encode($error);
    }

    /**
     * Check Url
     * @param (array) $_post - Post array $_POST = array('url'=>'http://www.youtube.com/?w=32kdfkskfdsn')
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function checkUrl($_post = array(), $encode = 'obj')
    {
        if (!isset($_post['url']) && strlen($_post['url']) < 10) {
            throw new InvalidArgumentException('No valid param "url" provided (checkUrl)');
        }
        return $this->call(array('url' => 'video/checkUrl', 'params' => $_post), $encode);
    }

    /**
     * Set partner upload flags
     * @param (array) $_post - Post array $_p = array('id'=>1, 'upload'=>1)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function partnerUpload($_p = array(), $encode = 'obj')
    {
        if (!isset($_p['id']) || !isset($_p['upload'])) {
            throw new InvalidArgumentException('No valid id or upload parameters provided (partnerUpload).');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Partner][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'partnerUpload', 'params' => $post), $encode);
    }

    protected function askForMonetization($_p = array(), $encode = 'obj')
    {
        if (!isset($_p['id'])) {
            throw new InvalidArgumentException('No valid partner id (askForMonetization).');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Partner][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'askForMonetization', 'params' => $post), $encode);
    }

    protected function askForEnterprise($_p = array(), $encode = 'obj')
    {
        if (!isset($_p['id'])) {
            throw new InvalidArgumentException('No valid id or upload parameters provided (askForEnterprise).');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Upgrade][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'askForEnterprise', 'params' => $post), $encode);
    }

    /**
     * Update partner field
     * @param (array) $_post - Post array $_POST = array('id'=>1)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function updatePartnerField($_p = array(), $encode = 'obj')
    {
        if (isset($_p['id'])) {
            $_p['id'] = intval($_p['id']);
        }

        if (!isset($_p['id']) || $_p['id'] == 0 || !is_numeric($_p['id'])) {
            throw new InvalidArgumentException('Partner id is invalid (updatePartnerField).');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Partner][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'updatePartnerField', 'params' => $post), $encode);
    }

    /**
     * Update partner field
     * @param (array) $_post - Post array $_POST = array('id'=>1)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function editPlayer($_p = array(), $encode = 'obj')
    {

        if (isset($_p['Player']['id'])) {
            $_p['Player']['id'] = (int)$_p['Player']['id'];
        }

        if (!isset($_p['Player']['id']) || $_p['Player']['id'] == 0 || !is_numeric($_p['Player']['id'])) {
            throw new InvalidArgumentException('Player id is invalid (editPlayer).');
        }

        $post = array();

        function updateValue(&$data, $key)
        {
            if ($key === "custom_params" || $key === "bids" || $key === "media_types") {
                $re = '/\\\\+"/m';
                $data = preg_replace($re, '"', $data);
            }
        }

        if (empty($_p['Adbid'])) $_p['Adbid'] = [];
        foreach ($_p['Adbid'] as $k => $v) {
            try {
                array_walk_recursive($v, 'updateValue');
            } catch (Exception $exception) {
                var_export($exception);
            }

            $post['data[Adbid][' . $k . ']'] = $v;
        }

        foreach ($_p['Player'] as $k => $v) {
            $post['data[Player][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => "player/edit/{$_p['Player']['id']}", 'params' => $post), $encode);
    }

    /**
     * Update default outstream unit fields
     * @param (array) $_post - Post array $_POST
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function editUnit($_p = array(), $encode = 'obj')
    {
        if (isset($_p['Unit']['id'])) {
            $_p['Unit']['id'] = (int)$_p['Unit']['id'];
        }

        if (!isset($_p['Unit']['id']) || $_p['Unit']['id'] == 0 || !is_numeric($_p['Unit']['id'])) {
            throw new InvalidArgumentException('Unit id is invalid (editUnit).');
        }

        $post = array();

        function updateValue(&$data, $key)
        {
            if ($key === "custom_params" || $key === "bids" || $key === "media_types") {
                $re = '/\\\\+"/m';
                $data = preg_replace($re, '"', $data);
            }
        }

        if (isset($_p['Adbid'])) {
            foreach ($_p['Adbid'] as $k => $v) {
                try {
                    array_walk_recursive($v, 'updateValue');
                } catch (Exception $exception) {
                    var_export($exception);
                }

                $post['data[Adbid][' . $k . ']'] = $v;
            }
        }

        foreach ($_p['Unit'] as $k => $v) {
            $post['data[Unit][' . $k . ']'] = $v;
        }

        if (isset($_p['unitAd'])) {
            foreach ($_p['unitAd'] as $k => $v) {
                $post['data[Ad][' . $k . ']'] = $v;
            }
        }

        return $this->call(array('url' => "unit/edit/{$_p['Unit']['id']}", 'params' => $post), $encode);
    }

    /**
     * Update carousel fields
     * @param (array) $_post - Post array $_POST
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function saveCarousel($_p = array(), $encode = 'obj')
    {
        if (isset($_p['id'])) {
            $_p['id'] = (int)$_p['id'];
        }

        $post = array();
        foreach ($_p as $k => $v) {
            if ($k === 'action') continue;
            if ($k === 'Carousel') continue;
            if ($k === 'submit') continue;
            if ($k === 'mrssFeed' && $v === '') continue;
            if ($k === 'slides') {
                foreach ($v['slide_title'] as $sid => $sprop) {
                    $post["data[Carousel][slide_title][{$sid}]"] = $sprop;
                }
                foreach ($v['slide_url'] as $sid => $sprop) {
                    $post["data[Carousel][slide_url][{$sid}]"] = $sprop;
                }
                foreach ($v['custom_slide_img'] as $sid => $sprop) {
                    $post["data[Carousel][custom_slide_img][{$sid}]"] = $sprop;
                }
            } else {
                $post['data[Carousel][' . $k . ']'] = $v;
            }
        }

        if (!empty($post['data[Carousel][mrssFeed]'])) {
            unset($post['data[Carousel][urls]']);
        }

        if (isset($_p['action']) && $_p['action'] === 'add_carousel') {
            unset($post['data[Carousel][id]']);
            return $this->call(array('url' => "carousel/add", 'params' => $post), $encode);
        }

        if (!isset($_p['id']) || $_p['id'] == 0 || !is_numeric($_p['id'])) {
            throw new InvalidArgumentException('Carousel id is invalid (editCarousel).');
        }

        unset($post['data[Carousel][partner_id]']);
        return $this->call(array('url' => "carousel/edit/{$_p['id']}", 'params' => $post), $encode);
    }

    /**
     * Change status
     * @param (array) $_post - Post array $_POST = array('id'=>1, 'partner_id'=>1, 'controller'=>'videos', 'sttus'=>1)
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function changeStatus($_post = array(), $encode = 'obj')
    {
        if (isset($_post['id'])) {
            $_post['id'] = intval($_post['id']);
        }
        if (!isset($_post['id']) || $_post['id'] == 0 || !is_numeric($_post['id'])) {
            throw new InvalidArgumentException('Content id is invalid (changeStatus).');
        }
        if (!isset($_post['partner_id']) || $_post['partner_id'] == 0 || !is_numeric($_post['partner_id'])) {
            throw new InvalidArgumentException('Partner id is invalid (changeStatus).');
        }
        if (!isset($_post['status']) && !is_numeric($_post['status'])) {
            throw new InvalidArgumentException('"status" param is required (changeStatus).');
        }
        if (!isset($_post['controller']) || $_post['controller'] == '') {
            throw new InvalidArgumentException('Controller param must be valid value ("videos" or "playlists") (changeStatus).');
        }

        $_post['data[Video][ids]'] = $_post['id'];

        if ($_post['controller'] == "videos") {
            return $this->call(array('url' => 'video/changeStatus', 'params' => $_post), $encode);
        }

        if ($_post['controller'] == "playlists") {
            return $this->call(array('url' => 'playlist/change_status/' . $_post['id'], 'params' => $_post), $encode);
        }
    }

    /**
     * Add ad tags
     * @param (array) $_post - Post array ad tag
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function addAdTag($_post = array(), $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            if ($k === 'id' && empty($v)) continue;
            $post['data[Adtag][' . $k . ']'] = $v;
        }
        return $this->call(array('url' => 'adtag/add', 'params' => $post), $encode);
    }

    /**
     * Edit ad tag
     * @param (array) $_post - Post array ad tag
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function editAdTag($id, $_post = array(), $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        $post = array();
        foreach ($_post as $k => $v) {
            $post['data[Adtag][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => 'adtag/edit/' . $id, 'params' => $post), $encode);
    }

    /**
     * Get ad tag
     * @param (int) $id - Ad tag id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function adTag($id = null,  $encode = 'obj')
    {
        $id = (int)$id;
        if ($id == null || $id == 0 || !is_numeric($id)) {
            throw new InvalidArgumentException('Partner id is invalid.');
        }

        $adTag = $this->call(array('url' => 'adtag/view/' . $id), $encode);

        return $adTag;
    }

    /**
     * Delete ad tags
     * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'ids'=>'1,2,3')
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     **/
    protected function deleteAdTags($_p = array(),  $encode = 'obj')
    {
        if (isset($_p) && !isset($_p['id'])) {
            throw new InvalidArgumentException('Ids (ids) is required post param.');
        }
        $post = array();
        foreach ($_p as $k => $v) {
            $post['data[Adtag][' . $k . ']'] = $v;
        }

        return $this->call(array('url' => 'deleteAdTags', 'params' => $post), $encode);
    }

    /**
     * Seek snapshot
     * @param (int) $id - Video id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function seek_snapshot($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['Video']['id']) || $_post['Video']['id'] == 0 || !is_numeric($_post['Video']['id'])) {
            throw new InvalidArgumentException('Video id is required.');
        }

        return $this->call(['url' => 'video/seek_snapshot', 'params' => $_post], $encode);
    }

    /**
     * new snapshot
     * @param (int) $_post - Video id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function new_snapshot($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['Video']['id']) || $_post['Video']['id'] == 0 || !is_numeric($_post['Video']['id'])) {
            throw new InvalidArgumentException('Video id is required.');
        }

        return $this->call(['url' => 'video/uploadNewSnapshot/upload_snapshot.json?partner_id=' . $_post['Partner']['id'], 'params' => $_post], $encode);
    }

    /**
     * Resync carousel
     * @param (int) $id - Carousel id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function resync_carousel($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        if (!isset($_post['Carousel']['id']) || $_post['Carousel']['id'] == 0 || !is_numeric($_post['Carousel']['id'])) {
            throw new InvalidArgumentException('Carousel id is required.');
        }

        return $this->call(['url' => 'carousel/resync/' . $_post['Carousel']['id']], $encode);
    }

    /**
     * carousel parse url
     * @param (int) $id - Carousel id
     * @param (bool) $encode - False to encode it in json, true to return it in StdClass
     */
    protected function carousel_parse_url($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }

        return $this->call(['url' => 'carousel/parseurl', 'params' => $_post], $encode);
    }

    protected function updated_cc($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        return $this->call(['url' => 'video/uploaded_cc', 'params' => $_post], $encode);
    }

    protected function remove_cc($_post = array(),  $encode = 'obj')
    {
        if (!isset($_post) || empty($_post)) {
            throw new InvalidArgumentException('Post is empty.');
        }
        return $this->call(['url' => 'video/remove_cc', 'params' => $_post], $encode);
    }

    protected function checkAllStatuses($ids = array(), $encode = 'obj')
    {
        $url = "video/checkAllStatuses";

        return $this->call(array('url' => $url, 'params' => $ids), $encode);
    }
}
