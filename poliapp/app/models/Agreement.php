<?php

class Agreement extends \Phalcon\Mvc\Model
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
    public $objective;

    /**
     *
     * @var string
     */
    public $valid_to;

    /**
     *
     * @var integer
     */
    public $id_entity_from;

    /**
     *
     * @var integer
     */
    public $id_entity_with;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("agreement");
        $this->hasMany('id', 'AgreementHistory', 'id_agreement', ['alias' => 'AgreementHistory']);
        $this->belongsTo('id_entity_from', 'Entity', 'id', ['alias' => 'Entity']);
        $this->belongsTo('id_entity_with', 'Entity', 'id', ['alias' => 'Entity']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'agreement';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Agreement[]|Agreement|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Agreement|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
