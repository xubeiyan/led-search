<?php
$datasql = 'INSERT INTO LedStdEntity (
	ArchId, StdNum           , StdLevel  , Category, ChName                     ,
	EnName                                                , 
	ReleaseDate, ImpelementDate, StdStatus , AlterStandard, AdoptNo, 
	AdoptName, AdoptLev, AdoptType, ICS        , CCS  , StandardType, 
	ProductType, DepartCharge           , DepartResponse                       , AnnounceNum ,
	CtnLink                                                                             , Abstract
) VALUES (
	1     , "GB/T 31111-2014", "国家标准", ""      , "反射型自镇流LED灯规格分类", 
	"Classification of self-ballasted LED reflector lamps",
	"2014/9/3" , "2015/8/1"    , "现行有效", ""           , ""     , ""       , ""      , "无"     , "29.140.99", "K71", "产品"      ,
	"LED光源"  ,"中国轻工业联合会(607)", "全国照明电器标准化技术委员会(TC224)", "2014年第21号",
	"http://c.gb688.cn/bzgk/gb/showGb?type=online&hcno=8D850753CED321658C986E67A10EEBBF", 
	"本标准规定了用于替换PAR系列卤钨灯的反射型自镇流LED灯的规格分类。
    本标准适用于在家庭、商业和类似场合作为定向照明用，把稳定燃点部件集成为一体的发射型自镇流LED灯。
    适用范围如下：额定电压AC 220V 50Hz；符合GB/T 1406.1、GB/T 1406.2或GB/T 1406.5要求的灯头。
    本标准产品规格分类包括：外形规格、光束角规格、光通量规格、色调规格等4个方面。"
);

INSERT INTO LedStdEntity (
	ArchId, StdNum           , StdLevel  , Category, ChName                     ,
	EnName                                                , 
	ReleaseDate, ImpelementDate, StdStatus , AlterStandard, AdoptNo, 
	AdoptName, AdoptLev, AdoptType, ICS        , CCS  , StandardType, 
	ProductType, DepartCharge           , DepartResponse                       , AnnounceNum ,
	CtnLink                                                                             , Abstract
) VALUES (
	2     , "GB 24906-2010", "国家标准", ""      , "普通照明用50V以上自镇流LED灯　安全要求", 
	"Self-ballasted LED-Lamps for general lighting services >50V safety specifications",
	"2010/6/30" , "2011/2/1"    , "现行有效", ""           , ""     , ""       , ""      , "无"     , "29.140.99", "K71", "安全"      ,
	"LED光源"  ,"工业和信息化部(339)", "工业和信息化部(339)", "2010年第2号(总第157号)",
	"http://c.gb688.cn/bzgk/gb/showGb?type=online&hcno=CE96FF0C3C824C9ACAE3F331B3CF82FB", 
	"    本标准规定了在家庭和类似场合作为普通照明用的、把稳定燃点部件集成为一体的LED灯（自镇流LED灯）。本标准对该种灯规定了安全和互换性要求，以及试验方法和检验其是否合格的条件。
    本标准适用于如下范围：额定功率60W以下；额定电压大于50V且小于或等于250V；灯头符合表1要求。
    本标准的要求只涉及型式试验。关于全部产品的检验和批量产品的检验方法将在GB 24819-2009的附录C中定义。
    本标准主要技术要求包括：标志、互换性、意外接触带电部件的防护、潮湿处理后的绝缘电阻和介电强度、机械强度、灯头温升、耐热性、防火与防燃、故障状态。"
);';

?>