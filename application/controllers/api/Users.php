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
class Users extends REST_Controller
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
        $response = $this->users->getUserEmail($data->email);

        if (!empty($response)) {
            if (password_verify($data->password, $response[0]->password)) {

                $userJSON = $this->_getUser($response[0]);

                $this->set_response($userJSON, REST_Controller::HTTP_OK);
            } else {
                $data = [
                    'status' => 'error',
                    'error' => 'WRONG_PASSWORD',
                    'message' => 'The password are wrong, please check the typed password entered',
                ];
                $this->set_response($data, REST_Controller::HTTP_OK);
            }

        } else {
            $data = [
                'status' => 'error',
                'error' => 'USER_NOT_FOUND',
                'message' => 'User not found at the database',
            ];
            $this->set_response($data, REST_Controller::HTTP_NOT_FOUND);
        }

    }

    public function refresh_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $response = $this->users->getUserToken($data->token);

        if (!empty($response)) {

            $userJSON = $this->_getUser($response[0]);

            $this->set_response($userJSON, REST_Controller::HTTP_OK);

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
        $response = $this->users->getUserEmail($data->email);

        if (empty($response)) {
            $user['email'] = $data->email;
            $user['first_name'] = $data->first_name;
            $user['last_name'] = $data->last_name;
            $user['phone_number'] = $data->phone_number;
            $user['password'] = password_hash($data->password, PASSWORD_DEFAULT);
            $user['token'] = bin2hex(random_bytes(25));
            $return = $this->users->setNewUser($user);

            $data = [
                'status' => 'success',
                'error' => 0,
                'message' => 'The user are registered at the database',
                'userdata' => 'USER_REGISTERED',
            ];
            $this->set_response($data, REST_Controller::HTTP_OK);
        } else {
            $data = [
                'status' => 'error',
                'error' => 'USER_ALREADY_REGISTERED',
                'message' => 'The email is already registered at the database',
            ];
            $this->set_response($data, REST_Controller::HTTP_OK);
        }

    }

    public function update_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $user = $this->users->getUserToken($data->token);

        if (!empty($user)) {

            $userUpdate = [];
            isset($data->first_name) ? $userUpdate['first_name'] = $data->first_name : null;
            isset($data->last_name) ? $userUpdate['last_name'] = $data->last_name : null;
            isset($data->phone_number) ? $userUpdate['phone_number'] = $data->phone_number : null;
            isset($data->birth_date) ? $userUpdate['birth_date'] = $data->birth_date : null;
            isset($data->address) ? $userUpdate['address'] = $data->address : null;
            isset($data->address_locale) ? $userUpdate['address_locale'] = $data->address_locale : null;
            isset($data->address_province) ? $userUpdate['address_province'] = $data->address_province : null;
            isset($data->address_postal) ? $userUpdate['address_postal'] = $data->address_postal : null;
            isset($data->address_country) ? $userUpdate['address_country'] = $data->address_country : null;

            $response = $this->users->setUpdateUser($user[0]->id, $userUpdate);

            $user = $this->users->getUserToken($data->token);
            $userJSON = $this->_getUser($user[0]);

            $this->set_response($userJSON, REST_Controller::HTTP_OK);

        } else {
            $data = [
                'status' => 'error',
                'error' => 'INVALID_TOKEN',
                'message' => 'The user has an invalid token, try again to sign in',
            ];
            $this->set_response($data, REST_Controller::HTTP_NOT_FOUND);
        }

    }

    public function password_post()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($stream_clean);
        $user = $this->users->getUserToken($data->token);

        if (!empty($user)) {

            if (password_verify($data->old_password, $user[0]->password)) {

                $userUpdate = [];
                $userUpdate['password'] = password_hash($data->new_password, PASSWORD_DEFAULT);

                $response = $this->users->setUpdateUser($user[0]->id, $userUpdate);

                $user = $this->users->getUserToken($data->token);
                $userJSON = $this->_getUser($user[0]);

                $this->set_response($userJSON, REST_Controller::HTTP_OK);
            } else {
                $data = [
                    'status' => 'error',
                    'error' => 'WRONG_PASSWORD',
                    'message' => 'The password are wrong, please check the typed password entered',
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
