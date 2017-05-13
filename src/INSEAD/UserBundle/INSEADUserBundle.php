<?php

namespace INSEAD\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class INSEADUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
