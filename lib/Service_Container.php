<?php
namespace Barn2\WCB_Lib;

use Barn2\WCB_Lib\Util;

/**
 * A trait for a service container.
 *
 * @package   Barn2\barn-lib
 * @author    Barn2 Plugins <support@barn2.co.uk>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 * @version   1.1
 */
trait Service_Container {

    private $services = [];

    public function get_service( $id ) {
        $services = $this->get_services();
        return isset( $services[$id] ) ? $services[$id] : null;
    }

    public function get_services() {
        if ( empty( $this->services ) ) {
            $this->services = $this->create_services();
        }

        return $this->services;
    }

    public function register_services() {
        Util::register_services( $this->get_services() );
    }

    public abstract function create_services();

}
