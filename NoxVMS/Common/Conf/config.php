<?php
//项目配置文件
return array(
	
	// 数据库配置
	'DB_TYPE' => 'mysql', 			// 数据库类型
	'DB_HOST' => 'localhost', 		// 服务器地址
	'DB_NAME' => 'noxvms', 			// 数据库名
	'DB_USER' => 'root', 			// 用户名
	'DB_PWD'  => 'root', 			// 密码
	'DB_PORT' => 3306, 				// 端口
	'DB_PREFIX' => 'nox_', 			// 数据库表前缀
	'DB_CHARSET'=> 'utf8', 			// 字符集
	'DB_FIELDS_CACHE'=>false,  		//关闭字段缓存
	
	//开启全局过滤 => 同I函数
	'REQUEST_VARS_FILTER'=>true,

	//URL配置
	'URL_CASE_INSENSITIVE' =>true,		//不区分URL大小写
	'URL_MODEL'			   =>'2',		//URL模式
	'DEFAULT_MODULE'	   =>'System',	//默认模块
	'MULTI_MODULE' 		   => false, 	//关闭多模块访问
	
	//用户权限等级说明
	'POWER_NAME' => array(
		3=>'读',
		2=>'写',
		1=>'超级管理员',
		0=>'ROOT',
	),
	
	//用户权限访问控制 权限等级->'POWER_NAME'
	'POWER_CONTRO' => array(
		'Project'	=>2,		//产品操作权限
		'Vip/manage'=>2,		//会员管理权限
		'Set/index'	=>1,		//系统设置权限
		'Set/manage'=>1,		//系统管理权限
	),
	
	//跳转说明
	'SUCCESS_MSG' 	=> '操作成功！',
	'Error_MSG' 	=> '操作失败',
	
	//分页样式
	'PAGE_PREV' => '<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>',  //上一页
	'PAGE_NEXT' => '<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>',		//下一页
	
	//允许访问IP地址列表,空数组表示没有限制 array()、array('0.0.0.0','255.255.255.255')
	'IP_ADDRESS'=> array('0.0.0.0'),
	
);

