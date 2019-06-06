<?php

namespace audunru\FikenClient\Models;

class FikenAttachment extends FikenBaseModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/attachments';

    protected static $multipart = true;

    protected $fillable = [
        'path',
        'filename',
        'comment',
        'attachToPayment',
        'attachToSale',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attachToPayment = false;
        $this->attachToSale = true;
    }

    /*
     * Convert the model instance to an array that can be used to create a new resource
     *
     * @return array
     */
    public function toNewResourceArray(): array
    {
        return [
            [
                'name'     => 'AttachmentFile',
                'contents' => fopen($this->path, 'rb'),
                'filename' => $this->filename,
            ],
            [
                'name'     => 'SaleAttachment',
                'contents' => json_encode([
                    'filename' => $this->filename,
                    'comment' => $this->comment,
                    'attachToPayment' => $this->attachToPayment,
                    'attachToSale' => $this->attachToSale,
                ]),
            ],
        ];
    }
}
