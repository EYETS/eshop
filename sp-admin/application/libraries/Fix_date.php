<?php

include_once APPPATH . '/third_party/date_data/classDate.php';

class Fix_date {

    function express_date($date, $type, $correction = false) {

        $fixedtime;
        $ex_date;
        $da;

        $da = new I18N_Arabic_Date('Date');
        if (is_numeric($date)) {

            $fixedtime = $date;
        } else {

            $fixdateformat = new DateTime($date);
            $fixedtime = $fixdateformat->getTimestamp();
        }

        switch ($type) {
            case 0:
                $da->setMode(1);
                $hj_date = $da->date('dS F Y  h:i:s A', $fixedtime, $correction);
                $da->setMode(3);
                $ge_date = $da->date('l dS F Y ', $fixedtime, $correction);
                $ex_date = $ge_date . "," . $hj_date;

                break;
            case 1:

                $da->setMode($type);
                $ex_date = $da->date('l dS F Y  h:i:s A', $fixedtime, $correction);
                break;
            case 2:
                $da->setMode($type + 1);
                $ex_date = $da->date('l dS F Y  h:i:s A', $fixedtime, $correction);

                break;
            case 3:
                $da->setMode($type + 1);
                $ex_date = $da->date('l dS F Y  h:i:s A', $fixedtime, $correction);

                break;

            default:
                $da->setMode(1);
                $ex_date = $da->date('l dS F Y  h:i:s A', $fixedtime, $correction);

                break;
        }

        return $ex_date;
    }

}

?>
