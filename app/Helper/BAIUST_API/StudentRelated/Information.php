<?php

namespace App\Helper\BAIUST_API\StudentRelated;

use App\Helper\BAIUST_API\Auth\HandleAuthentication;

class Information
{
    public static function get_parent_id($program, $session)
    {
        if ($program == "CSE") {
            if ($session == config("studentSession.Fall-2022")) {
                $parent_id = 64;
            } elseif ($session == config("studentSession.Spring-2022")) {
                $parent_id = 63;
            } elseif ($session == config("studentSession.Fall-2021")) {
                $parent_id = 62;
            } elseif ($session == config("studentSession.Spring-2021")) {
                $parent_id = 61;
            } elseif ($session == config("studentSession.Fall-2020")) {
                $parent_id = 60;
            } elseif ($session == config("studentSession.Spring-2020")) {
                $parent_id = 59;
            } elseif ($session == config("studentSession.Fall-2019")) {
                $parent_id = 58;
            } elseif ($session == config("studentSession.Spring-2019")) {
                $parent_id = 57;
            } elseif ($session == config("studentSession.Fall-2018")) {
                $parent_id = 56;
            } elseif ($session == config("studentSession.Spring-2018")) {
                $parent_id = 55;
            } elseif ($session == config("studentSession.Fall-2017")) {
                $parent_id = 54;
            } elseif ($session == config("studentSession.Spring-2017")) {
                $parent_id = 53;
            } elseif ($session == config("studentSession.Fall-2016")) {
                $parent_id = 52;
            } elseif ($session == config("studentSession.Spring-2016")) {
                $parent_id = 51;
            } elseif ($session == config("studentSession.Fall-2015")) {
                $parent_id = 50;
            } else {
                $parent_id = 49;
            }
            return $parent_id;
        } elseif ($program == "EEE") {
            if ($session == config("studentSession.Spring-2022")) {
                $parent_id = 922;
            } elseif ($session == config("studentSession.Fall-2021")) {
                $parent_id = 921;
            } elseif ($session == config("studentSession.Spring-2021")) {
                $parent_id = 920;
            } elseif ($session == config("studentSession.Fall-2020")) {
                $parent_id = 919;
            } elseif ($session == config("studentSession.Spring-2020")) {
                $parent_id = 918;
            } elseif ($session == config("studentSession.Fall-2019")) {
                $parent_id = 917;
            } elseif ($session == config("studentSession.Spring-2019")) {
                $parent_id = 916;
            } elseif ($session == config("studentSession.Fall-2018")) {
                $parent_id = 915;
            } elseif ($session == config("studentSession.Spring-2018")) {
                $parent_id = 914;
            } elseif ($session == config("studentSession.Fall-2017")) {
                $parent_id = 913;
            } elseif ($session == config("studentSession.Spring-2017")) {
                $parent_id = 912;
            } elseif ($session == config("studentSession.Fall-2016")) {
                $parent_id = 911;
            } elseif ($session == config("studentSession.Spring-2016")) {
                $parent_id = 910;
            } elseif ($session == config("studentSession.Fall-2015")) {
                $parent_id = 909;
            } else {
                $parent_id = 908;
            }
            return $parent_id;
        } elseif ($program == "CE") {
            if ($session == config("studentSession.Spring-2022")) {
                $parent_id = 935;
            } elseif ($session == config("studentSession.Fall-2021")) {
                $parent_id = 934;
            } elseif ($session == config("studentSession.Spring-2021")) {
                $parent_id = 933;
            } elseif ($session == config("studentSession.Fall-2020")) {
                $parent_id = 932;
            } elseif ($session == config("studentSession.Spring-2020")) {
                $parent_id = 931;
            } elseif ($session == config("studentSession.Fall-2019")) {
                $parent_id = 930;
            } elseif ($session == config("studentSession.Spring-2019")) {
                $parent_id = 929;
            } elseif ($session == config("studentSession.Fall-2018")) {
                $parent_id = 928;
            } elseif ($session == config("studentSession.Spring-2018")) {
                $parent_id = 927;
            } elseif ($session == config("studentSession.Fall-2017")) {
                $parent_id = 926;
            } elseif ($session == config("studentSession.Spring-2017")) {
                $parent_id = 925;
            } elseif ($session == config("studentSession.Fall-2016")) {
                $parent_id = 924;
            } else {
                $parent_id = 923;
            }
            return $parent_id;
        } elseif ($program == "BBA") {
            if ($session == config("studentSession.Fall-2022")) {
                $parent_id = 949;
            } elseif ($session == config("studentSession.Spring-2022")) {
                $parent_id = 948;
            } elseif ($session == config("studentSession.Fall-2021")) {
                $parent_id = 947;
            } elseif ($session == config("studentSession.Spring-2021")) {
                $parent_id = 946;
            } elseif ($session == config("studentSession.Fall-2020")) {
                $parent_id = 945;
            } elseif ($session == config("studentSession.Spring-2020")) {
                $parent_id = 944;
            } elseif ($session == config("studentSession.Fall-2019")) {
                $parent_id = 943;
            } elseif ($session == config("studentSession.Spring-2019")) {
                $parent_id = 942;
            } elseif ($session == config("studentSession.Fall-2018")) {
                $parent_id = 941;
            } elseif ($session == config("studentSession.Spring-2018")) {
                $parent_id = 940;
            } elseif ($session == config("studentSession.Fall-2017")) {
                $parent_id = 939;
            } elseif ($session == config("studentSession.Spring-2017")) {
                $parent_id = 938;
            } elseif ($session == config("studentSession.Fall-2016")) {
                $parent_id = 937;
            } elseif ($session == config("studentSession.Spring-2016")) {
                $parent_id = 936;
            } else {
                $parent_id = 950;
            }
            return $parent_id;
        } elseif ($program == "English") {
            if ($session == config("studentSession.Fall-2022")) {
                $parent_id = 964;
            } elseif ($session == config("studentSession.Spring-2022")) {
                $parent_id = 963;
            } elseif ($session == config("studentSession.Fall-2021")) {
                $parent_id = 962;
            } elseif ($session == config("studentSession.Spring-2021")) {
                $parent_id = 961;
            } elseif ($session == config("studentSession.Fall-2020")) {
                $parent_id = 960;
            } elseif ($session == config("studentSession.Spring-2020")) {
                $parent_id = 959;
            } elseif ($session == config("studentSession.Fall-2019")) {
                $parent_id = 958;
            } elseif ($session == config("studentSession.Spring-2019")) {
                $parent_id = 957;
            } elseif ($session == config("studentSession.Fall-2018")) {
                $parent_id = 956;
            } elseif ($session == config("studentSession.Spring-2018")) {
                $parent_id = 955;
            } elseif ($session == config("studentSession.Fall-2017")) {
                $parent_id = 954;
            } elseif ($session == config("studentSession.Spring-2017")) {
                $parent_id = 953;
            } elseif ($session == config("studentSession.Fall-2016")) {
                $parent_id = 952;
            } else {
                $parent_id = 951;
            }
            return $parent_id;
        } else {
            if ($session == config("studentSession.Fall-2022")) {
                $parent_id = 698;
            } elseif ($session == config("studentSession.Spring-2022")) {
                $parent_id = 697;
            } elseif ($session == config("studentSession.Fall-2021")) {
                $parent_id = 696;
            } elseif ($session == config("studentSession.Spring-2021")) {
                $parent_id = 695;
            } elseif ($session == config("studentSession.Fall-2020")) {
                $parent_id = 694;
            } elseif ($session == config("studentSession.Spring-2020")) {
                $parent_id = 693;
            } elseif ($session == config("studentSession.Fall-2019")) {
                $parent_id = 692;
            } else {
                $parent_id = 691;
            }
            return $parent_id;
        }
    }

    public static function get_ledger_database_id($fee_id_from_iumss)
    {
        if ($fee_id_from_iumss == "1") {
            return 2392;
        } elseif ($fee_id_from_iumss == "2") {
            return 147;
        } elseif ($fee_id_from_iumss == "3") {
            return 8;
        } elseif ($fee_id_from_iumss == "5") {
            return 2386;
        } elseif ($fee_id_from_iumss == "6") {
            return 898;
        } elseif ($fee_id_from_iumss == "8") {
            return 900;
        } elseif ($fee_id_from_iumss == "9") {
            return 896;
        } elseif ($fee_id_from_iumss == "10") {
            return 2385;
        } elseif ($fee_id_from_iumss == "11") {
            return 902;
        } elseif ($fee_id_from_iumss == "12") {
            return 903;
        } elseif ($fee_id_from_iumss == "13") {
            return 904;
        } elseif ($fee_id_from_iumss == "14") {
            return 905;
        } elseif ($fee_id_from_iumss == "15") {
            return 906;
        } elseif ($fee_id_from_iumss == "16") {
            return 907;
        } else {
            return 0;
        }
    }
}
