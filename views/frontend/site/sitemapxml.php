<?php
/** @var $list array */
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($list as $row) {
    echo "\t<url>\n";
    echo "\t\t<loc>" . CHtml::encode($row['loc']) . "</loc>\n";
    echo "\t\t<changefreq>" . $row['frequency'] . "</changefreq>\n";
    echo "\t\t<priority>" . $row['priority'] . "</priority>\n";
    if (!empty($row['lastmod'])) {
        echo "\t\t<lastmod>" . CHtml::encode($row['lastmod']) . "</lastmod>\n";
    }
    echo "\t</url>\n";
}
echo "</urlset>\n";
