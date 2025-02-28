<?php

/**
 * Created by PhpStorm.
 * User: Windy
 * Date: 2019/2/2
 * Time: 9:31
 */

namespace Common\Console\Commands\User;

use Common\Models\User\User;
use Common\Models\User\UserAuth;
use Common\Models\User\UserContact;
use Common\Models\User\UserInfo;
use Common\Models\User\UserWork;
use Common\Models\Order\Order;
use Common\Models\BankCard\BankCardPeso;
use Common\Models\Upload\Upload;
use Common\Utils\MerchantHelper;
use Common\Services\NewClm\ClmServer;
use DB;
use Illuminate\Console\Command;

class DataImportTools extends Command {

    const FROM_MERCHANT_ID = 4;
    const TO_MERCHANT_ID = 6;
    const TO_APP_ID = 7;
    const TABLES = [
        "user_auth" => ["where" => "", "model" => UserAuth::class],
        "user_contact" => ["where" => "", "model" => UserContact::class],
        "user_info" => ["where" => "", "model" => UserInfo::class],
        "user_work" => ["where" => "", "model" => UserWork::class],
        "bank_card_peso" => ["where" => " AND status=1 ", "model" => BankCardPeso::class],
        "order" => ["where" => " AND left(order_no, 1)=3 ", "model" => Order::class],
        "upload" => ["where" => " AND status=1", "model" => Upload::class]
    ];
    const COUPON_MAP = [
        "type1" => "7",
        "type2" => "8",
        "type3" => "9",
        "type4" => "10",
        "type5" => "11",
    ];
    const DATA_LIST = [
        ['112699'],
        ['112700'],
        ['112701'],
        ['112702'],
        ['112703'],
        ['112704'],
        ['112705'],
        ['112706'],
        ['112708'],
        ['112709'],
        ['112710'],
        ['112711'],
        ['112712'],
        ['112713'],
        ['112714'],
        ['112715'],
        ['112716'],
        ['112717'],
        ['112718'],
        ['112719'],
        ['112720'],
        ['112721'],
        ['112722'],
        ['112723'],
        ['112724'],
        ['112725'],
        ['112726'],
        ['112727'],
        ['112728'],
        ['112729'],
        ['112730'],
        ['112732'],
        ['112733'],
        ['112734'],
        ['112735'],
        ['112736'],
        ['112737'],
        ['112740'],
        ['112742'],
        ['112743'],
        ['112745'],
        ['112746'],
        ['112748'],
        ['112749'],
        ['112750'],
        ['112752'],
        ['112754'],
        ['112755'],
        ['112756'],
        ['112757'],
        ['112758'],
        ['112759'],
        ['112761'],
        ['112762'],
        ['112763'],
        ['112765'],
        ['112767'],
        ['112768'],
        ['112769'],
        ['112770'],
        ['112771'],
        ['112772'],
        ['112773'],
        ['112774'],
        ['112775'],
        ['112776'],
        ['112777'],
        ['112778'],
        ['112779'],
        ['112780'],
        ['112781'],
        ['112783'],
        ['112784'],
        ['112785'],
        ['112786'],
        ['112788'],
        ['112789'],
        ['112790'],
        ['112791'],
        ['112792'],
        ['112793'],
        ['112795'],
        ['112796'],
        ['112798'],
        ['112799'],
        ['112800'],
        ['112801'],
        ['112803'],
        ['112804'],
        ['112805'],
        ['112806'],
        ['112807'],
        ['112808'],
        ['112810'],
        ['112811'],
        ['112812'],
        ['112813'],
        ['112814'],
        ['112816'],
        ['112817'],
        ['112818'],
        ['112821'],
        ['112822'],
        ['112823'],
        ['112824'],
        ['112825'],
        ['112826'],
        ['112828'],
        ['112829'],
        ['112830'],
        ['112831'],
        ['112832'],
        ['112833'],
        ['112834'],
        ['112835'],
        ['112836'],
        ['112837'],
        ['112838'],
        ['112839'],
        ['112840'],
        ['112841'],
        ['112842'],
        ['112843'],
        ['112844'],
        ['112845'],
        ['112846'],
        ['112847'],
        ['112848'],
        ['112849'],
        ['112850'],
        ['112851'],
        ['112852'],
        ['112854'],
        ['112855'],
        ['112856'],
        ['112857'],
        ['112858'],
        ['112859'],
        ['112860'],
        ['112861'],
        ['112862'],
        ['112863'],
        ['112864'],
        ['112865'],
        ['112866'],
        ['112867'],
        ['112868'],
        ['112869'],
        ['112870'],
        ['112871'],
        ['112872'],
        ['112873'],
        ['112874'],
        ['112875'],
        ['112876'],
        ['112877'],
        ['112878'],
        ['112879'],
        ['112880'],
        ['112881'],
        ['112883'],
        ['112884'],
        ['112886'],
        ['112887'],
        ['112888'],
        ['112889'],
        ['112890'],
        ['112891'],
        ['112892'],
        ['112893'],
        ['112894'],
        ['112895'],
        ['112897'],
        ['112898'],
        ['112899'],
        ['112900'],
        ['112901'],
        ['112902'],
        ['112903'],
        ['112904'],
        ['112905'],
        ['112906'],
        ['112907'],
        ['112908'],
        ['112909'],
        ['112910'],
        ['112911'],
        ['112912'],
        ['112913'],
        ['112914'],
        ['112915'],
        ['112916'],
        ['112917'],
        ['112918'],
        ['112919'],
        ['112920'],
        ['112921'],
        ['112922'],
        ['112924'],
        ['112925'],
        ['112926'],
        ['112927'],
        ['112928'],
        ['112929'],
        ['112930'],
        ['112931'],
        ['112934'],
        ['112936'],
        ['112937'],
        ['112938'],
        ['112939'],
        ['112940'],
        ['112942'],
        ['112943'],
        ['112945'],
        ['112946'],
        ['112947'],
        ['112948'],
        ['112949'],
        ['112950'],
        ['112951'],
        ['112952'],
        ['112953'],
        ['112954'],
        ['112955'],
        ['112956'],
        ['112957'],
        ['112958'],
        ['112959'],
        ['112960'],
        ['112962'],
        ['112963'],
        ['112964'],
        ['112965'],
        ['112966'],
        ['112967'],
        ['112968'],
        ['112969'],
        ['112970'],
        ['112971'],
        ['112972'],
        ['112973'],
        ['112975'],
        ['112976'],
        ['112977'],
        ['112978'],
        ['112979'],
        ['112981'],
        ['112982'],
        ['112983'],
        ['112984'],
        ['112985'],
        ['112986'],
        ['112988'],
        ['112989'],
        ['112990'],
        ['112991'],
        ['112992'],
        ['112993'],
        ['112994'],
        ['112996'],
        ['112998'],
        ['113000'],
        ['113001'],
        ['113003'],
        ['113004'],
        ['113005'],
        ['113007'],
        ['113008'],
        ['113009'],
        ['113010'],
        ['113011'],
        ['113013'],
        ['113014'],
        ['113016'],
        ['113017'],
        ['113019'],
        ['113020'],
        ['113021'],
        ['113023'],
        ['113025'],
        ['113027'],
        ['113028'],
        ['113029'],
        ['113030'],
        ['113032'],
        ['113033'],
        ['113034'],
        ['113035'],
        ['113036'],
        ['113037'],
        ['113038'],
        ['113039'],
        ['113040'],
        ['113041'],
        ['113042'],
        ['113043'],
        ['113044'],
        ['113045'],
        ['113046'],
        ['113047'],
        ['113048'],
        ['113049'],
        ['113050'],
        ['113052'],
        ['113053'],
        ['113054'],
        ['113055'],
        ['113056'],
        ['113057'],
        ['113058'],
        ['113060'],
        ['113061'],
        ['113062'],
        ['113064'],
        ['113065'],
        ['113066'],
        ['113067'],
        ['113068'],
        ['113070'],
        ['113072'],
        ['113073'],
        ['113074'],
        ['113075'],
        ['113076'],
        ['113077'],
        ['113078'],
        ['113079'],
        ['113080'],
        ['113082'],
        ['113083'],
        ['113084'],
        ['113085'],
        ['113086'],
        ['113087'],
        ['113088'],
        ['113090'],
        ['113092'],
        ['113093'],
        ['113094'],
        ['113095'],
        ['113097'],
        ['113098'],
        ['113099'],
        ['113100'],
        ['113101'],
        ['113102'],
        ['113103'],
        ['113104'],
        ['113105'],
        ['113106'],
        ['113108'],
        ['113109'],
        ['113110'],
        ['113111'],
        ['113112'],
        ['113113'],
        ['113114'],
        ['113116'],
        ['113117'],
        ['113118'],
        ['113119'],
        ['113120'],
        ['113121'],
        ['113123'],
        ['113124'],
        ['113125'],
        ['113126'],
        ['113127'],
        ['113128'],
        ['113129'],
        ['113130'],
        ['113131'],
        ['113132'],
        ['113133'],
        ['113134'],
        ['113136'],
        ['113137'],
        ['113139'],
        ['113140'],
        ['113141'],
        ['113142'],
        ['113143'],
        ['113144'],
        ['113145'],
        ['113146'],
        ['113147'],
        ['113148'],
        ['113149'],
        ['113150'],
        ['113151'],
        ['113152'],
        ['113154'],
        ['113155'],
        ['113157'],
        ['113158'],
        ['113159'],
        ['113160'],
        ['113161'],
        ['113163'],
        ['113164'],
        ['113165'],
        ['113167'],
        ['113168'],
        ['113169'],
        ['113170'],
        ['113171'],
        ['113173'],
        ['113174'],
        ['113175'],
        ['113176'],
        ['113177'],
        ['113179'],
        ['113180'],
        ['113182'],
        ['113183'],
        ['113184'],
        ['113185'],
        ['113187'],
        ['113188'],
        ['113189'],
        ['113190'],
        ['113191'],
        ['113192'],
        ['113193'],
        ['113196'],
        ['113197'],
        ['113198'],
        ['113199'],
        ['113201'],
        ['113204'],
        ['113205'],
        ['113206'],
        ['113207'],
        ['113208'],
        ['113209'],
        ['113210'],
        ['113211'],
        ['113212'],
        ['113213'],
        ['113215'],
        ['113216'],
        ['113217'],
        ['113218'],
        ['113220'],
        ['113221'],
        ['113222'],
        ['113223'],
        ['113224'],
        ['113225'],
        ['113226'],
        ['113227'],
        ['113228'],
        ['113229'],
        ['113231'],
        ['113233'],
        ['113234'],
        ['113236'],
        ['113237'],
        ['113238'],
        ['113239'],
        ['113240'],
        ['113241'],
        ['113242'],
        ['113243'],
        ['113245'],
        ['113246'],
        ['113247'],
        ['113250'],
        ['113251'],
        ['113252'],
        ['113253'],
        ['113254'],
        ['113256'],
        ['113257'],
        ['113258'],
        ['113259'],
        ['113260'],
        ['113261'],
        ['113262'],
        ['113263'],
        ['113264'],
        ['113265'],
        ['113266'],
        ['113267'],
        ['113268'],
        ['113269'],
        ['113270'],
        ['113271'],
        ['113272'],
        ['113273'],
        ['113274'],
        ['113275'],
        ['113276'],
        ['113279'],
        ['113280'],
        ['113281'],
        ['113283'],
        ['113284'],
        ['113285'],
        ['113287'],
        ['113288'],
        ['113290'],
        ['113291'],
        ['113292'],
        ['113295'],
        ['113296'],
        ['113298'],
        ['113300'],
        ['113301'],
        ['113302'],
        ['113303'],
        ['113304'],
        ['113305'],
        ['113306'],
        ['113307'],
        ['113310'],
        ['113311'],
        ['113312'],
        ['113313'],
        ['113314'],
        ['113315'],
        ['113316'],
        ['113317'],
        ['113318'],
        ['113319'],
        ['113320'],
        ['113321'],
        ['113322'],
        ['113323'],
        ['113324'],
        ['113325'],
        ['113326'],
        ['113327'],
        ['113328'],
        ['113329'],
        ['113331'],
        ['113332'],
        ['113333'],
        ['113334'],
        ['113335'],
        ['113336'],
        ['113337'],
        ['113338'],
        ['113339'],
        ['113340'],
        ['113342'],
        ['113343'],
        ['113344'],
        ['113345'],
        ['113346'],
        ['113347'],
        ['113350'],
        ['113351'],
        ['113354'],
        ['113355'],
        ['113356'],
        ['113357'],
        ['113358'],
        ['113359'],
        ['113360'],
        ['113361'],
        ['113364'],
        ['113365'],
        ['113366'],
        ['113367'],
        ['113369'],
        ['113370'],
        ['113371'],
        ['113372'],
        ['113373'],
        ['113375'],
        ['113376'],
        ['113377'],
        ['113379'],
        ['113380'],
        ['113381'],
        ['113382'],
        ['113383'],
        ['113384'],
        ['113385'],
        ['113386'],
        ['113387'],
        ['113388'],
        ['113389'],
        ['113390'],
        ['113391'],
        ['113392'],
        ['113393'],
        ['113394'],
        ['113395'],
        ['113396'],
        ['113397'],
        ['113398'],
        ['113399'],
        ['113400'],
        ['113401'],
        ['113403'],
        ['113404'],
        ['113405'],
        ['113406'],
        ['113407'],
        ['113408'],
        ['113409'],
        ['113410'],
        ['113411'],
        ['113412'],
        ['113413'],
        ['113414'],
        ['113415'],
        ['113416'],
        ['113417'],
        ['113418'],
        ['113419'],
        ['113420'],
        ['113421'],
        ['113422'],
        ['113423'],
        ['113424'],
        ['113425'],
        ['113426'],
        ['113427'],
        ['113428'],
        ['113430'],
        ['113431'],
        ['113432'],
        ['113433'],
        ['113434'],
        ['113436'],
        ['113437'],
        ['113438'],
        ['113440'],
        ['113441'],
        ['113442'],
        ['113443'],
        ['113444'],
        ['113446'],
        ['113447'],
        ['113448'],
        ['113449'],
        ['113450'],
        ['113452'],
        ['113453'],
        ['113455'],
        ['113456'],
        ['113457'],
        ['113458'],
        ['113459'],
        ['113460'],
        ['113462'],
        ['113463'],
        ['113464'],
        ['113465'],
        ['113467'],
        ['113468'],
        ['113469'],
        ['113470'],
        ['113471'],
        ['113472'],
        ['113473'],
        ['113474'],
        ['113475'],
        ['113476'],
        ['113477'],
        ['113478'],
        ['113480'],
        ['113481'],
        ['113482'],
        ['113483'],
        ['113484'],
        ['113485'],
        ['113488'],
        ['113489'],
        ['113490'],
        ['113492'],
        ['113494'],
        ['113495'],
        ['113496'],
        ['113497'],
        ['113498'],
        ['113499'],
        ['113500'],
        ['113501'],
        ['113503'],
        ['113504'],
        ['113506'],
        ['113507'],
        ['113508'],
        ['113509'],
        ['113510'],
        ['113513'],
        ['113514'],
        ['113516'],
        ['113518'],
        ['113519'],
        ['113521'],
        ['113522'],
        ['113523'],
        ['113524'],
        ['113525'],
        ['113527'],
        ['113528'],
        ['113529'],
        ['113530'],
        ['113531'],
        ['113532'],
        ['113533'],
        ['113534'],
        ['113535'],
        ['113536'],
        ['113537'],
        ['113539'],
        ['113540'],
        ['113541'],
        ['113542'],
        ['113543'],
        ['113544'],
        ['113545'],
        ['113546'],
        ['113547'],
        ['113548'],
        ['113550'],
        ['113551'],
        ['113552'],
        ['113553'],
        ['113554'],
        ['113555'],
        ['113556'],
        ['113557'],
        ['113559'],
        ['113560'],
        ['113561'],
        ['113562'],
        ['113563'],
        ['113564'],
        ['113565'],
        ['113566'],
        ['113567'],
        ['113568'],
        ['113569'],
        ['113570'],
        ['113572'],
        ['113573'],
        ['113574'],
        ['113575'],
        ['113576'],
        ['113577'],
        ['113578'],
        ['113579'],
        ['113580'],
        ['113581'],
        ['113582'],
        ['113585'],
        ['113586'],
        ['113587'],
    ];

