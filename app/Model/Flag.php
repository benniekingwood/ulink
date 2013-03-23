<?php
/*********************************************************************************
 * Copyright (C) 2013 uLink, Inc. All Rights Reserved.
 *
 * Created On: 3/21/13
 * Description: This model will contain the flag data
 ********************************************************************************/
class Flag extends AppModel {
    var $name = 'Flag';
    var $uses = array('Flag');
    var $primaryKey = 'id';
}
?>