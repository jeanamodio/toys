<?php
namespace Toy\Controller;

use Toy\Model\ToyTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Toy\Form\ToyForm;
use Toy\Model\Toy;

use Brand\Model\Brand;
use Brand\Model\BrandTable;

class ToyController extends AbstractActionController
{
    private $table;
    private $brandTable;

    public function __construct(ToyTable $table, BrandTable $brandTable)
    {
        $this->table = $table;
        $this->brandTable = $brandTable;
    }
    
    public function indexAction()
    {
        return new ViewModel([
            'toys' => $this->table->fetchAll(),
        ]);

    }

    public function addAction()
    {

        $brands = $this->brandTable->fetchAll();
        $form = new ToyForm(null,$brands);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $toy = new Toy();
        $form->setInputFilter($toy->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $toy->exchangeArray($form->getData());
        $this->table->saveToy($toy);
        return $this->redirect()->toRoute('toy');
    }

    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('toy', ['action' => 'add']);
        }

        $brands = $this->brandTable->fetchAll();


        try {
            $toy = $this->table->getToy($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('toy', ['action' => 'index']);
        }

        $form = new ToyForm(null, $brands);
        $form->bind($toy);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($toy->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveToy($toy);
        } catch (\Exception $e) {
        }

        return $this->redirect()->toRoute('toy', ['action' => 'index']);
        
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('toy');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteToy($id);
            }

            return $this->redirect()->toRoute('toy');
        }

        return [
            'id'    => $id,
            'toy' => $this->table->getToy($id),
        ];
    }
}
