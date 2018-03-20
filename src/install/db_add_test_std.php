<?php
// 这段需要将其复制到数据库管理工具中执行
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
);

INSERT INTO LedStdEntity (
	ArchId, StdNum           , StdLevel  , Category, ChName                     ,
	EnName                                                , 
	ReleaseDate, ImpelementDate, StdStatus , AlterStandard, AdoptNo, 
	AdoptName, AdoptLev, AdoptType, ICS        , CCS  , StandardType, 
	ProductType, DepartCharge           , DepartResponse                       , AnnounceNum ,
	CtnLink                                                                             , Abstract
) VALUES (
	122     , "IEC 62776:2014", "国际标准", ""      , "设计用于改造线性萤光灯的双端LED灯-安全规格", 
	"Double-capped LED lamps designed to retrofit linear fluorescent lamps - Safety specifications",
	"2014/12/11" , "2014/12/11"    , "现行有效", ""           , ""     , ""       , ""      , "ISO/IEC/IEEE"     , "29.140.99", "", "安全"      ,
	"基础通用"  ,"IEC", "TC34 SC34A", "",
	"https://webstore.iec.ch/publication/7425", 
	"IEC 62776:2014规定了安全性、可互换性的要求，以及相关的测试方法和测试条件，以证明采用G5和G13的双端LED灯的合规性，其目的是用相同的双端灯取代荧光灯，双端LED灯要求包括:
	-额定功率高达125瓦;
	-额定电压高达250v。"
);';

// 这段需要将其复制到数据库管理工具中执行
$sql = 'INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"通用标准", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"材料", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"材料通用标准", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"衬底材料", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"发光材料", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"芯片和器件", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"外延片", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"芯片", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"器件", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"照明设备和系统", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"LED模块", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"LED光源", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"灯用附件", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"专用集成电路", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"驱动控制装置", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"照明接口", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"灯头灯座", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"灯具", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"照明系统", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"智能控制系统", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"传感器系统", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"其他连接系统", 0, 0
	);
	
	INSERT INTO `LedStdStatistic` (
		`Type`, `NationalNum`, `InternationalNum`
	) VALUES (
		"其他", 0, 0
	);';

?>