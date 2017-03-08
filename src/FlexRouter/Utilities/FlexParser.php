<?php

namespace FlexRouter\Utilities;

/**
 * Class FlexParser
 *
 * @package FlexRouter\Utilities
 */
class FlexParser
{
    /**
     * @var bool
     */
    public $routed = false;

    /**
     * @var bool
     */
    public $caseSensitive;

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
     * @var int
     */
    private $pathCt = 0;

    /**
     * FlexParser constructor.
     *
     * @param $mode
     * @param $caseSensitive
     * @param $params
     * @param $pathCt
     */
    public function __construct(
        $mode,
        $caseSensitive,
        $params,
        $pathCt
    ) {
        $this->mode          = $mode;
        $this->caseSensitive = $caseSensitive;
        $this->params        = $params;
        $this->pathCt        = $pathCt;
    }

    /**
     * Parses the route and returns the appropriate response.
     *
     * @param $mode
     * @param $pattern
     * @return bool
     */
    public function parse($mode, $pattern)
    {
        $this->dynParams = array();

        // Validate mode
        if (is_array($mode)) {
            $modeValid = false;

            for ($i = 0; $i < count($mode); $i++) {
                $cM = $mode[$i];

                if (strtolower($cM) == strtolower($this->mode)) {
                    $modeValid = true;
                }
                if ($modeValid) {
                    break;
                }
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
}