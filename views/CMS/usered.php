<div class="container">
    <?php
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
        echo '<input type="submit" name="submit" value="Submit">';
        echo '</form>';
        $timestamp = strtotime($user->lastupdated);
        echo '<span class="greytext">Last updated: '.date('d/m/y H:i',$timestamp).'</span>';
    ?>
</div>