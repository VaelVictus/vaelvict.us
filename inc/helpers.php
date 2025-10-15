<?
    if ($_SERVER['SERVER_NAME'] == 'localhost' OR strstr($_SERVER['SERVER_NAME'], '.loc') OR strstr($_SERVER['HTTP_HOST'], '192.168')) {
        define('DEV_ENV', 'dev');
    } else {
        define('DEV_ENV', 'prod');
    }

    function get_age($birthdate) {
        // explode the date into meaningful variables
        list($birth_year, $birth_month) = explode("-", $birthdate);
        
        // find the difference between current value for the date, and input date
        $years_old = intval(date("Y") - $birth_year);
        $months_diff = intval(date("n") - $birth_month);
        
        // it will be negative if the date has not occured this year
        if ($months_diff < 0)
        $years_old--;
        
        // Just give months for our cute little babies!
        if ($years_old === 0) {
            $months_old = months($birthdate);
            $label = ($months_old > 1 ? 'months' : 'month');
            return "<b>$months_old</b> $label";
        }

        // while the kids are age 2 or younger, display 1/2 ages
        if ($years_old <= 2) {
            $mos = months($birthdate);
            $half = ($mos - ($years_old * 12) > 6) ? '&#189;' : '';
            $label = ($years_old > 1 ? 'years' : 'year');

            return "<b>$years_old</b> $half $label";
        }
            
        return "<b>$years_old</b> years";
    }

    function months($date)
    {
        $tmp = explode('-', $date);
        return (date('Y') - $tmp[0]) * 12 + (( 12 - $tmp[1]) - (12 - date( 'n' )));
    }
?>