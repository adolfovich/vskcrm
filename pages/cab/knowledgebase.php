<?php

$records = $db->getAll("SELECT * FROM knowledgebase WHERE is_del = 0");

//var_dump($user_profile);

include ('tpl/cab/knowledgebase.tpl');