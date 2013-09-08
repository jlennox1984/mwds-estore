<?php

/**
 * Language.class.php
 *
 * Copyright (c) 2003-2005 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This contains functions needed to handle mime messages.
 *
 * $Id: Language.class.php,v 1.1 2005/06/14 13:42:16 indigoleopard Exp $
 */

class Language {
    function Language($name) {
       $this->name = $name;
       $this->properties = array();
    }
}

?>
