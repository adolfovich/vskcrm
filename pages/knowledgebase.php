<?php

$records = $db->getAll("SELECT * FROM knowledgebase WHERE is_del = 0");


include ('tpl/header.tpl');
include ('tpl/knowledgebase.tpl');
include ('tpl/footer.tpl');
