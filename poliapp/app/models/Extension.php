<?php



class Extension extends \Phalcon\Mvc\Model
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
    public $id_coordinator;

    /**
     *
     * @var integer
     */
    public $id_type;

    /**
     *
     * @var integer
     */
    public $id_program;

      /**
     *
     * @var string
     */
    public $users;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("extension");
        $this->hasMany('id', 'ExtensionProject', 'id_extension', ['alias' => 'ExtensionProject']);
        $this->belongsTo('id_type', 'ExtensionType', 'id', ['alias' => 'ExtensionType']);
        $this->belongsTo('id_coordinator', 'Person', 'id', ['alias' => 'Person']);
        $this->belongsTo('id_program', 'Program', 'id', ['alias' => 'Program']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'extension';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Extension[]|Extension|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Extension|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
