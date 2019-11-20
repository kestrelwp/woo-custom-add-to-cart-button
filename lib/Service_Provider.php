<?php

namespace Barn2\Lib;

/**
 * An object that provides services (instances of Barn2\Lib\Service).
 */
interface Service_Provider {

    /**
     * Get the service for the specified ID.
     *
     * @param string $id The service ID
     * @return Service The service object
     */
    public function get_service( $id );

}
