<?php
$admin_pass_hash = password_hash('isthereapass', PASSWORD_DEFAULT);
$user_pass_hash = password_hash('abc', PASSWORD_DEFAULT);
$disable_pass_hash = password_hash('disable', PASSWORD_DEFAULT);

$conn = mysqli_connect('localhost', 'root', '', 'led_search');
mysqli_set_charset($conn, 'utf8');
if (mysqli_multi_query($conn, $insert_userdata_sql)) {
	echo 'create tables successful!<br />';
} else {
	die(mysqli_error($conn));
}

$insert_userdata_sql = 'INSERT INTO LedRole (
	`roletype`, `remark`        ,`createTime`, `updateTime`
) VALUES (
	"管理员"  , "最高权限拥有者", NOW()      , NOW()
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                    , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	1       , "admin"   ,"' . $admin_pass_hash . '", "admin"   , "enable"    , NOW()       , NOW()       , "admin@led.cn"
);

INSERT INTO LedRole (
	`roletype`, `remark`, `createTime`, `updateTime`
) VALUES (
	"一般用户", ""      , NOW()       , NOW()
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                   , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	2       , "abc"     ,"' . $user_pass_hash . '", "abc"     , "enable"    , NOW()       , NOW()       , "abc@led.cn"
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                      , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	2       , "disable" ,"' . $disable_pass_hash . '", "disable"     , "disable"    , NOW()       , NOW()       , "disable@led.cn"
);

INSERT INTO LedRole (
	`roletype`, `remark`, `createTime`, `updateTime`
) VALUES (
	"VIP用户", ""      , NOW()       , NOW()
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                      , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	3       , "vip" ,"' . $user_pass_hash . '", "vip"     , "enable"    , NOW()       , NOW()       , "vip@led.cn"
);
';

echo $admin_pass_hash . '<br>';
echo $user_pass_hash . '<br>'; 
?>