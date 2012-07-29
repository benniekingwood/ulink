<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 7/28/12
 * Description:  This class will hold the trends for a school
 *  Model attributes: _id, items, collegeID, created
 ********************************************************************************/
  class Trend extends AppModel {
      var $name = 'Trend';
      var $uses = array('Trend');
      var $primaryKey = '_id';
      var $useDbConfig = 'mongo';

      /**
       * This function will return the Trend based on the school Id
       * @param null $schoolID
       * @return array|null
       */
      public function getTrendBySchoolID($schoolID = null) {
          $retVal = null;
          try {
              $retVal = $this->find('all', array('conditions' => array('collegeID' => $schoolID)));
          } catch (Exception $e) {
              $this->log('{Trend#getTrendBySchoolID} - An exception was thrown: ' . $e->getMessage());
          }
          return $retVal;
      }

      /**
       * This function will delete the trends based on the $schoolID
       * @param null $schoolID
       */
      public function deleteBySchoolID($schoolID = null) {
          try {
              $this->delete('all', array('conditions' => array('collegeID' => $schoolID)));
          } catch (Exception $e) {
              $this->log('{Trend#deleteBySchoolID} - An exception was thrown: ' . $e->getMessage());
          }
      }
  }
?>