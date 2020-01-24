<?php
namespace WpCore\Controllers;
/**
 * Class ApiController, api controller
 */
class ApiController extends \WP_REST_Controller
{
    /**
     * Default namespace for the WP REST API.
     * Can be overridden in child class to change the namespace.
     * @var string
     */
    protected $namespace = 'api/v1';


    /**
     * ApiController constructor.
     * Once the controller has been instantiated, we hook an action to register the routes upon full initialisation of WP API.
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Registers a route for GET transport method.
     * @param $route
     * @param $callback
     * @param array $args
     */
    public function register_readeable($route, $callback, $args = [])
    {
        register_rest_route($this->namespace, $route, [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => $callback,
            'args' => $args,
            'permission_callback' => [$this, 'get_items_permissions_check']
        ]);
    }

    /**
     * Registers a route for POST transport method.
     * @param $route
     * @param $callback
     * @param array $args
     */
    public function register_creatable($route, $callback, $args = [])
    {
        register_rest_route($this->namespace, $route, [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => $callback,
            'args' => $args,
            'permission_callback' => [$this, 'create_item_permissions_check']
        ]);
    }

    /**
     * Registers a route for POST, PUT, PATCH transport methods together.
     * @param $route
     * @param $callback
     * @param array $args
     */
    public function register_editable($route, $callback, $args = [])
    {
        register_rest_route($this->namespace, $route, [
            'methods' => \WP_REST_Server::EDITABLE,
            'callback' => $callback,
            'args' => $args,
            'permission_callback' => [$this, 'update_item_permissions_check']
        ]);
    }

    /**
     * Registers a route for DELETE transport method.
     * @param $route
     * @param $callback
     * @param array $args
     */
    public function register_deletable($route, $callback, $args = [])
    {
        register_rest_route($this->namespace, $route, [
            'methods' => \WP_REST_Server::DELETABLE,
            'callback' => $callback,
            'args' => $args,
            'permission_callback' => [$this, 'delete_item_permissions_check']
        ]);
    }

    /**
     * Registers routes for a collection of items.
     * One to return ALL the items and another one to return ONE specific item.
     * @param $route
     * @param string $pluralCallback
     * @param string $singularCallback
     */
    public function register_collection($route, $pluralCallback = 'get_items', $singularCallback = 'get_item')
    {
        register_rest_route($this->namespace, $route, [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [$this, $pluralCallback],
            'permission_callback' => [$this, 'get_items_permissions_check']
        ]);

        register_rest_route($this->namespace, $route . '(?P<id>[\d]+)', [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [$this, $singularCallback],
            'permission_callback' => [$this, 'get_items_permissions_check']
        ]);
    }

    /**
     * Override methods to grant permissions or not for each of the above routes.
     * These methods MUST be overridden in child class if you want to check authentication cases or else it'll continuously authorize access to REST API routes.
     * @param $request
     * @return bool
     */
    public function get_items_permissions_check($request)
    {
        return true;
    }
}