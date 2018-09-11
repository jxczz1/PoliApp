<?php


class ExtensionProject extends \Phalcon\Mvc\Model
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
    public $date;

    /**
     *
     * @var integer
     */
    public $id_financing;

    /**
     *
     * @var integer
     */
    public $id_extension;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("extension_project");
        $this->belongsTo('id_extension', 'Extension', 'id', ['alias' => 'Extension']);
        $this->belongsTo('id_financing', 'inancingType', 'id', ['alias' => 'FinancingType']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'extension_project';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ExtensionProject[]|ExtensionProject|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ExtensionProject|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
