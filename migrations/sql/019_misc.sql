-- hide banner on post

ALTER TABLE `tr_post` ADD `hide_banners` tinyint(1) NOT NULL DEFAULT '0' AFTER `gtb_post_id`;

-- subscribe text

INSERT INTO `tr_block` (`name`, `description`, `content`) VALUES
('subscribe_text', 'Текст в блоке подписки', '<h2>ЛЮБИШЬ ПУТЕШЕСТВИЯ?</h2>\r\n<p>Подпишись на еженедельную рассылку!<br>\r\nСвежие идеи путешествий, содержательные гайды по городам мира, главные новости и акции с лучшими ценами на билеты.</p>'),
('subscribe_text_en', 'Текст в блоке подписки (EN)', '<h2>ЛЮБИШЬ ПУТЕШЕСТВИЯ?</h2>\r\n<p>Подпишись на еженедельную рассылку!<br>\r\nСвежие идеи путешествий, содержательные гайды по городам мира, главные новости и акции с лучшими ценами на билеты.</p>');

-- links to gtb

INSERT INTO `tr_block` (`name`, `description`, `content`) VALUES ('header_links_to_gtb', 'Ссылки на GTB', '<div class="links">\r\n    <a href="/rubrics/go-to-belarus">Go to<br>Belarus!</a>\r\n    <a href="/rubrics/edem-v-belarus">Едем в<br>Беларусь!</a>\r\n</div>');
