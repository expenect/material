<?php
/**
 * Created by PhpStorm.
 * User: egorov
 * Date: 23.12.2014
 * Time: 22:12
 */
namespace samsoncms\app\material;

use samsoncms\app\material\field\Navigation;
use samsoncms\app\material\field\User;
use samsonframework\orm\QueryInterface;
use samsoncms\field\Generic;
use samsoncms\field\Control;

/**
 * Collection of materials
 * @package samsonos\cms\app\material
 */
class Collection extends \samsoncms\MetaCollection
{
    /**
     * Function for joining tables to get some extra data in result set
     *
     * @param dbQuery $query Collection query
     */
    public function joinTables(&$query)
    {
        $query->join('user')
            ->order_by('Modyfied', 'DESC')
            ->join('structurematerial')
            ->join('structure')
            //->cond('structure.system', 0)
        ;
    }

    /**
     * Function to cut off related and table materials
     *
     * @param QueryInterface $query Base entity query for modification
     */
    public function parentIdInjection(& $query)
    {
        // Cut off related and table materials
        $query
            ->cond('parent_id', 0)
            ->order_by('Modyfied', 'DESC');
    }

    /** {@inheritdoc} */
    public function __construct($renderer, $query = null, $pager = null)
    {
        // Call parents
        parent::__construct($renderer, $query, $pager, locale());

        // Call external handlers
        $this->entityHandler(array($this, 'joinTables'));
        $this->baseEntityHandler(array($this, 'parentIdInjection'));

        // Fill default column fields for collection
        $this->fields = array(
            new Generic('MaterialID', '#', 0, 'id', false),
            new Generic('Name', t('Наименование', true), 0),
            new Generic('Url', t('Идентификатор', true), 0),
            new Navigation(),
            new Generic('Modyfied', t('Последнее изменение', true), 7, 'modified', false, true),
            new User(),// Create object instance with fixed parameters
            new Generic('Published', t('Показывать', true), 11, 'publish'),
            new Control(),
        );
    }
}
