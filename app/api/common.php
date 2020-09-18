<?php


function _httpGet($url=""){
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}


function _httpPost($url="" ,$requestData=array()){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //普通数据
    //curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestData));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);

    curl_setopt($curl, CURLOPT_HEADER, false); // 返回response头部信息
    curl_setopt($curl, CURLINFO_HEADER_OUT, true); // TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header

    //设置请求头
    $headers = array();
    $header[] = 'User-Agent: iMAG0';
    $header[] = 'token:Test';
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);


    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}


function curlPost($url, $data = '', $headers = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $result = curl_exec($ch);
    //这里解析
    return $result;
};




function getToBeSignedStringV1($aBasicParams, $aBodyParams, $sHTTPMethod, $sURI, $bIsNotify = false) {
    //所有参数合集（不包括 appSignContent 字段））
    ksort($aBasicParams);
    if (!$bIsNotify) {
        ksort($aBodyParams);//1.0的签名，接收参数和回调传参的方式不同，一个是form data格式，一个是http body，这导致签名的方法不一致，接收时要求json排序，但回调时又不要求，给API使用方造成很大困扰。这个问题在1.1中已经修复，此处是为了兼容旧版
    }
    //保证拼接json时所有的值都是字符串类型（因为jrdidi服务器在验签的之前通过HTTP接收到的参数值都是字符串）
    array_walk($aBodyParams, function(&$value){
        $value = (string)$value;
    });
    $sToBeSigned = $sHTTPMethod . $sURI . '?' . http_build_query($aBasicParams) . json_encode($aBodyParams, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    return $sToBeSigned;
}

function getToBeSignedStringV2($aBasicParams, $aRequestParams = array()) {
    //所有参数合集（不包括 appSignContent 字段））
    $aAllParams = array_merge($aBasicParams, $aRequestParams);
    ksort($aAllParams);
    $sToBeSigned = http_build_query($aAllParams);

    return $sToBeSigned;
}

function buildAutoSubmitForm($sRequestURL, $sHTTPMethod, $aFormParams) {
    // action 是JRDiDi系统的下单请求API地址
    // method='POST' 使用POST方法提交
    // method='GET' 使⽤GET方法提交
    // target='_blank' 在用户浏览器中新开标签页打开下单页面
    $sHtml = "<form id='jrdidi_submit' name='jrdidi_submit' action='". $sRequestURL ."' method='" . $sHTTPMethod. "'>";
    // 将所有参数都拼装成form表单待提交的参数
    foreach ($aFormParams as $key => $value) {
        $value = str_replace("'", "&apos;", $value);
        $sHtml.= "<input type='hidden' name='".$key."' value='".$value."'/>";
    }
    //submit按钮控件请不要含有name属性
    $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
    // ⽤用JavaScript自动提交form表单
    $sHtml = $sHtml."<script>document.forms['jrdidi_submit'].submit();</script>";

    return $sHtml;
}