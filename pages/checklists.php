<?php


$checklists = $db->getAll("SELECT * FROM checklists");


include('tpl/header.tpl');
include('tpl/checklists.tpl');
include('tpl/footer.tpl');
