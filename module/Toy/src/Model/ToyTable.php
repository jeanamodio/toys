<?php
namespace Toy\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class ToyTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getToy($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveToy(Toy $toy)
    {
        $data = [
            'name' => $toy->name,
            'date_add'  => $toy->date_add,
            'id_brand'  => $toy->id_brand,
        ];

        $id = (int) $toy->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getToy($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteToy($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
