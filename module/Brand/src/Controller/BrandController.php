<?php
namespace Brand\Controller;

use Brand\Model\BrandTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Brand\Form\BrandForm;
use Brand\Model\Brand;

class BrandController extends AbstractActionController
{
    private $table;

    public function __construct(BrandTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction()
    {
        return new ViewModel([
            'brands' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new BrandForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $brand = new Brand();
        $form->setInputFilter($brand->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $brand->exchangeArray($form->getData());
        $this->table->saveBrand($brand);
        return $this->redirect()->toRoute('brand');
    }

    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('brand', ['action' => 'add']);
        }


        try {
            $brand = $this->table->getBrand($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('brand', ['action' => 'index']);
        }

        $form = new BrandForm();
        $form->bind($brand);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($brand->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveBrand($brand);
        } catch (\Exception $e) {
        }

        return $this->redirect()->toRoute('brand', ['action' => 'index']);
        
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('brand');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteBrand($id);
            }

            return $this->redirect()->toRoute('brand');
        }

        return [
            'id'    => $id,
            'brand' => $this->table->getBrand($id),
        ];
    }
}
