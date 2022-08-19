TYPE=VIEW
query=select `tirtash_db`.`xxuser_username`.`xusernameid` AS `xusernameid`,`tirtash_db`.`xxuser_username`.`xusername` AS `xusername` from `tirtash_db`.`xxuser_username` where (`tirtash_db`.`xxuser_username`.`xuserstatus` = _utf8\'Active\')
md5=935ede9ee92eb96984d0ce6ad9bdcfbb
updatable=1
algorithm=0
definer_user=root
definer_host=%
suid=2
with_check_option=0
timestamp=2022-08-09 19:10:07
create-version=1
source=select `xxuser_username`.`xusernameid` AS `xusernameid`,`xxuser_username`.`xusername` AS `xusername` from `xxuser_username` where (`xxuser_username`.`xuserstatus` = _utf8\'Active\')
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_unicode_ci
view_body_utf8=select `tirtash_db`.`xxuser_username`.`xusernameid` AS `xusernameid`,`tirtash_db`.`xxuser_username`.`xusername` AS `xusername` from `tirtash_db`.`xxuser_username` where (`tirtash_db`.`xxuser_username`.`xuserstatus` = \'Active\')
