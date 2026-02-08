<?php

namespace App\Controllers;

use App\Services\BookingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class BookingController
{
    private BookingService $service;

    // Inject PDO here
    public function __construct(PDO $pdo)
    {
        $this->service = new BookingService($pdo);
    }

    public function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write(
            view::render('/home', ['bodyid' => 'home'])
        );
        return $response;
    }
    public function cmsindex(Request $request, Response $response, $args)
    {
        $response->getBody()->write(
            view::render('/cms/index', ['bodyid' => 'home'], true)
        );
        return $response;
    }

    public function list(Request $request, Response $response, $args)
    {
        $bookings = $this->service->listBookings();
        $response->getBody()->write(
            View::render('cms/bookings', ['bookings' => $bookings, 'bodyid' => 'booking'], true)
        );
        return $response;
    }
    public function view(Request $request, Response $response, $args)
    {
        $booking = $this->service->listBookings();
        $response->getBody()->write(
            View::render('cms/bookings', ['bookings' => $bookings, 'bodyid' => 'booking'], true)
        );
        return $response;
    }

    public function create(Request $request, Response $response, $args)
    {
        $name = $request->getQueryParams()['name'] ?? 'Unnamed';
        $booking = $this->service->addBooking($name);
        $response->getBody()->write("Created booking: {$booking->id} - {$booking->name}");
        return $response;
    }
    public function updateWorkingDays(Request $request, Response $response, $args){
        $response->getBody()->write("Working date updated");
        return $response;
    }
    public function updateCalendar(Request $request, Response $response, $args){

        $current = $_POST['current'] ?? '';
        $newmonth = $_POST['month'] ?? '';
        $currentyear = $_POST['currentyear'] ?? '';
        $date = array();

        if($newmonth == 'previous'){
            $newmonth = date('Y-m-01', strtotime("$current, -1 month"));
        } else {
            $newmonth = date('Y-m-01', strtotime("$current, +1 month"));
        }
        $number = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($newmonth)),  date('y', strtotime($newmonth)));

        //add days into array
        $i = 0;
        while($i < $number){
            $date[] = array('date' => date('Y-m-d', strtotime(date($newmonth). ' + '.$i.' days')),
                            'day' => date('w', strtotime(date($newmonth). ' + '.$i.' days')));
            $i++;
        }

        $table = '';
        $table.= '<div class="center mt-5"><h1 class="month">'. date("F Y", strtotime($newmonth)).'</h1></div>';
        $table.= '<div class="row">
                    <div class="col-md-6">
                        <span id="previousmonth" data-month="previous" data-current="'.date("Y-m-d", strtotime("$newmonth")).'">Previous</span>
                    </div>
                    <div class="col-md-6 textright">
                        <span id="nextmonth" data-month="next" data-current="'.date("Y-m-d", strtotime("$newmonth")).'">Next</span>
                    </div>
                  </div>';
        $table.= '<form name="workingdays" id="workingdays">';
        $table.= '<table class="barberdates">';
        $table.= '<tr>';
        $table.= '<th>Sunday</th>';
        $table.= '<th>Monday</th>';
        $table.= '<th>Tuesday</th>';
        $table.= '<th>Wednesday</th>';
        $table.= '<th>Thursday</th>';
        $table.= '<th>Friday</th>';
        $table.= '<th>Saturday</th>';
        $table.= '</tr>';
        $table.= '<tr>';
        //get starting day of the week
        $firstday = date('w', strtotime($date[0]['date']));
        //set $i to starting day of the week
        $i = 0;
        //add disabled squares for first days of the week that are not in the given month
        while ($i < $firstday){
            if($i >= 7){
                $table.= '</tr>';
                $table.= '<tr>';
                $i = 0;
            }
            $table.= '<td class="disabled"></td>';
            $i++;
        }
        $i = 0;

        //check that month selected matches current month to block off days past
        if(date('Y-m-01', strtotime("$newmonth")) == date('Y-m-01')){
            //add disabled block for each day from first day to today
            $y = 0;
            $i = 0;
            //add disabled block for each day from first day to today
            while ($y+1 < date('j')){
                if($i > 6){
                    break;
                }
                $table.= '<td class="disabled ">'.date('jS', strtotime($date[$y]['date'])).'</td>';
                if(date('w', strtotime($date[$y]['date'])) == 6){
                    $table.= '</tr>';
                    $table.= '<tr>';
                    $i = 0;
                }
                unset($date[$y]);
                $y++;
            }
        }
        //add block for each remaining day of the month
        foreach($date as $day){
            $table.= '<td data-date="'.$day['date'].'"><input type="checkbox" name="workingdate[]" value="'.$day['date'].'">'.date('jS', strtotime($day['date'])).'</input></td>';
            if(date('w', strtotime($day['date'])) == 6){
                $table.= '</tr>';
                $table.= '<tr>';
            }
        }
        $table.= '</tr>';
        $table.= '</table>';
        $table.= '</form>';
        $response->getBody()->write($table);
        return $response;
    }

    public function viewAppointments(Request $request, Response $response, $args){
        $response->getBody()->write(
            View::render('/appointments', ['bodyid' => 'appointments'])
        );
        return $response;
    }
}
