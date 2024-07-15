<?php
namespace Brand\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class BrandTable
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

    public function getBrand($id)
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

    public function saveBrand(Brand $brand)
    {
        $data = [
            'name' => $brand->name,
        ];

        $id = (int) $brand->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getBrand($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteBrand($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
