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
class Restaurants extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // $this->load->model('UsersModel', 'users');
        // $this->load->model('FavoritesModel', 'favorites');
        $this->load->model('RestaurantsModel', 'restaurants');
        // $this->load->model('CategoriesModel', 'categories');
    }

    public function index_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $response = $this->restaurants->getRestaurantId($data->id_restaurant);

        if (!empty($response)) {
            $response[0]->entrees = $this->restaurants->getRestaurantsEntrees($response[0]->id);
            $response[0]->salads = $this->restaurants->getRestaurantsSalads($response[0]->id);
            $response[0]->soups = $this->restaurants->getRestaurantsSoups($response[0]->id);
            $response[0]->meats = $this->restaurants->getRestaurantsMeats($response[0]->id);
            $response[0]->fishes = $this->restaurants->getRestaurantsFishes($response[0]->id);
            $response[0]->specialties = $this->restaurants->getRestaurantsSpecialties($response[0]->id);
            $response[0]->schedule = $this->restaurants->getRestaurantsSchedule($response[0]->id);

            $data = [
                'status' => 'success',
                'error' => 0,
                'data' => $response[0],
            ];
            $this->set_response($data, REST_Controller::HTTP_OK);

        } else {
            $data = [
                'status' => 'error',
                'error' => 'RESTAURANT_NOT_FOUND',
                'message' => 'Restaurant not found at the database',
            ];
            $this->set_response($data, REST_Controller::HTTP_NOT_FOUND);
        }

    }
}
