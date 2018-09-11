<?php


class Person extends \Phalcon\Mvc\Model
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
    public $id_role;

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
        $this->setSource("person");
        $this->hasMany('id', 'Extension', 'id_coordinator', ['alias' => 'Extension']);
        $this->hasMany('id', 'Innovation', 'id_performed_by', ['alias' => 'Innovation']);
        $this->hasMany('id', 'Visitor', 'id_visitor_person', ['alias' => 'Visitor']);
        $this->belongsTo('id_program', 'Program', 'id', ['alias' => 'Program']);
        $this->belongsTo('id_role', 'PersonRole', 'id', ['alias' => 'PersonRole']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'person';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Person[]|Person|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Person|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
