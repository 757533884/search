<?php
/**
 * Created by PhpStorm.
 * User: xiaorui
 * Date: 2018/3/7
 * Time: 下午4:05
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Excel;

class ToolController
{
    const CATEGORY = [
        1 => [
            "id"              => 1,
            "title"           => "玉翠珠宝",
            "secCategory_ids" => [
                1001 => [
                    "id"    => 1001,
                    "title" => "和田玉",
                ],
                1002 => [
                    "id"    => 1002,
                    "title" => "翡翠",
                ],
                1003 => [
                    "id"    => 1003,
                    "title" => "南红",
                ],
                1004 => [
                    "id"    => 1004,
                    "title" => "琥珀/蜜蜡",
                ],
                1005 => [
                    "id"    => 1005,
                    "title" => "玛瑙",
                ],
                1006 => [
                    "id"    => 1006,
                    "title" => "水晶",
                ],
                1007 => [
                    "id"    => 1007,
                    "title" => "碧玺",
                ],
                //1008
                1009 => [
                    "id"    => 1009,
                    "title" => "黄龙玉",
                ],
                1010 => [
                    "id"    => 1010,
                    "title" => "珍珠",
                ],
                1011 => [
                    "id"    => 1011,
                    "title" => "青金石",
                ],
                //1012 石榴石
                1013 => [
                    "id"    => 1013,
                    "title" => "金银饰品",
                ],
                1014 => [
                    "id"    => 1014,
                    "title" => "天珠",
                ],
                1015 => [
                    "id"    => 1015,
                    "title" => "松石",
                ],
                //1016砗磲
                1017 => [
                    "id"    => 1017,
                    "title" => "珊瑚",
                ],
                1018 => [
                    "id"    => 1018,
                    "title" => "玉髓",
                ],
                1019 => [
                    "id"    => 1019,
                    "title" => "原石",
                ],
                1020 => [
                    "id"    => 1020,
                    "title" => "贵重宝石",
                ],
                1022 => [
                    "id"    => 1022,
                    "title" => "独山玉",
                ],
                1000 => [
                    "id"    => 1000,
                    "title" => "其他",
                ],
                1023 => [
                    "id"    => 1023,
                    "title" => "翡翠原石",
                ],
            ]
        ],
        2 => [
            "id"              => 2,
            "title"           => "书画篆刻",
            "secCategory_ids" => [
                2001 => [
                    "id"    => 2001,
                    "title" => "国画",
                ],
                2002 => [
                    "id"    => 2002,
                    "title" => "西画",
                ],
                2003 => [
                    "id"    => 2003,
                    "title" => "书法",
                ],
                2004 => [
                    "id"    => 2004,
                    "title" => "印章篆刻",
                ],
                2005 => [
                    "id"    => 2005,
                    "title" => "印石章料",
                ],
                2006 => [
                    "id"    => 2006,
                    "title" => "信札/手记",
                ],
                2007 => [
                    "id"    => 2007,
                    "title" => "宣纸",
                ],
                2000 => [
                    "id"    => 2000,
                    "title" => "其他",
                ]
            ]
        ],
        3 => [
            "id"              => 3,
            "title"           => "茶酒滋补",
            "secCategory_ids" => [
                3001 => [
                    "id"    => 3001,
                    "title" => "白酒",
                ],
                3002 => [
                    "id"    => 3002,
                    "title" => "其他茶叶",
                ],
                3003 => [
                    "id"    => 3003,
                    "title" => "滋补营养品",
                ],
                3004 => [
                    "id"    => 3004,
                    "title" => "普洱茶",
                ],
                3005 => [
                    "id"    => 3005,
                    "title" => "岩茶",
                ],
                3006 => [
                    "id"    => 3006,
                    "title" => "洋酒",
                ],
                3007 => [
                    "id"    => 3007,
                    "title" => "红酒",
                ],
                3000 => [
                    "id"    => 3000,
                    "title" => "其他",
                ]
            ]
        ],
        4 => [
            "id"              => 4,
            "title"           => "紫砂陶瓷",
            "secCategory_ids" => [
                4001 => [
                    "id"    => 4001,
                    "title" => "紫砂",
                ],
                4002 => [
                    "id"    => 4002,
                    "title" => "瓷器",
                ],
                4003 => [
                    "id"    => 4003,
                    "title" => "陶器",
                ],
                4004 => [
                    "id"    => 4004,
                    "title" => "瓷片标本"
                ],
                4000 => [
                    "id"    => 4000,
                    "title" => "其他",
                ]
            ]
        ],
        5 => [
            "id"              => 5,
            "title"           => "工艺作品",
            "secCategory_ids" => [
                5001 => [
                    "id"    => 5001,
                    "title" => "木质珠串",
                ],
                5002 => [
                    "id"    => 5002,
                    "title" => "木雕",
                ],
                5003 => [
                    "id"    => 5003,
                    "title" => "树根",
                ],
                5004 => [
                    "id"    => 5004,
                    "title" => "铜/铁/锡器",
                ],
                5005 => [
                    "id"    => 5005,
                    "title" => "菩提珠串",
                ],
                5006 => [
                    "id"    => 5006,
                    "title" => "石雕",
                ],
                5007 => [
                    "id"    => 5007,
                    "title" => "金/银器",
                ],
                5008 => [
                    "id"    => 5008,
                    "title" => "琉璃",
                ],
                5009 => [
                    "id"    => 5009,
                    "title" => "漆器/雕漆",
                ],
                5010 => [
                    "id"    => 5010,
                    "title" => "扇子",
                ],
                5011 => [
                    "id"    => 5011,
                    "title" => "竹雕",
                ],
                5012 => [
                    "id"    => 5012,
                    "title" => "小叶紫檀",
                ],
                5013 => [
                    "id"    => 5013,
                    "title" => "黄花梨",
                ],
                5014 => [
                    "id"    => 5014,
                    "title" => "木质把件",
                ],
                5015 => [
                    "id"    => 5015,
                    "title" => "工艺刀剑",
                ],
                5016 => [
                    "id"    => 5016,
                    "title" => "家具",
                ],
                5017 => [
                    "id"    => 5017,
                    "title" => "矿石摆件",
                ],
                5018 => [
                    "id"    => 5018,
                    "title" => "崖柏",
                ],
                5019 => [
                    "id"    => 5019,
                    "title" => "宗教文化",
                ],
                5020 => [
                    "id"    => 5020,
                    "title" => "沉香",
                ],
                5021 => [
                    "id"    => 5021,
                    "title" => "刺绣",
                ],
                5022 => [
                    "id"    => 5022,
                    "title" => "皮具",
                ],
                5023 => [
                    "id"    => 5023,
                    "title" => "模型",
                ],
                5000 => [
                    "id"    => 5000,
                    "title" => "其他",
                ]
            ]
        ],
        0 => [
            "id"              => 0,
            "title"           => "文玩杂项",
            "secCategory_ids" => [
                1  => [
                    "id"    => 1,
                    "title" => "文房器",
                ],
                2  => [
                    "id"    => 2,
                    "title" => "核雕/核桃",
                ],
                3  => [
                    "id"    => 3,
                    "title" => "烟具",
                ],
                4  => [
                    "id"    => 4,
                    "title" => "邮票",
                ],
                5  => [
                    "id"    => 5,
                    "title" => "钱币",
                ],
                7  => [
                    "id"    => 7,
                    "title" => "图书",
                ],
                8  => [
                    "id"    => 8,
                    "title" => "化石",
                ],
                9  => [
                    "id"    => 9,
                    "title" => "陨石",
                ],
                10 => [
                    "id"    => 10,
                    "title" => "砚台",
                ],
                11 => [
                    "id"    => 11,
                    "title" => "香料/香炉",
                ],
                //12
                13 => [
                    "id"    => 13,
                    "title" => "奇石",
                ],
                14 => [
                    "id"    => 14,
                    "title" => "建阳建盏",
                ],
                15 => [
                    "id"    => 15,
                    "title" => "青田石雕",
                ],
                16 => [
                    "id"    => 16,
                    "title" => "龙泉剑瓷",
                ],
                0  => [
                    "id"    => 0,
                    "title" => "其他",
                ]
            ]
        ],
        6 => [
            "id"              => 6,
            "title"           => "其他品类",
            "secCategory_ids" => [
                6000 => [
                    "id"    => 6000,
                    "title" => "其他",
                ]
            ]
        ],
        7 => [
            "id"              => 7,
            "title"           => "花鸟文娱",
            "secCategory_ids" => [
                7001 => [
                    "id"    => 7001,
                    "title" => "盆景/盆栽",
                ],
                7002 => [
                    "id"    => 7002,
                    "title" => "花卉",
                ],
                7003 => [
                    "id"    => 7003,
                    "title" => "观赏鱼",
                ],
                7004 => [
                    "id"    => 7004,
                    "title" => "宠物",
                ],
                //7007武术健身
                7000 => [
                    "id"    => 7000,
                    "title" => "其他",
                ]
            ]
        ],
        8 => [
            "id"              => 8,
            "title"           => "奢侈品",
            "secCategory_ids" => [
                8001 => [
                    "id"    => 8001,
                    "title" => "鞋履服饰",
                ],
                8002 => [
                    "id"    => 8002,
                    "title" => "钟表",
                ],
                8003 => [
                    "id"    => 8003,
                    "title" => "箱包",
                ],
                8004 => [
                    "id"    => 8004,
                    "title" => "珠宝首饰",
                ],
                8000 => [
                    "id"    => 8000,
                    "title" => "其他",
                ]
            ]
        ]
    ];

    //用户等级
    function sellerLevel($score)
    {
        $_sellerLevelConfig = array(
            40,
            150,
            500,
            2000,
            10000,
            20000,
            50000,
            100000,
            200000,
            500000,
            1000000,
            2000000,
            5000000,
            10000000
        );
        if ($score <= $_sellerLevelConfig[0]) {
            $level = 1;
        } else if ($score <= $_sellerLevelConfig[1]) {
            $level = 2;
        } else if ($score <= $_sellerLevelConfig[2]) {
            $level = 3;
        } else if ($score <= $_sellerLevelConfig[3]) {
            $level = 4;
        } else if ($score <= $_sellerLevelConfig[4]) {
            $level = 5;
        } else if ($score <= $_sellerLevelConfig[5]) {
            $level = 6;
        } else if ($score <= $_sellerLevelConfig[6]) {
            $level = 7;
        } else if ($score <= $_sellerLevelConfig[7]) {
            $level = 8;
        } else if ($score <= $_sellerLevelConfig[8]) {
            $level = 9;
        } else if ($score <= $_sellerLevelConfig[9]) {
            $level = 10;
        } else if ($score <= $_sellerLevelConfig[10]) {
            $level = 11;
        } else if ($score <= $_sellerLevelConfig[11]) {
            $level = 12;
        } else if ($score <= $_sellerLevelConfig[12]) {
            $level = 13;
        } else if ($score <= $_sellerLevelConfig[13]) {
            $level = 14;
        } else {
            $level = 15;
        }
        return $level;
    }
    //获取地址栏参数
    public function getUrl(Request $Request)
    {
        $url = $Request->path();
        $arr = explode("/",$url);
        $id = $arr[count($arr)-1];
        return $id;
    }

    //导出export_csv
    public function export_csv($data)
    {
        $string="";
        foreach ($data as $key => $value)
        {
            foreach ($value as $k => $val)
            {
                $value[$k]=iconv('UTF-8','UTF-8',$value[$k]);
            }

            //$string .= implode("-",$value)."\n"; //用英文逗号分开
            $string .= implode(",",$value)."\n"; //用英文逗号分开
        }
        $filename = date('Ymd').'.csv'; //设置文件名
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo chr(0xEF).chr(0xBB).chr(0xBF);
        echo $string;
    }

    //最新excel数据导出
    public function downLoadDataList($data, $file_name = '收货地址',$sheet_name='统计信息')
    {
        Excel::create($file_name, function ($excel) use ($data, $sheet_name) {
            $excel->sheet($sheet_name, function ($sheet) use ($data) {
                $sheet->fromModel($data)
                    ->freezeFirstRow(); #冻结第一行
            });
        })->export('xls'); //导出格式为xls
    }


    /**
     *      把秒数转换为时分秒的格式
     *      @param Int $times 时间，单位 秒
     *      @return String
     */
    function Sec2Time($time){
        if(is_numeric($time)){
            $value = array(
                "years" => 0, "days" => 0, "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if($time >= 31556926){
                $value["years"] = floor($time/31556926);
                $time = ($time%31556926);
            }
            if($time >= 86400){
                $value["days"] = floor($time/86400);
                $time = ($time%86400);
            }
            if($time >= 3600){
                $value["hours"] = floor($time/3600);
                $time = ($time%3600);
            }
            if($time >= 60){
                $value["minutes"] = floor($time/60);
                $time = ($time%60);
            }
            $value["seconds"] = floor($time);
            //return (array) $value;
            $t=$value["years"] ."年". $value["days"] ."天"." ". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            Return $t;

        }else{
            return (bool) FALSE;
        }
    }

    function getDayBE($day) {
        return array(strtotime($day), strtotime($day)+24*3600-1);
    }

    function get_property($obj, $property, $default = null)
    {
        if (!$obj) return $default;
        is_string($obj) and $obj = json_decode($obj, true);
        if (is_object($obj)) {

            return property_exists($obj, $property) || isset($obj->$property) ? $obj->$property : $default;
        }

        return isset($obj[$property]) ? $obj[$property] : $default;
    }
}