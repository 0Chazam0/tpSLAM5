<?php

trait JsonEncode{
    function getJSONEncode() {
        return json_encode(get_object_vars($this));
    }
}

