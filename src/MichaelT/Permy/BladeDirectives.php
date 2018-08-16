<?php

namespace MichaelT\Permy;

/**
 * Registers custom blade directives for Laravel 5.1+
 */
class BladeDirectives
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
        \Blade::directive($function, function ($expression) use ($method) {
            return "<?php if (Permy::$method($expression)): ?>";
        });
    }

    /**
     * Close conditional helper blade directive
     *
     * @return string
     */
    private function closeConditional($function = 'endpermy')
    {
        \Blade::directive($function, function ($expression) {
            return "<?php endif; ?>";
        });
    }
}
