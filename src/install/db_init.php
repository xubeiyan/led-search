<?php
$admin_pass_hash = password_hash('isthereapass', PASSWORD_DEFAULT);
$user_pass_hash = password_hash('abc', PASSWORD_DEFAULT);
$disable_pass_hash = password_hash('disable', PASSWORD_DEFAULT);

$sql = 'DROP TABLE if exists LedRole;

CREATE TABLE LedRole
(
   RoleId               INT NOT NULL AUTO_INCREMENT COMMENT "权限角色Id",
   roletype             VARCHAR(32) COMMENT "权限角色类型",
   remark               VARCHAR(256) COMMENT "备注",
   createTime           DATETIME COMMENT "创建时间",
   updatetime           DATETIME COMMENT "更新时间",
   PRIMARY KEY (RoleId)
);

DROP TABLE if exists LedUser;

CREATE TABLE LedUser
(
   uid                  INT NOT NULL AUTO_INCREMENT COMMENT "用户id",
   RoleId               INT COMMENT "权限角色Id",
   username             VARCHAR(64) COMMENT "用户名",
   pwd                  VARCHAR(255) COMMENT "密码",
   nickname             VARCHAR(64) COMMENT "显示名称",
   userStatus           ENUM("enable", "disable", "toauth") DEFAULT "toauth" COMMENT "用户状态",
   createTime           DATETIME COMMENT "创建时间",
   updateTime           DATETIME COMMENT "更新时间",
   email                VARCHAR(255) COMMENT "电子邮箱",
   unique key AK_username (uid, username)
);

ALTER TABLE LedUser ADD CONSTRAINT FK_Reference_30 FOREIGN KEY (RoleId)
      REFERENCES LedRole (RoleId) ON DELETE RESTRICT ON UPDATE RESTRICT;

DROP TABLE if exists LedStdEntity;

CREATE TABLE LedStdEntity
(
   EntityId             INT NOT NULL AUTO_INCREMENT,
   ArchId               INT,
   StdNum               VARCHAR(20) COMMENT "标准编号",
   StdLevel             INT COMMENT "标准层级",
   ChName               VARCHAR(40) COMMENT "中文名称",
   EnName               VARCHAR(40) COMMENT "英文名称",
   ReleaseDate          DATE COMMENT "发布日期",
   ImpelementDate       DATE COMMENT "实施日期",
   AlterStandard        VARCHAR(40) COMMENT "代替标准",
   AdoptNo              VARCHAR(20) COMMENT "采标号",
   AdoptName            VARCHAR(40) COMMENT "采标名称",
   AdoptLev             VARCHAR(20) COMMENT "采标程度",
   AdoptType            VARCHAR(20) COMMENT "采标类型",
   ICS                  VARCHAR(20) COMMENT "ICS",
   CCS                  VARCHAR(20) COMMENT "CCS",
   StandardType         VARCHAR(20) COMMENT "标准类型",
   DepartCharge         VARCHAR(127) COMMENT "主管部门",
   DepartResponse		VARCHAR(127) COMMENT "归口单位",
   CtnLink              VARCHAR(255) COMMENT "全文链接",
   Abstract             TEXT COMMENT "摘要",
   PRIMARY KEY (EntityId)
);

ALTER TABLE LedStdEntity ADD CONSTRAINT FK_Reference_2 FOREIGN KEY (ArchId)
      REFERENCES LedStdArch (ArchId) ON DELETE RESTRICT ON UPDATE RESTRICT;

DROP TABLE IF EXISTS LedStdArch;

CREATE TABLE LedStdArch
(
   ArchId               INT NOT NULL AUTO_INCREMENT,
   ParendArchId         INT,
   ArchSN               VARCHAR(20) COMMENT "体系编号",
   ArchCode             VARCHAR(20) COMMENT "标准的代号和编号",
   StandardName         VARCHAR(40) COMMENT "标准名称",
   InterCode            VARCHAR(20) COMMENT "采用的或相应的国际、国外标准号",
   StdStatus            VARCHAR(20) COMMENT "标准状态",
   Remark               VARCHAR(40) COMMENT "备注",
   PRIMARY KEY (ArchId)
);

INSERT INTO LedRole (
	`roletype`, `remark`        ,`createTime`, `updateTime`
) VALUES (
	"管理员"  , "最高权限拥有者", NOW()      , NOW()
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                    , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	1       , "admin"   ,"' . $admin_pass_hash . '", "admin"   , "enable"    , NOW()       , NOW()       , ""
);

INSERT INTO LedRole (
	`roletype`, `remark`, `createTime`, `updateTime`
) VALUES (
	"一般用户", ""      , NOW()       , NOW()
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                   , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	2       , "abc"     ,"' . $user_pass_hash . '", "abc"     , "enable"    , NOW()       , NOW()       , ""
);

INSERT INTO LedUser (
	`RoleId`, `username`, `pwd`                      , `nickname`, `userStatus`, `createTime`, `updateTime`, `email`
) VALUES (
	2       , "disable" ,"' . $disable_pass_hash . '", "disable"     , "disable"    , NOW()       , NOW()       , ""
);
';


$conn = mysqli_connect('localhost', 'root', '', 'led_search');
mysqli_set_charset($conn, 'utf8');
if (mysqli_multi_query($conn, $sql)) {
	echo 'create tables successful!<br />';
} else {
	die(mysqli_error($conn));
}

echo $admin_pass_hash . '<br>';
echo $user_pass_hash . '<br>'; 
?>