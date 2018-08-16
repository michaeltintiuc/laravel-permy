<?php
namespace MichaelT\Permy;

class LegacyBladeDirectives
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->can();
        $this->cant();
        $this->closeConditional();
    }

    /**
     * Permy::can blade directive
     *
     * @return string
     */
    private function can()
    {
        $this->openConditional('permyCan', 'can');
        $this->closeConditional('endpermyCan');
    }

    /**
     * Permy::cant blade directive
     *
     * @return string
     */
    private function cant()
    {
        $this->openConditional('permyCant', 'cant');
        $this->closeConditional('endpermyCant');
    }

    /**
     * Open conditional helper
     *
     * @return string
     */
    private function openConditional($function, $method)
    {
        \Blade::extend(function ($view, $compiler) use ($function, $method) {
            $pattern = $compiler->createMatcher($function);
            return preg_replace($pattern, "$1<?php if (Permy::$method$2): ?>", $view);
        });
    }

    /**
     * Close conditional helper blade directive
     *
     * @return string
     */
    private function closeConditional($function = 'endpermy')
    {
        \Blade::extend(function ($view, $compiler) use ($function) {
            $pattern = $compiler->createPlainMatcher($function);
            return preg_replace($pattern, '$1<?php endif; ?>', $view);
        });
    }
}
