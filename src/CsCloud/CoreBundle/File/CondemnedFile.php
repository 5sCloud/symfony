<?php

namespace CsCloud\CoreBundle\File;

use Symfony\Component\HttpFoundation\File\File;

/**
 * CondemnedFile represent a file that should be removed
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class CondemnedFile extends File
{
    public function __construct()
    {
    }

    public function move($directory, $name = null)
    {
        // Do nothing
    }
}
