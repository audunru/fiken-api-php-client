<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\Traits\HasChildren;
use audunru\FikenClient\Traits\IsWritable;
use Illuminate\Support\Collection;

class Sale extends FikenBaseModel
{
    use IsWritable, HasChildren {
        HasChildren::add as addChild;
    }

    protected static $relation = 'https://fiken.no/api/v1/rel/sales';

    protected $fillable = [
        'date',
        'kind',
        'identifier',
        'paid',
        'dueDate',
        'kid',
        'paymentDate',
    ];

    protected $casts = [
        'paid'        => 'boolean',
        'date'        => 'date',
        'dueDate'     => 'date',
        'paymentDate' => 'date',
    ];

    /**
     * Get payments.
     */
    public function payments(): ?Collection
    {
        return $this->getEmbeddedResources(Payment::getRelation())->map(function ($resource) {
            return Payment::newFromApi($resource);
        });
    }

    /**
     * Get attachments.
     */
    public function attachments(): ?Collection
    {
        return Attachment::all($this);
    }

    /**
     * Get customer.
     */
    public function customer(): ?Contact
    {
        return Contact::load($this->customer);
    }

    /**
     * Get invoice lines.
     */
    public function lines(): ?Collection
    {
        return collect($this->lines)->map(function ($line) {
            return OrderLine::newFromApi($line);
        });
    }

    /**
     * Add invoice line.
     *
     * @return Invoice
     */
    public function add(FikenBaseModel $line): FikenBaseModel
    {
        if ($line instanceof OrderLine) {
            $this->attributes['lines'][] = $line->toNewResourceArray();

            return $this;
        } else {
            return $this->addChild($line);
        }
    }

    /**
     * Set payment account.
     */
    public function setPaymentAccount(Account $account): self
    {
        $this->paymentAccount = $account;

        return $this;
    }

    /*
     * Convert the model instance to an array that can be used to create a new resource
     *
     * @return array
     */
    public function toNewResourceArray(): array
    {
        return [
            'date'           => $this->date,
            'kind'           => $this->kind,
            'identifier'     => $this->identifier,
            'paid'           => $this->paid,
            'identifier'     => $this->identifier,
            'lines'          => $this->lines,
            'customer'       => $this->customer ? $this->customer->getLinkToSelf() : null,
            'dueDate'        => $this->dueDate,
            'kid'            => $this->kid,
            'paymentAccount' => $this->paymentAccount ? $this->paymentAccount->code : null,
            'paymentDate'    => $this->paymentDate,
        ];
    }
}
