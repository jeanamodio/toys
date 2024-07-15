<?php
namespace Toy\Form;

use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Date;
use Laminas\Form\Element\Select;
use Laminas\Form\Form;

class ToyForm extends Form
{
    protected $brands;

    public function __construct($name = null, $brands = [])
    {
        parent::__construct('toy');
        $this->brands = $brands;

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
            'name' => 'date_add',
            'type' => Date::class,
            'options' => [
                'label' => 'Date',
            ],
            'attributes' => [
                'value' => date('Y-m-d'),
            ],
        ]);

        $this->add([
            'name' => 'id_brand',
            'type' => Select::class,
            'options' => [
                'label' => 'Brand',
                'value_options' => $this->getBrandsForSelect(),
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

    protected function getBrandsForSelect()
    {
        $brands = [];
        foreach ($this->brands as $brand) {
            $brands[$brand->id] = $brand->name;
        }
        print_r($brands);
        return $brands;
    }
}
