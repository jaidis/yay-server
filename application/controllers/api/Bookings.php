<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Bookings extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('UsersModel', 'users');
        $this->load->model('RestaurantsModel', 'restaurants');
        $this->load->model('CreditCardModel', 'creditcard');
        $this->load->model('BookingsModel', 'bookings');
    }

    public function index_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $user = $this->users->getUserToken($data->token);

        if (!empty($user)) {

            $response = $this->bookings->getBookingUserId($user[0]->id);

            $data = [
                'status' => 'success',
                'error' => 0,
                'data' => $response,
            ];
            $this->set_response($data, REST_Controller::HTTP_OK);

        } else {
            $data = [
                'status' => 'error',
                'error' => 'INVALID_TOKEN',
                'message' => 'The user has an invalid token, try again to sign in',
            ];
            $this->set_response($data, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function register_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $user = $this->users->getUserToken($data->token);

        if (!empty($user)) {

            $restaurant = $this->restaurants->getRestaurantId($data->id_restaurant);
            $creditCard = $this->creditcard->getCreditCardUserId($user[0]->id);

            $bookings["restaurant_logo"] = $restaurant[0]->logo;
            $bookings["restaurant_name"] = $restaurant[0]->name;
            $bookings["reserve_date"] = $data->reserve_date;
            $bookings["reserve_time"] = $data->reserve_time;
            $bookings["diners"] = $data->diners;
            $bookings["id_restaurant"] = $restaurant[0]->id;
            $bookings["email"] = $user[0]->email;
            $bookings["first_name"] = $user[0]->first_name;
            $bookings["last_name"] = $user[0]->last_name;
            $bookings["phone_number"] = $user[0]->phone_number;
            $bookings["id_user"] = $user[0]->id;
            $bookings["id_credit_card"] = $data->id_credit_card;

            $response = $this->bookings->setNewBooking($bookings);

            if (!empty($response)) {
                $response = $this->bookings->getBookingUserId($user[0]->id);

                $data = [
                    'status' => 'success',
                    'error' => 0,
                    'data' => $response,
                ];
                $this->set_response($data, REST_Controller::HTTP_OK);
            } else {
                $data = [
                    'status' => 'error',
                    'error' => 'BOOKING_ERROR',
                    'data' => 'An error has occurred when try to insert a new Booking at the Database',
                ];
                $this->set_response($data, REST_Controller::HTTP_OK);
            }

        } else {
            $data = [
                'status' => 'error',
                'error' => 'INVALID_TOKEN',
                'message' => 'The user has an invalid token, try again to sign in',
            ];
            $this->set_response($data, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
