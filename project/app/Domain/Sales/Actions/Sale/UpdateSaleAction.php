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

    function convertCustomerData($dataArray, $data) {
        if (isset($data->customer->name)) {
            $dataArray['customer_name'] = $data->customer->name;
        }
        if (isset($data->customer->document)) {
            $dataArray['customer_document'] = $data->customer->document;
        }
        if (isset($data->customer->email)) {
            $dataArray['customer_email'] = $data->customer->email;
        }
        if (isset($data->customer->phone)) {
            $dataArray['customer_phone'] = $data->customer->phone;
        }

        unset($dataArray['customer']);

        return $dataArray;
    }
}
