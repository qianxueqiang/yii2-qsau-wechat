<?php
namespace qwechat\tool;

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
     * 获取异常信息
     *
     * @return string
     */
    public function getError()
    {
        if ($this->curl)
            curl_error($this->curl);
        else
            return 'curl is null!';
    }

    /**
     * 获取异常码
     *
     * @return string
     */
    public function getErron()
    {
        if ($this->curl)
            curl_errno($this->curl);
        else
            return 'curl is null!';
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
//         var_dump($data);
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
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        return $this;
    }

    /**
     * 执行并返回执行结果
     *
     * @return mixed
     */
    private function exec()
    {
        return curl_exec($this->curl);
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
     * post请求
     *
     * @param unknown $url            
     */
    public function post($url, $data = [])
    {
        $this->setUrl($url);
        if (! empty($data)) {
            $this->setPostBodyData($data);
        }
//         var_dump($url);
        return $this->exec();
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