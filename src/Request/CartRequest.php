<?php

namespace Request;

class CartRequest extends Request
{
    public function getProductId()
    {
        return $this->body['id'];
    }

}