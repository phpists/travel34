--- type_id = 2 - guide
--- type_id = 4 - post
--- rubric_id = 13 - 2 days in city
UPDATE tr_post SET type_id = 5, rubric_id = NULL WHERE type_id = 4 AND rubric_id = 13;