    protected $signature = 'tools:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '哥大项目导入数据';

    public function handle() {
        $newAppID = \Yunhan\Utils\Env::isProd() ? self::TO_APP_ID : 6;
        $success = 0;
        $total = count(self::DATA_LIST);
        foreach (self::DATA_LIST as $item) {
            $sql = "select * from `user` where id='{$item[0]}'";
            $user = DB::connection("mysql_readonly")->select($sql);
            if ($user[0]) {
                $user = $this->object2array($user[0]);

                MerchantHelper::setMerchantId(self::TO_MERCHANT_ID);
                $oldUid = $user['id'];
                unset($user['id']);
                unset($user['created_at']);
                unset($user['updated_at']);

                $user['merchant_id'] = self::TO_MERCHANT_ID;
                $user['app_id'] = $newAppID;
                $newUser = User::model()->updateOrCreateModel($user, ['telephone' => $user['telephone'], 'app_id' => $user['app_id']]);
                foreach (self::TABLES as $tableName => $tableItem) {
                    $where = " user_id='{$oldUid}' {$tableItem['where']}";
                    $sql = "select * from `{$tableName}` where {$where}";
                    $list = DB::connection("mysql_readonly")->select($sql);
                    if ($list) {
                        $model = new $tableItem['model'];
                        foreach ($list as $subItem) {
                            $subItem = $this->object2array($subItem);
                            unset($subItem['id']);
                            unset($subItem['created_at']);
                            unset($subItem['updated_at']);
                            $subItem['user_id'] = $newUser->id;
                            if (isset($subItem['merchant_id'])) {
                                $subItem['merchant_id'] = self::TO_MERCHANT_ID;
                            }
                            if (isset($subItem['dg_pay_lifetime_id'])) {
                                $subItem['dg_pay_lifetime_id'] = '';
                            }
                            if ($tableName == "order" && isset($subItem['order_no'])) {
                                $subItem['order_no'] = "S1" . $subItem['order_no'];
                            }
                            if ($tableName == "user_auth") {
                                if(isset($subItem['time'])) {
                                    $subItem['auth_status'] = UserAuth::STATUS_VALID;
                                    $subItem['time'] = date("Y-m-d 00:00:00");
                                }
                            }
                            if (isset($subItem['app_id'])) {
                                $subItem['app_id'] = $newAppID;
                            }

                            $model->updateOrCreateModel($subItem, $subItem);
                        }
                    }
                }

                ClmServer::server()->getOrInitCustomer($newUser);
                $success++;
                echo $user['telephone'] . " OVER " . "{$success}/{$total}" . PHP_EOL;
            }
        }
    }

    private function object2array(&$object) {
        $object = json_decode(json_encode($object), true);
        return $object;
    }

}
