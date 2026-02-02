<div class="container">
    <?php
        echo '<div class="useredidform">';
        echo '<form name="useredit" method="POST" action="/usered/'. $user->userid .'">';
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
            while($i < 28){
                $date[] = date('Y-m-d', strtotime(date('y-m-d'). ' + '.$i.' days') );
                $i++;
            }
            echo '<form name="workingdays" id="workingdays">';
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
            $i = 0;
            while ($i < date('w')){
                echo '<td class="disabled"></td>';
                $i++;
            }
            foreach($date as $day){
                if($i == 7){
                    echo '</tr>';
                    echo '<tr>';
                    $i = 0;
                }
                echo '<td data-date="'.$day.'"><input type="checkbox" name="workingdate[]" value="'.$day.'">'.$day.'</input></td>';
                $i++;
            }
            echo '</tr>';
            echo '</table>';
            echo '</form>';
        }
    ?>
</div>