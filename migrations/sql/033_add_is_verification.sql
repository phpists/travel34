alter table tr_user add column  is_verification boolean default 0 after role;
update tr_user set tr_user.is_verification = 1 where id > 0;

ALTER TABLE tr_user ADD CONSTRAINT unique_email UNIQUE (email);
CREATE UNIQUE INDEX idx_unique_email ON tr_user (email);

alter table tr_user add column  is_social boolean default 0 after is_verification;
