<?php
class Xmli {

	private $xmlHeader = '<?xml version="1.0" encoding="utf-8"?>';
	private $xml = '';

	/**
	 * 将一维或多维数组转为xml格式
	 * $arr [Array]
	 * $xmlRoot [String] xml根元素
	 * $xmlHeader [String] 是否需要xml文档头声明   <?xml version="1.0" encoding="utf-8"?>
	 * return [String] 返回一个xml字符串
	 */
	public function arrayToXml($arr,$xmlRoot='root',$xmlHeader=true){
		if(!is_array($arr)){
			return '第一个参数必须为一个数组';
		}
		$this->xml = '';   //每次进行xml转换时需要将保存在xml属性里的值清空，以防上次转换的值还存在
		$xml = '';
		if($xmlHeader){   //是否需要xml文档声明头
			$xml.= $this->xmlHeader;
		}
		$xml.= '<'.$xmlRoot.'>';
		$xml.= $this->arrayToXmlDispose($arr);
		$xml.= '</'.$xmlRoot.'>';
		
		return $xml;
	}
	/**
	 * 将一维或多维数组转为xml格式处理
	 * $arr [Array]
	 * return [String] 返回一个xml字符串
	 */
	private function arrayToXmlDispose($arr){
		
		foreach($arr as $key=>$val){
        	$this->xml.='<'.$key.'>';
        	if(is_array($val)){

        		$this->arrayToXmlDispose($val);   //递归
        		
        	}else{
        		$this->xml.=$val;
        	}
        	$this->xml.='</'.$key.'>';
        	//dump($this->xml);
        }
        return $this->xml;
	}

	/**
	 * [xmlToArray xml转数组]
	 * @param  [String] $xml [xml数据]
	 * @return [Array]      [xml转换后的数组]
	 */
	public function xmlToArray($xml){

		$xmlObj = @simplexml_load_string($xml);   //将xml数据生成xml对象
		
		$xmlJson = json_encode($xmlObj);   //将xml对象转为json字符串
	
		$xmlArray = json_decode($xmlJson,true);   //将json数据转为数组

		return $xmlArray;
	}
}