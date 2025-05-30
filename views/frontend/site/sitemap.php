<?php
/** @var $list array */
foreach ($list as $row) {
    echo '<ul>';
    echo '<li>' . CHtml::link($row['loc'], $row['loc']) . '</li>';
    echo '</ul>';
}
