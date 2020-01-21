<?php

return [

    'validator.message' => 'Ocorreu um erro no resource deliveries',

    'validator.client.required' => 'O nome do cliente é obrigatório',
    'validator.client.min' => 'o nome do cliente precisa ter pelo menos 3 caracteres',
    'validator.client.max' => 'o nome do cliente nao pode passar de 255 caracteres',

    'validator.delivery_date.required' => 'A data da entrega é obrigatória',
    'validator.delivery_date.date' => 'a data da entrega precisa ser uma data válida',

    'validator.target_start.required' => 'O endereço de origem é obrigatório',
    'validator.target_start.min' => 'O endereço de origem precisa ter pelo menos 3 caracteres',
    'validator.target_start.max' => 'O endereço de origem nao pode passar de 255 caracteres',

    'validator.target_end.required' => 'O endereço de destino é obrigatório',
    'validator.target_end.min' => 'O endereço de destino precisa ter pelo menos 3 caracteres',
    'validator.target_end.max' => 'O endereço de destino nao pode passar de 255 caracteres',
];
