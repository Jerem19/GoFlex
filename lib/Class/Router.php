<?php

class Request {
    private $url;
    private $uri;

    public $body;
    public $headers;
    public $params;

    public function __construct($uri, $params = []) {
        $this->uri = $uri;
        $this->url = $params[0];
        unset($params[0]);

        $this->body = $_REQUEST;
        $this->headers = apache_request_headers();
        $this->params = $params;
    }
}

class Response {

    public function send() {

    }

    public function sendData() {

    }

    public function redirect($url) {
        header("Location: " . $url, true);
    }
}

/**
 * Class Router
 * Simply routes manager
 */
class Router {
    const GET = 'GET';
    const POST = 'POST';

    private $_baseUrl;
    private $_url;
    private $_method;

    /**
     * Return the base URl of the server
     * @return string
     */
    public function getBaseURL() {
        return $this->_baseUrl;
    }

    /**
     * Return the url
     * @return string
     */
    public function getURL() {
        return $this->_url;
    }

    /**
     * Return the method (GET|POST)
     * @return string
     */
    public function getMethod() {
        return $this->_method;
    }

    /**
     * Create the router
     */
    public function __construct() {
        $this->_baseUrl = pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);
        $this->_url = str_replace($this->_baseUrl, "" , $_SERVER["REQUEST_URI"]);
        $this->_url = $this->removeSlash($this->_url);
        $this->_method = $_SERVER["REQUEST_METHOD"]; //GET || POST
    }

    /**
     * Use the extension of the uri to redirect
     * @param string|string[] $extension
     * @param string $folder
     * @param string $contentType
     * @return Router $this
     */
    public function byExt($extension, $folder, $contentType) {
        $extension = is_array($extension) ? $extension : [$extension];
        if (in_array(pathinfo($this->_url, PATHINFO_EXTENSION), $extension)) {
            $file = $folder . $this->_url;
            if (file_exists($file)) {
                header("Content-type: " . $contentType);
                require_once $file;
                die();
            }
        }
        return $this;
    }

    private function removeSlash($string) {
        if(substr($string, -1) === '/') {
            return substr($string, 0, -1);
        }
        return $string;
    }

    private function doPattern($string) {
        preg_match('/([\w\/]+)(\:[a-zA-Z]+|\*)([\w\/\:\*?]*)/', $string, $matches);

        $wanted = $matches[2];
        $after = $matches[3];
        $middle = '(\w+)';

        if (strpos($after, '*') !== false || strpos($after, ':') !== false)
            $after = $this->doPattern($after);
        if (strpos($wanted, ':') !== false)
            $middle = '(?P<' . substr($wanted, 1) . '>\w+)';

        return $matches[1] . $middle . $after;
    }

    /**
     * @param string $uri
     * @param callable $callback
     */
    private function testUrl($uri, $callback) {
        // To Do (improve)
        $uri = $this->removeSlash($uri);

        $isOk = $uri == $this->_url;
        if (!$isOk && (strpos($uri, '*') !== false || strpos($uri, ':') !== false )) {
            $pattern = str_replace('/', '\/', $this->doPattern($uri));
            $isOk = preg_match('/^' . $pattern . '(?:\?[\w=&]*)?$/', $this->_url, $matches);
        }

        if ($isOk) {
            $callback(new Request($uri, $matches), new Response());
            die();
        }
    }

    /**
     * @param string $url
     * @param callable(Request, Response) $callback
     * @return Router $this
     */
    public function get($uri, $callback) {
        if($this->_method == self::GET) {
            $this->testUrl($uri, $callback);
        }
        return $this;
    }

    /**
     * @param string $url
     * @param callable $callback
     * @return Router $this
     */
    public function post($uri, $callback) {
        if($this->_method == self::POST) {
            $this->testUrl($uri, $callback);
        }
        return $this;
    }

    /**
     * @param string $url
     * @param callable $callback
     * @return Router $this
     */
    public function on($uri, $callback) {
        $this->testUrl($uri, $callback);
        return $this;
    }

    /**
     *
     * @param string|string[] $url
     * @param string[] $routes
     * @return Router $this
     */
    public function use($url, $routes) {
        foreach ($routes as $key => $route) {
            if (substr($key, 0, 1) !== '/')
                $key = '/' . $key;
            $uri = $url . $key;
            if (array_key_exists('routes', $route)) {
                $this->use($uri, $route['routes']);
            } else {
                $callback = $route['callback'];

                if($route['method'] === self::POST) {
                    $this->post($uri, $callback);
                } else if($route['method'] === self::GET) {
                    $this->get($uri, $callback);
                } else {
                    $this->on($uri, $callback);
                }
            }
        }
        return $this;
    }
}