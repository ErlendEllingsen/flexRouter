<?php
/**
 * flexRouter - a small, lightweight php-router for clean, restful urls. Extremely easy to setup and configure.
 * Supports setting up routes based on their mode (GET, POST). E.x: GET /user/:id/profile or POST /user/:id:/update-profile
 * Now supports wildcards aswell. E.g. /picture/:id/edit*
 * @author Erlend Ellingsen <erlend.ame@gmail.com>
 * @version 1.5 15.06.2016
 */
class flexRouter {
    public $mode;
    public $params;
    public $dynParams;
    public $basePath;
    private $pathCt = 0;

    public $routed = false;

    public function __construct() {
        // Determine the path
        if (!isset($_GET['path'])) $_GET['path'] = '';
        $this->params = explode('/', $_GET['path']);
        $this->pathCt = count($this->params);
        for ($i = 0; $i < $this->pathCt - 1; $i++) {
            $this->basePath .= '../';
        }
        // Determine the mode
        $this->mode = (empty($_POST) ? 'GET' : 'POST');
    }
    /**
     * Mode: GET/POST
     * Pattern: /users/:id/update
     */
    public function route($mode, $pattern) {
        $this->dynParams = array();
        // Validate mode
        if (is_array($mode)) {
            $modeValid = false;
            for ($i = 0; $i < count($mode); $i++) {
                $cM = $mode[$i];
                if (strtolower($cM) == strtolower($this->mode)) $modeValid = true;
                if ($modeValid) break;
            }
            if (!$modeValid) return false;
        } else {
            if (strtolower($mode) != strtolower($this->mode)) return false;
        }
        // Validate pattern
        $wildCard = (substr($pattern, -1) == "*" ? true : false);
        if ($wildCard) $pattern = substr($pattern, 0, strlen($pattern) - 1);
        $routePattern = explode('/', $pattern);
        if (empty($routePattern[0])) unset($routePattern[0]);
        $routePattern = array_values($routePattern);
        $routePatternCt = count($routePattern);
        $validWildCard = ($wildCard && $this->pathCt >= $routePatternCt);
        if (!$validWildCard && ($routePatternCt != $this->pathCt)) return false;
        for ($i = 0; $i < $routePatternCt; $i++) {
            $patternElement = $routePattern[$i];
            if ($patternElement[0] == ':') {
                $this->dynParams[$patternElement] = $this->params[$i];
                continue;
            }
            if ($patternElement != $this->params[$i]) return false;
            // end of routePattern-loop
        }
        $this->routed = true;
        return true;
        // end route-function
    }
    public function param($tag) {
        return $this->dynParams[$tag];
    }
    // end flexRouter
}
?>
