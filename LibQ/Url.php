<?php

/**
 * Manejador de URL
 *
 * @author WERD
 */
class LibQ_Url
{
    /**
     * Las clases de caracteres para la validación de expresiones regulares
     */
    const CHAR_ALNUM    = 'A-Za-z0-9';
    const CHAR_MARK     = '-_.!~*\'()\[\]';
    const CHAR_RESERVED = ';\/?:@&=+$,';
    const CHAR_SEGMENT  = ':@&=+$,;';
    const CHAR_UNWISE   = '{}|\\\\^`';
    
    const HOST_ALL                            = 0x1F; //11111
    const HOST_IPVANY                         = 0x07; //00111
    const HOST_IPV4                           = 0x01; //00001
    
    /**
     * URI scheme
     *
     * @var string
     */
    protected $scheme;

    /**
     * URI userInfo part (usually user:password in HTTP URLs)
     *
     * @var string
     */
    protected $userInfo;

    /**
     * URI hostname
     *
     * @var string
     */
    protected $host;

    /**
     * URI port
     *
     * @var int
     */
    protected $port;

    /**
     * URI path
     *
     * @var string
     */
    protected $path;

    /**
     * URI query string
     *
     * @var string
     */
    protected $query;

    /**
     * URI fragment
     *
     * @var string
     */
    protected $fragment;

    
    /**
     * Url port
     * @var string
     */
    protected $_port = '';
        
    /**
     * Which host part types are valid for this URI?
     *
     * @var int
     */
    protected $validHostTypes = self::HOST_ALL;
    
    /**
     * Protocolo de la URL
     * @var stryng
     */
    protected $_protocolo = '';
    
    /**
     * Sirve para completar el protocolo
     * @var string
     */
    protected $_preURL = '://';
    
    /**
     * El resto de la url
     * @var string
     */
    protected $_pageURL = '';


