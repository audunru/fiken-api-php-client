<?php

namespace audunru\FikenClient;

use audunru\FikenClient\Models\FikenCompany;
use audunru\FikenClient\Traits\ConnectsToFiken;
use Illuminate\Support\Collection;

class FikenClient
{
    use ConnectsToFiken;

    public $company;

    public function company(string $organizationNumber): FikenCompany
    {
        $this->company = FikenCompany::where('organizationNumber', $organizationNumber, $this)->first();

        return $this->company;
    }

    public function user(): array
    {
        return $this->get('whoAmI');
    }

    public function companies(): Collection
    {
        return FikenCompany::all();
    }

    // TODO: Needs refactoring
    public function findAttachmentLinkByInvoice(string $invoice): string
    {
        $json = $this->get($invoice);
        $sale = $json['sale'];
        $json = $this->get($sale);

        return $json['_links']['https://fiken.no/api/v1/rel/attachments']['href'];
    }

    // TODO: Needs refactoring
    public function createAttachment(string $link, string $path, string $filename)
    {
        return $this->post($link, [
            'auth' => [$this->username, $this->password],
            'multipart' => [
                [
                    'name'     => 'AttachmentFile',
                    'contents' => fopen($path, 'rb'),
                    'filename' => $filename,
                ],
                [
                    'name'     => 'SaleAttachment',
                    'contents' => json_encode([
                        'filename' => $filename,
                        'attachToPayment' => false,
                        'attachToSale' => true,
                    ]),
                ],
            ],
        ]);
    }
}
