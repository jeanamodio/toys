<?php
namespace Category\Form;

use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Date;
use Laminas\Form\Form;

class CategoryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('category');

        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
        ]);
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'name',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