    /**
     * Global configuration array
     * @var array
     */
    static protected $_config = array(
        'allow_unwise' => false
    );
    
    
    /**
     * Constructor acepta un string $url 
     * (ej example.com/path/to/resource?query=param#fragment)
     *
     * @param  Uri|string|null $url
     * @throws Exception cuando la Url no es valida
     */
    public function __construct($url = null)
    {
        if (is_string($url)) {
            $this->parse($url);
        }elseif ($url instanceof UriInterface) {
            // Copy constructor
            $this->setScheme($uri->getScheme());
            $this->setUserInfo($uri->getUserInfo());
            $this->setHost($uri->getHost());
            $this->setPort($uri->getPort());
            $this->setPath($uri->getPath());
            $this->setQuery($uri->getQuery());
            $this->setFragment($uri->getFragment());
        } elseif ($url !== null) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expecting a string or a URI object, received "%s"',
                (is_object($uri) ? get_class($uri) : gettype($uri))
            ));
        }     
    }
    
    /**
     * Parse a URI string
     *
     * @param  string $uri
     * @return Uri
     */
    public function parse($uri)
    {
        $this->reset();
        
        // Capture scheme
        if (($scheme = self::parseScheme($uri)) !== null) {
            $this->setScheme($scheme);
            $uri = substr($uri, strlen($scheme) + 1) ?: '';
        }

        // Capture authority part
        if (preg_match('|^//([^/\?#]*)|', $uri, $match)) {
            $authority = $match[1];
            $uri       = substr($uri, strlen($match[0]));

            // Split authority into userInfo and host
            if (strpos($authority, '@') !== false) {
                // The userInfo can also contain '@' symbols; split $authority
                // into segments, and set it to the last segment.
                $segments  = explode('@', $authority);
                $authority = array_pop($segments);
                $userInfo  = implode('@', $segments);
                unset($segments);
                $this->setUserInfo($userInfo);
            }

            $nMatches = preg_match('/:[\d]{1,5}$/', $authority, $matches);
            if ($nMatches === 1) {
                $portLength = strlen($matches[0]);
                $port = substr($matches[0], 1);

                $this->setPort((int) $port);
                $authority = substr($authority, 0, -$portLength);
            }

            $this->setHost($authority);
        }

        if (!$uri) {
            return $this;
        }

        // Capture the path
        if (preg_match('|^[^\?#]*|', $uri, $match)) {
            $this->setPath($match[0]);
            $uri = substr($uri, strlen($match[0]));
        }

        if (!$uri) {
            return $this;
        }

        // Capture the query
        if (preg_match('|^\?([^#]*)|', $uri, $match)) {
            $this->setQuery($match[1]);
            $uri = substr($uri, strlen($match[0]));
        }
        if (!$uri) {
            return $this;
        }

        // All that's left is the fragment
        if ($uri && substr($uri, 0, 1) == '#') {
            $this->setFragment(substr($uri, 1));
        }

        return $this;
    }
    
    /**
     * Reset URI parts
     */
    protected function reset()
    {
        $this->setScheme(null);
        $this->setPort(null);
        $this->setUserInfo(null);
        $this->setHost(null);
        $this->setPath(null);
        $this->setFragment(null);
        $this->setQuery(null);
    }
    
    /**
     * Extract only the scheme part out of a URI string.
     *
     * This is used by the parse() method, but is useful as a standalone public
     * method if one wants to test a URI string for it's scheme before doing
     * anything with it.
     *
     * Will return the scheme if found, or NULL if no scheme found (URI may
     * still be valid, but not full)
     *
     * @param  string $uriString
     * @throws Exception\InvalidArgumentException
     * @return string|null
     */
    public static function parseScheme($uriString)
    {
        if (! is_string($uriString)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expecting a string, got %s',
                (is_object($uriString) ? get_class($uriString) : gettype($uriString))
            ));
        }

        if (preg_match('/^([A-Za-z][A-Za-z0-9\.\+\-]*):/', $uriString, $match)) {
            return $match[1];
        }

        return;
    }

    public static function obtenerURL()
    {
        $protocolo = 'http';
        if (isset($_SERVER["HTTPS"])) {
            if ($_SERVER["HTTPS"] == "on") {
                $protocolo .= "s";
            }
        }
        $preURL = "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        return $protocolo . $preURL . $pageURL;
    }
    
    public static function validarQueryString($queryString)
    {
        $query = strip_tags($queryString);
        $query1 = utf8_decode($query);
        $query2 = urldecode($query1);
        if (strpos($query2, 'Transcripts.php') === false && strpos($query2, 'medical alert') === false) {

            $search = array("..//", "*", "../", "/.", "<", ">", "alert", "(", ")", "script", "javascript", "///", "union", "%3dalert", "{", "}", "\n", "%22", "%27", " ' ", "%23", "%3C", "%2F", "%", "%3E", "%3D", "%7B", "%7D", "%3F", "%3B", "%25", "%28", "%29", "%2A", "%26");
            $VAL = str_replace($search, "#", $queryString);
            $ddd = preg_match("/([\#\'\%\*])/ ", $VAL);
            if ($ddd == 1) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Set the URI scheme
     *
     * If the scheme is not valid according to the generic scheme syntax or
     * is not acceptable by the specific URI class (e.g. 'http' or 'https' are
     * the only acceptable schemes for the Zend\Uri\Http class) an exception
     * will be thrown.
     *
     * You can check if a scheme is valid before setting it using the
     * validateScheme() method.
     *
     * @param  string $scheme
     * @throws Exception\InvalidUriPartException
     * @return Uri
     */
    public function setScheme($scheme)
    {
        if (($scheme !== null) && (!self::validateScheme($scheme))) {
            throw new Exception\InvalidUriPartException(sprintf(
                'Scheme "%s" is not valid or is not accepted by %s',
                $scheme,
                get_class($this)
            ), Exception\InvalidUriPartException::INVALID_SCHEME);
        }

        $this->scheme = $scheme;
        return $this;
    }
    
    /**
     * Set the port part of the URI
     *
     * @param  int $port
     * @return Uri
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }
    
    /**
     * Set the URI User-info part (usually user:password)
     *
     * @param  string $userInfo
     * @return Uri
     * @throws Exception\InvalidUriPartException If the schema definition
     * does not have this part
     */
    public function setUserInfo($userInfo)
    {
        $this->userInfo = $userInfo;
        return $this;
    }
    
    /**
     * Set the URI host
     *
     * Note that the generic syntax for URIs allows using host names which
     * are not necessarily IPv4 addresses or valid DNS host names. For example,
     * IPv6 addresses are allowed as well, and also an abstract "registered name"
     * which may be any name composed of a valid set of characters, including,
     * for example, tilda (~) and underscore (_) which are not allowed in DNS
     * names.
     *
     * Subclasses of Uri may impose more strict validation of host names - for
     * example the HTTP RFC clearly states that only IPv4 and valid DNS names
     * are allowed in HTTP URIs.
     *
     * @param  string $host
     * @throws Exception\InvalidUriPartException
     * @return Uri
     */
    public function setHost($host)
    {
        if (($host !== '')
            && ($host !== null)
            && !self::validateHost($host, $this->validHostTypes)
        ) {
            throw new Exception\InvalidUriPartException(sprintf(
                'Host "%s" is not valid or is not accepted by %s',
                $host,
                get_class($this)
            ), Exception\InvalidUriPartException::INVALID_HOSTNAME);
        }

        $this->host = $host;
        return $this;
    }
    
    /**
     * Set the path
     *
     * @param  string $path
     * @return Uri
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    
    /**
     * Set the URI fragment part
     *
     * @param  string $fragment
     * @return Uri
     * @throws Exception\InvalidUriPartException If the schema definition
     * does not have this part
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
        return $this;
    }
    
    /**
     * Set the query string
     *
     * If an array is provided, will encode this array of parameters into a
     * query string. Array values will be represented in the query string using
     * PHP's common square bracket notation.
     *
     * @param  string|array $query
     * @return Uri
     */
    public function setQuery($query)
    {
        if (is_array($query)) {
            // We replace the + used for spaces by http_build_query with the
            // more standard %20.
            $query = str_replace('+', '%20', http_build_query($query));
        }

        $this->query = $query;
        return $this;
    }
    
    /**
     * Get the URI host
     *
     * @return string|null
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * Get the URI port
     *
     * @return int|null
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Get the URI path
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the URI query
     *
     * @return string|null
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Return the query string as an associative array of key => value pairs
     *
     * This is an extension to RFC-3986 but is quite useful when working with
     * most common URI types
     *
     * @return array
     */
    public function getQueryAsArray()
    {
        $query = array();
        if ($this->query) {
            parse_str($this->query, $query);
        }

        return $query;
    }

    /**
     * Get the URI fragment
     *
     * @return string|null
     */
    public function getFragment()
    {
        return $this->fragment;
    }
    
    /**
     * Check if a scheme is valid or not
     *
     * Will check $scheme to be valid against the generic scheme syntax defined
     * in RFC-3986. If the class also defines specific acceptable schemes, will
     * also check that $scheme is one of them.
     *
     * @param  string $scheme
     * @return bool
     */
    public static function validateScheme($scheme)
    {
        if (!empty(static::$validSchemes)
            && !in_array(strtolower($scheme), static::$validSchemes)
        ) {
            return false;
        }

        return (bool) preg_match('/^[A-Za-z][A-Za-z0-9\-\.+]*$/', $scheme);
    }
    
    /**
     * Validate the host part
     *
     * Users may control which host types to allow by passing a second parameter
     * with a bitmask of HOST_* constants which are allowed. If not specified,
     * all address types will be allowed.
     *
     * Note that the generic URI syntax allows different host representations,
     * including IPv4 addresses, IPv6 addresses and future IP address formats
     * enclosed in square brackets, and registered names which may be DNS names
     * or even more complex names. This is different (and is much more loose)
     * from what is commonly accepted as valid HTTP URLs for example.
     *
     * @param  string  $host
     * @param  int $allowed bitmask of allowed host types
     * @return bool
     */
    public static function validateHost($host, $allowed = self::HOST_ALL)
    {
        /*
         * "first-match-wins" algorithm (RFC 3986):
         * If host matches the rule for IPv4address, then it should be
         * considered an IPv4 address literal and not a reg-name
         */
        if ($allowed & self::HOST_IPVANY) {
            if (static::isValidIpAddress($host, $allowed)) {
                return true;
            }
        }

        if ($allowed & self::HOST_REGNAME) {
            if (static::isValidRegName($host)) {
                return true;
            }
        }

        if ($allowed & self::HOST_DNS) {
            if (static::isValidDnsHostname($host)) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Check if a host name is a valid IP address, depending on allowed IP address types
     *
     * @param  string  $host
     * @param  int $allowed allowed address types
     * @return bool
     */
    protected static function isValidIpAddress($host, $allowed)
    {
        $validatorParams = array(
            'allowipv4'      => (bool) ($allowed & self::HOST_IPV4),
            'allowipv6'      => false,
            'allowipvfuture' => false,
            'allowliteral'   => false,
        );

        // Test only IPv4
//        $validator = new Validator\Ip($validatorParams);
//        $return = $validator->isValid($host);
//        if ($return) {
            return true;
//        }

        // IPv6 & IPvLiteral must be in literal format
        $validatorParams = array(
            'allowipv4'      => false,
            'allowipv6'      => (bool) ($allowed & self::HOST_IPV6),
            'allowipvfuture' => (bool) ($allowed & self::HOST_IPVFUTURE),
            'allowliteral'   => true,
        );
        static $regex = '/^\[.*\]$/';
        $validator->setOptions($validatorParams);
        return (preg_match($regex, $host) && $validator->isValid($host));
    }

}

