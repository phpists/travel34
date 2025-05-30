<?php

class SitePager extends CLinkPager
{
    public $wrapperCssClass = 'b-nav';

    public $nextMobilePageCssClass = 'b-nav__more b-nav__more-mobile';

    public $previousPageCssClass = 'b-nav__list__prev';

    public $nextPageCssClass = 'b-nav__list__next';

    public $maxButtonCount = 8;

    public $nextPageLabel = '';

    public $prevPageLabel = '';

    public $header = '';

    public $htmlOptions = array('class' => 'b-nav__list');

    public $showMoreText = 'Show More';

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $buttons = $this->createPageButtons();
        if (empty($buttons)) return;
        echo CHtml::openTag('div', array('class' => $this->wrapperCssClass)) . "\n";
        if ($this->getCurrentPage(false) < $this->pageCount - 1) {
            $link = CHtml::link(CHtml::tag('span', array(), $this->showMoreText), $this->createPageUrl($this->getCurrentPage(false) + 1));
            echo CHtml::tag('div', array('class' => $this->nextMobilePageCssClass), $link) . "\n";
        }
        echo CHtml::tag('div', $this->htmlOptions, implode(' ', $buttons)) . "\n";
        echo CHtml::closeTag('div');
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
        if (($page = $currentPage - 1) < 0)
            $page = 0;
        if ($currentPage > 0) {
            $buttons[] = CHtml::link('', $this->createPageUrl($page), array('class' => $this->previousPageCssClass));
            $buttons[] = '<span class="b-nav__list__separe"></span>';
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
        if (($page = $currentPage + 1) >= $pageCount - 1)
            $page = $pageCount - 1;
        if ($currentPage < $pageCount - 1) {
            $buttons[] = '<span class="b-nav__list__separe"></span>';
            $buttons[] = CHtml::link('', $this->createPageUrl($page), array('class' => $this->nextPageCssClass));
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
        if ($selected) {
            return CHtml::tag('b', array('class' => 'current'), $label);
        }
        if ($hidden) {
            return CHtml::tag('b', array(), $label);
        }
        return CHtml::link($label, $this->createPageUrl($page));
    }
}
