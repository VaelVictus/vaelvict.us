<?
    function GetAge($birthdate) {
            // explode the date into meaningful variables
            list($birthyear, $birthmonth, $birthday) = explode("-", $birthdate);
            
            // find the difference between current value for the date, and input date
            $yeardiff = date("Y") - $birthyear;
            $monthdiff = date("n") - $birthmonth;
            $daydiff = date("j") - $birthday;
            
            // it will be negative if the date has not occured this year
            if ($monthdiff < 0)
            $yeardiff--;
            
            // while the kids are age 5 or younger, display 1/2
            $half = '';
            if ($yeardiff <= 5) {
                $mos = months($birthdate);
                if (($mos - ($yeardiff * 12)) > 6) {
                    $half = '&#189;';
                }
            }
            
        return "<span title='$birthdate'>$yeardiff$half</span>";
    }

    function months($date)
    {
        $tmp = explode('-', $date);
        return (date('Y') - $tmp[0]) * 12 + (( 12 - $tmp[1]) - (12 - date( 'n' )));
    }
?>