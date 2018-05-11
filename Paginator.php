<?php

namespace Naroga\DoctrinePaginatorBundle;

use Doctrine\ORM\QueryBuilder;
use Naroga\DoctrinePaginatorBundle\Exception\InvalidArgumentException;

/**
 * Class Paginator
 * @package Naroga\DoctrinePaginatorBundle\Service
 */
class Paginator
{
    /**
     * Paginates the QueryBuilder
     *
     * @param QueryBuilder $queryBuilder                A QueryBuilder to be paginated.
     * @param int $maxResults                           Maximum number of results (defaults to 10).
     * @param int $page                                 The page number (defaults to 1).
     * @return Page                                     The paginated resultset.
     * @throws \Doctrine\ORM\NonUniqueResultException   In case multiple records get returned on the COUNT(*) query.
     * @throws InvalidArgumentException                 In case any of the arguments are invalid.
     */
    public function paginate(QueryBuilder $queryBuilder, $page = 1, $maxResults = 10)
    {
        if (!is_numeric($page) || $page < 1) {
            throw new InvalidArgumentException("Argument \$page needs to be an integer, grater than 0");
        }

        if (!is_numeric($maxResults) || $maxResults < 1) {
            throw new InvalidArgumentException("Argument \$maxResults needs to be an integer, grater than 0");
        }

        if (strtolower($page) == 'all') {
            $items = $queryBuilder->getQuery()->getResult();
            $total = count($items);
            $pages = 1;
        } else {
            $totalQueryBuilder = clone $queryBuilder;

            $total = $totalQueryBuilder
                ->select("COUNT('*')")
                ->getQuery()
                ->getSingleScalarResult();

            if ($page !== 'all') {
                $queryBuilder
                    ->setMaxResults($maxResults)
                    ->setFirstResult(($page - 1) * $maxResults);
            }

            $items = $queryBuilder
                ->getQuery()
                ->getResult();

            $pages = $page === 'all' ? 0 : max(ceil($total/$maxResults), 1);
        }

        return Page::create($page, $total, count($items), $pages, $items);
    }
}
