<?php
function displayPageOptions($currentPageNumber, $totalRecords, $limit)
{
    $previousPage = $currentPageNumber - 1;
    $nextPage = $currentPageNumber + 1;
    $maxNumberOfPages = ceil($totalRecords/$limit);


    echo('<div class="row mt-4">
            <div class="col-12 text-center">
                <form action="" method="GET">
    ');

    if($currentPageNumber == 1)
    {
        echo('<button type="submit" class="btn btn-outline-dark" name="pageNumber" value="1" disabled><</button>');

    }
    else
    {
        echo('<button type="submit" class="btn btn-outline-primary" name="pageNumber" value="'. $previousPage . '"><</button>');
        echo('<button type="submit" class="btn btn-outline-primary" name="pageNumber" value="1">1</button>');
    }


    if($currentPageNumber >= 4)
    {
        echo('<button type="submit" class="btn btn-outline-dark" name="pageNumber" value="1" disabled>...</button>');
    }

    if($currentPageNumber != 1 && $previousPage != 1)
    {
        echo('<button type="submit" class="btn btn-outline-primary" name="pageNumber" value="'. $previousPage . '">'.$previousPage.'</button>');
    }

    echo('<button type="submit" class="btn btn-primary" name="pageNumber" value="'. $currentPageNumber . '">'.$currentPageNumber.'</button>');

    if(!($nextPage >= $maxNumberOfPages))
    {
        echo('<button type="submit" class="btn btn-outline-primary" name="pageNumber" value="'. $nextPage . '">'.$nextPage.'</button>');
    }

    if($currentPageNumber <= ($maxNumberOfPages - 3))
    {
        echo('<button type="submit" class="btn btn-outline-dark" name="pageNumber" value="1" disabled>...</button>');
    }



    if($currentPageNumber >= $maxNumberOfPages)
    {
        echo('<button type="submit" class="btn btn-outline-dark" name="pageNumber" value="1" disabled>></button>');
    }
    else
    {
        echo('<button type="submit" class="btn btn-outline-primary" name="pageNumber" value="'. $maxNumberOfPages . '">'.$maxNumberOfPages.'</button>');
        echo('<button type="submit" class="btn btn-outline-primary" name="pageNumber" value="'. $nextPage . '">></button>');
    }









    echo('  </form>
            </div>
            </div>
    ');

}
