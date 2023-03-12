<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mario@raval.li so I can send you a copy immediately.
 *
 * @author    Mario Ravalli <mario@raval.li>
 * @copyright Since 2023 Mario Ravalli
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace MyModule\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class MyModuleBoilerRepository
{
    const DEFAULT_PRODUCTS_PER_PAGE = 5;

    /**
     * @var Connection the Database connection
     */
    private $connection;

    /**
     * @var string the Database prefix
     */
    private $databasePrefix;

    public function __construct(
        Connection $connection,
        $databasePrefix
    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
    }

    /**
     * @param int $page
     * @param int $productsPerPage
     *
     * @return array
     */
    public function paginate($page, $productsPerPage)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->addSelect('pb.id_mymodule_boiler, pb.boiler')
            ->from($this->databasePrefix . 'mymodule_boiler', 'pb')
            ->setMaxResults($productsPerPage)
            ->setFirstResult(($page - 1) * $productsPerPage);

        return $qb->execute()->fetchAll();
    }
}
