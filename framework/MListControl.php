<?php

class MListControl
{

    private $postFilters;

    public function __construct()
    {
        $listControlName = get_called_class();
        $listViewName = str_replace('Control', 'View', $listControlName);

        $this->postFilters = $this->getFiltersFromPost();
    }

    public function getFiltersFromPost()
    {
        return arrayToObject($_POST);
    }

    public function search()
    {
        var_dump($this->postFilters);
    }

}

?>