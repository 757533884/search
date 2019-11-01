<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    >
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.min.js"></script>
    <script type="text/javascript" src="/admin/lib/html5shiv.js"></script>


    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>用户管理</title>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#hide").click(function(){
                $("p").hide();
            });
            $("#show").click(function(){
                $("p").show();
            });
        });
    </script>

</head>
<body>
<pre>
        <h4>1.当面交易：</h4>
        以下情况不支持当面交易：
        1.有保证金商品
        2.此拍品买家支付了保证金
        3.该订单拍品买家已付款
        4.包退拍品、活动拍品和分类推广拍品
        5.截拍时间（endTime）不满24小时
        当面交易的要求：
        截拍24小时后才能申请当面交易
        <h4>2.延长付款期限(48小时)要求</h4>
        1.	商品状态为成交易状态（status=deal）
        2.	付款时间没有延长48小时（delayPayTime>endTime+48*3600）
        3.	商品存在，卖家id存在
        <h4>3.显示鉴真阁要求</h4>
        1.	支持的分类：和田玉、翡翠、琥珀/蜜蜡、玛瑙、水晶、碧玺、珍珠、青金石、钱币、松石、珊瑚、玉髓、奢侈品手表、贵重宝石、金银饰品、黄龙玉、独山玉
        2.	拍品类型：type= 0（普通拍品）6（新手拍品）7（镇店宝拍品）
        3.	交易时间不能超过7天，发货时间超过三天
        <h4>4.显示小二介入（争议）</h4>
        1.	二者要求：dispute = in( 1.错发/漏发  2.描述不符  3.假冒品牌 )，并且类型不能为公益捐款拍品，
        2.	卖家sale状态status=in[refunding(发起退款)、returning(发起退货)、agreeReturn(同意退款)、deliveryReturn()]
        3.	买家sale状态status =in[ paid(已付款)、delivery(发货)、refunding(发起退款)、returning(发起退货)、agreeReturn(同意退货)]
        <h4>5.推广中心</h4>
        1.	分类频道
        分类推广位拍品要求：
        1.	0元起拍，无条件包邮（expressFee=freePost）
        2.	20≦拍品加价幅度＜100
        3.	不能当面交易
        4.	不能出现微信、电话、二维码等联系方式（拍品描述、图片及个性签名），禁止发布违禁品
        5.	只允许选择对应分类的拍品（其他类只能在属于自己的一级分类下）
        6.	经核实有售价行为，将立即取消推广资格且剩余推广费不退
        7.	推广过的拍品，中拍后仅支持在线付款，不支持当面交易
        8.	若拍品被买家投诉或官方查实违反规则，将对商家进行相应处罚，加入黑名单并且一段时间内无法在抢购推广位
        出现在普通分类的要求：
        9.	实名认证，最近30天，没有处罚，没有售假
        10.	排名靠前条件相关：消保金、违约率
        松石、琥珀、蜜蜡分类，必须满足消保金≥5000，必须设置包退
        参与抢购/暗拍要求： 实名认证，不在黑名单，消保金≥3000，等级≥v2，评分≥4.65
        暗拍：六人中拍，按第六名的出价额成拍，每周五0:00-12:00开放下周暗拍推广名额，每位商家只能暗拍1个二级分类，参与了暗拍就无法参与抢购
        抢购：每周五12:00开始，若暗拍有未售出的推广位，则以抢购形式出售，每位商家只能抢购一个二级分类，抢购截止于每周日23:59，若某个分类的名额抢完则提前截止
        2．分类橱窗
        功能：自行指定自己店铺在分类里出现的第一个拍品，该拍品获得分类排名提升
        店铺条件：店铺实名认证，消保金≥1000，店铺未处于处罚期
        拍品条件：拍品需0元起拍、包邮
        拍品加价幅度≧ 20元
        分类正确，非违禁品、假货，无敏感词汇
        拍品未参加其他活动、推广
        注意：橱窗上成交的拍品不收取技术服务费，每天6次投放机会，每次最多投放    1件拍品
        3．精选频道
        精选暗拍
        商家要求：1. 近30天平均成交价>400
        2.	近30天成交额≧20万
        3.	等级≥v4
        4.	评分≥4.7分
        5.	违约率、争议比例≤1%
        6.	一个月内无未完结的争议、投诉、无微拍堂处罚记录
        7.	消保金≥10000(审核通过后可补交)
        8.	上精选商品实际价值≥2000
        9.	一个商家可以报名唯一的优势分类
        10.	拍品背景要求简洁美观，不允许出现指甲，手臂等影响美观的图片
        11.	每天推广拍品数量不得低于6个
        12.	不可以推广违禁品（象牙、羚羊角、虎、鸟头、玳瑁、狼、犀角等国家保护动物）
        推广位要求：
        1）参与暗拍的商家必须符合五点要求：优店商家；消保金≥10000；店     铺等级≥4；店铺评分≥4.7；30天平均成交价＞400。黑名单商家不能参与。
        2）暗拍模式的起拍价为精选限价7000元，每位商家只能出价一次，出价成功不可修改。
        3）暗拍采用25人中拍模式。即排除出价失败的商家后，按第25名的出价额成拍。
        精选拍品要求：
        1.  设置参考价格
        2.  0元起拍
        3.  包邮、包退
        4.  不设置一口价，不能当面交易
        5.  100≤加价≤店铺消保金的10%
        6.  属于报名时确认过的分类
        7.  不能出现微信号、二维码、电话等联系方式（拍品描述、图片及个人签名）
        精选报名
        报名审核通过均可报名
        报名条件：店铺等级≧4，店铺评分≧4.7，30天平均成交价>400，违约率、争议率≦1%
        4．捡漏频道
        功能： 曝光未出价且即将截拍的拍品
        店铺条件：店铺实名认证，消保金≥1000，店铺未处于处罚期
        拍品条件： 当天截拍且无人出价的拍品
        起拍价为0，10≦加价幅度 ≦50
        分类正确，非违禁品、假货，无敏感词汇
        参与方式： 兑换捡漏推广和随机捡漏推广（从满足条件的店铺和拍品随机抽取）
        捡漏推广时间：8:00～22:00点，10分钟一场，一个整点共有6场
        注意： 一家店铺最多被推广4个拍品，且一个整点场最多被推广一个拍品
        拍品在推广前被出价或被下架，均会取消推广
        5．优店频道
        成功入驻的商家，可增加大量曝光
        入驻条件：店铺等级≧3，店铺评分≧4.7，违约、争议比例≦1%，近30天平均客单价≧300元，近30天总成交额≧10万，消保金>5000元，不是精选卖家
        6．兑换有礼
        捡漏推广位（1周=900积分）
        推广店铺条件：实名认证，消保金≧1000元，遵守平台秩序
        橱窗推广位（1周=300积分）：提升分类排名
        橱窗店铺条件：实名认证，消保金≧1000元，遵守平台秩序
        7．邀请有礼
        条件：仅限邀请非认证商家，支付认证费才算邀请成功
        邀请人的链接有效期为24小时
        8．分享+
        优惠券加上分享红包的金额，不能超过订单的5%
        条件：近30天销售均价≧50元
        <h4>6.扩展服务</h4>
        扩展服务
        1．店铺报表
        2．对账单
        3．快捷发货
        4．子账号
        权限：发布拍品，回复私信，发货退货，推广等权限。目前支持设置三个子账号权限，且授权及被授权的账号必须是实名认证账号。

        商家把买家的私信转交给子账号，显示无转交的客服？
        原因：转交要保证子账号在线

        5．微拍预展
        6．投诉处理
        7．鉴真阁
        鉴真阁关联订单条件：
        发货30天内

        8. 客服功能
        营销工具
        1．优惠券
        2．折扣
        折扣期间不能修改折扣设置
        3．福袋
        福袋有效期14天，每天10:02执行退回过期未领完福袋任务!
        4．镇店宝
        5．抽奖
        6．代言人
        7．包装盒
        8．店铺二维码
        <h4>7.积分规则</h4>
        1.获取途径
        首次认证+1000
        续费认证+600
        首次认证，首次兑换捡漏推广+200

        4.	商家积分：
        每人每天每店铺只记一笔积分
        大于1级的商家，如果发货时间大于付款时间8天，不加分
        发货时间超过8天，确认收货后扣卖家一倍积分，会员扣两倍
        <h4>8.实名认证</h4>
        功能优势：
        1）视频功能：上传拍品的时候，可添加15秒短视频功能；
        2）分类功能：可选择拍品的“分类”进行上拍，可被收录到“分类”频道；
        3）预展功能：可自定义拍品的开拍时间，增加店铺预热玩法；可在微拍预展中添加预展拍品，点击图片直达预展拍品页面；
        4）产品库/名匠库功能：可享受产品库/名匠库功能，可以找到自己的分销渠道和供应商渠道，可解决货源与代理问题；
        5）子帐号功能：可开通子帐号功能，通过授权形式给予新微信帐号管理权限，即授权多人同时进行店铺管理，进行工作分配，提高管理效率；
        6）优惠券功能：店铺拥有自动生成优惠券的工具，此项功能通过满减的形式，使买家得到一定优惠并形成二次销售，也可通过分享优惠券功能进行扩散，获得新买家；
        7）多拍设置功能：可设置多人中拍置，拍品共有N人可中拍，成交价均以拍品的第N高出价；
        权益优势：
        1）专属认证标记：认证标记是保障的象征，利用认证标注加强客户信任感；
        2）提现金额：提现金额提高到15万元，并且支持提现到银行卡；
        3）黑名单、点赞上限：黑名单上限增加到320；点赞上限增加；
        流量优势：
        1）活动流量优势：
        平台各类大、中小型的活动只允许认证卖家报名。平台的活动一般是抢占流量最有利的一种方式之一，多多利用平台的活动可以大幅提高曝光率。
        2）频道流量优势：
        频道流量有逛逛、分类、分类推广位、精选、捡漏、优店等等，都是属于频道流量。
        冻结机制：
        1.	支持7天无理由退货的拍品，退货期货款冻结7天
        2.	非送货上门 && 付款时间（paidTime）- 上拍时间（createTime）<5min,冻结7天
        3.	如果平台补贴了且消保金小于1000，冻结7天
        4.	延迟账期处罚

        <h4>9.关于服务退款</h4>
        1. 显示退款，退货按钮
        退款：付完款，三天后才能退款
        退货：发货时间过了12小时，才能退货
        2.自动退款逻辑
        买家付款8天后商家不发货，自动申请退款
        必须V2级别的卖家，买家可以手动申请

        3.申请退货理由选择（未按约定时间发货）会影响分类权重，选择（其他）不会处罚
        包含（48小时内不去同意退款或者是发货），（超过8天自动发起退款买家取消后重新修改成其他这个理由），只要选择其他，都不会受到处罚
        4.冻结机制
        七天无理由退货拍品，退货货款冻结7天
        非送货上门 且（付款时间与上拍时间在半小时内），冻结七天
        如果平台补贴了 且 消保金小于1000，冻结七天
        申请退货的订单不会解冻
        <h4>5.保证金自动退款</h4>
        时间：1小时一次，详情查看order表
        要求：payMethod in (weixin，app_weixin，wap_weixin)

        <h4>10.关于封店</h4>
        每天0点删除封店到期用户

        <h4>11.关于账号</h4>
        每张身份证只能绑定5个账号
        主账号：以第一个手机端登录的账号为主账号（小程序除外）
        微信和app会冲突，同时只能在一边用
        <h4>12．各种退款时间</h4>
        消保金提现完成时间为：createTime+86400*30(交易时间后过30天)
        包退时间：delivery +7天 之内
        <h4>13. 延迟收货</h4>
        显示延迟收货按钮：最迟收货时间-发货时间<7天 且 当前时间< 最迟收货时间
        <h4>14.关于逛逛</h4>
        1. 五分钟展示600个拍品，每日可以请求500次
        <h4>15.关于拍卖</h4>
        无人出价流拍的不会自动隐藏，需商家自己下架
        恢复交易的订单，不会自动流拍

        <h4>16.我的代言</h4>
        推荐代言店铺10分钟更新一次
        <h4>17.关于新手优惠券</h4>
        用户等级必须为一级，如果用过一次新手优惠券，在新手拍品不会在显示
        <h4>18.关于群发消息</h4>
        交互要求：点击菜单进入拍场，回复微信公众号
        <h4>19.后台报表</h4>
        争议数：disput = 2（买家）3（卖家）
        卖家违约数：用户退款选择：未按约定时间发货 （退回理由：七天无理由和其他以外的都算违约）
        退货选择：afterJson(reasonID=3)
        <h4>20.店铺评分</h4>
        店铺的评分每天更新一次
        计算方法：取有评分记录的最近100天每日评分平均值的总和，除以100天，得出的数据为店铺动态评分
            </pre>

<button id="hide" type="button">隐藏</button>
<button id="show" type="button">显示</button>
用户名：<input type="text" name="name" id="name">
年  龄：<input type="text" name="age" id="age">
<input type="button" name="btn" id="btn" value="点击">

<script type="text/javascript">
    $('#btn').click(function(){
        $.ajax({
            url:"/response/index",
            datatype:"json",
            success:function(msg){
                $('#name').val(msg.name);
                $('#age').val(msg.age);
            }
        });
    });
</script>
</body>
</html>
