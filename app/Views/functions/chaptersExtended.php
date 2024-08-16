<?php
if ($list->pos=='left') { $list->pos='left1'; }
if ($list->pos=='right') { $list->pos='right1'; }
echo view('functions/chapters',array('list'=>$list),array('options' => $options));