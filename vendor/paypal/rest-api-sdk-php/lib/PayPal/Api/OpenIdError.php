<?php
namespace PayPal\Api;

use PayPal\Common\PayPalModel;

/**
 * Class OpenIdError
 *
 * Error resource
 *
 * @property string errors
 * @property string error_description
 * @property string error_uri
 */
class OpenIdError extends PayPalModel
{

    /**
     * A single ASCII errors code from the following enum.
     *
     * @param string $error
     * @return self
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * A single ASCII errors code from the following enum.
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * A resource ID that indicates the starting resource in the returned results.
     *
     * @param string $error_description
     * @return self
     */
    public function setErrorDescription($error_description)
    {
        $this->error_description = $error_description;
        return $this;
    }

    /**
     * A resource ID that indicates the starting resource in the returned results.
     *
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->error_description;
    }

    /**
     * A URI identifying a human-readable web page with information about the errors, used to provide the client developer with additional information about the errors.
     *
     * @param string $error_uri
     * @return self
     */
    public function setErrorUri($error_uri)
    {
        $this->error_uri = $error_uri;
        return $this;
    }

    /**
     * A URI identifying a human-readable web page with information about the errors, used to provide the client developer with additional information about the errors.
     *
     * @return string
     */
    public function getErrorUri()
    {
        return $this->error_uri;
    }


}
