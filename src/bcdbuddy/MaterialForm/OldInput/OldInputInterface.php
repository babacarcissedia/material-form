<?php

namespace bcdbuddy\MaterialForm\OldInput;

interface OldInputInterface
{
    public function hasOldInput();

    public function getOldInput($key);
}
