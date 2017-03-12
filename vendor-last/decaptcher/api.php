<?php
// ERROR CODES
define('CC_ERR_OK', 0); // everything went OK
define('CC_ERR_GENERAL', -1); // general internal error
define('CC_ERR_STATUS', -2); // status is not correct
define('CC_ERR_NET_ERROR', -3); // network data transfer error
define('CC_ERR_TEXT_SIZE', -4); // text is not of an appropriate size
define('CC_ERR_OVERLOAD', -5); // server's overloaded
define('CC_ERR_BALANCE', -6); // not enough funds to complete the request
define('CC_ERR_TIMEOUT', -7); // request timed out
define('CC_ERR_BAD_PARAMS', -8); // provided parameters are not good for this function
define('CC_ERR_UNKNOWN', -200); // unknown error

// picture processing TIMEOUTS
define('CC_PTO_DEFAULT', 0); // default timeout, server-specific
define('CC_PTO_LONG', 1); // long timeout for picture, server-specfic
define('CC_PTO_30SEC', 2); // 30 seconds timeout for picture
define('CC_PTO_60SEC', 3); // 60 seconds timeout for picture
define('CC_PTO_90SEC', 4); // 90 seconds timeout for picture

// picture processing TYPES
define('CC_PT_UNSPECIFIED', 0); // unspecified
define('CC_PT_ASIRRA', 86); // ASIRRA pictures
define('CC_PT_TEXT', 83); // TEXT questions
define('CC_PT_MULTIPART', 82); // MULTIPART quetions

// multi-picture processing specifics
define('CC_PT_ASIRRA_PICS_NUM', 12);
define('CC_PT_MULTIPART_PICS_NUM', 20);
