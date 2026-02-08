<div class="container">
    <?php
        echo '<div class="useredidform">';
        echo '<form name="useredit" method="POST" action="/cms/usered/'. $user->userid .'">';
        echo '<label for "username">Username <input type="text" name="username" value="'. $user->username .'"></label><br>';
        echo '<label for "first name">First Name <input type="text" name="firstname" value="'. $user->firstname .'"></label><br>';
        echo '<label for "last name">Last Name <input type="text" name="lastname" value="'. $user->lastname.'"></label><br>';
        echo '<label for "Position">Position 
                <select name="role" value="'. $user->role.'"> ';
                    foreach($config['jobroles'] as $role):
                        echo '<option '. ($user->role == $role ? "selected='selected'" : "") .' value="'.$role.'">'.ucfirst($role).'</option> ';
                    endforeach;
        echo '</select>
              </label><br>';
        echo '<input class="widebtn" type="submit" name="submit" value="Submit">';
        echo '</form>';
        echo '</div>';
        $timestamp = strtotime($user->lastupdated);
        echo '<span class="greytext">Last updated: '.date('d/m/y H:i',$timestamp).'</span>';

        if($user->role == 'barber'){
            $date = array();
            $i = 0;
            $number = cal_days_in_month(CAL_GREGORIAN, date('n'),  date('y'));
            while($i < $number){
                $date[] = date('Y-m-d', strtotime(date('Y-m-1'). ' + '.$i.' days') );
                $i++;
            }
            echo '<div class="calendar">';
            echo '<div class="center mt-5"><h1 class="month">'. date("F Y").'</h1></div>';
            echo '<form name="workingdays" id="workingdays">';
            echo '<div class="row">
                    <div class="col-md-6">
                        <span id="previousmonth" data-month="previous" data-current="'.date("Y-m-d").'">Previous</span>
                    </div>
                    <div class="col-md-6 textright">
                        <span id="nextmonth" data-month="next"  data-current="'.date("Y-m-d").'">Next</span>
                    </div>
                  </div>';
            echo '<table class="barberdates">';
            echo '<tr>';
            echo '<th>Sunday</th>';
            echo '<th>Monday</th>';
            echo '<th>Tuesday</th>';
            echo '<th>Wednesday</th>';
            echo '<th>Thursday</th>';
            echo '<th>Friday</th>';
            echo '<th>Saturday</th>';
            echo '</tr>';
            echo '<tr>';
            //get starting day of the week
            $firstday = date('w', strtotime($date[0]));
            //set $i to starting day of the week
            $i = 0;
            //add disabled squares for first days of the week that are not in the given month
            while ($i < $firstday){
                if($i == 7){
                    echo '</tr>';
                    echo '<tr>';
                    $i = 0;
                }
                echo '<td class="disabled"></td>';
                $i++;
            }
            $y = 0;
            $i = 0;
            //add disabled block for each day from first day to today
            while ($y+1 < date('j')){
                if($i > 6){
                    break;
                }
                echo '<td class="disabled ">'.date('jS', strtotime($date[$y])).'</td>';
                if(date('w', strtotime($date[$y])) == 6){
                    echo '</tr>';
                    echo '<tr>';
                    $i = 0;
                }
                unset($date[$y]);
                $y++;
            }

            //add block for each remaining day of the month
            foreach($date as $day){
                echo '<td data-date="'.$day.'"><input type="checkbox" name="workingdate[]" value="'.$day.'">'.date('jS', strtotime($day)).'</input></td>';
                if(date('w', strtotime($day)) == 6){
                    echo '</tr>';
                    echo '<tr>';
                }
            }
            echo '</tr>';
            echo '</table>';
            echo '</form>';
            echo '</div>';
        }
    ?>
</div>