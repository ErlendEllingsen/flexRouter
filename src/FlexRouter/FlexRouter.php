<?php

namespace FlexRouter;

/**
 * Class FlexRouter
 *
 * FlexRouter is a small, lightweight php-router for clean, restful urls. Extremely easy to setup and configure.
 * Supports setting up routes based on their mode (GET, POST).
 * E.x: GET /user/:id/profile or POST /user/:id:/update-profile
 * Supports wildcards as well. E.g. /picture/:id/edit*
 *
 * @author Erlend Ellingsen <erlend.ame@gmail.com>, Robert Cox <robert@studiorclv.com>
 * @version 1.1.0 03.08.2017
 * @package FlexRouter
 */
class FlexRouter {
    /**
     * @var string
     */
    public $basePath = '';

    /**
     * @var bool
     */
    public $routed = false;

    /**
     * @var bool
     */
    public $caseSensitive;

    /**
     * @var int
     */
    private $pathCt = 0;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var array
     */
    private $params;

    /**
     * @var
     */
    private $dynParams;

    /**
     * FlexRouter constructor.
     *
     * @param bool $caseSensitive
     */
    public function __construct($caseSensitive = true)
    {
        $this->caseSensitive = $caseSensitive;

        // Determine the path
        if (!isset($_GET['path'])) {
            $_GET['path'] = '';
        }

        $this->params = explode('/', $_GET['path']);

        if (!$this->caseSensitive) {
            for ($i = 0; $i < count($this->params); $i++) { $this->params[$i] = strtolower($this->params[$i]); }
        }

        $this->pathCt = count($this->params);

        for ($i = 0; $i < $this->pathCt - 1; $i++) {
            $this->basePath .= '../';
        }

        // Determine the mode
        $this->mode = (empty($_POST) ? 'GET' : 'POST');
    }

    /**php
     * Matches the routing
     *
     * Mode: GET/POST
     * Pattern: /users/:id/update
     *
     * @param $mode
     * @param $pattern
     * @return bool
     */
    public function route($mode, $pattern)
    {
        $this->dynParams = array();

        // Validate mode
        if (is_array($mode)) {
            $modeValid = false;

            for ($i = 0; $i < count($mode); $i++) {
                $cM = $mode[$i];
                if (strtolower($cM) == strtolower($this->mode)) $modeValid = true;
                if ($modeValid) break;
            }

            if (!$modeValid) {
                return false;
            }
        } else if ($mode != '*') {
            if (strtolower($mode) != strtolower($this->mode)) {
                return false;
            }
        }

        // Check empty pattern
        if ($pattern == '' && ($this->pathCt == 0 || ($this->pathCt == 1 && $this->params[0] == ''))) {
            $this->routed = true;
            return true;
        }

        // Validate pattern
        $wildCard = (substr($pattern, -1) == "*" ? true : false);

        if ($wildCard) {
            $pattern = substr($pattern, 0, strlen($pattern) - 1);
        }

        $routePattern = explode('/', $pattern);

        if (empty($routePattern[0])) {
            unset($routePattern[0]);
        }

        $routePattern   = array_values($routePattern);
        $routePatternCt = count($routePattern);
        $validWildCard  = ($wildCard && $this->pathCt >= $routePatternCt);

        if (!$validWildCard && ($routePatternCt != $this->pathCt)) {
            return false;
        }

        for ($i = 0; $i < $routePatternCt; $i++) {
            $patternElement = $routePattern[$i];

            if (isset($patternElement[0]) && $patternElement[0] == ':') {
                $this->dynParams[$patternElement] = $this->params[$i];
                continue;
            }

            if ($this->caseSensitive && ($patternElement != $this->params[$i])) {
                return false;
            }
            if (!$this->caseSensitive && (strtolower($patternElement) != $this->params[$i])) {
                return false;
            }
        }
        $this->routed = true;

        return true;
    }

    /**
     * Returns a parameter based upon the tag
     *
     * @param $tag
     * @return mixed
     */
    public function param($tag)
    {
        return $this->dynParams[$tag];
    }

    /**
     * Retrieves the mode from the router
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
}
