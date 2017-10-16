<?php

if (!function_exists('M')) {
    /**
     * 兼容以前3.2的单字母单数 M
     * @param string $name 表名     
     * @return DB对象
     */
    function M($name = '')
    {
        if(!empty($name))
        {          
            return Db::name($name);
        }                    
    }
}

if (!function_exists('D')) {
    /**
     * 兼容以前3.2的单字母单数 D
     * @param string $name 表名     
     * @return DB对象
     */
    function D($name = '')
    {               
        $name = Loader::parseName($name, 1); // 转换驼峰式命名
        if(is_file(APP_PATH."/".MODULE_NAME."/model/$name.php")){
            $class = '\app\\'.MODULE_NAME.'\model\\'.$name;
        }elseif(is_file(APP_PATH."/home/model/$name.php")){
            $class = '\app\home\model\\'.$name;
        }elseif(is_file(APP_PATH."/mobile/model/$name.php")){
            $class = '\app\mobile\model\\'.$name;
        }elseif(is_file(APP_PATH."/api/model/$name.php")){            
            $class = '\app\api\model\\'.$name;     
        }elseif(is_file(APP_PATH."/admin/model/$name.php")){
            $class = '\app\admin\model\\'.$name;
        }elseif(is_file(APP_PATH."/seller/model/$name.php")){
            $class = '\app\seller\model\\'.$name;
        }
        if($class)
        {
            return new $class();
        }            
        elseif(!empty($name))
        {          
            return Db::name($name);
        }                    
    }
}

if (!function_exists('U')) {
    /**
     * 兼容以前3.2的单字母单数 M
     * URL组装 支持不同URL模式
     * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
     * @param string|array $vars 传入的参数，支持数组和字符串
     * @param string|boolean $suffix 伪静态后缀，默认为true表示获取配置值
     * @param boolean $domain 是否显示域名
     * @return string
     */
    function  U($url='',$vars='',$suffix=true,$domain=false) 
    {
       return Url::build($url, $vars, $suffix, $domain);
    }
}
 
if (!function_exists('S')) {
    /**
     * 兼容以前3.2的单字母单数 S 
    * @param mixed $name 缓存名称，如果为数组表示进行缓存设置
    * @param mixed $value 缓存值
    * @param mixed $options 缓存参数
    * @return mixed
    */
   function S($name,$value='',$options=null) {
       if(!empty($value))
            Cache::set($name,$value,$options);
       else
           return Cache::get($name);
   }
}

if (!function_exists('C')) {
/**
 * 兼容以前3.2的单字母单数 S 
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
    function C($name=null, $value=null,$default=null) {
        return config($name);
   }   
}

if (!function_exists('I')) {
    /**
     * 兼容以前3.2的单字母单数 I
     * 获取输入参数 支持过滤和默认值
     * 使用方法:
     * <code>
     * I('id',0); 获取id参数 自动判断get或者post
     * I('post.name','','htmlspecialchars'); 获取$_POST['name']
     * I('get.'); 获取$_GET
     * </code>
     * @param string $name 变量的名称 支持指定类型
     * @param mixed $default 不存在的时候默认值
     * @param mixed $filter 参数过滤方法
     * @param mixed $datas 要获取的额外数据源
     * @return mixed
     */
    function I($name,$default='',$filter='htmlspecialchars',$datas=null) {
     
        $value = input($name,'',$filter);        
        if($value !== null && $value !== ''){
            return $value;
        }
        if(strstr($name, '.'))  
        {
            $name = explode('.', $name);
            $value = input(end($name),'',$filter);           
            if($value !== null && $value !== '')
                return $value;            
        }  
        return $default;        
    } 
}
	
    
if (!function_exists('F')) {
       /**
        * 兼容以前3.2的单字母单数 F
       * @param mixed $name 缓存名称，如果为数组表示进行缓存设置
       * @param mixed $value 缓存值
       * @param mixed $path 缓存参数
       * @return mixed
       */
      function F($name,$value='',$path='') {
          if(!empty($value))
               Cache::set($name,$value);
          else
              return Cache::get($name);
      }
}
   
   

if (!function_exists('A')) {
	 /**
 * 兼容以前3.2的单字母实例化多层控制器 格式：[资源://][模块/]控制器
 * @param string $name 资源地址
 * @param string $layer 控制层名称
 * @param integer $level 控制器层次
 * @return Think\Controller|false
 */
	function A($name, $layer = '', $level = 0)
	{
		static $_action = array();
		$layer = $layer ?: C('CONTROLLER_LAYER');
		$level = $level ?: ($layer == C('CONTROLLER_LAYER') ? C('CONTROLLER_LEVEL') : 1);
		if (isset($_action[$name . $layer])) {
			return $_action[$name . $layer];
		}
		$class = parse_res_name($name, $layer, $level);
		if (class_exists($class)) {
			$action = new $class();
			$_action[$name . $layer] = $action;
			return $action;
		} else {
			return false;
		}
	}
}




if (!function_exists('W')) {	
/**
 * 兼容以前3.2的单字母渲染输出Widget
 * @param string $name Widget名称
 * @param array $data 传入的参数
 * @return void
 */
	function W($name, $data = array())
	{
		return R($name, $data, 'Widget');
	}
}


if (!function_exists('R')) {
/**
 * 兼容以前3.2的单字母远程调用控制器的操作方法 URL 参数格式 [资源://][模块/]控制器/操作
 * @param string $url 调用地址
 * @param string|array $vars 调用参数 支持字符串和数组
 * @param string $layer 要调用的控制层名称
 * @return mixed
 */
	function R($url, $vars = array(), $layer = '')
	{
		$info = pathinfo($url);
		$action = $info['basename'];
		$module = $info['dirname'];
		$class = A($module, $layer);
		if ($class) {
			if (is_string($vars)) {
				parse_str($vars, $vars);
			}
			return call_user_func_array(array(&$class, $action . C('ACTION_SUFFIX')), $vars);
		} else {
			return false;
		}
	}
}



if (!function_exists('E')) {
/**
 * 兼容以前3.2的单字母抛出异常处理
 * @param string $msg 异常消息
 * @param integer $code 异常代码 默认为0
 * @throws Think\Exception
 * @return void
 */
	function E($msg, $code = 0)
	{
		throw new think\Exception($msg, $code);
	}
}