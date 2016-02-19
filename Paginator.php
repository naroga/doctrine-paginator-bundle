<?php

namespace Naroga\DoctrinePaginatorBundle;

use Doctrine\ORM\QueryBuilder;

/**
 * Class Paginator
 * @package Naroga\DoctrinePaginatorBundle\Service
 */
class Paginator
{
    /**
     * Paginates the QueryBuilder
     *
     * @param QueryBuilder $queryBuilder    A QueryBuilder to be paginated.
     * @param string $countableProperty     A property name ('q.id', for example), to count.
     * @param int $maxResults               Maximum number of results (defaults to 10).
     * @param int $page                     The page number (defaults to 1).
     * @return Page                         The paginated resultset.
     */
    public function paginate(QueryBuilder $queryBuilder, $countableProperty, $page = 1, $maxResults = 10)
    {
        if (strtolower($page) == 'all') {
            $items = $queryBuilder->getQuery()->getResult();
            $total = count($items);
            $pages = 1;
        } else {
            $totalQueryBuilder = clone $queryBuilder;

            $total = $totalQueryBuilder
                ->select('COUNT(' . $countableProperty . ')')
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
