<?php

class GtbPager extends CLinkPager
{
    public $previousPageCssClass = 'prev';

    public $nextPageCssClass = 'next';

    public $maxButtonCount = 7;

    public $nextPageLabel = '';

    public $prevPageLabel = '';

    public $header = '';

    public $htmlOptions = array();

    public $firstPageCssClass = '';

    public $lastPageCssClass = '';

    public $internalPageCssClass = '';

    public $selectedPageCssClass = 'current';

    /**
     * Initializes the pager by setting some default property values.
     */
    public function init()
    {
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $buttons = $this->createPageButtons();
        if (empty($buttons)) {
            return;
        }
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
    }

    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1) {
            return array();
        }

        list($beginPage, $endPage) = $this->getPageRange();
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons = array();

        // prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }
        if ($currentPage > 0) {
            $buttons[] = $this->createPageButton($this->prevPageLabel, $page, $this->previousPageCssClass, false, false);
        }

        // first page
        if ($beginPage > 0) {
            $buttons[] = $this->createPageButton(1, 0, $this->firstPageCssClass, false, false);
        }
        if ($beginPage > 1) {
            $buttons[] = $this->createPageButton('...', 0, '', true, false);
        }

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
        }

        // last page
        if ($endPage < $pageCount - 2) {
            $buttons[] = $this->createPageButton('...', 0, '', true, false);
        }
        if ($endPage < $pageCount - 1) {
            $buttons[] = $this->createPageButton($pageCount, $pageCount - 1, $this->lastPageCssClass, false, false);
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }
        if ($currentPage < $pageCount - 1) {
            $buttons[] = $this->createPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, false, false);
        }

        return $buttons;
    }

    /**
     * Creates a page button.
     * You may override this method to customize the page buttons.
     *
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $hidden whether this page button is visible
     * @param boolean $selected whether this page button is selected
     *
     * @return string the generated button
     */
    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden || $selected) {
            $link = CHtml::tag('span', array(), $label);
        } else {
            $link = CHtml::link($label, $this->createPageUrl($page));
        }
        if ($selected) {
            $class .= ' ' . $this->selectedPageCssClass;
        }
        $class = trim($class);
        return '<li' . (!empty($class) ? ' class="' . $class . '"' : '') . '>' . $link . '</li>';
    }
}
