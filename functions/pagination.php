<?php
function pagination($item_count, $limit, $cur_page, $link)
{
       $page_count = ceil($item_count/$limit);
       if($cur_page - 1 <= 0 )
       {
            array_push($arrows, 1);
       }
       else
       {
           array_push($arrows, $cur_page - 2);
       }
       if($cur_page+2 > $page_count)
       {
            array_push($arrows, $page_count);
       }
       else
       {
            array_push($arrows, $cur_page + 2);
       }
       //$arrows = array(($cur_page-2 < 1 ? 1 : $cur_page-2), ($cur_page+2 > $page_count ? $page_count : $cur_page+2));

       // First and Last pages
       $first_page = $cur_page > 3 ? '<a href="'.sprintf($link, '1').'">1</a>'.($cur_page < 5 ? ', ' : ' ... ') : null;
       $last_page = $cur_page < $page_count-2 ? ($cur_page > $page_count-4 ? ', ' : ' ... ').'<a href="'.sprintf($link, $page_count).'">'.$page_count.'</a>' : null;

       // Previous and next page
       $previous_page = $cur_page > 1 ? '<a href="'.sprintf($link, ($cur_page-1)).'">Previous</a> | ' : null;
       $next_page = $cur_page < $page_count ? ' | <a href="'.sprintf($link, ($cur_page+1)).'">Next</a>' : null;

       // Display pages that are in range
       for ($x=$arrows[0];$x <= $arrows[1]; ++$x)
               $pages[] = '<a href="'.sprintf($link, $x).'">'.($x == $cur_page ? '<strong>'.$x.'</strong>' : $x).'</a>';

       if ($page_count > 1)
       {
        return '<p class="pagination"><strong>Pages:</strong> '.$previous_page.$first_page.implode(', ', $pages).$last_page.$next_page.'</p>';
       }
}
?>
