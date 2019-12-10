<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CommonUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use mysql_xdevapi\Exception;
use QL\QueryList;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Models\LookUp;

class LookUpController extends ToolController
{
    const  NAME = '洪扬';

    public function  demo(){
        $num = 0;
        while (true):
            $num++;
        switch ($num){
            case $num % 2 == 0:
                echo $num."<hr/>";
                break;
            case $num % 7 == 0:
                echo $num."<hr/>";
                break;
            case $num % 9 == 0:
                echo $num."<hr/>";
                break;
            case $num % 11 == 0:
                echo $num."<hr/>";
                break 2;
        }
        endwhile;
    }

    function  sum(...$vars){
        print_r($vars);die;//返回Array ( [0] => 1 [1] => 2 [2] => 3 [3] => 4 [4] => 5 [5] => 6 [6] => 10 )
        return array_sum($vars);
    }
    function  mobile($tel,$num=3,$fix='#'){
        $tel = substr($tel,0,-1*$num).str_repeat($fix,$num);
        return $tel;
    }
    //点方法
    public function  demo2(){
//        echo $this->sum(1,2,3,4,5,6,10);//31
        echo $this->mobile('15825502331',4,'*');//1582550****
    }

    function demo3_1():string//int类型就会报错，限制输出的返回值类型，string前面加?则代表，允许返回的值为NULL
    {
        return 'hongyang';
    }
    //函数返回值约束
    public function  demo3(){
       echo $this->demo3_1();//hongyang
    }
    function  demo4_1(int ...$a):int
    {
        static $count = 0;//static，让变量在函数体内持久保留，只有第一次调用函数的时候执行，去掉则每次都执行
        return $count += array_sum($a);
    }
    //静态变量
    public function demo4(){
        echo  $this->demo4_1(1,2,3);//6
        echo '<br/>';
        echo  $this->demo4_1(1,2,3);//12，去掉static类型则是6
    }

