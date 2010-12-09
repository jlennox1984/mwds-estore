<?php

/**
 * Disposition.class.php
 *
 * Copyright (c) 2003-2005 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This contains functions needed to handle mime messages.
 *
 * $Id: Disposition.class.php,v 1.1 2005/06/14 13:42:16 indigoleopard Exp $
 */

class Disposition {
    function Disposition($name) {
       $this->name = $name;
       $this->properties = array();
    }

    function getProperty($par) {
        $value = strtolower($par);
        if (isset($this->properties[$par])) {
            return $this->properties[$par];
        }
        return '';
    }
}

?>
