<?php
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\ORM\DataObject;

    class UserData extends DataObject {

        private static $create_table_options = [
            'MySQLDatabase' => 'ENGINE=InnoDB'
        ];

        private static $db = [
            'Name'              => 'Varchar(255)',
            'Email'             => 'Varchar(255)',
            'Company'             => 'Varchar(15)'
        ];
        
        private static $default_sort = 'SortOrder';
    }