# LED-search

### 简介

这是某个LED标准查询的项目

### SQL表设计

```sql
drop table if exists LedRole;

/*==============================================================*/
/* Table: LedRole                                               */
/*==============================================================*/
create table LedRole
(
   RoleId               int not null auto_increment comment '权限角色Id',
   roletype             varchar(32) comment '权限角色类型',
   remark               varchar(256) comment '备注',
   isUsed               boolean comment '状态',
   createTime           datetime comment '创建时间',
   updatetime           datetime comment '更新时间',
   primary key (RoleId)
);

drop table if exists LedUser;

/*==============================================================*/
/* Table: LedUser                                               */
/*==============================================================*/
create table LedUser
(
   RoleId               int,
   uid                  int not null auto_increment comment '用户id',
   username             varchar(64) comment '用户名',
   nickname             varchar(64) comment '名字',
   pwd                  varchar(32) comment '密码',
   userStatus           boolean comment '用户状态',
   createTime           datetime comment '创建时间',
   updateTime           datetime comment '更新时间',
   email                varchar(255) comment '电子邮箱',
   unique key AK_username (uid, username)
);

alter table LedUser add constraint FK_Reference_30 foreign key (RoleId)
      references LedRole (RoleId) on delete restrict on update restrict;

drop table if exists LedStdEntity;

/*==============================================================*/
/* Table: LedStdEntity                                          */
/*==============================================================*/
create table LedStdEntity
(
   EntityId             int not null auto_increment,
   ArchId               int,
   SN                   varchar(20) comment '标准编号',
   StdLevel             int comment '标准层级',
   ChName               varchar(40) comment '中文名称',
   EnName               varchar(40) comment '英文名称',
   ReleaseDate          date comment '发布日期',
   ImpelementDate       date comment '实施日期',
   AlterStandard        varchar(40) comment '代替标准',
   AdoptNo              varchar(20) comment '采标号',
   AdoptName            varchar(40) comment '采标名称',
   AdoptLev             varchar(20) comment '采标程度',
   AdoptType            varchar(20) comment '采标类型',
   ICS                  varchar(20) comment 'ICS',
   CCS                  varchar(20) comment 'CCS',
   StandardType         varchar(20) comment '标准类型',
   DepartCharge         varchar(40) comment '主管部门',
   CtnLink              varchar(50) comment '全文链接',
   Abstract             text comment '摘要',
   primary key (EntityId)
);

alter table LedStdEntity add constraint FK_Reference_2 foreign key (ArchId)
      references LedStdArch (ArchId) on delete restrict on update restrict;

drop table if exists LedStdArch;

/*==============================================================*/
/* Table: LedStdArch                                            */
/*==============================================================*/
create table LedStdArch
(
   ArchId               int not null auto_increment,
   ParendArchId         int,
   ArchSN               varchar(20) comment '体系编号',
   ArchCode             varchar(20) comment '标准的代号和编号',
   StandardName         varchar(40) comment '标准名称',
   InterCode            varchar(20) comment '采用的或相应的国际、国外标准号',
   StdStatus            varchar(20) comment '标准状态',
   Remark               varchar(40) comment '备注',
   primary key (ArchId)
);

/*alter table LedStdArch comment 'Led标准体系表，生成标准框架展示模块';*/

/*==============================================================*/
/* Table: LedStdStatistic                                       */
/*==============================================================*/
create table LedStdStatistic
(
   id	                int not null auto_increment,
   Type					varchar(255) comment '分类文字',
   NationalNum			int comment '国内标准数量',
   InternationalNum		int comment '国外标准数量',
   primary key (id)
);
```