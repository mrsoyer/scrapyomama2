<?php

namespace Snapchat\API;

class Constants {

    /*
	 * The API Base URL.
	 */
    const BASE_URL = "https://app.snapchat.com";

    /*
	 * The API Secret. Used to create Request Tokens.
	 */
    const SECRET = "4b5bd5aece1896e08c52eb06dd90f7ab";

    /*
     * The Static Token. Used when no AuthToken is available.
     */
    const STATIC_TOKEN = "fd0b334564dd031283e7b017cd85e5cf";

    /*
     * The Hash Pattern. Use to create Request Tokens.
     */
    const HASH_PATTERN = "0001110111101110001111010101111011010001001110011000110001000110";

    /*
     * Hardcoded Device Screen Sizes
     */
    const SCREEN_WIDTH_IN = "5.82";
    const SCREEN_HEIGHT_IN = "7.75";
    const SCREEN_WIDTH_PX = "320";
    const SCREEN_HEIGHT_PX = "480";

}