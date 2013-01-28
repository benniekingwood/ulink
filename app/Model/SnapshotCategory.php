<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 10/20/12
 * Description:  This class will hold the snapshot category
 *  Model attributes: _id, name 
 ********************************************************************************/
class SnapshotCategory extends AppModel {
    var $name = 'SnapshotCategory';
    var $uses = array('SnapshotCategory');
    var $primaryKey = '_id';
    //var $useDbConfig = 'mongo';

    /**
     * Helper method to return the snapshot category by the id
     * @param id
     * @return SnapshotCategory
    */
    public function findById($id) {
           return $this->find('first', array('conditions' => array('_id' => $id)));
    }

    /**
     * Helper method to return all the Snapshot Categories
     */
    public function getAll() {
        return $this->find('all', array('order' => array('SnapshotCategory.name DESC')));
    }
}
?>