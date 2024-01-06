<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Models\Sale;

class UpdateSaleAction
{
    public function execute(Sale $sale, SaleInfoData $data): Sale
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'sellerId' => 'seller_id',
        ]);

        $dataArray = $this->convertCustomerData($dataArray, $data);

        return tap($sale)
            ->update($dataArray);
    }

    function convertCustomerData($dataArray)
    {
        if (!isset($dataArray['customer'])) {
            return $dataArray;
        }
        if (isset($dataArray['customer']['name'])) {
            $dataArray['customer_name'] = $dataArray['customer']['name'];
        }
        if (isset($dataArray['customer']['email'])) {
            $dataArray['customer_email'] = $dataArray['customer']['email'];
        }
        if (isset($dataArray['customer']['document'])) {
            $dataArray['customer_document'] = $dataArray['customer']['document'];
        }
        if (isset($dataArray['customer']['phone'])) {
            $dataArray['customer_phone'] = $dataArray['customer']['phone'];
        }

        unset($dataArray['customer']);

        return $dataArray;
    }
}
