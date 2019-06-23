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
class Creditcard extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('UsersModel', 'users');
        $this->load->model('FavoritesModel', 'favorites');
        $this->load->model('CreditCardModel', 'creditcard');
        $this->load->model('RestaurantsModel', 'restaurants');
        $this->load->model('CategoriesModel', 'categories');
    }

    private function _getUser($user)
    {
        // Search favorites
        $user_favorites = $this->favorites->getFavoritesUserId($user->id);

        // Search credit cards
        $user_credit_card = $this->creditcard->getCreditCardUserId($user->id);

        // Search restaurants
        $user_restaurants = $this->restaurants->getRestaurantsProvince("Granada");

        $promoted_content = [];
        $nearby_content = [];

        foreach ($user_restaurants as $key => $restaurant) {
            if ($restaurant->promoted_content == 1) {
                $promo_content = [];
                $promo_content['id'] = $restaurant->id;
                $promo_content['logo'] = $restaurant->logo;
                $promo_content['name'] = $restaurant->name;
                array_push($promoted_content, $promo_content);
            }

            $near_content = [];
            $near_content['id'] = $restaurant->id;
            $near_content['logo'] = $restaurant->logo;
            $near_content['name'] = $restaurant->name;
            $near_content['price'] = $restaurant->price;
            $near_content['score'] = $restaurant->score;
            $near_content['categories'] = $this->restaurants->getRestaurantCategories($restaurant->id);
            array_push($nearby_content, $near_content);

        }

        $user_categories = $this->categories->getAllCategories();

        foreach ($user_categories as $key => $category) {
            $category->list = $this->categories->getCategoriesRestaurant($category->id);
        }

        $userdata = [
            "id" => $user->id,
            "token" => $user->token,
            "user" => [
                "name" => $user->first_name,
                "lastName" => $user->last_name,
                "phoneNumber" => $user->phone_number,
                "email" => $user->email,
                "birthdate" => $user->birth_date,
                "address" => $user->address,
                "address_locale" => $user->address_locale,
                "address_province" => $user->address_province,
                "address_postal" => $user->address_postal,
                "address_country" => $user->address_country,
            ],
            "favorites" => $user_favorites,
            "credit_card" => $user_credit_card,
            "promoted_content" => $promoted_content,
            "nearby_content" => $nearby_content,
            "categories" => $user_categories,
        ];

        return $data = [
            'status' => 'success',
            'error' => 0,
            'userdata' => $userdata,
        ];

    }

    public function index_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $user = $this->users->getUserToken($data->token);

        if (!empty($user)) {

            $creditcard['number'] = $data->number;
            $creditcard['expiry'] = $data->expiry;
            $creditcard['cvc'] = $data->cvc;
            $creditcard['type'] = $data->type;
            $creditcard['name'] = $data->name;
            $creditcard["id_user"] = $user[0]->id;

            $response = $this->creditcard->setNewCreditCard($creditcard);

            if (!empty($response)) {
                $data = $this->_getUser($user[0]);
                $this->set_response($data, REST_Controller::HTTP_OK);
            } else {
                $data = [
                    'status' => 'error',
                    'error' => 'CREDIT_CARD_ERROR',
                    'data' => 'An error has occurred when try to insert a new Credit Card at the Database',
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

    public function update_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $user = $this->users->getUserToken($data->token);

        if (!empty($user)) {

            $creditcard['number'] = $data->number;
            $creditcard['expiry'] = $data->expiry;
            $creditcard['cvc'] = $data->cvc;
            $creditcard['type'] = $data->type;
            $creditcard['name'] = $data->name;
            $creditcard["id_user"] = $user[0]->id;

            $response = $this->creditcard->setUpdateCreditCard($data->id, $creditcard);

            if (!empty($response)) {
                $data = $this->_getUser($user[0]);
                $data['response'] = $response;
                $this->set_response($data, REST_Controller::HTTP_OK);
            } else {
                $data = [
                    'status' => 'error',
                    'error' => 'CREDIT_CARD_ERROR',
                    'message' => 'An error has occurred when try to update a Credit Card with id '.$data->id.' at the Database',
                    'data' => $response
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
