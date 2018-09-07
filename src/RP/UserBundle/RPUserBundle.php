<?php
// src/OC/UserBundle/OCUserBundle.php

namespace RP\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RPUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}