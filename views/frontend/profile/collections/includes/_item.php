<div class="collections__item col-12 col-us-6 col-sm-6 col-md-4 col-lg-3">
    <a href="<?= $this->createUrl('/profile/', ['collection' => $collection->id]) ?>" class="collections__item_wrap">
        <div class="collections__item_img">
            <img src="<?= $collection->getPostImage() ?>"/>
        </div>
        <div class="collections__item__header"><span><?= $collection->title ?></span></div>
        <?php if (count($collection->userCollections) <= 0): ?>
            <div class="collections__item_bottom">
                <div class="collections__faves_empty">
                    <span></span>
                    0
                </div>
                <object>
                    <a href="#form_edit" data-collection_id="<?= $collection->id ?>"
                       class="collections__faves_edit popup-with-form editCollection">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11.3085 2.21704L13.7834 4.69191L5.00417 13.4711L2.5293 10.9962L11.3085 2.21704Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M2.52892 10.9961L1.29167 14.7084L5.004 13.4712L2.52892 10.9961V10.9961Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M13.7832 4.6914L11.3087 2.2169L11.7211 1.80448C12.4077 1.14128 13.4992 1.15076 14.1743 1.8258C14.8493 2.50083 14.8588 3.59232 14.1956 4.27898L13.7832 4.6914Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </object>
            </div>
        <?php else: ?>
            <div class="collections__item_bottom faves_empty">
                <div class="collections__faves_full">
                    <span></span>
                    <?= count($collection->userCollections) ?>
                </div>
                <object>
                    <a href="#form_edit" data-collection_id="<?= $collection->id ?>"
                       class="collections__faves_edit popup-with-form editCollection">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11.3085 2.21704L13.7834 4.69191L5.00417 13.4711L2.5293 10.9962L11.3085 2.21704Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M2.52892 10.9961L1.29167 14.7084L5.004 13.4712L2.52892 10.9961V10.9961Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M13.7832 4.6914L11.3087 2.2169L11.7211 1.80448C12.4077 1.14128 13.4992 1.15076 14.1743 1.8258C14.8493 2.50083 14.8588 3.59232 14.1956 4.27898L13.7832 4.6914Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </object>
            </div>
        <?php endif; ?>
    </a>
</div>