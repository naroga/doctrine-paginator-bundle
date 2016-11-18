# doctrine-paginator-bundle

Creates beautiful pagination objects for Doctrine.

## Installation

    $ composer require naroga/doctrine-paginator-bundle
    
## Usage

    <?php
    
    use Naroga\DoctrinePaginatorBundle\Paginator;
    
    $paginator = new Paginator;
    
    $qBuilder = $entityManager
        ->createQueryBuilder()
        ->select('q')
        ->from(MyEntity::class);
        
    $result = $paginator->paginate($qBuilder, 'q.id', 1, 10);
    
    var_dump($result); 
    
    /* Object (Page) { 
        page: 1, 
        totalItems: 58, 
        pageItems: 10, 
        totalPages: 6, 
        items: [...]
    }*/
    
    
