<?php

class Program extends \Phalcon\Mvc\Model
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
    public $id_university;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("program");
        $this->hasMany('id', 'Extension', 'id_program', ['alias' => 'Extension']);
        $this->hasMany('id', 'Person', 'id_program', ['alias' => 'Person']);
        $this->hasMany('id', 'Visitor', 'id_program', ['alias' => 'Visitor']);
        $this->belongsTo('id_university', 'Entity', 'id', ['alias' => 'Entity']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'program';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Program[]|Program|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Program|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
