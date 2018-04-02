<?php
namespace qwechat\tool;

/**
 * http客户端，用它可以发起http请求
 *
 * 示例：GET
 * $http = new HttpClient();
 * $http->get("http://www.baidu.com");
 *
 * 示例：POST
 * $http = new HttpClient();
 * $postdata = [];
 * $http->post("http://www.baidu.com",$postdata);
 * 或者
 * $http = new HttpClient();
 * $http->setPostBodyData($postdata);
 * $http->post();
 *
 * 抓取http状态码：
 * $http = new HttpClient();
 * $http->get("http://www.baidu.com");
 * $http->getResponseStateCode();
 *
 * 抓取http返回信息：
 * $http = new HttpClient();
 * $http->get("http://www.baidu.com");
 * $http->getResponseInfo();
 *
 *
 * @date 2018年3月8日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class HttpClient
{

    /**
     * 默认设置
     *
     * @var array
     */
    private $defOption = [
        // 如果成功只将结果返回，不自动输出任何内容。
        CURLOPT_RETURNTRANSFER => true,
        // 超时时间未10秒
        CURLOPT_TIMEOUT => 10,
        // 是否跳过证书检查
        CURLOPT_SSL_VERIFYPEER => FALSE
    ];

    /**
     * curl对象
     *
     * @var unknown
     */
    private $curl;

    /**
     * 请求响应的数据
     *
     * @var unknown
     */
    private $response_data;

    /**
     * 请求响应的信息
     *
     * @var unknown
     */
    private $response_info;

    /**
     * 异常信息
     *
     * @var array
     */
    private $errors = [
        'error' => '',
        'errno' => 0
    ];

    /**
     * 请求数据
     *
     * @var array
     */
    private $request_data = [];

    /**
     * 请求地址
     *
     * @var string
     */
    private $request_url = '';

    /**
     * 初始化函数
     */
    public function __construct()
    {
        $this->curl = curl_init();
        $this->setDefOption();
    }

    /**
     * 设置header
     *
     * @param unknown $header            
     * @return \qwechat\tool\HttpClient
     */
    public function setHeader($header)
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
        return $this;
    }

    /**
     * 设置超时时间
     *
     * @param unknown $timeout            
     * @return \qwechat\tool\HttpClient
     */
    public function setTimeout($timeout)
    {
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
        return $this;
    }

    /**
     * 设置CA证书
     *
     * @param unknown $cert_url            
     * @param unknown $key_url            
     * @return \qwechat\tool\HttpClient
     */
    public function setCA($cert_url, $key_url)
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSLCERT, $cert_url);
        curl_setopt($ch, CURLOPT_SSLKEY, $key_url);
        return $this;
    }

    /**
     * 设置默认选项
     */
    public function setDefOption()
    {
        $this->setOption($this->defOption);
    }

    /**
     * 请求选项设置，注意：设置属性时数组key不可加引号，否则会出错
     * 例如：[ CURLOPT_TIMEOUT=>'10', CURLOPT_HTTPHEADER=>[] ]
     *
     * @param array $option            
     * @return \qwechat\tool\HttpClient
     */
    public function setOption($option = [])
    {
        foreach ($option as $key => $val) {
            curl_setopt($this->curl, $key, $val);
        }
        return $this;
    }

    /**
     * 设置body数据
     *
     * @param string|array $data            
     * @return \qwechat\tool\HttpClient
     */
    public function setPostBodyData($data)
    {
        $this->request_data = $data;
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this;
    }

    /**
     * 数据以数组形式进行提交（form-data提交）
     *
     * 提交的数据在nginx抓取数据会乱码，不推荐以这种方式
     *
     * @param array $data            
     */
    public function setPostBodyFormData($data = [])
    {
        return $this->setPostBodyData($data);
    }

    /**
     * 数据以字符串形式进行提交（x-www-form-urlencode提交），提交格式是：aa=1&bb=2
     *
     * @param string $data            
     */
    public function setPostBodyFormUrlencode($data = '')
    {
        return $this->setPostBodyData($data);
    }

    /**
     * 数据以字符串形式进行提交，抓取可用body直接抓取，也可以post抓取
     *
     * @param string $data            
     * @return \qwechat\tool\HttpClient
     */
    public function setPostBodyRaw($data = '')
    {

        return $this->setPostBodyData($data);
    }

    /**
     * 设置请求的url
     *
     * @param String $url            
     * @return \qwechat\tool\HttpClient
     */
    public function setUrl($url)
    {
        $this->request_url = $url;
        curl_setopt($this->curl, CURLOPT_URL, $url);
        return $this;
    }

    /**
     * 设置跟踪爬取重定向页面
     *
     * location属性就代表重定向的地址。如果curl爬取过程中，设置CURLOPT_FOLLOWLOCATION为true
     *
     * @return \qwechat\tool\HttpClient
     */
    public function setLocation()
    {
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        return $this;
    }

    /**
     * get请求
     *
     * @param unknown $url            
     */
    public function get($url)
    {
        $this->setUrl($url);
        return $this->exec();
    }

    /**
     * 执行post请求
     *
     * @param unknown $url            
     * @param array $postdata            
     * @return mixed|\qwechat\tool\unknown
     */
    public function post($url, $postdata = [])
    {
        $this->setUrl($url);
        if (! empty($postdata)) {
            $this->setPostBodyData($postdata);
        }
        return $this->exec();
    }

    /**
     * 执行并返回执行结果
     *
     * @return mixed
     */
    private function exec()
    {
        $this->response_data = curl_exec($this->curl);
        $this->errors['errno'] = curl_errno($this->curl);
        $this->errors['error'] = curl_error($this->curl);
        $this->response_info = curl_getinfo($this->curl);
        return $this->response_data;
    }

    /**
     * 获取请求数据
     *
     * @return array
     */
    public function getReqeustData()
    {
        return $this->request_data;
    }

    /**
     * 获取请求的url
     * 
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->request_url;
    }

    /**
     * 获取返回的数据
     *
     * @return string
     */
    public function getResponseData()
    {
        return $this->response_data;
    }

    /**
     * 获取异常信息
     *
     * @return []
     */
    public function getResponseErrors()
    {
        return $this->errors;
    }

    /**
     * 获取异常信息
     *
     * @return string
     */
    public function getResponseError()
    {
        return $this->errors['error'];
    }

    /**
     * 获取异常码
     *
     * @return string
     */
    public function getResponseErron()
    {
        return $this->errors['errno'];
    }

    /**
     * 获取响应信息
     *
     * @return \qwechat\tool\unknown
     */
    public function getResponseInfo()
    {
        return $this->response_info;
    }

    /**
     * 获取响应的状态码
     *
     * @return resource
     */
    public function getResponseStateCode()
    {
        return isset($this->response_info['http_code']) ? $this->response_info['http_code'] : 0;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        if (! empty($this->curl))
            curl_close($this->curl);
    }
}