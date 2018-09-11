<?php


class Innovation extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var integer
     */
    public $id_performed_by;

    /**
     *
     * @var integer
     */
    public $id_beneficiary_entity;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("innovation");
        $this->belongsTo('id_beneficiary_entity', 'Entity', 'id', ['alias' => 'Entity']);
        $this->belongsTo('id_performed_by', 'Person', 'id', ['alias' => 'Person']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'innovation';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Innovation[]|Innovation|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Innovation|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
