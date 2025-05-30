<?php

class ProposalForm extends CFormModel
{
    public $name;
    public $phone;
    public $form_type;
    public $confirmed;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name, phone', 'required'],
            ['name, phone, form_type', 'length', 'max' => 100],
            ['confirmed', 'boolean'],
            ['confirmed', 'errorIfEmpty'],
        ];
    }

    /**
     * @param string $attribute
     */
    public function errorIfEmpty($attribute)
    {
        if ($this->$attribute != '1') {
            $this->addError($attribute, 'Примите условия обработки персональных данных.');
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Номер телефона',
        ];
    }

    /**
     * @return bool
     */
    public function saveData()
    {
        $model = new Proposal();
        $model->form_type = $this->form_type;
        $model->name = $this->name;
        $model->phone = $this->phone;
        return $model->save();
    }
}
