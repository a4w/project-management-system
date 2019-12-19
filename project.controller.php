<?php
require 'db.inc.php';

$action = $_POST['action'] ?? null;
 
switch($action){
    case 'set_task_complete':
        $tid = $_POST['task_id'] ?? 0;
        $wh = $_POST['working_hours'] ?? 0;
        $stmt = $link->prepare('UPDATE `task` SET `is-complete` = 1, `actual-working-hours` = ? WHERE `id` = ?');
        $stmt->bind_param('ii', $wh, $tid);
        $stmt->execute();
        break;
}
