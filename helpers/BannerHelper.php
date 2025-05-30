<?php

declare(strict_types=1);

class BannerHelper
{
    public static function getHtml(Banner $banner): string
    {
        if ($banner->image === '') {
            return static::getOldBannerHtml($banner);
        }

        $attributes = (boolean)$banner->open_new_tab === true ? ['target' => '_blank'] : [];

        return CHtml::link(
            CHtml::image($banner->getImageUrl('image')),
            $banner->url,
            $attributes
        );
    }

    protected static function getOldBannerHtml(Banner $banner): string
    {
        if (trim($banner->code) !== '') {
            return $banner->code;
        }

        if (trim($banner->content) !== '') {
            return $banner->content;
        }

        return '';
    }
}