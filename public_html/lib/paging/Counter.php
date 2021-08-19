<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 22/04/2016
 * Time: 18:34
 */

namespace paging;


class Counter
{
    private $totalResults, $page, $perPage, $pageCount;

    public function __construct($totalResults, $page, $perPage){
        $this->totalResults = (int) $totalResults;
        $this->page = (int) $page;
        $this->perPage = (int) $perPage;

        $this->pageCount = ceil($totalResults / $perPage);
    }

    private function getLink($toPage){
        //Create links
        $gets = $_GET;
        $gets['page'] = $toPage;

        $params = [];
        foreach ($gets as $key => $value) {
            $params[] = "$key=$value";
        }

        return '?' . join('&', $params);
    }

    public function getButtons(){
        $buttons = [];

        //First button
        if ($this->page != 1) $buttons[] = ['text' => '<span class="icon-chevron-left"></span>Prev', 'href' => $this->getLink($this->page - 1), 'class' => 'prev'];

        for ($i = 1; $i <= $this->pageCount; $i++){

            //todo: Build in a check that says
            // if $i is more than 5 away (either up or down) from $page, continue.
            //if (abs($this->page - $i) > 2) continue;
            $button = [];
            $button['text'] = $i;
            $button['class'] = ($this->page == $i) ? 'page active' : "page";
            $button['href'] = $this->getLink($i);
            $buttons[] = $button;
        }

        //Last button
        if ($this->pageCount != $this->page) $buttons[] = ['text' => 'Next<span class="icon-chevron-right"></span>', 'href' => $this->getLink($this->page + 1), 'class' => 'next'];

        return $buttons;
    }

}
