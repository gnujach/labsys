<?php

it('has puesto page', function () {
    $response = $this->get('/puesto');

    $response->assertStatus(200);
});
