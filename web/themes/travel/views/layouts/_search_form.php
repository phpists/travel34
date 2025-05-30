<?php
/* @var $this FrontEndController */
?>
<form action="<?= $this->createUrl('/search/results') ?>" method="get" class="search-form">
    <div class="form-wrap">
        <input type="text" name="text" placeholder="" required="">
    </div>
    <button type="submit"></button>
</form>
