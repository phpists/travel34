--- проверить неправильные rubric_id
select id, rubric_id from tr_post where not exists (select * from tr_rubric where tr_rubric.id = tr_post.rubric_id) and rubric_id is not null;
select id, gtb_rubric_id from tr_gtb_post where not exists (select * from tr_gtb_rubric where tr_gtb_rubric.id = tr_gtb_post.gtb_rubric_id) and gtb_rubric_id is not null;

ALTER TABLE `tr_post` ADD FOREIGN KEY (`rubric_id`) REFERENCES `tr_rubric` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
ALTER TABLE `tr_gtb_post` ADD FOREIGN KEY (`gtb_rubric_id`) REFERENCES `tr_gtb_rubric` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
