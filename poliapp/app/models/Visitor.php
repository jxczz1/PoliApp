<?php

class Visitor extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $objective;

    /**
     *
     * @var string
     */
    public $arrival_date;

    /**
     *
     * @var string
     */
    public $departure_date;

    /**
     *
     * @var integer
     */
    public $id_visitor_person;

    /**
     *
     * @var integer
     */
    public $id_program;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("visitor");
        $this->belongsTo('id_visitor_person', 'Person', 'id', ['alias' => 'Person']);
        $this->belongsTo('id_program', 'Program', 'id', ['alias' => 'Program']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visitor';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Visitor[]|Visitor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Visitor|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
