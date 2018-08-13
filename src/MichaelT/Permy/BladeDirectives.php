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
    }

    /**
     * Permy::can blade directive
     *
     * @return string
     */
    public function can()
    {
        \Blade::directive('permyCan', function ($expression) {
            return "<?php if (Permy::can($expression)): ?>";
        });

        \Blade::directive('endpermyCan', function ($expression) {
            return "<?php endif; ?>";
        });
    }


    /**
     * Permy::cant blade directive
     *
     * @return string
     */
    public function cant()
    {
        \Blade::directive('permyCant', function ($expression) {
            return "<?php if (Permy::cant($expression)): ?>";
        });

        \Blade::directive('endpermyCant', function ($expression) {
            return "<?php endif; ?>";
        });
    }
}
