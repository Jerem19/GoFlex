<?php

class Response {

    private $_baseUrl;
    private $_viewsPath = null;

    public function __construct(string $baseUrl, string $viewsPath = null) {
        $this->_baseUrl = $baseUrl;
        $this->_viewsPath = $viewsPath;
    }

    /**
     * Stop the execution of the script
     */
    private function stopExec() {
        exit();
    }

    public function render(string $viewPath, $params = null) {
        $this->setContentType("text/html");
        extract($params);
        require_once $this->_viewsPath != null ? $this->_viewsPath."/".$viewPath : $viewPath; // if no file => error (intentional)
        $this->stopExec();
    }

    /**
     * Send some data (without json encode)
     * @param int|string|array $data
     * @param boolean $jsonEncode default encode in JSON
     * @param string $contentType
     * @param boolean $stopScript to send more data
     */
    public function send($data, bool $jsonEncode = true, $contentType = null, bool $stopScript = true) {
        if ($contentType == null)
            $contentType = is_array($data) ? "application/json" : (new finfo(FILEINFO_MIME))->buffer((string)$data);
        $this->setContentType($contentType);
        if (!$jsonEncode) // if is null => encode
            echo $data;
        else
            echo json_encode($data);
        if($stopScript)
            $this->stopExec();
    }

    /**
     * @param string $file
     * @param string|null $contentType if you want to force the MIME Type
     */
    public function sendFile(string $file, $contentType = null) {
        if (file_exists($file)) {
            if ($contentType == null) {
                $mimeType = json_decode(file_get_contents(PRIVATE_FOLDER . 'Class/MIME_TYPES.json'), true);
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $contentType = isset($mimeType[$ext]) ? $mimeType[$ext] : "text/plain";
            }
            $this->setContentType($contentType);
            require_once $file;
        } else
            echo json_encode("Error: no file at " . $file);
        $this->stopExec();
    }

    /**
     * Redirect to an URL
     * @param string $url
     * @param bool $local
     */
    public function redirect(string $url, bool $local = true) {
        $this->setHeader("Location: " . ($local ? $this->_baseUrl : '') . $url);
        $this->stopExec();
    }

    /**
     * Set a content type for the header
     * @param $contentType
     */
    private function setContentType(string $contentType) {
        $this->setHeader("Content-type: " . $contentType);
    }

    /**
     * @param string $stringHeader
     * @param bool $replace
     * @param null|int $http_response_code
     */
    public function setHeader(string $header, bool $replace = true, $http_response_code = null) {
        header($header, $replace, $http_response_code);
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

    private $_viewsPath = null;

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
     * Return the path to the views
     * @return string
     */
    public function getViewsPath() {
        return $this->_viewsPath;
    }

    /**
     * Set the path to the views
     * @param string $viewPath
     * @return Router
     */
    public function setViewsPath(string $viewPath) {
        $this->_viewsPath = $viewPath;
        return $this;
    }

    /**
     * Create the router
     */
    public function __construct() {
        $this->_baseUrl = pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);
        $this->_url = $this->removeSlash(str_replace($this->_baseUrl, "" , $_SERVER["REQUEST_URI"]));        
        $this->_method = $_SERVER["REQUEST_METHOD"]; //GET || POST
    }

    /**
     * Use the extension of the uri to redirect
     * @param string|string[] $extension
     * @param string $folder
     * @param string $contentType
     * @return Router $this
     */
    public function byExt($extension, string $folder, $contentType = null) {
        $extension = is_array($extension) ? $extension : [$extension];
        if (in_array(pathinfo($this->_url, PATHINFO_EXTENSION), $extension)) {
            (new Response($this->_baseUrl, $this->_viewsPath))->sendFile($folder . $this->_url, $contentType);
        }
        return $this;
    }

    private function removeSlash(string $string) {
        if(substr($string, -1) === '/') {
            return substr($string, 0, -1);
        }
        return $string;
    }

    private function doPattern(string $string) {
        preg_match('/([\w\/]*)(\:[a-zA-Z]+|\*)([\w\/\:\.\*]*)/', $string, $matches);

        $wanted = $matches[2];
        $after = $matches[3];
        $middle = '([/\w\.\-\_]*)'; // remplace * => + if :par

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
    private function testUrl(string $uri, callable $callback) {
        // To Do (improve)
        $uri = $this->removeSlash($uri);

        $url = $this->_url;

        {
            $pos = strpos($url, "?");
            if ($pos !== false)
                $url = substr($url, 0, $pos);
        }

        $isOk = $uri == $url;

        $matches = [];
        if (!$isOk && (strpos($uri, '*') !== false || strpos($uri, ':') !== false )) {
            $pattern = str_replace('/', '\/', $this->doPattern($uri));
            $isOk = preg_match('/^' . $pattern . '$/', $url, $matches);
        } else
            $matches = [$this->_url];

        if ($isOk) {
            if(!empty($matches))
                array_splice($matches, 0, 1);
            $callback(new Response($this->_baseUrl, $this->_viewsPath), $matches);
        }
    }

    /**
     * @param string $uri
     * @param callable(Request, Response) $callback
     * @return Router $this
     */
    public function get(string $uri, callable $callback) {
        if ($this->_method == self::GET)
            $this->testUrl($uri, $callback);
        return $this;
    }

    /**
     * @param string $uri
     * @param callable $callback
     * @return Router $this
     */
    public function post(string $uri, callable $callback) {
        if ($this->_method == self::POST)
            $this->testUrl($uri, $callback);
        return $this;
    }

    /**
     * @param string $uri
     * @param callable $callback
     * @return Router $this
     */
    public function on(string $uri, callable $callback) {
        $this->testUrl($uri, $callback);
        return $this;
    }

    /**
     *
     * @param string $url
     * @param string[] $routes
     * @return Router $this
     */
    public function use(string $url, array $routes) {
        foreach ($routes as $key => $route) {
            if (substr($key, 0, 1) !== '/')
                $key = '/' . $key;
            $uri = $url . $key;
            if (array_key_exists('routes', $route)) {
                $this->use($uri, $route['routes']);
            } else {
                if (!isset($route["callback"]))
                    $route["callback"] = function() {};
                if (!isset($route["method"]))
                    $route["method"] = "";

                $callback = $route['callback'];
                if($route['method'] === self::POST)
                    $this->post($uri, $callback);
                else if($route['method'] === self::GET)
                    $this->get($uri, $callback);
                else $this->on($uri, $callback);
            }
        }
        return $this;
    }
}