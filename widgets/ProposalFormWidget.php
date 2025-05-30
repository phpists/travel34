<?php

class ProposalFormWidget extends CWidget
{
    public $blockName = 'ruletka_form_result';
    public $formType = 'roulette';

    public function run()
    {
        $model = new ProposalForm();
        $model->form_type = $this->formType;
        $this->render('proposalForm', [
            'model' => $model,
            'blockName' => $this->blockName,
        ]);
    }
}
