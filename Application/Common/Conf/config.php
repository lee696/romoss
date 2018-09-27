<?php

return [
// 网站配置
    'WEB_CONFIG' => [
        'SITENAME' => '罗马仕后台管理中心'
    ],
    'LIST_ROWS'	=> 20,
	'PAGE_THEME' => '<ul class="am-pagination">%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%</ul>',
    // 数据库配置
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '101.200.45.185',
    'DB_NAME' => 'romoss',
    'DB_USER' => 'ykp_user',
    'DB_PWD' => 'Abc123456',
    'DB_PREFIX' => 'cm_',
    // redis配置
    'DB_PORT' => '3306',
    'REDIS_HOST' => '127.0.0.1',
    'REDIS_PORT' => '6379',
    // 加盐随机数
    'DATA_AUTH_KEY' => 'of@!#dgds!@#34gdfds25@46$%123?#!@$@#',
    'MODULE_ALLOW_LIST' => array('Wx', 'Admin'),
    'URL_MODEL' => 2, //URL模式
// 域名部署
    'DEFAULT_MODULE' => 'Wx',
    /* 'APP_SUB_DOMAIN_DEPLOY' => 1,
      'APP_SUB_DOMAIN_RULES' => [
      'wx' => 'Wx',
      'admin' => 'Admin'
      ], */
// 语言包
    'LANG_SWITCH_ON' => true,
    'LANG_LIST' => 'zh-cn', // 允许切换的语言列表 用逗号分隔
// 资源目录
    'TMPL_PARSE_STRING' => array(
        '__K_EDITOR__' => __ROOT__ . '/static/keditor',
        '__AMAZEUI__' => __ROOT__ . '/static/amazeui',
        '__STATIC__' => __ROOT__ . '/static',
        '__COMMON_JS__' => __ROOT__ . '/static/common/js',
        '__COMMON_CSS__' => __ROOT__ . '/static/common/js',
        '__COMMON_IMG__' => __ROOT__ . '/static/common/images',
        '__ADMIN_JS__' => __ROOT__ . '/static/admin/js',
        '__ADMIN_CSS__' => __ROOT__ . '/static/admin/css',
        '__ADMIN_IMG__' => __ROOT__ . '/static/admin/images',
        '__WX__' => __ROOT__ . '/static/wx',
        '__WX_JS__' => __ROOT__ . '/static/wx/js',
        '__WX_CSS__' => __ROOT__ . '/static/wx/css',
        '__WX_IMG__' => __ROOT__ . '/static/wx/images',
        '__LAYER__' => __ROOT__ . '/static/layer',
        '__IOSSELECT__' => __ROOT__ . '/static/iosselect',
        '__T__' => 'v=0.01'
    ),
     /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => './static/upload/image/', //保存根路径
		'savePath' => '', //保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    'PICTURE_UPLOAD_DRIVER'=>'local',
    //本地上传文件驱动配置
    'UPLOAD_LOCAL_CONFIG'=>array(),
    'UPLOAD_BCS_CONFIG'=>array(
        'AccessKey'=>'',
        'SecretKey'=>'',
        'bucket'=>'',
        'rename'=>false
    ),
    //阿里云短信服务配置（非阿里大于）
    'SMS' => array(
        'accessKeyId' => 'LTAIEEvLCQQFR7Ov',
        'accessKeySecret' => 'hFlByWdmpHDObLqbAaQy35Qd9L0dCr',
        'product' => 'Dysmsapi', //产品名称
        'domain' => 'dysmsapi.aliyuncs.com', //api域名
        'region' => 'cn-hangzhou',
        'SignName' => 'DIY3知定', //短信签名
        'TemplateCode' => 'SMS_77225003', //短信模板ID
    ),
     'wxopt' =>array(
    		'token'=>'diy3', //填写你设定的key
    		'encodingaeskey'=>'4RiumUX1zx79GZLe2yTcL4YUBQrIsv85RlWQyuC9Sm6', //填写加密用的EncodingAESKey
    		'appid'=>'wxfabf8b0b5bd487f2', //填写高级调用功能的app id
    		'appsecret'=>'159e2220a0aaeab239c8a8415633ed99' //填写高级调用功能的密钥
    ),
    //微信公众号相关配置
    'wx_options' => [
        /**
         * Debug 模式，bool 值：true/false
         *
         * 当值为 false 时，所有的日志都不会记录
         */
        'debug' => true,
        /**
         * 账号基本信息，请从微信公众平台/开放平台获取
         */
        'app_id' => 'wx75de541dcc9ac3b3', // AppID
        'secret' => '953252709a94670f9d6cb91e25cfd1f0', // AppSecret
        'token' => 'diy3', // Token
        'aes_key' => '4RiumUX1zx79GZLe2yTcL4YUBQrIsv85RlWQyuC9Sm6', // EncodingAESKey，安全模式下请一定要填写！！！
        /**
         * 日志配置
         *
         * level: 日志级别, 可选为：
         *         debug/info/notice/warning/error/critical/alert/emergency
         * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level' => 'debug',
            'permission' => 0777,
            'file' => '/tmp/easywechat.log',
        ],
        /**
         * OAuth 配置
         *
         * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
         * callback：OAuth授权完成后的回调页地址
         */
        'oauth' => [
            'scopes' => ['snsapi_userinfo'],
            'callback' => 'Account/callback.html',
        ],
        /**
         * 微信支付
         */
        'payment' => [
            'merchant_id' => '1448288102',
            'key' => '060d795f11c9c44cbcfa91bf9d9435cb',
            'cert_path' => VENDOR_PATH . 'wxpay/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
            'key_path' => VENDOR_PATH . 'wxpay/cert/apiclient_key.pem', // XXX: 绝对路径！！！！
            'notify_url' => 'http://romass.jlkfapp.com/Order/wxreturn.html',
        ],
        /**
         * Guzzle 全局设置
         *
         * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
         */
        'guzzle' => [
            'timeout' => 3.0, // 超时时间（秒）
        //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
        ],
    ],
];
