<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    // For overriding FOSUserBundle Controllers
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
