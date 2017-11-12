<?php

namespace Svi\OrmBundle\Console;

use Doctrine\DBAL\Schema\Schema;
use Svi\OrmBundle\Manager;
use Svi\Service\ConsoleService\ConsoleCommand;

class EntityUpdateCommand extends ConsoleCommand
{

	public function getName()
	{
		return 'db:update';
	}

	public function getDescription()
	{
		return 'List an SQL which need to update of database schema';
	}

	public function execute(array $args)
	{
		$execute = in_array('--execute', $args);

		$updates = $this->getUpdateSchemaSql();
		$needUpdate = false;
		foreach ($updates as $key => $sqls) {
			if (!count($sqls)) {
				$this->writeLn('There is no updates for schema "' . $key . '"');
			} else {
				$needUpdate = true;
			}
		}

		if ($needUpdate) {
			if (!$execute) {
				$this->writeLn('This SQL commans need to be executed to synchronize database.');
				$this->writeLn('You can execute it manual or run command: "php app/console db:update --execute"');
				$this->writeLn(strtoupper('P.S. Making database backup will be a good idea!'));
				$this->writeLn();
			} else {
				$this->writeLn('Executing commands:');
			}
			foreach ($updates as $key => $sqls) {
				$this->writeLn('For schema "' . $key . '":');
				$this->writeLn('=============================');
				foreach ($sqls as $sql) {
					$sql .= ';';
					$this->writeLn();
					$this->writeLn($sql);
					if ($execute) {
						$this->getApp()['dbs'][$key]->exec($sql);
					}
				}
			}
		}
	}

	protected function getUpdateSchemaSql()
	{
        /** @var Schema[] $schemas */
        $schemas = [];
	    $managers = [];

        foreach ($this->getApp() as $value) {
            if ($value instanceof Manager) {
                $managers[] = $value;
            }
        }

		foreach ($managers as $manager) {
			$manager->getTableSchema();
			$schemas[$manager->getSchemaName()] = $manager->getDbSchema();
		}

		$sqls = [];
		foreach ($schemas as $key => $schema) {
			$dbSchema = $this->getApp()['dbs'][$key]->getSchemaManager()->createSchema();
			$sqls[$key] = $schema->getMigrateFromSql($dbSchema, $this->getApp()['dbs'][$key]->getDatabasePlatform());
		}

		return $sqls;
	}

} 