    function get_real_ip(){
        static $realip;
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }else if(isset($_SERVER['HTTP_CLIENT_IP'])){
                $realip=$_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip=$_SERVER['REMOTE_ADDR'];
            }
        }else{
            if(getenv('HTTP_X_FORWARDED_FOR')){
                $realip=getenv('HTTP_X_FORWARDED_FOR');
            }else if(getenv('HTTP_CLIENT_IP')){
                $realip=getenv('HTTP_CLIENT_IP');
            }else{
                $realip=getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }
    function getRedisVersion()
    {
        if (extension_loaded('redis')) {
            try {
                $redis = new \redis\Redis();
                // $redis->connect('redis', 6379);
                $redis->connect('127.0.0.1', 6379);//这里的ip填写的是redis容器的ip
                $info = $redis->info();
                return $info['redis_version'];
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return 'Redis 扩展未安装 ×';
        }
    }
    public function  demo5(){
//        $this->getRedisVersion();die;
//        echo  phpinfo();die;
        Redis::set('name', 'guwenjie');
        $values = Redis::get('name');
        dd($values);
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth("php001");
//这个key记录该ip的访问次数 也可改成用户id
//$key = 'userid_11100';
        $key=$this->get_real_ip();
//限制次数为5
        $limit = 5;
        $check = $redis->exists($key);
        if($check){
            $redis->incr($key);
            $count = $redis->get($key);
            if($count > 5){
                exit('请求太频繁，请稍后再试！');
            }
        }else{
            $redis->incr($key);
            //限制时间为60秒
            $redis->expire($key,60);
        }
        $count = $redis->get($key);
        echo '第 '.$count.' 次请求';
//获取客户端真实ip地址
    }

    function unique_rand($min, $max, $num) {
        $count = 0;
        $return = array();
        while ($count < $num) {
            $return[] = mt_rand($min, $max);
            $return = array_flip(array_flip($return));
            $count = count($return);
        }
        //打乱数组，重新赋予数组新的下标
        shuffle($return);
        return $return;
    }

    public function demo6(){
        //生成10个1到100范围内的不重复随机数
        $arr = $this->unique_rand(1, 100, 10);
        echo implode($arr, ",");
    }

    //序列化
    public function demo7(){
        $a = [1,2,3];
        $b = serialize($a);//序列化
        $c = unserialize($b);//反序列化
        var_dump($b);//a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}
        var_dump($c);//正常数组结构
    }

    function yzm(int $len=5):string
    {
        $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $code = '';
        for ($i=0;$i<$len;$i++){
            $index = $str[mt_rand(0,strlen($str)-1)];//随机取一位
            $code .= strtoupper($index);//转大写拼接
        }
        return $code;
    }
    //生成 验证码
    public function demo8(){
       echo $this->yzm(4);
    }


    public function demo9(){
        $handle = fopen('hongy.txt','r+');
        fseek($handle,filesize('hongy.txt'));
        $res = fwrite($handle,'123456789');
        fseek($handle,0);
        echo fread($handle,99);
    }

    public function demo10($num){
        try{
            $code = $this->geterror($num);
        }catch (\Exception $e){
            return $e->getMessage();
        }
        return '传值<=5，准确';
    }

    function geterror($num){
        $num =is_numeric($num) ? $num : '';

        if($num > 5){
            throw new \Exception('传值超过5了呀，注意注意');
//            CommonUtil::throwException('传值超过5了呀，注意注意');
        }else if ($num == ''){
            throw new \Exception('不是数字');
        }else if ($num < 0){
            throw new \Exception('不能小于0');
        }
    }

    //计算时间
    public function demo11(){
        $start = microtime(true);
        sleep(2);
        $end = microtime(true);

        $time=$end-$start;

//精确到十位小数,可自行调节

        echo number_format($time, 10, '.', '')." seconds";

    }


    public function demo12($time,$day){
        $time = strlen($time)>8 ? date('Ymd',$time) : $time;
        $time1 = date('Ymd',strtotime("$time -$day day"));
        $time2 = date('Ymd',strtotime("$time -1 day"));
        $time3 = strtotime($time1);
        $time4 = strtotime($time)-1;
        echo  '最近'.$day.'天为:'.$time1.'-'.$time2;
        echo "<br/>";
        echo $time3.'-'.$time4;
    }

    //新认证店铺邀请人查询
    public function  verifyInvitation($id){
        $id = $this->user_Identity($id);
        $userinfoVerify = DB::connection('mysql_U')->table('userinfo_verify')->where('userinfoId', $id)->first();
        $Invitation_id = $this->user_Identity($userinfoVerify->scene);
        $userinfoCenter = DB::connection('mysql_U')->table('userinfo_center')->where('bindId', $Invitation_id)->first();
        echo '认证状态：0 未申请，1 审核中 2 不通过， 3通过, 4 违规被取消';
        echo '<br>';
        echo '店铺ID:'.$id.',认证状态:'.$userinfoVerify->status;
        echo '<br>';
        echo '邀请人id:'.$userinfoCenter->bindId;
        echo '<br>';
        echo "邀请人uri:".$userinfoCenter->bindUri;
        echo '<br>';
        echo '邀请人手机号:'.$userinfoCenter->telephone;
    }

    //用户表和认证表绑定身份证信息比对
    public function userIdcardMatch($id){
        $id = $this->user_Identity($id);
        $userinfo = DB::connection('mysql_U')->table('userinfo')->where('id', $id)->first();
        $userinfoVerify = DB::connection('mysql_U')->table('userinfo_verify')->where('userinfoId', $id)->first();
        echo '用户ID:'.$id;
        echo '<br>';
        echo '用户表'.'用户名:'.$userinfo->name.'身份证:'.$userinfo->idCode;
        echo '<br>';
        echo '认证表'.'用户名:'.$userinfoVerify->name.'身份证:'.$userinfoVerify->idCode;
    }

    //产品库拍品佣金比例
    public function depotCommission($id){
        $id = $this->sale_Indentity($id);
        $data = DB::connection('mysql')->table('sale')->where('id', $id)->first();
        $profileJson = json_decode($data->profileJson,true);
        $depotCommission = $profileJson['depotCommission'];
        echo '拍品id:'.$id;
        echo '<br>';
        echo '佣金比例:'.$depotCommission.'%';
    }

    public function  event_hall($uri){
//        dump($uri);
//        $data = DB::connection('mysql_B')->table('balance')->where('out_trade_no', "$uri")->value('contentJson');
//        $str = 'targetUri":"';
//        $a = substr($data,strpos($data,$str),29);
//        $b = substr($a,12,16);
//        $title = DB::connetion('mysql_New')->table('common_apply_period')->where('uri',$b)->first();
//        dump($title);
//        dump($a);
//        dump($b);
//        dump($data);
    }

    public function  bank_verify(){
//        dump(123);die;
        $host = "https://yunyidata.market.alicloudapi.com";
        $path = "/bankAuthenticate4";
        $method = "POST";
        $appcode = "b3f0056c88a8456ba33883325d17a650";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
        $querys = "";
        $bodys = "ReturnBankInfo=YES&cardNo=6216618300017191952&idNo=342222198404050414&name=陈钢&phoneNo=13999829912";
        $url = $host . $path;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
        dump(curl_exec($curl));
    }

    public function one()
    {
        dd(1);
        return view('admin/lookUp/one');
    }

    public function info()
    {
        //return view('admin/lookUp/info');
        //phpinfo();
        $a = '';
        dd(empty($a));
        dd(isset($a));

    }

    public function index()
    {
//        $id = DB::connection('mysql_U')->table('userinfo')->where('id',18429200)->first();
//        $sns = $id->snsJson;
//        $arr = json_decode($sns,true);
//        $a = $arr['nickname'];
//        //dd($a);
//        $nickname = $this->get_property($a,"nickname",'');
//        dd($nickname);
        //return view('admin/lookUp/index');
        //date_default_timezone_set('PRC');
//         $b = date('Y-m-d H:i:s');
//         echo $b;
//         phpinfo();
//         $arr['aa'] = ['bb'];
//         $aa = $this->arrayLevel($arr);
//         dd($aa);
//        $val = 1.888;
//        $aa= intval(number_format($val, 2, ".", ""));
//        dd($aa);
//          date_default_timezone_set('PRC');
//          $startHour = date('G');
//          $a = [1,2];
//          $b = [3,4];
//          print_r($a + $b);
          //下分类词
        $arr = [
            '大马士革', '猎刀', '勃朗宁', '城市猎人', '削纸', '破甲', '折刀', '腰夹', '轴锁', '线锁', '背锁', '军刺', '开山刀', '血槽',
            '弹簧', '折叠刀', '美武士', '军刀', '警棍', '军用', '警用', '弹珠式锁定', '轴承', '甩棍', '甩刀', '扣刀', '袖刀', '武士刀',
            '兰博', '狗腿刀', '三棱刀', '四棱刀', '五棱刀', '多棱刀', '军警', '靴刀', '电击器', '防狼喷雾', '手铐', '特警', '武警', '公安',
            '麻醉吹管', '瞄准镜', '刮刀', '手刺', '拳刺', '三角镖', '六角镖', '多角镖', '弩', '砍骨刀', '剥皮刀', '放血刀', '屠宰刀', '分骨刀',
            '剔骨刀', '尼泊尔刀', '潜水刀', '海军陆战队', '敢死队', '战术直刀', '生存刀', '求生刀', '水管螺旋',
            '国外样品刀', '飞刀', '月牙铲', '工兵铲', '军工铲', 'kabar', '巴克', '直刀', '亿万年前', '狼鳍鱼', '大苗',
            '大喵骨', '狼牙', '大喵', '大猫', '大m', '剑齿虎', '孟加拉', '东北虎', '裸爪', '勾子', '血蝌蚪', '蝌蚪文', '蝌蚪纹', '象牙',
            '砗磲', '犀牛角', '鹤顶红', '盔犀鸟', '羚羊角', '虎骨', '虎皮', '玳瑁', '熊牙', '大猫骨', '新坑', '狼皮', '犭良皮', '熊胆',
            '虎鞭', '烟味', '烟草', 'V类', '烟砖', '干草香', '弗吉尼亚', '雪茄', '烟丝', '烟叶', '混合型草', '斗粮',
            'E草', 'Wessex', 'V草', 'Wessex', '稀草', '登喜路', '万宝路', '肯塔基', '烟气', '吸食', '卷烟', '古巴CUBA',
            '焦油量', '阿诗玛', '烤烟型', '烟气烟碱量', '雪佳', '白肋', '肯塔基', '烟民', '亨利木', '玉溪', '利群',
            '黄金叶', '第五套',
            '第五版人民币', '虎爪', '狼钩',
            'Virginia', 'Burleys', 'Perique', 'Kentucky', 'Black', 'Cavendish and Orient', 'Periqu', 'Bengal Slices',
            'Black Cavendish', 'Latakia', 'Oriental', 'Vriginia', 'Marlboro', 'ARK ROYAL', '白火种', 'Maba', '鸭绿江', 'CUBA', '鸟头',
            '丘吉尔', 'xuejia', '剑 齿', '吴高龙', '两会纪念币', '两会币', '两会纪念', '两会纪念b', '2会纪念币',
            '阿迪', 'Adidas', '耐克', 'Nike', '彪马', 'puma', '乔丹', '锐步', 'Reebok ', '斐乐', 'FILA', '美津侬', 'Mizuno', '茵宝',
            'UMBRO', '卡帕', 'KAPPA'
        ];
        //橱窗全平台违禁词
//        $arr = ["习近平", "彭丽媛", "江泽民", "胡锦涛", "邓小平", "温家宝", "毛泽东", "张德江", "李克强", "俞正声", "刘云山", "王岐山", "张高丽", "吴邦国", "贾庆林", "李长春", "贺国强", "周永康", "鹤顶红", "红珊瑚", "出土", "走私","人体写真", "人体艺术", "人体模特", "张嘉应", "张加应", "李贵君", "曾新伟", "杨飞云", "张义波","吴梅英", "李向标", "陈顺强", "张木林", "陈力", "陈建华", "春宫", "张晨燕", "黄振能", "性文化", "男女交合", "黄杏宝", "林国风", "吉秀荣", "冷军", "欧启春", "何家英", "李国华", "陈逸飞", "林成武", "黄兴宝", "颜良欣", "李卓然", "何艳梅", "吴静涵", "陈剑飞", "人与自然", "吕远清", "袁飞阳", "羞羞手卷"];

        $str = "【类别】:   打火机 ⭐古董打火机⭐ ✨✨金钱来来往往，特别的东西却不会经常都有✨ 拍        品      FLAMIDOR 产        地      法国 材        质      铝 描        述      五十年代法国flamidor生产烟斗机，机型FAVORI，半开放火石仓结构为更早期产品，顶部带备用火石仓，成色如图打火良好。 尺 寸mm      长70，直径18左右 ✔特殊说明      无 ✔邮        寄      稳妥起见，所有物品国内默认韵达到付。有时候会拆卸掉火石弹簧单独包装，请收到包裹打开仔细检查，以免误扔，确保物品安装到位再打火测试。 备        注      我不是砖家，无法普及关于它们的知识，只能尽力展示物品各个细节，做到不夸大不遮掩，✔请仔细看物品描述及图片视频✔，一切以图片视频为准，请考虑近景特写的放大效果，有需要引起买家注意的我会写在特殊说明中，有疑惑的尽管提问。对于百八十年的老机器，请勿以现代机标准套用，收货后请客观评价，谢谢。 二手收藏类物品，拍出后不以任何理由退货，敬请收货时录制开箱视频，港澳台不发货 ";//dd($str);
        foreach ($arr as $k => &$v) {
            if (strpos($str, $v)) {
                echo $v;
            }
        }
    }

//    //获取用户id
//    public function getID(Request $Request)
//    {
//        $telephoneId = $this->getUrl($Request);
//        $id = DB::connection('mysql_U')->table('userinfo_center')->where('telephone', "$telephoneId")->first();
//        //dd($id);
//        $id = $id->bindId;
//        return $id;
//    }

    //获取拍品id
    public function getSale(Request $Request)
    {
        $sale = $this->getUrl($Request);
        if(strlen($sale)==16){
            $sale = DB::connection('mysql')->select("select id from sale where uri = '$sale';");
            return $sale;
        }
        return $sale;
    }

    //获取用户其他的店铺
    public function AllShop(Request $Request)
    {
        $id = $this->getUrl($Request);
        $len = strlen($id);
        //dd($len);
        if ($len == 11) {
            $id = $this->getID($Request);
        }
        $idCode = DB::connection('mysql_U')->select("select idCode from userinfo where id='$id'");
        //dd($idCode);
        //转成字符串
        $idCode = $idCode[0]->idCode;
        if (empty($idCode)) {
            echo "用户没有绑定身份证";
            exit;
        }
        $data = DB::connection('mysql_U')->select("select id from userinfo where idCode='$idCode'");
        //json转换为数组
        foreach ($data as &$v) {
            $v = (array)$v;
        }
        $data2 = array_column($data, 'id');
        if (empty($data2)) {
            $idCode = DB::connection('mysql_U')->select("select idCode from userinfo_verify where id='$id'");
            $idCode = $idCode[0]->idCode;
            $data = DB::connection('mysql_U')->select("select id from userinfo_verify where idCode='$idCode'");
            foreach ($data as &$v) {
                $v = (array)$v;
            }
            $data2 = array_column($data, 'id');
            dd($data2);
        }
        dd($data2);
    }

    //卖家 每人每天每店铺限制
    public function sellerLimit(Request $Request)
    {
        $saleId = $this->getUrl($Request);
        $data = DB::connection('mysql')->select("select userinfoId,winUserinfoId,finishedTime from sale where id = $saleId;");
        foreach($data as &$value){
            $value = (array)$value;
        }
        $startTime = strtotime(date('Y-m-d' . '00:00:00', $value['finishedTime']));
        $endTime = strtotime(date('Y-m-d' . '00:00:00', $value['finishedTime'] + 86400));
        $userinfoId = $value['userinfoId'];
        $winUserinfoId = $value['winUserinfoId'];
        $order = DB::connection('mysql')->select("select id,uri,userinfoId,winUserinfoId,paidTime,deliveryTime,finishedTime from sale where userinfoId = $userinfoId and winUserinfoId = $winUserinfoId and finishedTime BETWEEN $startTime and $endTime order by finishedTime asc;");
        foreach($order as &$value){
            $value = (array)$value;
            $value['paidTime'] = date('Y-m-d H:i:s',$value['paidTime']);
            $value['deliveryTime'] = date('Y-m-d H:i:s',$value['deliveryTime']);
            $value['finishedTime'] = date('Y-m-d H:i:s',$value['finishedTime']);
        }
        dd($order);
    }

    //买家 每人每天每店铺限制
    public function buyerLimit(Request $Request)
    {

    }

    //商家积分扣分记录
    public function saleScore(Request $Request)
    {
        $Uid = $this->getUrl($Request);
        //dd($Uid);
        $len = strlen($Uid);
        if ($len == 11) {
            $Uid = $this->getID($Request);
            $data = DB::connection('mysql')->select("select saleId,deductScoreJson from sale left join sale_extend on sale.id = sale_extend.saleId where userinfoId = '$Uid' and trim(deductScoreJson) != '';");
            dd($data);
        } else {
            $saleId = $this->getUrl($Request);
            $saleId = (int)$saleId;
            $data = DB::connection('mysql')->select("select saleId,ScoreJson,deductScoreJson from sale_extend where saleId = '$saleId' and trim(ScoreJson) != '';");
            dd($data);
        }

    }

    //每日抽奖
    public function lottery()
    {
//        $info = DB::connection('mysql')->select("select id,uri,endtime from sale where type=1 and status='sale' and isDel=0 order by endtime");
//        //dd($info);
//        $saleId = [];
//        foreach ($info as $k => &$v) {
//            $v = (array)$v;
//            $saleId[] = $v['id'];
//        }
//        $saleId = implode($saleId, ',');
//        $data = DB::connection('mysql')->select("select saleId,uri,endtime,count(saleId) as number from sale left join bid_extend on sale.id = bid_extend.saleId where type=1 and status='sale' and isDel=0 and saleId in ($saleId) group by saleId order by number");
//        dd($data);
        // 获取去掉重复数据的数组
        $arr = ['1180266233','1170764013','1189219533','1173053487','1174800919','1188006093','1191203612','1194511572','1182007914','1189312973','1169394286','1154074729','1186486487','1154191124','1180616820','1170198740','1158696278','1193436852','1138294282','1011885067','1186767072','1190085197','1169531059','1183958205','1139497387','1153321606','1151239442','1176042954','1172516509','1183377884','1118128785','1169968273','1181157156','1178333723','1199963727','1191956903','1183666098','1187490902','1196342190','1167558737','1198972363','1186007733','1190977008','992651816','977291012','1192490343','1198712209','976955443','1173116216','1190020592','1191419896','1168813599','1191587124','1188853284','1198741668','1194791140','1199406874','1180426745','1199035947','1178604302','1206691785','1197762628','1202830107','642253157','1202702642','1187763310','1192162848','1131669889','1180179970','1107901323','1150900832','1199726972','969359946','1187705399','1195906939','1203703805','1187844197','1180949541','1186733714','1195471073','1181679899','1176292383','1201149340','1118363060','1202280045','1179805087','1199966251','1187608030','1200781914','1124785771','1197312644','1190019564','1187575399','1202146759','1193714132','1165927711','1200311249','1201979852','1205439680','1208739085','1205429992','1200151340','1201240459','1208707084','1196387198','1204938566','1198588498','1196797794','1210092797','1208484089','1204666390','1184531657','1193184413','1193174181','1187092477','1191234151','1212062358','1192322951','1208890258','1182222896','1203728613','1208603036','1209350631','1192331680','1196738937','1215682391','1209615228','1210289586','1203410271','1218442192','1183572556','1173722843','1163224691','1142750173','1176885714','1199026331','1200140818','1195258452','1205306346','1196545914','1218011949','1214204992','1210167395','1209845793','1214658348','1170331910','1188012069','1192147638','1163972669','1207899933','1190126218','1200432422','1213713512','1210303635','1192487616','1194529964','1216604020','1144696397','1193517042','1214702890','1215859578','1215469202','1216690904','1151903084','859892471','1201221388','1207476593','1215704440','1199878167','1214762516','1216217954','1217023748','1181685629','1133198730','1189344389','1200093778','1169003503','1216938439','1204836122','1166961163','1176639289','1224987497','1219374153','1214831017','1205197953','1205114188','1167509647','1205297559','1195955552','1217181013','1221792879','1220050822','1220117035','1055027383','1177237981','1220644525','1212016852','1203115242','1207841236','1205743733','1220071335','1207628553','1219240337','1209650884','1213631252','1215591684','1190731042','1211988029','1208655278','1197410980','1160894667','1221698558','1217704374','1191079394','1198967054','1194512847','1198374254','1217214433','1228360546','1223310268','1210283558','1027046046','1223693675','1225111142','1216182024','1215460114','1198566267','1189443569','1227240637','1206544239','1217049541','1146885475','1202509052','1190085752','1201908611','1179212572','1189970099','411807325','1217355992','1229415935','id1199213969','id1228474782','id1201112348','1228551347','1179526470','1215847015','1217019907','1228341268','1221560043','1227478572','1212434502','1201908511','1209969211','1211099196','1224422274','1232057730','1206546863','1223650480','1216975420','1207843733','1219350480','1235478075','1206585650','1097311003','1236382634','1217729229','1200827991','1203602865','1217248400','1188101787','1192088899','1220145921','1220192558','1239707114','1223983889','1234122121','1230977769','1211313963','1214394743','1210216450','1213207936','1187336470','1225681805','1238598265'];
        $unique_arr = array_unique ( $arr );
        // 获取重复数据的数组
        $repeat_arr = array_diff_assoc ( $arr, $unique_arr );
        dd($repeat_arr);
    }

    //根据订单获取id
    public function toBlance(Request $Request)
    {
        $OutTradeNo = $this->getUrl($Request);
        $id = DB::connection('mysql_B')->select("select userinfoId from balance where out_trade_no = '$OutTradeNo'");
        dd($id);
    }

    //根据银行卡查询用户信息
    public function bankCard(Request $Request)
    {
        $bankCard = $this->getUrl($Request);
        $info = DB::connection('mysql_B')->select("select * from bank_card where cardNo = '$bankCard'");
        $id = [];
        foreach ($info as $k => $v) {
            $id[] = $info[0]->userinfoId;
        }
        //$id = array_unique($id[]);
        dd($id);
        //dd($info);
    }

    //用户积分变动日志
    public function verifyScore(Request $Request,$id)
    {
//        $id = $this->getID($Request);
        $exchangeScore = DB::connection('mysql_B')->select("select * from exchange_log where userinfoId = '$id'");
        //dd($exchangeScore);
        //时间戳转化为时间
        foreach ($exchangeScore as $v) {
            date_default_timezone_set('PRC');
            $v->createTime = date('Y-m-d H:i:s', $v->createTime);
            switch ($v->type) {
                case 1:
                    $v->type = "实名认证";
                    break;
                case 2:
                    $v->type = "兑换捡漏推广位";
                    break;
                case 3:
                    $v->type = "首次兑换捡漏推广位赠送积分";
                    break;
                case 4:
                    $v->type = "兑换橱窗推广位";
                    break;
                case 5:
                    $v->type = "邀请商家认证兑换积分";
                    break;
                case 6:
                    $v->type = "首次缴满1000元消保金";
                    break;
                case 7:
                    $v->type = "邀请人认证领取积分";
                    break;
                case 8:
                    $v->type = "新年邀请有礼积分加倍";
                    break;
                case 9:
                    $v->type = "兑换分类推广位";
                    break;
            }
        }
        dd($exchangeScore);
    }

    //屏蔽的用户数量
    public function blacklist(Request $Request)
    {
        $id = $this->getID($Request);
        $blacklist = DB::connection('mysql_U')->select("select count(*) as num from userinfo_blacklist where userinfoId= '$id'");
        $num = $blacklist[0]->num;
        dd($num);
    }

    //获取卖家违约扣分
    public function afterSale(Request $request)
    {
        $uId = $this->getID($request);
        //dd($uId);
        $data = DB::connection('mysql')->select("select saleId from sale left join sale_extend on sale.id = sale_extend.saleId where userinfoId = $uId and trim(scoreJson) != '' and scoreJson like '%\"sellerLevelScores\":-%' order by saleId desc;");
        if (empty($data)) {
            die('商家无违约记录');
        }
        foreach($data as &$v)
        {
            $v = array($v);
            $ids = array_column($v, 'saleId');
            $ids = implode($ids);
            echo "，".$ids;
        }

    }

    public function  readcsv(){
        $file = fopen('23.00-24.00.csv','r');
        while ($data = fgetcsv($file)) { //每次读取CSV里面的一行内容
//print_r($data); //此为一个数组，要获得每一个数据，访问数组下标即可
            $goods_list[] = $data;
        }
//print_r($goods_list);
        /* foreach ($goods_list as $arr){
            if ($arr[0]!=""){
                echo $arr[0]."<br>";
            }
        } */
        echo $goods_list[2][0];
        fclose($file);

    }

    //获取卖家违约不扣分
    public function deduct(Request $request)
    {
        $uId = $this->getID($request);
        //dd($uId);
        $data = DB::connection('mysql')->select("select saleId,uri,scoreJson,afterSaleJson,deductScoreJson from sale left join sale_extend on sale.id = sale_extend.saleId where userinfoId = '$uId' and trim(scoreJson) != '' and deductScoreJson like '%\"deductScores\":-%';");
        if (empty($data)) {
            die('商家无扣分订单');
        }
        dd($data);
    }

    //买家违约扣分
    public function buySale(Request $request,$id,$type)
    {
        $winId = $this->getID($request);
//        dd($winId);
        $type == 1?'违约':'退货';
        dd($type);die;
//        $data = DB::connection('mysql')->select("select saleId,scoreJson,finishedTime from sale left join sale_extend on sale.id = sale_extend.saleId where winUserinfoId = '$winId' and trim(scoreJson) != '' and scoreJson like '%\"buyerLevelScores\":-%' order by finishedTime desc");
        $data = DB::connection('mysql_U')->select("select * from userinfo_member_log where userinfoId = '$winId' and  memberLevelScores < 0 and in('$type')");
//        if (empty($data)) {
//            die('用户无违约记录');
//        }
//        dd($data);
        foreach ($data as $k => &$v) {
            $v = (array)$v;
//            $v['finishedTime'] = date("Y-m-d H:i:s", $v['finishedTime']);
        }
        //$this->export_csv($data);
        dd($data);
    }

    //违约商品ID
    public function saleId(Request $request)
    {
        $uId = $this->getID($request);
        //dd($uId);
        $data = DB::connection('mysql')->select("select saleId,uri,scoreJson,afterSaleJson,deductScoreJson from sale left join sale_extend on sale.id = sale_extend.saleId where userinfoId = '$uId' and trim(scoreJson) != '' != '' and scoreJson like '%\"sellerLevelScores\":-%' order by saleId desc;");
        if (empty($data)) {
            die('用户无违约记录');
        }
        //dd($data);
        $id = [];
        foreach ($data as $k => $v) {
            $id[] = $data[0]->saleId;
        }
        dd($id);
    }

    public function re_verify(Request $request,$phone){
        if(preg_match("/^1[345678]{1}\d{9}$/",$phone)){
            $data = DB::connection('mysql_U')->select("select * from userinfo_verify where telephone = '$phone';");
        }else{
            $data = DB::connection('mysql_U')->select("select * from userinfo_verify where userinfoId = '$phone';");
        }
//        $data = DB::connection('mysql_U')->select("select * from userinfo_verify where telephone = '$phone';");
        $count = count($data) == 1 ? count($data) : 1;
        if($count !== 1){
            return $count.'个数据';
        }
        $expiredTime ='过期时间是:'.$data[0]->expiredTime;
        $time = "当前时间是:".time();
        $days = "60天的时间是:5184000";
        $days2 = "15天的时间是:1296000";
        $re_verify_time = $data[0]->expiredTime-time()-5184000;
        $re_verify_time = "最后时间:".$re_verify_time;
        $uid = $data[0]->userinfoId;
        dump("店铺名:".$data[0]->shopName);
        dump("用户id:".$uid);
        dump($expiredTime);
        dump($time);
        dump($days);
        dump("free_edit_verify_".$uid);
        dump($re_verify_time);
        dump("allow_free_edit_verify_".$uid);
        dump($days2);
    }


    //聚合搜索
    //用户手机号,uri,id判断（获取用户id）
    public  function  user_Identity($params){
        $uid = 0;
        $uri = "";
        if (!$params) {
            return [$uid, $uri];
        }
        //如果是数字类型
        if (is_numeric($params)) {
            if (strlen($params) == 11) {
                $uid = DB::connection('mysql_U')->table('userinfo_center')->where('telephone', $params)->value('userinfoId');
            }else {
                $uid = $params;
            }
           return $uid;
        }

        //如果是字符串类型,并且字符长度是16位
        if (strlen($params) == 16 && preg_match("/^[a-z\d]*$/i", $params)) {
            $uri = $params;
            $uid = $uri = DB::connection('mysql_U')->table('userinfo_center')->where('bindUri', $params)->value('userinfoId');
            return $uid;
        }
    }
    //拍品id，uri搜索
    public function  sale_Indentity($params){
        //如果是数字类型
        if (is_numeric($params)) {
                $id = $params;
        }
        //如果是字符串类型,并且字符长度是16位
        if (strlen($params) == 16 && preg_match("/^[a-z\d]*$/i", $params)) {
            $id = $uri = DB::connection('mysql')->table('sale')->where('uri', $params)->value('id');
        }
        return $id;
    }

    //查询商家15天退款（从昨天开始往前推15天）
    public function sell_returned($id)
    {
        $id = $this->user_Identity($id);
        //今天0点时间
        $endTime = strtotime(date('Y-m-d',time()-1));
        //往前推15天
        $startTime = strtotime(date('Y-m-d'))-15*86400;
        $time3 = time();
//        $data = DB::connection('mysql')->select("select * from sale where finishedTime between {$time2} and {$time1} and userinfoId = {$id} and unsoldReason = 'returned';");
        $data = DB::connection('mysql')->table('sale')->where(['userinfoId'=>$id,'unsoldReason' => 'returned'])->whereBetween('finishedTime',[$startTime,$endTime])->get();
        $arr = [];
       foreach ($data as $key=>$val){
            $arr[$key] = $val->id;
        }
        var_dump($arr);
        dd($data);
    }

    //查询商家15天交易的订单（从昨天开始往前推15天）
    public function sell_finished($id)
    {
        $id = $this->user_Identity($id);
        //今天0点时间
        $endTime = strtotime(date('Y-m-d',time()-1));
        //往前推15天
        $startTime = strtotime(date('Y-m-d'))-15*86400;
        $time3 = time();
//        $data = DB::connection('mysql')->select("select * from sale where finishedTime between {$time2} and {$time1} and userinfoId = {$id}  and status = 'finished';");
        $arr = [];
        $data = DB::connection('mysql')->table('sale')->where(['userinfoId'=>$id,'status' => 'finished'])->whereBetween('finishedTime',[$startTime,$endTime])->get();
        foreach ($data as $key=>$val){
            $arr[$key] = $val->id;
        }
        var_dump($arr);
        dd($data);
    }

    //查询某天时间段
    public function returned()
    {
        //商家订单数据导出(sale)
        //$data = DB::connection('mysql')->select("select id,userinfoId,winUserinfoId,launchTime from sale where launchTime between UNIX_TIMESTAMP('2018-05-16 00:00:00') and UNIX_TIMESTAMP('2018-05-23 00:00:00') and userinfoId = 7720471 and unsoldReason = 'returned';");
//        foreach ($data as $k=>&$v)
//        {
//            $v = (array)$v;
//        }
//        //dd($data);
//        $aa = $this->export_csv($data);
//        return $aa;
//        $data = DB::connection('mysql')->select("select id,winJson from sale where userinfoId = 5074386 and status='finished' and finishedTime BETWEEN 1525104000 and 1527695940");
//        //dd($data);
//        foreach ($data as $k => &$v) {
//            $v = (array)$v;
//            $v['winJson'] = json_decode($v['winJson'], true);
//            $v['price'] = $v['winJson']['price'];
//            //$v['finishedTime'] = date("Y-m-d H:i:s", $v['finishedTime']);
//            unset($v['winJson']);
//        }
//
//        //dd($data);
//        $aa = $this->export_csv($data);
//        return $aa;
        ini_set('memory_limit', '2048M');
        //商家手续费导出 (balance)
//        $arr = ['1811231220ekhvdm','1811122226tykeh4','18112022028ftuos','1811111414eyqfgt','1811181615amfaxf','1811151824oa4lht','1811151946vf44mm','1811151725yiqxqh','1811151549yustwi','18111515347xre8s','1811151536psvs5f','1811141139lqacsk','1811221651ymhks3','18111817286ohvy4','1811181728zfupk5','1811131844lgezz1','181112210278pi1j','1811151746idouc1','1811151552zspz2t','1811151538aylbs7','1811202214d2bqey','1811141913cybkw7','1811131542lgdrz3','18111315422zcx9o','1811121422md9zun','1811121825bswpll','18111313218lgi0b','1811112248x6rjfb','1811120829vyqi2z','1811111904xxiy91','1811120948489w7z','1811120944l620xp','18111000000cmwko','1811121438m0uz2l','1811151539qy23et','1811112010jnqkiv','18111113028osmp0','1811111242nssrry','1811111205skcotn','1811111112au9zjg','18111111128wjz7x','1811111103cltfr0','18111111034cmckc','181111005867kvgl','1811111640jlbcqt','1811111313e1ljw1','1811111228g0l6xa','18111112165vzwtx','18111011311mwimz','1811101113mbbd3y','1811112221fp3cii','1811112219r1crfu','18111122201xbg8v','1811112219vhkehr','181111221852qju6','1811101026h9agng','1811101027p6aar0','18111010274vqd7d','1811101027ws2lti','18110921257uqc8w','1811092124spifps','1810301011srzjmg','1811031959f158v2','1811031959y36ujh','1810301012atjbbb','18103010128sy641','1810301012x9fus9','1810301011elfuib','1810301011m70lh4','1810261848c7moxg'];
//        $a = [];
//        foreach ($arr as $k=>&$v){
//            $data = DB::connection('mysql_B')->select("select money/100,out_trade_no,contentJson from balance where out_trade_no = '$v' AND `type` = 'system_in'");
//            $a[] = (array)$data;
//        }
//        dd($a);
//        //$b []= [];
//        foreach($a as $k1=>&$v1){
//            foreach($v1 as $k2=>&$v2){
//                $v2 = (array)$v2;
//                $v2['contentJson'] = json_decode($v2['contentJson'], true);
//                $v2['contentJson']['fee'] = implode('，',$v2['contentJson']['feeJson']);
//                //$b[] =  $v2['contentJson']['out_trade_no'];
//                $b[][] = $v2['contentJson']['fee'];
//                //unset($v['contentJson']);
//            }
//        }
//        dd($b);
        //$this->downLoadDataList($b);
//        $data = DB::connection('mysql_B')->select("select saleUri,money,fee,contentJson,updateTime from balance where userinfoId = 1132768 and fee >0 and updateTime >1530806400");
//        foreach ($data as $k => &$v) {
//            $v = (array)$v;
//            $v['contentJson'] = json_decode($v['contentJson'], true);
//            $v['money'] = $v['money']/100;
//            $v['fee'] = $v['fee']/100;
//            $v['remark'] = $v['contentJson']['feeJson'];
//            $v['remark'] = implode($v['remark'],'；');
//            $v['updateTime'] = date("Y-m-d H:i:s", $v['updateTime']);
//            $v['saleUri'] = 'https://w.weipaitang.com/uri/'.$v['saleUri'];
//            unset($v['contentJson']);
//        }
//        //dd($data);
//        $this->downLoadDataList($data);


         //订单编号，商家名称，商家电话，成交金额 ，交易完成时间
//        $data = DB::connection('mysql')->select("select uri,finishedTime,winJson,userinfoId from sale where winUserinfoId = 7083973 AND status = 'finished';");
//        foreach($data as $k=>&$v){
//            $v = (array)$v;
//            $v['winJson'] = json_decode($v['winJson'],true);
//            $v['成交金额'] = $v['winJson']['price'];
//            $v['拍品链接'] = 'https://w.weipaitang.com/uri/'.$v['uri'];
//            $v['交易完成时间'] = date('Y-m-d H:i:s',$v['finishedTime']);
//            unset($v['finishedTime']);
//        }
//        //$this->downLoadDataList($data);
////        dd($data);
//        $ids = array_column($data, 'userinfoId');
//        $ids = implode($ids, ',');
//
//        //dd($data);
//        //用户电话，店铺名
//        $uId = DB::connection('mysql_U')->select("select userinfoId,telephone,shopName from userinfo_verify where userinfoId in ($ids)");
//        foreach ($uId as $key=>&$val){
//            $val = (array)$val;
//        }
//        $uId = collect($uId)->keyBy('userinfoId')->toArray();
//         dd($uId);
//        foreach ($data as $k=>$item){
//            if(isset($uId[$item['userinfoId']])){
//                $data[$k]['telephone'] = $uId[$item['userinfoId']]['telephone'];
//                $data[$k]['shopName'] = $uId[$item['userinfoId']]['shopName'];
//            }else{
//                $data[$k]['telephone'] = '';
//                $data[$k]['shopName'] = '';
//            }
//        }
//        dd($data);
//        $this->downLoadDataList($data);
//        dd($uId);

        //订单号，商家名称，成交金额，交易状态，付款时间，完成时间 (sale)
//        $data = DB::connection('mysql')->select("select id as '拍品id',winJson,status as '拍品状态',unsoldReason as '流拍原因',paidTime,finishedTime from sale where userinfoId = 1037163 and winUserinfoId = 18665860;");
//        foreach ($data as $k=>&$v) {
//            $v = (array)$v;
//            $v['winJson'] = json_decode($v['winJson'],true);
//            $v['price'] = $v['winJson']['price'];
//            $v['paidTime'] = date("Y-m-d H:i:s", $v['paidTime']);
//            $v['finishedTime'] = date("Y-m-d H:i:s", $v['finishedTime']);
//            unset($v['winJson']);
//        }
//        $this->downLoadDataList($data);
//        //$this->export_csv($data);
//        dd($data);

        //用户余额明细导出（balance）
//        $data = DB::connection('mysql_B')->select("select saleId,money,type,contentJson,updateTime from balance where userinfoId = 23557014 order by createTime DESC ");
//        //dd($data);
//        foreach ($data as $k => &$v) {
//            $v = (array)$v;
//            $v['contentJson'] = json_decode($v['contentJson'], true);
//            $v['updateTime'] = date("Y-m-d H:i:s", $v['updateTime']);
//            $v['money'] = $v['money']/100;
//            if (empty($v['contentJson']['body']) && $v['type'] == 'repay')
//            {
//                $v['remark'] = '违约赔偿金';
//            }else{
//                $v['remark'] = $v['contentJson']['body'];
//                $v['remark'] = preg_replace("/(,)/" ,'' ,$v['remark']);
//            }
//            //$v['remark'] = $v['contentJson']['body'];
//            unset($v['contentJson']);
//            unset($v['type']);
//        }
//        dd($data);
        //$this->export_csv($data);

        //商家订单查询
//        $data = DB::connection('mysql')->select("select id,secCategory,priceJson,winJson,status,createTime from sale where userinfoId = 2922981 and createTime BETWEEN '2018-11-5 0:0:0' and '2018-11-6 0:0:0'");
//
//        foreach ($data as $k => &$v) {
//            $v = (array)$v;
//            $v['name'] = '蜜蜡缘';
//            $v['priceJson'] = json_decode($v['priceJson'], true);
//            $v['bidmoney'] = $v['priceJson']['bidmoney'];
//            if(in_array($v['status'],['finished','paid','delivery','refunding','refundpause','returning','agreeReturn','returnpause','deliveryReturn'])){
//                $v['isPaid'] ='是';
//            }else{
//                $v['isPaid'] ='否';
//            }
//            if(!empty($v['winJson'])){
//                $v['winJson'] = json_decode($v['winJson'], true);
//                $v['price'] = $v['winJson']['price'];
//            }else{
//                $v['price'] = '未成拍';
//            }
//            if($v['secCategory'] ===1004){
//                $v['secCategory'] ='琥珀/蜜蜡';
//            }
//            unset($v['priceJson']);
//            unset($v['winJson']);
//            unset($v['status']);
//        }
        //$this->export_csv($data);
        //dd($data);

        //订单状态查询
//        $data = DB::connection('mysql_B')->select("select saleId,status from `order` where saleId in(1342882578,1342851273,1342862390,1341402278,1341402280,1341445990,1342848885,1342852778,1342858711,1342863603,1341410654,1341439054,1341453334,1342847090,1342871259,1341410647,1341428887,1342873573,1342875532,1342878930,1342860681,1341402292,1342892810,1342856414,1342814980,1342832320,1341428896,1342890202,1342876439,1342877205,1342878064,1342879710,1342883570,1341369554,1342890812,1342891424,1341402290,1342874510,1340535117,1342896902,1340534201,1342894291,1341402285,1340535434,1341410642,1342824892,1341410644,1340535728,1341410651,1342889393,1341402286,1340534815,1342896117,1342880638,1341402294,1342841053,1342869682,1342821851,1341453343,1342872487,1342826601,1341410653,1341439059,1341402288,1341435388,1341410649,1341410656,1341428891,1342895015,1342892148,1342893495,1341425209,1341435386,1341445988,1342884553,1341453341)");
//        $arr = ['1342882578','1342851273','1342862390','1341402278','1341402280','1341445990','1342848885','1342852778','1342858711','1342863603','1341410654','1341439054','1341453334','1342847090','1342871259','1341410647','1341428887','1342873573','1342875532','1342878930','1342860681','1341402292','1342892810','1342856414','1342814980','1342832320','1341428896','1342890202','1342876439','1342877205','1342878064','1342879710','1342883570','1341369554','1342890812','1342891424','1341402290','1342874510','1340535117','1342896902','1340534201','1342894291','1341402285','1340535434','1341410642','1342824892','1341410644','1340535728','1341410651','1342889393','1341402286','1340534815','1342896117','1342880638','1341402294','1342841053','1342869682','1342821851','1341453343','1342872487','1342826601','1341410653','1341439059','1341402288','1341435388','1341410649','1341410656','1341428891','1342895015','1342892148','1342893495','1341425209','1341435386','1341445988','1342884553','1341453341'];
//        $data = [];
//        foreach ($arr as $k => $v) {
//            $data[] = DB::connection('mysql_B')->select("select saleId,status from `order` where `type` = 'residue' and saleId = $v");
//        }
//        dd($data);
//        $new = array();
//        foreach($data as $k=>$v){
//            foreach($v as $key => $val){
//                $json = json_encode($val);
//                $new[] = json_decode($json,true);
//            }
//        }
//        //$this->export_csv($new);
//        dd($new);
        //取消上捡漏
//        $arr=['13817780828','13434471835'];
//        $id = [];
//        foreach ($arr as $k=>$v){
//            //$ids[] = DB::connection('mysql_U')->select("select bindId from userinfo_center where telephone = '$v'");
//            $id [] = (array)DB::connection('mysql_U')->table('userinfo_center')->where('telephone', "$v")->first();
//            //dd($id);
//            $id []= $id[$k]['bindId'];
//        }
//        //$ids = DB::connection('mysql_U')->select("select * from userinfo_center where telephone = '$v'");
//
////        dd($id);
//        $arr = ['1453172642','1453180089','1453194457','1453195817','1453201749','1453209720','1453217480','1453237513','1453259018','1453260889','1453262135','1453291247','1453338565','1453347542','1453347900','1453364822','1453365145','1453366020','1453366309','1453370045','1453370691','1453371399','1453373684','1453373940','1453374193','1453374496','1453374761','1453375281','1453375848','1453382904','1453384558','1453409204','1453418280','1453419231','1453426733','1453427090','1453427434','1453440762','1453442464','1453450756','1453452405','1453456853','1453467396','1453471532','1453472582','1453473385','1453473731','1453503285','1453503386','1453503469','1453503515','1453503558','1453503646','1453506393','1453506561','1453506741','1453506833','1453507398','1453507472','1453507615'	];
//        $data = DB::connection('mysql_B')->select("select out_trade_no from balance_log where backJson = '' AND payMethod = 'balance' AND saleId in('1453172642','1453180089','1453194457','1453195817','1453201749','1453209720','1453217480','1453237513','1453259018','1453260889','1453262135','1453291247','1453338565','1453347542','1453347900','1453364822','1453365145','1453366020','1453366309','1453370045','1453370691','1453371399','1453373684','1453373940','1453374193','1453374496','1453374761','1453375281','1453375848','1453382904','1453384558','1453409204','1453418280','1453419231','1453426733','1453427090','1453427434','1453440762','1453442464','1453450756','1453452405','1453456853','1453467396','1453471532','1453472582','1453473385','1453473731','1453503285','1453503386','1453503469','1453503515','1453503558','1453503646','1453506393','1453506561','1453506741','1453506833','1453507398','1453507472','1453507615')");
//        dd($data);
//        $data = DB::connection('mysql')->select("select id,userinfoId from sale where endTime > '2018-12-21 00:00:00' and status = 'paid' AND paidTime < 1545667200");
//        foreach ($data as $k=>&$v)
//        {
//            $v = (array)$v;
//        }
//        //dd($data);
//        $ids = array_column($data,'userinfoId');
//        $ids = (array)array_unique($ids);
//        dd($ids);


//        $sum = DB::connection('mysql')->select("select * from sale where UserinfoId = 10344463 and isDel = 0");
//        foreach ($sum as &$value) {
//            $value = (array)$value;
//            $value['delayPayTime'] = date('Y-m-d H:i:s', $value['delayPayTime']);
//            $value['delayReceiptTime'] = date('Y-m-d H:i:s', $value['delayReceiptTime']);
//            $value['paidTime'] = date('Y-m-d H:i:s', $value['paidTime']);
//            $value['deliveryTime'] = date('Y-m-d H:i:s', $value['deliveryTime']);
//            $value['finishedTime'] = date('Y-m-d H:i:s', $value['finishedTime']);
//            if ($value['launchTime'] != 0) {
//                $value['launchTime'] = date('Y-m-d H:i:s', $value['launchTime']);
//            }
//        }
//        dd($sum);
//        $price = DB::connection('mysql')->select("select uri from sale where uri in('19010523236ivd52','1901090620g8s4zx','1901102132hk7qm6','19011023175kjkpw','1901111809a3i5tz','1901120852zbxq6e','1901122329ktd0hp','19011223479zwlev','1901122349u8s2xy','19011312107a0zof','1901131623ohsec6','19011321073arn5u','1901132129n8gzma','1901132201mryjic','1901132204rsyxsu','1901132356xo7k5o','1901141033nzhq35','1901142205mkpe2z','1901150103gj6e5q','19011501048f7ev0','1901150510h6klhs','1901151045mdipao','1901152204gxbrsf','1901152204u6repa','19011522070y7hat','19011522218ul5zm','1901152237d1s7t0','190115224739gbxr','1901152247rx1vbb','1901152257i65hck','1901160839vq4xtg','1901161546m6n50o','1901161708bqn593','1901161945752v7h','19011621298v44en','1901162200op1xzj','19011622024eb73m','1901162203w9gsjp','1901162215epcv60','1901162216j4e1ga','1901162217wfh41j','1901162341od6p6d','1901170504mzf1rp','1901170510gx9yrc','1901170710smmbl7','19011707302705i7','19011710223hczds','19011710228jey9a','1901171022srp7h7','19011710232qutqi','1901171023ddk436','1901171546jctdrj','1901171550lvariw','1901171754h47mji','19011719110za6fy','1901171914bdz44o','19011722084v49qm','19011722134a5vf1','1901172213c46n0o','1901172213rqugag','1901172213vjylco','19011722194ikv3x','19011722266l6x8w','190117230690ih7f','1901172313nsngkt','1901172315um2q31','1901172325jbpss6','1901180730eqfucv','1901180803qt4kxq','1901180918m6p6yr','1901180919akhw9e','19011810410whbcf','1901181057n32t7f','19011814590lf6uz','1901181815hb2hmw','19011818417z61oj','1901182001dk8guv','1901182155ilkcnc','1901182203bj6b8e','1901182203f365i2','1901182203fucepi','1901182203mnlg4i','1901182206qxynuu','1901182210zoquqs','1901182215hnscap','1901182218s99ukn','1901182249uxdqnl','1901182254hsuq14','19011822575il83b','1901190152u930lj','1901190733iz1qpp','1901191233qivm7f','1901191235txpfrc','1901191634wc3phx','19011916408n5y8k','1901191940r53v7l','1901191945cp7q7e','1901191950h24z0k','19011920180nbnj0','1901192037qlo4c4','19011923158n0x99','1901192322h0en44','1901192358wap7tl','19012008599i80mo','1901201331ie9t3x','1901202116nzutru','1901202329gi1z4j','1901202353ft4a3f','19012117522txyr8','1901212047h3yie0','1901220408a1is2l','1901220408avanxu','1901220408otbil3','1901220415h6onmi','1901220415nnw3ml','1901220419nm7p31','1901220419np73nq','1901220419wedd2n','1901220423cpk51q','1901220424rm9ya2','1901220428cyy9gs','1901220428o9k1i7','1901220428yxdofe','1901220434ir52o4','AN19011717xc95c7','J1901191neb3iuf7','J190119g0yy4gumt','N1901201725ak5g1') and status = 'finished' ");
//        foreach($price as &$value){
//            $value = (array)$value;
//            $value['winJson'] = json_decode($value['winJson'], true);
//            $value['price'] = (int)$value['winJson']['price'];
//            unset($value['winJson']);
//        }
        //$this->downLoadDataList($price);
//        dd($price);


        /********************************************工单完结时间数据********************************************/
//        $order = DB::connection('mysql_O')->select("select one.id,seller_name,seller_phone,seller_id,user_name,user_phone,user_id,sale_order,sec_category_name,solved_time,one.created_at,handling_time,operate_person,`name`,workorderId from `order` AS one left join `user` AS two on one.operate_person = two.id left join order_payment_divide AS three on one.id = three.workorderId  where sale_order is not null and solved_time BETWEEN 1546272000 AND 1548950400");
//        foreach ($order as &$value){
//            $value = (array)$value;
//            $value['useTime'] = $this->Sec2Time($value['solved_time'] - strtotime($value['created_at']));
//            $value['aUseTime'] = $this->Sec2Time($value['solved_time'] - $value['handling_time']);
//            if(empty($value['workorderId'])){
//                $value['order_payment_divide'] = '否';
//            }else{
//                $value['order_payment_divide'] = '是';
//            }
//            unset($value['solved_time']);
//            unset($value['created_at']);
//            unset($value['handling_time']);
//            unset($value['operate_person']);
//            unset($value['workorderId']);
//        }
//        //dd($order);
//        //$this->export_csv($order);
//        //dd($order);
//        $ids = array_column($order, 'sale_order');
//        $ids = implode($ids, ',');
//
//        $ids = str_replace("取消工单","111111",$ids);
//
//        $ids = preg_replace("/\r\n/","",$ids);
//
//        echo($ids);
//           exit;

        //成交金额，拍品分类
//        $uId = DB::connection('mysql')->select("select id,category,secCategory,winJson from sale where id in() ORDER BY INSTR(',443,419,431,440,420,414,509,',CONCAT(',',eventId,','))");
//        $uId = DB::connection('mysql_M')->select("select workOrderId,score from punish_record where workOrderId in() ORDER BY INSTR(',,',CONCAT(',',workOrderId,','))");



//        $ids = [];


//        foreach ($uId as $key=>&$val){
//            $val = (array)$val;
//            $val['winJson'] = json_decode($val['winJson'],true);
//            $val['price'] = $val['winJson']['price'];
//            $val['secCategory']= ToolController::CATEGORY[$val['category']]['secCategory_ids'][$val['secCategory']]['title'] ?? '';
//            $val['category']= ToolController::CATEGORY[$val['category']]['title'] ?? '';
//            $val['cate'] = $val['category'].'/'.$val['secCategory'];
//            unset($val['winJson']);
//            unset($val['category']);
//            unset($val['secCategory']);
//        }
//        $uId = collect($uId)->keyBy('workOrderId')->toArray();

//        $data = [];
//        foreach ($ids as $id){
//            $row = $uId[$id] ?? 0;
//            $data[] = [
//                 'id' => $id,
//                 'price' =>  $row['price'] ??0,
//                'cate' => $row['cate'] ?? 0
//            ]   ;
//        }
//        foreach ($ids as $id){
//            $row = $uId[$id] ?? 0;
//            $data[] = [
//                'workOrderId' => $id,
//                'score' =>  $row['score'] ??0
//            ]   ;
//        }
//        $this->export_csv($data);
        /**********************************************工单完结时间数据*********************************************/



        /*************近一个月内钱币和家具类目的订单信息**************/
        /*****拍品ID，商家ID，拍品成交金额*****/
//        $order = DB::connection('mysql')->select("select id,userinfoId,winJson from sale where secCategory = 5 AND status = 'finished' AND isDel = 0 AND finishedTime > 1550419200 AND isRated BETWEEN 0 AND 1");
//        foreach($order as &$val){
//            $val = (array)$val;
//            $val['winJson'] = json_decode($val['winJson'],true);
//            $val['price'] = $val['winJson']['price'];
//            unset($val['winJson']);
//        }
//        $this->export_csv($order);
        //$this->downLoadDataList($order);
        /*****拍品ID，商家ID，拍品成交金额*****/

        /***********商家实名认证时间***********/
//        $data = DB::connection('mysql_U')->select("select userinfoId,verifiedTime from userinfo_verify where userinfoId in () ORDER BY INSTR(',,',CONCAT(',',userinfoId,','))");
//        //dd($data);
//
//        foreach($data as &$val){
//            $val = (array)$val;
//            $val['verifiedTime'] = date('Y-m-d H:i:s',$val['verifiedTime']);
//        }
//        $uId = collect($data)->keyBy('userinfoId')->toArray();
//        $ids = [];
//        $data = [];
//        foreach ($ids as $id){
//            $row = $uId[$id] ?? 0;
//            $data[] = [
//                 'userinfoId' => $id,
//                 'verifiedTime' =>  $row['verifiedTime'] ??0,
//            ];
//        }
//        $this->export_csv($data);
        //dd($data);
        /***********商家实名认证时间***********/

        /*****************************商家账户消保金金额，商家违约比例，商家等级********************************/
//        $data = DB::connection('mysql_U')->select("select id,bail,creditsJson,sellerLevelScores from userinfo where id in () ORDER BY INSTR(',16366213,25773479,',CONCAT(',',id,','))");
//        foreach($data as &$val){
//            $val = (array)$val;
//            $val['bail'] = $val['bail']/100;
//            $val['creditsJson'] = json_decode($val['creditsJson'],true);
//            $val['sellFaultNum'] = $val['creditsJson']['sellFaultNum'];
//            $val['sellNum'] = $val['creditsJson']['sellNum'];
//            $val['wyl'] = sprintf("%.2f",substr(sprintf("%.3f", ($val['sellFaultNum'] / $val['sellNum']) * 100), 0, -1)) . "%";
//            $val['sellerLevel'] = 'V' . $this->sellerLevel($val['sellerLevelScores']);
//            unset($val['creditsJson'],$val['sellFaultNum'],$val['sellNum']);
//        }
//        //dd($data);
//        $uId = collect($data)->keyBy('id')->toArray();
//        $ids = [16366213,25773479];
//        $data = [];
//        foreach ($ids as $id){
//            $row = $uId[$id] ?? 0;
//            $data[] = [
//                 'userinfoId' => $id,
//                 'bail' =>  $row['bail'] ??0,
//                 'wyl' =>  $row['wyl'] ??0,
//                 'sellerLevel' =>  $row['sellerLevel'] ??0,
//            ];
//        }
        //$this->export_csv($data);
//        dd($data);
        /******************************商家账户消保金金额，商家违约比例，商家等级********************************/




        /**************近一个月内钱币和家具类目的订单信息*************/

        //dd($data);



        //$this->export_csv($uId);
        /************************订单生成工单后处理时长*****************************/
        //$order = DB::connection('mysql_O')->select("select solved_time,created_at,sale_order from `order` where sale_order in ());
//        $data = [];
//        foreach ($ids as $id) {
//            $row = $uId[$id] ?? 0;
//            $data[] = [
//                'id' => $id,
//                'useTime' => $row['useTime'] ?? 0,
//            ];
//        }
//
//        $this->export_csv($data);
        //dd($data);
        /**************************订单生成工单后处理时长***************************/

        /*****************工单创建时间,工单分类,买家昵称,买家ID,商家昵称,商家ID,订单ID(3个月内)****************************/
//        $order = DB::connection('mysql_O')->select("select orderId,dutyType from order_disputer where orderId in ()");
//        foreach($order as &$value){
//            $value = (array)$value;
//        }
//        //dd($order);
//        $uId = collect($order)->keyBy('orderId')->toArray();
//        $ids = [];
//        $data = [];
//        foreach ($ids as $id){
//            $row = $uId[$id] ?? 100;
//            $data[] = [
//                 'orderId' => $id,
//                 'dutyType' =>  $row['dutyType'] ??0,
//            ];
//        }
//        //$this->export_csv($data);
//        dd($data);
        /*****************工单创建时间,工单分类,买家昵称,买家ID,商家昵称,商家ID,订单ID（3个月内）****************************/


        /*****************2月份优惠券赔付记录****************************/
//        $order = DB::connection('mysql_M')->select("select one.content,one.checkRemark,one.createTime,two.nikeName,two.userinfoId,two.telephone,two.applyUserName,two.saleUri,one.userinfoId,one.id,one.checkUserName from coupon_record AS one left join coupon_apply AS two on one.applyId  = two.id  where one.createTime BETWEEN '2019-02-01 00:00:00' AND '2019-02-28 00:00:00';");
//        foreach($order as &$value){
//            $value = (array)$value;
//        }
        //$this->downLoadDataList($order);
        /*****************2月份优惠券赔付记录****************************/
//        $saleList = [];
//        $om = new OrderModel();
//        print_r("拍品ID^拍品描述^图片1^图片2^图片3^图片4^图片5^图片6^图片7^图片8^图片9^收件人姓名^收件人手机号^收件地址^成拍价格^付款时间\n");
//        foreach ($saleList as $saleId) {
//            $sale = Sale::singleGetSale($saleId);
//            $Oimages = $this->get_property(get_property($sale, 'profile', []), 'imgs', []);
//            foreach ($Oimages as &$im) {
//                $im = "https://cdn.weipaitang.com/img/" . $im;
//            }
//            $images = array_pad($Oimages, 9, "无");
//            $content = $this->get_property(get_property($sale, 'profile', []), 'content', "");
//            $content = str_replace(array("\r\n", "\r", "\n"), "", $content);
//            $price = $this->get_property($sale->win,'price',0);
//            $order = $om->getOne(['deliverJson'], ['saleId' => $saleId,'type'=>'residue']);
//            $order->deliver = json_decode($order->deliverJson);
//            $address = $this->get_property($order->deliver, 'proviceFirstStageName' . '') . get_property($order->deliver, 'addressCitySecondStageName' . '') . get_property($order->deliver, 'addressCountiesThirdStageName' . '') . get_property($order->deliver, 'addressDetailInfo' . '');
//            $name = $this->get_property($order->deliver, 'userName' . '');
//            $tel = $this->get_property($order->deliver, 'telNumber' . '');
//            $pt = date("Y-m-d H:i:s",$sale->paidTime);
//            $imgstr = implode("^", $images);
//            $out = $saleId . "^" . $content . "^" . $imgstr . "^" . $name . "^" . $tel . "^" . $address."^".$price ."^".$pt;
//            print_r($out);
//            print_r("\n");
//        }

        /***********************商家【大阪竹荷堂】982043 的交易信息*********************/
//        $data = DB::connection('mysql')->select("select id,endTime,paidTime,winUserinfoId,profileJson from sale where userinfoId = 982043 AND isDel = 0 AND paidTime>0 AND status = 'finished' AND isRated BETWEEN 0 AND 1;");
//        foreach($data as &$val){
//            $val = (array)$val;
//            $val['profileJson'] = json_decode($val['profileJson'],true);
//            $val['imgs'] = $val['profileJson']['imgs'];
//            $val['content'] = $val['profileJson']['content'];
//            $val['content'] = str_replace(array("\r\n", "\r", "\n"), "", $val['content']);
//            $val['paidTime'] = date('Y-m-d H:i:s',$val['paidTime']);
//            foreach ($val['imgs'] as &$im) {
//                $im = "https://cdn.weipaitang.com/img/" . $im;
//            }
//            $val['imgs'] = implode("图片链接", $val['imgs']);
//            unset($val['winJson']);
//            unset($val['profileJson']);
//        }
//        $this->export_csv($data);
        //dd($data);

        //导出地址
//        $data = DB::connection('mysql_B')->select("select saleId,deliverJson from `order` where status ='finished' AND saleId in();");
//        foreach($data as &$value){
//            $value = (array)$value;
//            $value['deliverJson'] = json_decode($value['deliverJson'], true);
//            $value['telNumber'] = $value['deliverJson']['telNumber'];
//            $addressDetailInfo = str_replace(array("\n",","), "", $value['deliverJson']['addressDetailInfo']);
//            $value['deliver'] = $value['deliverJson']['proviceFirstStageName'].$value['deliverJson']['addressCitySecondStageName'].$value['deliverJson']['addressCountiesThirdStageName'].$addressDetailInfo;
//            unset($value['winJson']);
//            unset($value['deliverJson']);
//        }
//        $this->export_csv($data);
        //dd($data);

//        $data = DB::connection('mysql')->select("select id,winJson from sale where userinfoId = 2131652 AND winUserinfoId != '' AND endTime BETWEEN '2019/2/28 00:00:00' AND '2019/3/1 00:00:00';");
//        foreach($data as $k=>&$v) {
//            $v = (array)$v;
//            $v['winJson'] = json_decode($v['winJson'], true);
//            $v['成交金额'] = $v['winJson']['price'];
//            unset($v['winJson']);
//        }
//        dd($data);


        /*******************买家是否复购********************/
        $result = DB::connection('mysql')->select("select id,winUserinfoId,winJson,finishedTime from sale where winUserinfoId in (5191325,29439306,2501201,12646695,27799947,8145836,21046161,27386466,29578561,5807925,12801815,12879280,19644684,12890579,1729693,8945553,1267014,3382017,12957074,12801815,9023387,13858854,8595330,23788660,5617106,1455770,24657119,24808109,16931102,25792351,8744326,1719766,1719766,2671451,29658641,4569850,1777267,1905319,20127928,9274936,24108545,5003403,14453492,11034984,27754510,3797209,19988611,17480051,27791291,9490525,1588721,4506743,27799947,4440414,17106287,3906104,1314586,22972945,6744466,29726336,18998762,15634987,28405204,521691,2964893,3663278,25125416,2704006,25062779,4492809,4492809,22943280,25230243,29474727,703536,24797189,45269,678234,5287299,1749641,22943280,4404695,17583532,16483336,7098686,16132194,4167978,6656667,29692919,16646109,732125,6275330,6660218,12353982,1025189,19529824,8843444,18589245,14309714,12604112,27110294,5265448,24787574,18333343,5191325,17609520,22272224,26533739,2902010,3202653,13686921,10078252,2376462,30230955,1086415,28935782,28459025,11245010,489376,4427879,462286,2596375,12764206,5878870,5033693,2207031,7797013,14271956,16666964,11891774,11698063,27716164,2686943,28142662,28534354,22564894,12186735,15689084,24879718,5593983,4596961,27021612,27093487,11071153,29726336,27742616,12350933,17711008,18019591,410169,2346376,24551080,9300742,8782971,17348810,3476479,16591984,4621135,19229659,785613,29411907,27282206,5705643,29688444,28946759,2536675,28840910,28770661,30124110,761702,1965003,20572453,5627620,5174868,1920038,2808316,19163405,17627441,20620597,28840910,30026827,25489494,28218365,455090,5033693,21138344,30420104,24860293,21307681,10702971,3955993,5705643,816124,16291377,10966128,18507980,2069277,92835,26048262,11753014,7460186,29945885,18989511,28640760,5814992,1588479,21009965,23703020,3787944,24306794,2111930,5237730,29595623,15063474,29950951,10848247,3749997,24172,26299374,6946045,23358623,12023995,1442711,11166111,2261805,10216593,13937273,16401514,5603965,30816760,18221781,1236422,5562359,30989954,16907521,4248889,15313277,28813123,1699475,3351770,1633611,319533,31163810,10335300,2302894,4082060,608629,7316639,6412086,29595542,12190108,6272871,6772278,5521465,5521465,21937847,25877276,25877276,5008141,1744040,1744040,3230986,18970596,18970596,21040830,15341749,17443767,18771027,5514034,15994043,15994043,14865638,14865638,8584066,8584066,6222487,28460203,7236499,7236499,7236499,12128507,12128507,17923815,20548712,20548712,18837026,18837026,5182653,15361774,1021962,1021962,92843,22237053,1608612,14454614,28916177,7947921,27632213,22302901,1596547,8165393,14271956,7565674,23703020,3038606,783065,30793227,2800385,30749880,5300291,6230287,14521458,14521458,30371531,5869502,8555203,10466257,7353415,24994326,27774072,17562072,3553866,1239599,3749997,16622777,3418238,19517440,27774072,1042831,30165221,2261805,30240386,4723453,4224521,7368005,4273515,5417580,8914663,12964760,18726405,616510,28960003,6349679,13332527,8412912,5562359,30135540,1788674,5925416,18048783,17989567,11709644,4163362,29092134,27734072,31043482,5844599,25637678,5783677,16980664,303806,30377387,4021725,25193125,26495671,23117290,27799947,4169529,6289441,6289441,16945519,31248105,6226021,28866153,31038678,1209322,692740,5343299,24920245,6388468,29829539,20346798,4898560,31219630,9127904,24400326,11146238,11146238,847740,14022592,13423906,28068793,3446915,462482,14977650,30465881,18144452,6794305,10735925,9942470,3814980,1777267,2596375,8744326,2105090,5191325,5191325,16332773,1272819,17248709,5191325,21523509,5377823,11215252,17835959,19452208,5145450,2934794,29285666,29285666,12027488,8249461,3010930,232408,1299844,26675931,13626880,3755902,1125423,7669020,29115388,4103902,25774138,8282811,29635242,5340203,16271574,501365,1597511,29764379,1534639,8341314,8232585,30958309,30188057,1599335,26508075,12689848,28942187,2679484,14071001,1398031,2333978,19362836,457676,95370,16534899,30368435,4007712,6369765,3314982,1868276,12237403,15757563,4890027,12353220,30689844,7160286,30599742,29554750,29999288,7633200,8036618,25856599,15373689,13240545,7965344,12419620,14700547,645038,13795448,27848936,29781821,24798908,30368435,30596210,3742243,8495972,12067951,23398006,27799947,29532146,29285666,5482928,19115893,21425298,30293453,9099762,30077429,30077429,4103902,24381077,24381077,13982328,816124,27873749,15977355,15913485,21056782,2264265,600389,9551279,14505506,23837618,24096666,128545,26544508,25599453,25599453,23644130,30994213,2036290,7498667,5931114) AND finishedTime > 1547308800 order by finishedTime asc;");
        foreach($result as &$v) {
            $v = (array)$v;
            $v['winJson'] = json_decode($v['winJson'], true);
            $v['price'] = $v['winJson']['price'];
            $v['finishedTime'] = date("Y-m-d H:i:s",$v['finishedTime']);
            unset($v['winJson']);
        }
        $uId = collect($result)->keyBy('winUserinfoId')->toArray();
        $ids = [5191325,29439306,2501201,12646695,27799947,8145836,21046161,27386466,29578561,5807925,12801815,12879280,19644684,12890579,1729693,8945553,1267014,3382017,12957074,12801815,9023387,13858854,8595330,23788660,5617106,1455770,24657119,24808109,16931102,25792351,8744326,1719766,1719766,2671451,29658641,4569850,1777267,1905319,20127928,9274936,24108545,5003403,14453492,11034984,27754510,3797209,19988611,17480051,27791291,9490525,1588721,4506743,27799947,4440414,17106287,3906104,1314586,22972945,6744466,29726336,18998762,15634987,28405204,521691,2964893,3663278,25125416,2704006,25062779,4492809,4492809,22943280,25230243,29474727,703536,24797189,45269,678234,5287299,1749641,22943280,4404695,17583532,16483336,7098686,16132194,4167978,6656667,29692919,16646109,732125,6275330,6660218,12353982,1025189,19529824,8843444,18589245,14309714,12604112,27110294,5265448,24787574,18333343,5191325,17609520,22272224,26533739,2902010,3202653,13686921,10078252,2376462,30230955,1086415,28935782,28459025,11245010,489376,4427879,462286,2596375,12764206,5878870,5033693,2207031,7797013,14271956,16666964,11891774,11698063,27716164,2686943,28142662,28534354,22564894,12186735,15689084,24879718,5593983,4596961,27021612,27093487,11071153,29726336,27742616,12350933,17711008,18019591,410169,2346376,24551080,9300742,8782971,17348810,3476479,16591984,4621135,19229659,785613,29411907,27282206,5705643,29688444,28946759,2536675,28840910,28770661,30124110,761702,1965003,20572453,5627620,5174868,1920038,2808316,19163405,17627441,20620597,28840910,30026827,25489494,28218365,455090,5033693,21138344,30420104,24860293,21307681,10702971,3955993,5705643,816124,16291377,10966128,18507980,2069277,92835,26048262,11753014,7460186,29945885,18989511,28640760,5814992,1588479,21009965,23703020,3787944,24306794,2111930,5237730,29595623,15063474,29950951,10848247,3749997,24172,26299374,6946045,23358623,12023995,1442711,11166111,2261805,10216593,13937273,16401514,5603965,30816760,18221781,1236422,5562359,30989954,16907521,4248889,15313277,28813123,1699475,3351770,1633611,319533,31163810,10335300,2302894,4082060,608629,7316639,6412086,29595542,12190108,6272871,6772278,5521465,5521465,21937847,25877276,25877276,5008141,1744040,1744040,3230986,18970596,18970596,21040830,15341749,17443767,18771027,5514034,15994043,15994043,14865638,14865638,8584066,8584066,6222487,28460203,7236499,7236499,7236499,12128507,12128507,17923815,20548712,20548712,18837026,18837026,5182653,15361774,1021962,1021962,92843,22237053,1608612,14454614,28916177,7947921,27632213,22302901,1596547,8165393,14271956,7565674,23703020,3038606,783065,30793227,2800385,30749880,5300291,6230287,14521458,14521458,30371531,5869502,8555203,10466257,7353415,24994326,27774072,17562072,3553866,1239599,3749997,16622777,3418238,19517440,27774072,1042831,30165221,2261805,30240386,4723453,4224521,7368005,4273515,5417580,8914663,12964760,18726405,616510,28960003,6349679,13332527,8412912,5562359,30135540,1788674,5925416,18048783,17989567,11709644,4163362,29092134,27734072,31043482,5844599,25637678,5783677,16980664,303806,30377387,4021725,25193125,26495671,23117290,27799947,4169529,6289441,6289441,16945519,31248105,6226021,28866153,31038678,1209322,692740,5343299,24920245,6388468,29829539,20346798,4898560,31219630,9127904,24400326,11146238,11146238,847740,14022592,13423906,28068793,3446915,462482,14977650,30465881,18144452,6794305,10735925,9942470,3814980,1777267,2596375,8744326,2105090,5191325,5191325,16332773,1272819,17248709,5191325,21523509,5377823,11215252,17835959,19452208,5145450,2934794,29285666,29285666,12027488,8249461,3010930,232408,1299844,26675931,13626880,3755902,1125423,7669020,29115388,4103902,25774138,8282811,29635242,5340203,16271574,501365,1597511,29764379,1534639,8341314,8232585,30958309,30188057,1599335,26508075,12689848,28942187,2679484,14071001,1398031,2333978,19362836,457676,95370,16534899,30368435,4007712,6369765,3314982,1868276,12237403,15757563,4890027,12353220,30689844,7160286,30599742,29554750,29999288,7633200,8036618,25856599,15373689,13240545,7965344,12419620,14700547,645038,13795448,27848936,29781821,24798908,30368435,30596210,3742243,8495972,12067951,23398006,27799947,29532146,29285666,5482928,19115893,21425298,30293453,9099762,30077429,30077429,4103902,24381077,24381077,13982328,816124,27873749,15977355,15913485,21056782,2264265,600389,9551279,14505506,23837618,24096666,128545,26544508,25599453,25599453,23644130,30994213,2036290,7498667,5931114];
        $data = [];
        foreach ($ids as $id) {
            $row = $uId[$id] ?? 100;
            $data[] = [
                'id' => $row['id'] ?? '未复购',
                'winUserinfoId' => $id,
                'finishedTime' => $row['finishedTime'] ?? 0,
                'price' => $row['price'] ?? 0,
            ];
        }
        $this->export_csv($data);
        //dd($data);
//        $result = DB::connection('mysql_B')->select("SELECT createTime FROM user_coupon WHERE couponId in (145979,145982,145981,145983,158599,158600,158601,158602)");
//        foreach($result as &$val){
//            $val = (array)$val;
//            $val['createTime'] = date('Y-m-d H:i:s',$val['createTime']);
//        }
//        //dd($result);
//        $this->export_csv($result);
        /************************************************************/
    }

    //查询冻结拍品
    public function frozen()
    {
//        $saleId = DB::connection('mysql_B')->select("select saleId from balance where userinfoId = '5504743' and status = 'deduct' and fee='';");
//        foreach ($saleId as $k => &$v) {
//            $v = (array)$v;
//        }
//        //二维数组转一维数组
//        $ids = array_column($saleId, 'saleId');
//        $ids = array_unique($ids);
//        dd($ids);
        function getContents($url){
            $header = array("Referer: http://www.weipaitang.com/");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);  //能无法 抓取跳转后的页面
            ob_start();
            curl_exec($ch);
            $contents = ob_get_contents();
            ob_end_clean();
            curl_close($ch);
            return $contents;
        }
        $url = "www.weipaitang.com";
        $contents = getContents($url);
        echo $contents;
    }

    //银行卡四要素验证
    public function bankVerify()
    {
        $host = "http://lundroid.market.alicloudapi.com";
        $path = "/lianzhuo/verifi";
        $method = "GET";
        $appcode = "194148a946f345b3b84d95e814be868f";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "acct_name=%e8%a2%81%e5%85%8b%e5%ad%98&acct_pan=6222021001137076573&cert_id=321025196408176051&phone_num=15821849410";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        dd(curl_exec($curl));
    }

    //银行卡信息查询
    public function bankInfo()
    {
        $host = "http://cardinfo.market.alicloudapi.com";
        $path = "/lianzhuo/querybankcard";
        $method = "GET";
        $appcode = "194148a946f345b3b84d95e814be868f";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "bankno=6223093310011899237";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        dd(curl_exec($curl));
    }

    //当面交易订单查询
    public function faceTrade(Request $Request)
    {
        //最近七天
        $lastTime = time() - 7 * 24 * 3600;
        $nowTime = time();
        $uId = $this->getId($Request);
        $data = DB::connection('mysql')->select("select id from sale where userinfoId =$uId and status = 'finished' and paidTime = 0 and finishedTime BETWEEN 1483200000 and 1531482318 order by finishedTime;");
        foreach ($data as $k => &$v) {
            $v = (array)$v;
        }
        //$this->export_csv($data);
        dd($data);
        //dd($data);
    }

    //售假用户id,昵称
    public function sellOff()
    {
        $lastMonth = time() - 30 * 24 * 3600;
        $nowTime = time();
        $uId = DB::connection('mysql_B')->select("select targetId from dashboard_action_log where createTime BETWEEN $lastMonth and $nowTime and remark like '%售假%' ");
        $uId = array_column($uId, 'targetId');
        $uId = array_unique($uId);
        $uId = implode($uId, ',');
        $name = DB::connection('mysql_U')->select("select id,name from userinfo where id in ($uId)");
        foreach ($name as $k => &$v) {
            $v = (array)$v;
        }
        dd($name);
        $data = $this->export_csv($name);
        return $data;
    }

    //导出id格式
    public function formatId()
    {
        $uId = DB::connection('mysql_B')->select("select * from dashboard_action_log where createTime BETWEEN '1527782400' and '1530374399' and remark like '%封店%' and remark not like '%取消 封店%'");
        $uId = array_column($uId, 'targetId');
        $uId = array_unique($uId);
        $uId = implode($uId, ',');
        //dd($uId);
        $zhejiang = DB::connection('mysql_U')->select("select * from userinfo_address where userinfoId in ($uId) and addressJson like '%浙江省%'");
        $uId = array_column($zhejiang, 'userinfoId');
        $uId = array_unique($uId);
        //$this->export_csv($uId);
        dd($uId);
    }

    //winJson
    public function win(Request $Request)
    {
        $id = $this->getSale($Request);
        $data = DB::connection('mysql')->select("select winJson from sale where id = '$id';");
        dd($data);
    }

    //橱窗投放次数次数
    public function windows()
    {
//        $history = DB::connection('mysql_B')->select("select history from promotion_category where type = 1 and history like '%\"2018-07-21\"%'");
//        dd($history);
//        $code = uniqid() . '_' . time();
//        $a = '哈哈哈哈哈';
//        dd(strlen($a));
        //通过code换取token
//        $aa = DB::connection('mysql_B')->select("select uri,status,toUserinfoId,reviewTime from complain where categoryId = 102 and reviewUserinfoId = 17279687 and  createTIme > 1533052800 and status != -1;");
//        foreach ($aa as $k => &$v) {
//            $v = (array)$v;
//        }
//        //dd($aa);
//        $ids = array_column($aa, 'toUserinfoId');
//        $ids = (array)array_unique($ids);
//        $ids = implode($ids, ',');
//        //dd($ids);
//
//        $uId = DB::connection('mysql_U')->select("select telephone,userinfoId,shopName from userinfo_verify where userinfoId in ($ids)");
//        foreach ($uId as $k => &$v) {
//            $v = (array)$v;
//        }
//        //dd($uId);
//        foreach ($aa as $k => &$v) {
//            foreach ($uId as $key => &$value) {
//                if ($value['userinfoId'] === $v['toUserinfoId']) {
//                    $aa[$k]['telephone'] = $uId[$key]['telephone'];
//                    $aa[$k]['shopName'] = $uId[$key]['shopName'];
//                    $aa[$k]['reviewTime'] = date("Y-m-d H:i:s", $aa[$k]['reviewTime']);
//                }
//            }
//        }
//        //dd($aa);
//        $this->export_csv($aa);
//        $startTime = mktime(0, 0, 0, date('m')-1, 1, date('Y'));
//        $endTime = mktime(0, 0, 0, date('m'), 1, date('Y'))-24*3600;
//        dd($startTime);
//        $actionSale = [
//            'deduct_seller_level_scores' => '扣除卖家等级积分',
//            'constraint_sale_hide'       => '强制隐藏拍品',
//            'constraint_sale_show'       => '显示拍品',
//            'constraint_sale_unsold'     => '强制流拍',
//            'sale_del'                   => '下架拍品'
//        ];
//        $actionSale =join('","', array_keys($actionSale));
//        dd($actionSale);
//        if(time() < strtotime('2018-11-09') || time() > strtotime('2018-11-10')){
//            return 0;
//        }
//        $hour = date('H');
//        if($hour >= 20){
//            return 50;
//        }
//        if($hour >= 12){
//            return 25;
//        }
//        return 1;

    }

    //获取封店的商家信息
    public function forbidden()
    {
//        $t1 = microtime(true);
//
        $forbidden = DB::connection('mysql_B')->select("select id,targetId,remark,userinfoId,createTime from dashboard_action_log where actionUrl like \"%forbiddenShop%\" and remark not like \"%取消%\" and remark not like \"%关联店铺自动降权\" and createTime BETWEEN 1546444800 and 1546531200;");
        foreach ($forbidden as $k => &$v) {
            $v = (array)$v;
            $forbidden[$k]['actionUserinfoId'] = $forbidden[$k]['userinfoId'];
            unset($forbidden[$k]['userinfoId']);
        }
        //dd($forbidden);
        $ids = array_column($forbidden, 'targetId');
        //$ids = (array)array_unique($ids);
        //操作人id
        //$actionUserinfoIds = array_column($forbidden, 'actionUserinfoId');
        //$actionUserinfoIds = (array)array_unique($actionUserinfoIds);
        //dd($actionUserinfoIds);
        //dd($actionUserinfoIds);

        //倒出操作人名字
//        $name = [];
//        foreach($actionUserinfoIds as $k=>$v){
//            $name[] = DB::connection('mysql_U')->select("select `name` from userinfo where id = $v");
//        }

        //$name = [];
        //三维数组转二维
//        foreach ($name as $k => &$v) {
//            $names[] = (array)$v[0];
//        }
        //$name = implode('',$name);
        //dd($names);
        //$this->downLoadDataList($names);
        /**************************导出数据********************************/
        $ids = implode($ids, ',');
        //dd($ids);
        $uId = DB::connection('mysql_U')->select("select telephone,userinfoId,shopName from userinfo_verify where userinfoId in ($ids)");
        //dd($uId);
        foreach($uId as $k=>&$v){
            $v = (array)$v;
        }
        foreach ($uId as $k => &$v) {
            foreach ($forbidden as $key => &$value) {
                if ($v['userinfoId'] == $value['targetId']) {
                    $uId[$k]['remark'] = trim($forbidden[$key]['remark']);
                    $uId[$k]['操作时间'] = date('Y-m-d H:i:s',$forbidden[$key]['createTime']);
                    $uId[$k]['操作人'] = $forbidden[$key]['actionUserinfoId'];
                    $a = explode('->', $uId[$k]['remark']);
                    $uId[$k]['扣分原因'] = isset($a[0]) ? $a[0] : "";
                    $uId[$k]['扣分内容'] = isset($a[1]) ? $a[1] : "";
                    $uId[$k]['remark'] = preg_replace("/(,)/", '，', $uId[$k]['remark']);
                    $uId[$k]['remark'] = str_replace("\n", "", $uId[$k]['remark']);
                    //$uId[$k]['actionUserinfoId'] = $forbidden[$key]['actionUserinfoId'];
                    //dd($uId[$k]['actionUserinfoId']);
//                    $name = DB::connection('mysql_U')->select("select `name` from userinfo where id = {$uId[$k]['actionUserinfoId']}");
//                    foreach ($name as $k => &$v) {
//                        foreach($v as $kay=>&$val){
//                            $name = (array)$val;
//                        }
//                        $name = implode('',$name);
//                        $uId[$k]['actionUserinfoId'] = $name;
//                        //dd($name);
//                    }
                    unset($uId[$k]['remark']);
                }

            }
        }
//        $t2 = microtime(true);
//        echo '耗时'.round($t2-$t1,3).'秒<br>';

        dd($uId);
        $this->downLoadDataList($uId);
    }

    //报表成拍金额
    public function order()
    {
        //报表成拍金额
        $data = DB::connection('mysql')->select("select id,winJson from sale where userinfoId = 16474626 AND endTime BETWEEN '2018-12-1 00:00:00' AND '2018-12-2 00:00:00' AND winUserinfoId != '';");
        foreach ($data as $k => &$v) {
            $v = (array)$v;
            $v['winJson'] = json_decode($v['winJson'],true);
            $v['price'] = $v['winJson']['price'];
            $ids = array_column($data, 'price');
            unset($v['winJson']);
        }
        //dd($data);
        $aa = array_sum($ids);
        dd($aa);
    }

    //橱窗购买明细
    public function buyWindows(Request $Request,$id)
    {
//        $uId = $this->getId($Request);
        $aa = DB::connection('mysql_B')->select("select startDate,endDate,createTime,money from promotion_category where userinfoId = $id AND type = 1 order by createTime DESC ;");
        dd($aa);
        foreach ($aa as &$v) {
            $v['info'] = "橱窗日期：".$v['startDate'].'-'.$v['endDate'].'，创建时间'.$v['createTime'];
            dd(1);
            unset($v['startDate'],$v['endDate'],$v['createTime']);
        }
//        foreach ($aa as $k => &$v) {
//            $v = (array)$v;
//            $v['info'] = "橱窗日期：".$aa[$k]['startDate'].'-'.$aa[$k]['endDate'].'，创建时间'.$aa[$k]['createTime'];
//            unset($v['startDate'],$v['endDate'],$v['createTime']);
//        }
        dd($aa);
    }

    //获取指定的时间
    public function sundayTimeStamp($time = 0, $isEnd = false)
    {
        $time = $time ? $time : time();
        if($isEnd){
            $flag = 'Y-m-d 23:59:59';
        }else{
            $flag = 'Y-m-d';
        }
        $day = empty(date('w', $time)) ? 7 : date('w', $time);
        return strtotime(date($flag,(7-$day)*86400+$time));
    }

    //15天成交笔数
    public function paid(Request $Request)
    {
        $uId = $this->getID($Request);
        $startTime = strtotime(date('Y-m-d 00:00:00', strtotime("-15 days")));
        $endTime = strtotime(date('Y-m-d 23:59:59', strtotime("-1 days")));
        $num = DB::connection('mysql')->select("select id,winJson from sale where userinfoId = $uId AND paidTime BETWEEN $startTime AND $endTime;");
        foreach($num as $k=>&$v){
            $v = (array)$v;
            $v['winJson'] = json_decode($v['winJson'],true);
            $v['price'] = $v['winJson']['price'];
            unset($v['winJson']);
            if($v['price']<10){
                unset($num[$k]);
            }
        }
        dd($num);
    }


    //同天买卖家完成的单子
    public function sameDayList($saleId)
    {
        $aa = DB::connection('mysql')->table('sale')->where('id',$saleId)->first();
//        $bb = DB::connection('mysql')->select("select * from sale where id = '$saleId';");//用这种方式出来的是二维数组，需要$bb[]调用
        $finishedTime = isset($aa->finishedTime)?$aa->finishedTime : '';
        $startTime = strtotime(date('Y-m-d 00:00:00', $finishedTime));
        $endTime = strtotime(date('Y-m-d 23:59:59', $finishedTime));
//        echo $startTime ;echo $endTime;
        $num = DB::connection('mysql')->select("SELECT * FROM `pc`.`sale` WHERE `userinfoId` = $aa->userinfoId AND `winUserinfoId` = $aa->winUserinfoId AND `finishedTime` BETWEEN $startTime AND $endTime ORDER BY `finishedTime` ASC;");
//        $num = DB::connection('mysql')->table('sale')->where(['userinfoId'=> $aa->userinfoId,'winUserinfoId' => $aa->winUserinfoId])->where('finishedTime',array('between',array($startTime,$endTime)))->get();
//        dd($aa);
        $c = [];
        foreach($num as $key => $data){
          $c[$key] = $data->id;
        }
        echo '同一天完成的拍品';
        echo json_encode($c);
        echo '<br/>';
        echo '当天首单完成拍品是'.$c[0];
        dd($num);
    }

    //某天成拍报表金额
    public function endSalePrice($id,$date)
    {
        $id = $this->user_Identity($id);
        $startTime = date('Y-m-d H:i:s',strtotime(date($date.'00:00:00')));
        $endTime = date('Y-m-d H:i:s',strtotime(date($date.'23:59:59')));
//        $aa = DB::connection('mysql')->table('sale')->where(['userinfoId'=>$id,'winUserinfoId'=>array('neq',0)])->where('endTime',array('between',array($startTime,$endTime)))->get();
        $data = DB::connection('mysql')->select("SELECT * FROM sale WHERE `userinfoId` = '$id' AND `winUserinfoId` <> '0' AND `endTime` >= '$startTime' AND `endTime` < '$endTime';");
        $c = [];
        foreach($data as $key => $val){
            $c[$key] = $val->id;
        }
        $d = [];
        foreach($data as $key => $val){
            $d[$key] = json_decode($val->winJson)->price;
        }
        echo date('d',$date).'号,id:'.$id.','.'笔数'.count($d).',金额'.array_sum($d);
        var_dump($d);
        dd(json_encode($c));
//        dd($data);
    }

    //用户昵称，是否订阅
    public function nickname(Request $Request){
//
//        define('DATA',[1,2,3,4]);
//
//        echo '<hr/>';
//        print_r(get_defined_constants(true)['user']);
//        echo  DATA[2];
//        DIE;
//        dd(LookUpController::NAME);

//        for($num = 10;$num>0;$num--){
//            if($num%2==0)continue;
//            echo $num."<br/>";
//        }
//        die;

//        $arr = array( array('price' =>10 , 'count' => 100 ),  array('price' =>20 , 'count' => 90 )  );
//        foreach ($arr as &$val) {
//            $val['total']=$val['price']*$val['count'];
//        }
//        dd($arr);
//        foreach ($arr as $k=>$val) {
//            $arr[$k]['total']=$val['price']*$val['count'];
//        }
//        dd($arr);
        $telephoneId = $this->getUrl($Request);
        if(preg_match("/^1[345678]{1}\d{9}$/",$telephoneId)){
            $id = DB::connection('mysql_U')->table('userinfo_center')->where('telephone', $telephoneId)->value('userinfoId');
            $data = DB::connection('mysql_U')->table('userinfo')->where('id',"$id")->first();
            $sns = json_decode($data->snsJson);
            return($sns->nickname);
        }else{
            $data = DB::connection('mysql_U')->table('userinfo')->where('id',$telephoneId)->first();
            $sns = $data->snsJson;
            $sns = json_decode($sns);
            return($sns->nickname);
        }
    }

    //ocr识别
    public function ocr()
    {
        //$this->login();
        $ql = QueryList::get('https://w.weipaitang.com/webApp/article/detail/1901091803ypwlry?r=menu_my');

        $rt = [];
// 采集文章标题
        $rt['title'] = $ql->find('h1')->text();
// 采集文章作者
        $rt['author'] = $ql->find('#author_baidu>strong')->text();
// 采集文章内容
        $rt['content'] = $ql->find('.post_content')->html();

        print_r($rt);

    }

    public function login()
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'http://ms-log.weipaitang.com/login?next=%2Fapp%2Fkibana#/discover?_g=()&_a=(columns:!(_source),index:AWXR3mdTq2ZRoAN3vqGB,interval:auto,query:(match_all:()),sort:!(time,desc))');
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = array(
            "username" => "ts",
            "password" => "wpt123456ts"
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        setcookie('username','ts',10);
        setcookie('password','wpt123456ts',10);
        //显示获得的数据
        return $data;
    }


}
