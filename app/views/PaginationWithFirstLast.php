
<?php
class PaginationWithFirstLast extends \Illuminate\Pagination\BootstrapPresenter
{

    public function render()
    {

        if ($this->lastPage < 6) {
            $content = $this->getPageRange(1, $this->lastPage);
        } else {
            $content = $this->getPageSlider();
        }

        return $this->getFirst().$this->getPrevious().$content.$this->getNext().$this->getLast();
    }

    protected function getPageSlider()
    {
        $window = 2;

        if ($this->currentPage <= $window)
        {
            $ending = $this->getFinish();

            return $this->getPageRange(1, $window + 2).$ending;
        }

       elseif ($this->currentPage >= $this->lastPage - $window)
        {
            $start = $this->lastPage - ($window +1);

            $content = $this->getPageRange($start, $this->lastPage);

            return $this->getStart().$content;
        }

        else
        {
            $content = $this->getAdjacentRange();

            return $this->getStart().$content.$this->getFinish();
        }
    }


    public function getFirst()
    {
        $text = Lang::get('pagination.first');
        if ($this->currentPage <= 1) {
            return '<li class="disabled"><span>'.$text.'</span></li>';
        } else {
            $url = $this->paginator->getUrl(1);
            return '<li><a href="'.$url.'">'.$text.'</a></li>';
        }
    }

    public function getLast()
    {
        $text = Lang::get('pagination.last');
        if ($this->currentPage >= $this->lastPage) {
            return '<li class="disabled"><span>'.$text.'</span></li>';
        } else {
            $url = $this->paginator->getUrl($this->lastPage);
            return '<li><a href="'.$url.'">'.$text.'</a></li>';
        }
    }
}?>
<?php

$presenter = new PaginationWithFirstLast($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="pagination">
        <?php echo $presenter->render(); ?>

    </ul>
<?php endif; ?>