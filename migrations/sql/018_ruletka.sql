INSERT INTO `tr_block` (`name`, `description`, `content`) VALUES
('ruletka_intro_text', 'Рулетка интро-текст', '<p><strong>Если направление твоих трипов все еще задают дешевые билеты Ryanair, пора попробовать кое-что новенькое – вместе с картой «Бумеранг» Visa Gold от Приорбанка мы создали рулетку приключений для любителей авантюр. Выбирай, чем ты хочешь заняться – бросить вызов себе или, наоборот, почиллить в тишине, время года, когда собираешься ехать – и вперед, навстречу приключениям!</strong></p>'),
('ruletka_form_text', 'Рулетка: текст возле формы', '<h4><span>Чем тебе может помочь в путешествии карта «Бумеранг» Visa Gold?</span></h4>\r\n<p>Карта «Бумеранг» Visa Gold гарантирует тебе money-back – 1% на счет с любых покупок. Пополнять карту можно бесплатно – с другой карты или ЕРИП, вместе с «Бумерангом» ты получаешь страховку для выезда за границу. Подать заявку на карту можно прямо здесь.</p>'),
('ruletka_form_result', 'Рулетка: текст после отправки формы', '<h3><span>Все правильно сделал(-а)!</span></h3>\r\n<p>Осталось немного подождать, и сотрудник Приорбанка свяжется с тобой, чтобы закончить процесс оформления карты «Бумеранг».</p>');

DROP TABLE IF EXISTS `tr_proposal`;

CREATE TABLE `tr_proposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_type` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
