<?php

jimport('joomla.application.component.modeladmin');

abstract class UniteHCarModel extends JModelAdmin {

    protected function prepareTable($table) {
        $this->prepareTableReal($table);
    }

}

?>