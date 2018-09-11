<?php


class Entity extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $id_type;

    /**
     *
     * @var integer
     */
    public $id_country;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("entity");
        $this->hasMany('id', 'Agreement', 'id_entity_from', ['alias' => 'Agreement']);
        $this->hasMany('id', 'Agreement', 'id_entity_with', ['alias' => 'Agreement']);
        $this->hasMany('id', 'Innovation', 'id_beneficiary_entity', ['alias' => 'Innovation']);
        $this->hasMany('id', 'Program', 'id_university', ['alias' => 'Program']);
        $this->belongsTo('id_country', 'Country', 'id', ['alias' => 'Country']);
        $this->belongsTo('id_type', 'EntityType', 'id', ['alias' => 'EntityType']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'entity';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Entity[]|Entity|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Entity|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
