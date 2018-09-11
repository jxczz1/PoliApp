<?php


class AgreementHistory extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $achievement;

    /**
     *
     * @var integer
     */
    public $id_agreement;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("poliapp");
        $this->setSource("agreement_history");
        $this->belongsTo('id_agreement', 'Agreement', 'id', ['alias' => 'Agreement']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'agreement_history';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AgreementHistory[]|AgreementHistory|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AgreementHistory|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
