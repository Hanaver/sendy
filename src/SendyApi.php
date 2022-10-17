<?php

namespace SendyApi;

use Illuminate\Support\Facades\Http;

/**
 * Author Andy
 * Date 2022-09-26
 * Time: 15:26
 */

class SendyApi
{
    /** @var sendy服务的API地址 */
    protected $apiUrl;

    /** @var Sendy网站的API Key */
    protected $apiKey;

    /** @var 列表ID */
    protected $listId;

    public function __construct()
    {
        $this->apiUrl = config('sendy.api_host');
        $this->apiKey = config('sendy.api_key');
        $this->listId = config('sendy.list_id');
    }

    /**
     * 获取品牌的所有列表
     * Author: Andy
     * @param string $brandId
     * @param false $includeHidden
     */
    public function getLists(string $brandId, $includeHidden = false)
    {
        $params = ['brand_id' => $brandId, 'include_hidden' => $includeHidden];
        return $this->http(config('sendy.api_get_lists'), $params);
    }

    /**
     * 获取品牌列表
     * Author: Andy
     */
    public function getBrands()
    {
        $param = [];
        return $this->http(config('sendy.api_get_brands'), $param);
    }

    /**
     * 添加邮箱订阅
     * Author: Andy
     * @param string $name
     * @param string $email
     * @param string $list
     * @param array $optionals 非必填参数如下
     * * string country     国家
     * * string ipaddress
     * * string referrer
     * * string gdpr
     * * string silent
     * * string hp
     * * string boolean
     * @return \Illuminate\Http\Client\Response
     */
    public function subscribe(string $name, string $email, string $list, array $optionals = [])
    {
        $params = $optionals;
        $params['name'] = $name;
        $params['email'] = $email;
        $params['list'] = $list;
        return $this->http(config('sendy.api_subscribe'), $params);
    }

    /**
     * 取消邮箱订阅
     * Author: Andy
     * @param string $email
     * @param string $list
     * @param bool $boolean
     */
    public function unsubscribe(string $email, string $list, bool $boolean = false)
    {
        $params = [
            'email' => $email,
            'list' => $list,
            'boolean' => $boolean
        ];
        return $this->http(config('sendy.api_unsubscribe'), $params);
    }

    /**
     * 删除订阅
     * Author: Andy
     * @param string $email
     * @param string $listId
     * @return \Illuminate\Http\Client\Response
     */
    public function delSubscribe(string $email, string $listId)
    {
        $params = [
            'list_id' => $listId,
            'email' => $email
        ];
        return $this->http(config('sendy.api_delete'), $params);
    }

    /**
     * 获取订阅状态
     * Author: Andy
     * @param string $email
     * @param string $listId
     * @return \Illuminate\Http\Client\Response
     */
    public function subscribeStatus(string $email, string $listId)
    {
        $params = [
            'list_id' => $listId,
            'email' => $email
        ];
        return $this->http(config('sendy.api_subscription_status'), $params);
    }

    /**
     * 获取列表订阅邮箱数量
     * Author: Andy
     * @param string $listId
     * @return \Illuminate\Http\Client\Response
     */
    public function activeSubscriberCount(string $listId)
    {
        $params = [
            'list_id' => $listId
        ];
        return $this->http(config('sendy.api_active_subscriber_count'), $params);
    }

    /**
     * 创建发送任务
     * Author: Andy
     * @param string $fromName  发送名称
     * @param string $fromEmail 发送邮件
     * @param string $replyTo   设置回复邮箱
     * @param string $title     任务标题
     * @param string $subject   邮件的主题
     * @param string $plainText     邮件纯文本版本
     * @param string $htmlText      邮件html版本
     * @param array $optionals      其他可选参数，详细如下
     * * list_ids   仅当将send_campaign设置为1且未传入segment_id时才需要。列表ID应为单个或逗号分隔。可以在名为ID的“查看所有列表”部分下找到加密的哈希ID。
     * * segment_ids    仅当将send_campaign设置为1且未传入list_id时才需要。段ID应为单个或逗号分隔。段ID可以在段设置页面中找到。
     * * exclude_list_ids   要从您的活动中排除的列表。列表ID应为单个或逗号分隔。可以在名为ID的“查看所有列表”部分下找到加密的哈希ID（可选）
     * * exclude_segments_ids   要从您的活动中排除的细分市场。段ID应为单个或逗号分隔。段ID可以在段设置页面中找到。（可选）
     * * brand_id   只有在创建“草稿”活动时才需要（send_campaign设置为0或保留为默认值）。品牌ID可以在名为ID的“Brands”页面下找到
     * * query_string   Google Analytics标签
     * * track_opens  0禁用，1启用, 2匿名打开跟踪
     * * track_clicks  0禁用，1启用, 2匿名点击跟踪
     * * send_campaign  0草稿，1发送实体
     * * schedule_date_time   如果通过有效的日期/时间，将安排活动。日期/时间格式2021年6月15日下午6:05。时间的分钟部分必须以5为例，例如。下午6:05，下午6:10，下午6:15。
     * * schedule_timezone   例如，“美国/纽约”。查看PHP支持的时区列表。此参数仅适用于使用schedule_date_time参数计划活动的情况。如果此参数为空，Sendy将使用默认时区。
     */
    public function create(string $fromName, string $fromEmail, string $replyTo, string $title, string $subject, string $plainText, string $htmlText, array $optionals = [])
    {
        $params = $optionals;
        $params['from_name'] = $fromName;
        $params['from_email'] = $fromEmail;
        $params['reply_to'] = $replyTo;
        $params['title'] = $title;
        $params['subject'] = $subject;
        $params['plain_text'] = $plainText;
        $params['html_text'] = $htmlText;

        return $this->http(config('sendy.api_create'), $params);
    }

    /**
     * 删除任务
     * Author: Andy
     * @param int $campaignId
     * @return array
     */
    public function campaignDelete(int $campaignId)
    {
        $params = ['campaign_id' => $campaignId];
        return $this->http(config('sendy.api_campaign_delete'), $params);
    }


    /**
     * http 请求方法
     * Author: Andy
     * @param string $url
     * @param array $params
     * @param int $type
     * @return array
     */
    private function http(string $url, array $params, int $type = 1)
    {
        // 添加授权api key 参数
        $params['api_key'] = $this->apiKey;

        switch ($type){
            case 1:
                $result = Http::withoutVerifying()
                    ->asForm()
                    ->post($this->apiUrl . $url, $params);
                break;
            default:
                $result = Http::withoutVerifying()->get($this->apiUrl . $url, $params);
                break;
        }

        return ['code'=>$result->status(), 'data'=>$result->json(), 'msg' =>$result->serverError() ] ;
    }
}
