<?php

namespace Svi\OrmBundle;

interface ManagerInterface
{

    public function getEntityClassName();

    public function createEntity();

    public function findOneBy(array $criteria = [], array $orderBy = null, $noCache = null);

    public function findBy(array $criteria = [], array $orderBy = null, $limit = null, $offset = null, $noCache = null);

    public function delete(Entity $entity);

    public function save(Entity $entity);

    public function getFieldValue(Entity $entity, $fieldName);

    public function setFieldValue(Entity $entity, $fieldName, $value);

    public function fillByData(array $data, Entity $entity = null);

    public function getListByData(array $data);

    public function getDataArray(Entity $entity, $onlyChanged = false, $updateLoadedData = false);

}